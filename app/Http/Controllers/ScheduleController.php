<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ScheduleController extends Controller
{
    /** Materi disimpan di disk 'local' => storage/app/private (tidak bisa diakses via URL publik). */
    private const DISK = 'local';

    public function index(Request $request): View
    {
        $user = $request->user();

        $schedules = Schedule::query()
            ->with('user:id,name')
            ->when(! $user->isAdmin(), fn ($q) => $q->where('user_id', $user->id))
            ->orderByDesc('schedule_date')
            ->orderByDesc('schedule_time')
            ->paginate(15);

        return view('schedules.index', compact('schedules'));
    }

    public function create(Request $request): View
    {
        $teachers = $request->user()->isAdmin()
            ? User::query()->orderBy('name')->get(['id', 'name'])
            : collect();

        return view('schedules.create', compact('teachers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:120'],
            'schedule_date' => ['required', 'date'],
            'schedule_time' => ['required', 'date_format:H:i'],
            'user_id' => [Rule::requiredIf($user->isAdmin()), 'nullable', 'integer', 'exists:users,id'],
        ]);

        // Pengajar hanya boleh membuat jadwal atas namanya sendiri.
        $ownerId = $user->isAdmin() ? (int) $validated['user_id'] : $user->id;

        $schedule = Schedule::create([
            'user_id' => $ownerId,
            'student_name' => trim($validated['student_name']),
            'schedule_date' => $validated['schedule_date'],
            'schedule_time' => $validated['schedule_time'],
        ]);

        return redirect()
            ->route('schedules.show', $schedule)
            ->with('status', 'Jadwal berhasil ditambahkan.');
    }

    public function show(Schedule $schedule): View
    {
        $this->authorizeSchedule($schedule);

        $schedule->load('user:id,name');

        return view('schedules.show', compact('schedule'));
    }

    public function update(Request $request, Schedule $schedule): RedirectResponse
    {
        $this->authorizeSchedule($schedule);

        $validated = $request->validate([
            'attendance' => ['required', Rule::in(['belum_absen', 'hadir', 'absen'])],
            'material_file' => [
                'nullable', 'file',
                'mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,mp3,wav,mp4',
                'max:20480', // 20 MB
            ],
        ]);

        $schedule->attendance = $validated['attendance'];

        if ($request->hasFile('material_file')) {
            $file = $request->file('material_file');

            $baseName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'materi';
            $storedName = Str::uuid().'_'.$baseName.'.'.$file->extension();

            if ($schedule->material_file && Storage::disk(self::DISK)->exists($schedule->material_file)) {
                Storage::disk(self::DISK)->delete($schedule->material_file);
            }

            $schedule->material_file = $file->storeAs('materials', $storedName, self::DISK);
        }

        $schedule->save();

        return redirect()
            ->route('schedules.show', $schedule)
            ->with('status', 'Absensi dan materi berhasil disimpan.');
    }

    /** Download materi: hanya lewat route terautentikasi, bukan URL file langsung. */
    public function download(Schedule $schedule): StreamedResponse
    {
        $this->authorizeSchedule($schedule);

        abort_if(
            ! $schedule->material_file || ! Storage::disk(self::DISK)->exists($schedule->material_file),
            404,
            'Materi belum diunggah.'
        );

        $downloadName = Str::after(basename($schedule->material_file), '_');

        return Storage::disk(self::DISK)->download($schedule->material_file, $downloadName);
    }

    public function destroy(Schedule $schedule): RedirectResponse
    {
        $this->authorizeSchedule($schedule);

        if ($schedule->material_file) {
            Storage::disk(self::DISK)->delete($schedule->material_file);
        }

        $schedule->delete();

        return redirect()
            ->route('schedules.index')
            ->with('status', 'Jadwal dihapus.');
    }

    private function authorizeSchedule(Schedule $schedule): void
    {
        $user = auth()->user();

        abort_unless($user->isAdmin() || $schedule->user_id === $user->id, 403);
    }
}

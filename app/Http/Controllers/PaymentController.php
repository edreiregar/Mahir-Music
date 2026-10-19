<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Support\Bulan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $payments = Payment::query()
            ->with('user:id,name')
            ->when(! $user->isAdmin(), fn ($q) => $q->where('user_id', $user->id))
            ->latest('id')
            ->paginate(15);

        return view('payments.index', compact('payments'));
    }

    public function create(): View
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        $teachers = User::query()->orderBy('name')->get(['id', 'name']);
        $months = Bulan::NAMES;

        return view('payments.create', compact('teachers', 'months'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()->role === 'admin', 403);

        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'student_name' => ['required', 'string', 'max:120'],
            'month' => ['required', Rule::in(array_keys(Bulan::NAMES))],
            'year' => ['required', 'integer', 'between:2020,2100'],
            'amount' => ['required', 'numeric', 'min:0', 'max:9999999999'],
        ]);

        $payment = Payment::create([
            'user_id' => $validated['user_id'],
            'student_name' => trim($validated['student_name']),
            'month_period' => Bulan::NAMES[(int) $validated['month']].' '.$validated['year'],
            'total_meetings' => 4,
            'status' => 'belum_bayar',
            'amount' => $validated['amount'],
        ]);

        return redirect()
            ->route('payments.show', $payment)
            ->with('status', 'Tagihan pembayaran berhasil dicatat.');
    }

    public function show(Payment $payment): View
    {
        $user = auth()->user();

        abort_unless($user->isAdmin() || $payment->user_id === $user->id, 403);

        $payment->load('user:id,name');
        $meetings = $payment->meetingSchedules();

        return view('payments.show', compact('payment', 'meetings'));
    }

    /**
     * Khusus admin. Admin memverifikasi bukti transfer dari WhatsApp secara manual,
     * lalu menekan "Approve Pembayaran". Non-admin => 403.
     */
    public function approve(int $id): RedirectResponse
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        $payment = Payment::findOrFail($id);

        if ($payment->isPaid()) {
            return redirect()
                ->route('payments.show', $payment)
                ->with('status', 'Pembayaran ini sudah berstatus Sudah Bayar.');
        }

        $payment->update(['status' => 'sudah_bayar']);

        return redirect()
            ->route('payments.show', $payment)
            ->with('status', 'Pembayaran disetujui. Nominal kini masuk ke total pendapatan.');
    }
}

<?php

namespace App\Models;

use App\Support\Bulan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'user_id', 'student_name', 'month_period', 'total_meetings', 'status', 'amount',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'total_meetings' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPaid(): bool
    {
        return $this->status === 'sudah_bayar';
    }

    /**
     * Rincian tanggal pertemuan: jadwal milik pengajar yang sama, murid yang sama,
     * pada bulan/tahun periode pembayaran ini.
     */
    public function meetingSchedules(): Collection
    {
        $period = Bulan::parse($this->month_period);

        if ($period === null) {
            return new Collection();
        }

        return Schedule::query()
            ->where('user_id', $this->user_id)
            ->whereRaw('LOWER(TRIM(student_name)) = ?', [mb_strtolower(trim($this->student_name))])
            ->whereYear('schedule_date', $period->year)
            ->whereMonth('schedule_date', $period->month)
            ->orderBy('schedule_date')
            ->orderBy('schedule_time')
            ->get();
    }
}

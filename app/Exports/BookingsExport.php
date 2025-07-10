<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookingsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $equipmentId;
    protected $userId;

    public function __construct($startDate = null, $endDate = null, $equipmentId = null, $userId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->equipmentId = $equipmentId;
        $this->userId = $userId;
    }

    public function collection()
    {
        $query = Booking::with(['equipment.category', 'user']);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        if ($this->equipmentId) {
            $query->where('equipment_id', $this->equipmentId);
        }

        if ($this->userId) {
            $query->where('user_id', $this->userId);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Kode Booking',
            'Tanggal Booking',
            'User',
            'Email User',
            'Alat',
            'Kategori',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Durasi (Hari)',
            'Harga per Hari (Rp)',
            'Total (Rp)',
            'Status',
            'Catatan',
        ];
    }

    public function map($booking): array
    {
        return [
            $booking->booking_code,
            $booking->created_at->format('d/m/Y H:i'),
            $booking->user->name,
            $booking->user->email,
            $booking->equipment->name,
            $booking->equipment->category->name,
            $booking->start_date->format('d/m/Y'),
            $booking->end_date->format('d/m/Y'),
            $booking->duration_days,
            number_format($booking->daily_rate, 0, ',', '.'),
            number_format($booking->total_amount, 0, ',', '.'),
            ucfirst($booking->status),
            $booking->notes ?: '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

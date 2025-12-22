<?php

namespace App\Exports;

use App\Models\Enrollment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class StudentEnrollmentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Enrollment::with(['student', 'course', 'batch', 'course.trainers'])
            ->orderBy('created_at', 'desc');

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', Carbon::parse($this->startDate)->startOfDay());
        }

        if ($this->endDate) {
            $query->whereDate('created_at', '<=', Carbon::parse($this->endDate)->endOfDay());
        }

        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Student Name',
            'Student Email',
            'Student Phone',
            'Course Title',
            'Course Status',
            'Batch Name',
            'Enrollment Status',
            'Progress (%)',
            'Enrolled Date',
            'Completed Date',
            'Assigned Trainers',
            'Created At',
        ];
    }

    /**
     * @param Enrollment $enrollment
     * @return array
     */
    public function map($enrollment): array
    {
        $trainers = $enrollment->course->trainers->pluck('name')->join(', ');
        
        return [
            $enrollment->id,
            $enrollment->student->name ?? 'N/A',
            $enrollment->student->email ?? 'N/A',
            $enrollment->student->phone ?? 'N/A',
            $enrollment->course->title ?? 'N/A',
            $enrollment->course->status ?? 'N/A',
            $enrollment->batch->name ?? 'N/A',
            $enrollment->status ?? 'N/A',
            $enrollment->progress_percentage ?? 0,
            $enrollment->enrolled_at ? Carbon::parse($enrollment->enrolled_at)->format('Y-m-d') : 'N/A',
            $enrollment->completed_at ? Carbon::parse($enrollment->completed_at)->format('Y-m-d') : 'N/A',
            $trainers ?: 'N/A',
            $enrollment->created_at ? Carbon::parse($enrollment->created_at)->format('Y-m-d H:i:s') : 'N/A',
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E0E0E0']]],
        ];
    }
}

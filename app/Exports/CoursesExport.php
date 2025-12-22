<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class CoursesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
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
        $query = Course::with(['trainers', 'batches', 'enrollments'])
            ->withCount(['enrollments', 'batches', 'videos', 'trainers'])
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
            'Course Title',
            'Description',
            'Status',
            'Start Date',
            'End Date',
            'Duration (Days)',
            'Price',
            'Total Enrollments',
            'Total Batches',
            'Total Videos',
            'Assigned Trainers',
            'Trainer Names',
            'Created At',
        ];
    }

    /**
     * @param Course $course
     * @return array
     */
    public function map($course): array
    {
        $trainerNames = $course->trainers->pluck('name')->join(', ');
        
        return [
            $course->id,
            $course->title ?? 'N/A',
            $course->description ?? 'N/A',
            $course->status ?? 'N/A',
            $course->start_date ? Carbon::parse($course->start_date)->format('Y-m-d') : 'N/A',
            $course->end_date ? Carbon::parse($course->end_date)->format('Y-m-d') : 'N/A',
            $course->duration_days ?? 0,
            $course->price ?? 0,
            $course->enrollments_count ?? 0,
            $course->batches_count ?? 0,
            $course->videos_count ?? 0,
            $course->trainers_count ?? 0,
            $trainerNames ?: 'N/A',
            $course->created_at ? Carbon::parse($course->created_at)->format('Y-m-d H:i:s') : 'N/A',
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

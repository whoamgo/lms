<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class InstructorsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
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
        $query = User::where('role', 'trainer')
            ->with(['assignedCourses'])
            ->withCount('assignedCourses')
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
            'Name',
            'Email',
            'Phone',
            'Status',
            'Total Assigned Courses',
            'Course Names',
            'Created At',
            'Last Login',
        ];
    }

    /**
     * @param User $instructor
     * @return array
     */
    public function map($instructor): array
    {
        $courseNames = $instructor->assignedCourses->pluck('title')->join(', ');
        
        return [
            $instructor->id,
            $instructor->name ?? 'N/A',
            $instructor->email ?? 'N/A',
            $instructor->phone ?? 'N/A',
            $instructor->status ?? 'N/A',
            $instructor->assigned_courses_count ?? 0,
            $courseNames ?: 'N/A',
            $instructor->created_at ? Carbon::parse($instructor->created_at)->format('Y-m-d H:i:s') : 'N/A',
            $instructor->last_login_at ? Carbon::parse($instructor->last_login_at)->format('Y-m-d H:i:s') : 'N/A',
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

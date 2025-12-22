<?php

namespace App\Exports;

use App\Models\CommunityQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class CommunityQueriesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
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
        $query = CommunityQuery::with(['student', 'assignedTrainer', 'course'])
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
            'Subject',
            'Question',
            'Answer',
            'Student Name',
            'Student Email',
            'Course Title',
            'Assigned Trainer',
            'Status',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * @param CommunityQuery $query
     * @return array
     */
    public function map($query): array
    {
        return [
            $query->id,
            $query->subject ?? 'N/A',
            $query->question ?? 'N/A',
            $query->answer ?? 'N/A',
            $query->student->name ?? 'N/A',
            $query->student->email ?? 'N/A',
            $query->course->title ?? 'N/A',
            $query->assignedTrainer->name ?? 'N/A',
            $query->status ?? 'N/A',
            $query->created_at ? Carbon::parse($query->created_at)->format('Y-m-d H:i:s') : 'N/A',
            $query->updated_at ? Carbon::parse($query->updated_at)->format('Y-m-d H:i:s') : 'N/A',
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

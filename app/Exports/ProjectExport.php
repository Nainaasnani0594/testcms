<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ProjectExport implements FromCollection, WithHeadings
{
    protected $project;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }
    public function collection()
    {
        return $this->project->tasks->map(function ($task) {
            return [
                'Deliverable' => $task->name,
                'UNIT' => $task->unit,
                'No. of Units' => $task->number_of_units,
                'Unit Price' => $task->unit_price,
                'Total Task Value' => $task->total_task_value,
                // Add other columns as needed
            ];
        });
    }
    public function headings(): array
    {
        return [
            'Deliverables & Tasks',
            'UNIT',
            'No. of Units',
            'Unit Price',
            'Total Task Value',
            // Add other headings as needed
        ];
    }
}

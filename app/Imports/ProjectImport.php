<?php

namespace App\Imports;
use App\Models\Project;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProjectImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            Project::updateOrCreate([
                'name' => $row['name'], 
            ], [
                'description' => $row['description'],
                'contract_value' => $row['contract_value'],
                'status' => $row['status'],               
            ]);
        }
    }
}

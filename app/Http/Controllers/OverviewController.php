<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Overview; 
use Inertia\Inertia;
use Log;

class OverviewController extends Controller
{
    public function index()
    {
        $overviews = Project::with(['groups.tasks']) 
            ->get()
            ->map(function ($project) {
                // Calculate contract value (sum of task prices)
                $contract_value = $project->groups->flatMap->tasks->sum('price');

                // Calculate work done (sum of task quantities)
                $work_done = $project->groups->flatMap->tasks->sum('quantity');

                // Determine status
                $status = $work_done >= $contract_value ? 'Done' : 'Work in Progress';

                return [
                    'id' => $project->id,
                    'project_name' => $project->project_name,
                    'contract_value' => $contract_value,
                    'work_done' => $work_done,
                    'country' => $project->contract_holder_country,
                    'phase' => $project->phase,
                    'therapeutic_area' => $project->therapeutic_area,
                    'status' => $status,
                ];
            });

        Log::info('Overviews data:', $overviews->toArray());

        return Inertia::render('Overview', [
            'overviews' => $overviews
        ]);
    }
}


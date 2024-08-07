<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Overview; // Add this line to import the model
use Inertia\Inertia;
use Log;
use Carbon\Carbon;

class OverviewController extends Controller
{
    public function index()
    {
        $overviews = Project::with(['groups.tasks']) // Load related groups and tasks
            ->get()
            ->map(function ($project) {
                // Calculate contract value (sum of task prices)
                $contract_value = $project->groups->flatMap->tasks->sum('price');

            // Calculate work done (sum of task quantities)
            $work_done = $project->groups->flatMap->tasks->sum('quantity');

            // Determine status based on the activities of each task
            $project_status = 'Work in Progress'; // Default status

            foreach ($project->groups as $group) {
                foreach ($group->tasks as $task) {
                    $sum_of_activities_before_current_month = $task->activities->sum(function ($activity) {
                        return Carbon::parse($activity->date)->lt(Carbon::now()->startOfMonth()) ? $activity->value : 0;
                    });

                    if ($sum_of_activities_before_current_month >= $task->quantity) {
                        $task->status = 'Task Done';
                    } else {
                        $task->status = 'WIP';
                    }

                    if ($task->status == 'WIP') {
                        $project_status = 'In Progress'; // Update project status if any task is still in progress
                    }
                }
            }

            return [
                'id' => $project->id,
                'project_name' => $project->project_name,
                'contract_value' => $contract_value,
                'work_done' => $work_done,
                'country' => $project->contract_holder_country,
                'phase' => $project->phase,
                'therapeutic_area' => $project->therapeutic_area,
                'status' => $project_status,
            ];
        });

        Log::info('Overviews data:', $overviews->toArray());

        return Inertia::render('Overview', [
            'overviews' => $overviews
        ]);
    }
}


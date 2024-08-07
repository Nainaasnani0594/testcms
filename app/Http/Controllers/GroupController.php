<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use Inertia\Inertia;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        $group = Group::create($request->validated());

        return redirect()->route('projects.show', $group->project_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }
    public function toggleFreezeMonth(Request $request, Group $group)
    {
        $month = $request->input('month');
    
        // Validate the month input
        if (!$month || !preg_match('/^\d{4}-\d{2}$/', $month)) {
            return response()->json(['error' => 'Invalid month format'], 400);
        }
    
        // Fetch and update frozen months
        $frozenMonths = $group->frozen_months ?? [];
        if (in_array($month, $frozenMonths)) {
            $frozenMonths = array_diff($frozenMonths, [$month]);
        } else {
            $frozenMonths[] = $month;
        }
    
        // Update the group's frozen months and save
        $group->frozen_months = array_values($frozenMonths);
        $group->save();
    
        return response()->json(['frozen_months' => $group->frozen_months]);
    }
     
}

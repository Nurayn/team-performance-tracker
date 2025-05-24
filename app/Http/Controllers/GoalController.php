<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoalRequest;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    protected array $middleware = [
        ['middleware' => 'permission:view goals', 'only' => ['index', 'show']],
        ['middleware' => 'permission:create goals', 'only' => ['create', 'store']],
        ['middleware' => 'permission:edit goals', 'only' => ['edit', 'update']],
        ['middleware' => 'permission:delete goals', 'only' => ['destroy']],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Goal::query()
            ->with(['user', 'team'])
            ->filter($request->only(['status', 'due_date']));

        // If user is not super admin, only show their team's goals
        if (!Auth::user()->isSuperAdmin()) {
            $query->where('team_id', Auth::user()->team_id);
        }

        $goals = $query->latest()->paginate(10);

        return view('goals.index', [
            'goals' => $goals,
            'statuses' => Goal::STATUSES,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('goals.create', [
            'statuses' => Goal::STATUSES,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GoalRequest $request)
    {
        $goal = Goal::create([
            'user_id' => Auth::id(),
            'team_id' => Auth::user()->team_id,
            ...$request->validated(),
        ]);

        return redirect()
            ->route('goals.index')
            ->with('success', 'Goal created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Goal $goal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Goal $goal)
    {
        return view('goals.edit', [
            'goal' => $goal,
            'statuses' => Goal::STATUSES,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GoalRequest $request, Goal $goal)
    {

        $goal->update($request->validated());

        return redirect()
            ->route('goals.index')
            ->with('success', 'Goal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Goal $goal)
    {

        $goal->delete();

        return redirect()
            ->route('goals.index')
            ->with('success', 'Goal deleted successfully.');
    }
}

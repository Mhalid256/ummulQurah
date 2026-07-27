<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\Project;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::with('project')->latest()->paginate(15);
        return view('admin.finance.budgets_index', compact('budgets'));
    }

    public function create()
    {
        return view('admin.finance.budget_form', ['budget' => new Budget(), 'projects' => Project::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        Budget::create($this->validated($request));
        return redirect()->route('admin.budgets.index')->with('success', 'Budget line created.');
    }

    public function edit(Budget $budget)
    {
        return view('admin.finance.budget_form', ['budget' => $budget, 'projects' => Project::orderBy('name')->get()]);
    }

    public function update(Request $request, Budget $budget)
    {
        $budget->update($this->validated($request));
        return redirect()->route('admin.budgets.index')->with('success', 'Budget updated.');
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();
        return back()->with('success', 'Budget removed.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'amount_allocated' => 'required|numeric|min:0',
            'fiscal_year' => 'required|string|max:9',
            'status' => 'required|in:draft,approved,closed',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\Expense;
use App\Models\Project;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = Expense::with(['budget', 'project'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest('expense_date')
            ->paginate(15)
            ->withQueryString();

        return view('admin.finance.expenses_index', compact('expenses'));
    }

    public function create()
    {
        return view('admin.finance.expense_form', [
            'expense' => new Expense(),
            'budgets' => Budget::orderBy('title')->get(),
            'projects' => Project::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['submitted_by'] = auth()->id();

        if ($request->hasFile('receipt_path')) {
            $data['receipt_path'] = $request->file('receipt_path')->store('receipts', 'public');
        }

        Expense::create($data);

        return redirect()->route('admin.expenses.index')->with('success', 'Expense submitted for approval.');
    }

    public function approve(Expense $expense)
    {
        $expense->update(['status' => 'approved', 'approved_by' => auth()->id()]);
        return back()->with('success', 'Expense approved.');
    }

    public function reject(Expense $expense)
    {
        $expense->update(['status' => 'rejected', 'approved_by' => auth()->id()]);
        return back()->with('success', 'Expense rejected.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return back()->with('success', 'Expense removed.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'budget_id' => 'nullable|exists:budgets,id',
            'project_id' => 'nullable|exists:projects,id',
            'category' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'vendor' => 'nullable|string|max:255',
            'receipt_path' => 'nullable|file|max:5120',
        ]);
    }
}

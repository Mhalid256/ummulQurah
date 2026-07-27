<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\InventoryTransaction;
use App\Models\Project;
use Illuminate\Http\Request;

class InventoryTransactionController extends Controller
{
    public function index(InventoryItem $item)
    {
        $transactions = $item->transactions()->latest('transaction_date')->paginate(20);
        return view('admin.inventory.transactions', compact('item', 'transactions'));
    }

    public function store(Request $request, InventoryItem $item)
    {
        $data = $request->validate([
            'type' => 'required|in:stock_in,stock_out,adjustment',
            'quantity' => 'required|numeric|min:0.01',
            'reference' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
            'project_id' => 'nullable|exists:projects,id',
            'notes' => 'nullable|string',
        ]);

        $data['inventory_item_id'] = $item->id;
        $data['recorded_by'] = auth()->id();

        InventoryTransaction::create($data);

        return back()->with('success', 'Stock movement recorded.');
    }
}

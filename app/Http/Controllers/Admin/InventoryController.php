<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $items = InventoryItem::latest()->paginate(15);
        return view('admin.inventory.index', compact('items'));
    }

    public function create()
    {
        return view('admin.inventory.form', ['item' => new InventoryItem()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['sku'] = $data['sku'] ?: 'SKU-' . strtoupper(uniqid());

        InventoryItem::create($data);

        return redirect()->route('admin.inventory.index')->with('success', 'Inventory item created.');
    }

    public function edit(InventoryItem $item)
    {
        return view('admin.inventory.form', compact('item'));
    }

    public function update(Request $request, InventoryItem $item)
    {
        $item->update($this->validated($request));
        return redirect()->route('admin.inventory.index')->with('success', 'Inventory item updated.');
    }

    public function destroy(InventoryItem $item)
    {
        $item->delete();
        return back()->with('success', 'Inventory item removed.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'sku' => 'nullable|string|max:100',
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'unit' => 'required|string|max:50',
            'reorder_level' => 'required|numeric|min:0',
            'unit_cost' => 'required|numeric|min:0',
            'warehouse' => 'nullable|string|max:255',
            'status' => 'required|in:active,discontinued',
        ]);
    }
}

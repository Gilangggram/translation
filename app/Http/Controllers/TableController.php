<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Order;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display tables in admin dashboard context.
     */
    public function adminIndex()
    {
        $orders = Order::with(['customer', 'table', 'orderItems.menu'])
            ->orderBy('created_at', 'desc')
            ->get();
        $tables = Table::all();
        $activeTab = 'tables';

        return view('admin.dashboard', compact('orders', 'tables', 'activeTab'));
    }

    /**
     * Store a newly created table.
     */
    public function store(Request $request)
    {
        $request->validate([
            'table_number' => 'required|string|unique:tables,table_number',
        ]);

        Table::create([
            'table_number' => $request->table_number,
            'is_available' => true,
        ]);

        return redirect()->route('admin.tables')->with('success', 'Meja ' . $request->table_number . ' berhasil ditambahkan.');
    }

    /**
     * Toggle the availability of a table.
     */
    public function toggleAvailability(Request $request, $id)
    {
        $table = Table::findOrFail($id);
        $table->is_available = !$table->is_available;
        $table->save();

        return back()->with('success', 'Status ketersediaan Meja ' . $table->table_number . ' berhasil diperbarui.');
    }

    /**
     * Remove the specified table.
     */
    public function destroy($id)
    {
        $table = Table::findOrFail($id);
        $table->delete();

        return back()->with('success', 'Meja ' . $table->table_number . ' berhasil dihapus.');
    }
}

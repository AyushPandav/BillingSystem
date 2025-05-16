<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        return view('billing');
    }

    public function history()
    {
        $bills = Bill::with('items')->latest()->get();
        return view('history', compact('bills'));
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        $bill = Bill::create(['total' => $validated['total']]);

        foreach ($validated['items'] as $item) {
            $bill->items()->create([
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['quantity'] * $item['price'],
            ]);
        }

        return response()->json(['message' => 'Bill saved successfully']);
    }
}

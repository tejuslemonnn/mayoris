<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {

        $sales = Sales::paginate(10);
        return view('pages.sales.index', [
            'sales' => $sales,
        ]);
    }

    public function create()
    {
        return view('pages.sales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            "date" => ['required'],
            "omset" => ['required'],
            "sold" => ['required'],
            "user_id" => ['required'],
        ]);

        $data = $request->all();


        Sales::create($data);

        $user = User::find(auth()->user()->id);

        $user->update([
            'omset' => $user->omset += $data['omset'],
            'profit' => $user->profit += $data['omset'],
        ]);

        return redirect()->route('sales')->with('success', 'Sale created successfully.');
    }

    public function delete($id)
    {
        $sale = Sales::find($id);

        $user = User::find(auth()->user()->id);
        
        $user->update([
            'profit'=>  $user->profit -= $sale->omset,
            'omset'=>  $user->omset -= $sale->omset,
        ]);

        $sale->delete();

        return redirect()->route('sales')->with('success', 'Sale deleted successfully.');;
    }

    public function edit($id)
    {
        $sale = Sales::find($id);

        return view('pages.sales.detail', [
            'sale' => $sale
        ]);
    }

    public function update($id, Request $request)
    {
        $sale = Sales::find($id);

        $request->validate([
            "date" => ['required'],
            "omset" => ['required'],
            "sold" => ['required'],
        ]);

        $data = $request->all();

        $sale->update($data);

        return redirect()->route('sales')->with('success', 'Sale deleted successfully.');;
    }
}

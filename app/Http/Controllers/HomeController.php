<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sales;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class HomeController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $latestPengeluaran  = Pengeluaran::latest('created_at')->first();
        $omset  = Sales::all();

        $omsetByMonth = $omset->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('F');
        });

        $produkTerjual = 0;

        foreach ($omset as $key => $value) {
            $produkTerjual = $value->sold += $produkTerjual;
        }

        return view('pages.dashboard', [
            'latestPengeluaran' => $latestPengeluaran,
            'omset' => $omset,
            'produkTerjual' => $produkTerjual,
            'latestOmset' => $omset->last(),
            'omsetByMonth' => $omsetByMonth,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pengeluaran;
use App\Http\Requests\StorePengeluaranRequest;
use App\Http\Requests\UpdatePengeluaranRequest;
use App\Models\PengeluaranDetail;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengeluarans = Pengeluaran::paginate(10);

        return view('pages.pengeluaran.index', [
            'pengeluarans' => $pengeluarans
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.pengeluaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            "date" => ['required'],
            "total" => ['required'],
            "user_id" => ['required'],
            "nama.*" => ['required'],
            "kategori.*" => ['required'],
            "harga.*" => ['required'],
        ]);

        // Create the Pengeluaran model
        $pengeluaran = Pengeluaran::create([
            'user_id' => auth()->user()->id,
            'date' => $request->input('date'),
            'total' => $request->input('total'),
        ]);

        foreach ($request->input('nama') as $key => $nama) {
            $data = [
                'pengeluaran_id' => $pengeluaran->id,
                'nama' => $request->input('nama')[$key],
                'kategori' => $request->input('kategori')[$key],
                'harga' => $request->input('harga')[$key],
            ];

            if ($request->input('kategori')[$key] == "Beli Bahan") {
                foreach ($request->input('jumlah') as $key => $jumlah) {
                    $data['jumlah'] = $request->input('jumlah')[$key];
                    $data['satuan'] = $request->input('satuan')[$key];
                }
            }

            PengeluaranDetail::create($data);
        }

        $user = User::find(auth()->user()->id);

        $user->update([
            'profit' => $user->profit -=  $request->input('total'),
        ]);

        // Redirect or perform additional actions as needed
        return redirect()->route('pengeluaran')->with('success', "Pengeluaran berhasil dibuat.");
    }

    /**
     * Display the specified resource.
     */
    public function edit($id)
    {
        $pengeluaran = Pengeluaran::with("pengeluaranDetails")->find($id);

        return view('pages.pengeluaran.detail', [
            'pengeluaran' => $pengeluaran
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $validateData = $request->validate([
            "date" => ['required'],
            "total" => ['required'],
            "nama.*" => ['required'],
            "kategori.*" => ['required'],
            "harga.*" => ['required'],
        ]);

        $pengeluaran = Pengeluaran::find($id);

        $user = User::find(auth()->user()->id);

        $profit = ($user->profit + $pengeluaran->total) - $request->input('total');

        // dd($profit);

        $user->update([
            'profit' => $profit,
        ]);

        $pengeluaran->update([
            'user_id' => auth()->user()->id,
            'date' => $request->input('date'),
            'total' => $request->input('total'),
        ]);

        PengeluaranDetail::where('pengeluaran_id', $id)->delete();

        foreach ($request->input('nama') as $key => $nama) {
            $data = [
                'pengeluaran_id' => $pengeluaran->id,
                'nama' => $request->input('nama')[$key],
                'kategori' => $request->input('kategori')[$key],
                'harga' => $request->input('harga')[$key],
            ];

            if ($request->input('kategori')[$key] == "Beli Bahan") {
                foreach ($request->input('jumlah') as $key => $jumlah) {
                    $data['jumlah'] = $request->input('jumlah')[$key];
                    $data['satuan'] = $request->input('satuan')[$key];
                }
            }

            PengeluaranDetail::create($data);
        }

        return redirect()->route('pengeluaran')->with('success', "Pengeluaran berhasil dibuat.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::find($id);

        $user = User::find(auth()->user()->id);
        
        $user->update([
            'profit'=>  $user->profit += $pengeluaran->total,
        ]);
        
        $pengeluaran->delete();

        return redirect()->route('pengeluaran')->with('success', "Pengeluaran berhasil dihapus.");
    }
}

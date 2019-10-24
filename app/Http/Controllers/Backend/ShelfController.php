<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Shelf;
use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ShelfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = Warehouse::orderBy('id', 'ASC')->get();
        $shelves = Shelf::orderBy('id', 'ASC')->get();
        return view('backend.shelves.index', compact('warehouses', 'shelves'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'warehouse_id' => 'required|numeric|exists:warehouses,id',
            'name' => 'required|string|unique:shelves'
        ]);

        try {
            $shelves = Shelf::firstOrCreate([
                'warehouse_id' => $request->warehouse_id,
                'name' => $request->name
            ]);

            session()->flash('success', 'Data Rak Penyimpanan di-Tambahkan!');
            return redirect(route('rak.index'));
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan ! Error ('.$e.') ');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $crypt = $this->Crypt($id);

        try {
            $edit = Shelf::findOrFail($crypt);
            $shelves = Shelf::orderBy('id', 'ASC')->get();

            return view('backend.shelves.index', compact('edit', 'shelves'));
        } catch (\Exception $e) {
            session()->flash('success', 'Terjadi Kesalahan ! Error ('.$e.')');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'warehouse_id' => 'required|numeric|exists:warehouses,id',
            'name' => 'required|string|unique:shelves'
        ]);

        $crypt = $this->Crypt($id);

        try {
            $shelves = Shelf::findOrFail($crypt);
            $shelves->update([
                'warehouse_id' => $request->warehouse_id,
                'name' => $request->name
            ]);

            session()->flash('success', 'Data Rak Penyimpanan di-Ubah !');
            return redirect(route('rak.index'));
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan !');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function Crypt($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
            return $decrypted;
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
}

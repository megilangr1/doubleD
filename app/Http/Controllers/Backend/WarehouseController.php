<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = Warehouse::orderBy('id', 'ASC')->get();
        return view('backend.warehouse.index', compact('warehouses'));
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
            'name' => 'required|string|unique:warehouses'
        ]);

        try {
            $warehouses = Warehouse::firstOrCreate([
                'name' => $request->name
            ]);

            session()->flash('success', 'Data Gudang di-Tambahkan !');

            return redirect(route('gudang.index'));
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan! Error ('.$e.')');
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
            $edit = Warehouse::findOrFail($crypt);
            $warehouses = Warehouse::orderBy('id', 'ASC')->get();

            return view('backend.warehouse.index', compact('warehouses', 'edit'));
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan ! Error ('.$e.')');
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
            'name' => 'required|string|unique:warehouses',
        ]);

        $crypt = $this->Crypt($id);
        try {
            $warehouses = Warehouse::findOrFail($crypt);
            $warehouses->update([
                'name' => $request->name
            ]);

            session()->flash('success', 'Data Gudang di-Ubah!');
            return redirect(route('gudang.index'));
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan ! Error ('.$e.')');
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
        $crypt = $this->Crypt($id);

        try {
            $warehouse = Warehouse::findOrFail($crypt);
            $warehouse->delete();

            session()->flash('success', 'Data Gudang di-Hapus!');
            return redirect(route('gudang.index'));
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan ! Error ('.$e.')');
            return redirect()->back();
        }
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

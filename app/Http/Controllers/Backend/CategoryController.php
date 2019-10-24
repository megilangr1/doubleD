<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'ASC')->get();
        return view('backend.categories.index', compact('categories'));
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
            'name' => 'required|string|unique:categories'
        ]);


        try {
            $categories = Category::firstOrCreate([
                'name' => $request->name
            ]);

            session()->flash('success', 'Kategori di-Tambahkan !');

            return redirect(route('kategori.index'));
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan ! Error ('.$e.')');
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
            $edit = Category::findOrFail($crypt);
            $categories = Category::orderBy('id', 'ASC')->get();
            return view('backend.categories.index', compact('categories', 'edit'));
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan ! Error ('.$e.')');
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
            'name' => 'required|string|unique:categories'
        ]);

        $crypt = $this->Crypt($id);

        try {
            $categories = Category::findOrFail($crypt);
            $categories->update([
                'name' => $request->name
            ]);

            session()->flash('success', 'Kategori di-Ubah !');
            return redirect(route('kategori.index'));

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
            $categories = Category::findOrFail($crypt);
            $categories->delete();

            session()->flash('success', 'Kategori di-Hapus !');

            return redirect(route('kategori.index'));
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan ! Error: ('.$e.')');
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

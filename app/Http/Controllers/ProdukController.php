<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::with('kategori')->get(); 
        return response()->json($produk);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdukRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'kategori_id' => 'required|min:1|integer|exists:kategori,id',
            'price' => 'required|min:1|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Gagal',
                'message' => $validator->errors(),
            ], 400);
        }

        $produk = Produk::create([
            'name' => $request->name,
            'kategori_id' => $request->kategori_id,
            'price' => $request->price,
        ]);

        return response()->json([
            'status' => 'Berhasil',
            'message' => 'Produk berhasil dibuat',
            'data' => ['produk' => $produk]
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdukRequest $request, $id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Produk tidak ditemukkan',
            ], 400);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'kategori_id' => 'required|min:1|integer|exists:kategori,id',
            'price' => 'required|min:1|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Gagal',
                'message' => $validator->errors(),
            ], 400);
        }

        $produk->update([
            'name' => $request->name,
            'kategori_id' => $request->kategori_id,
            'price' => $request->price,
        ]);

        return response()->json([
            'status' => 'Berhasil',
            'message' => 'Produk berhasil diperbaharui',
            'data' => ['produk' => $produk]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Produk tidak ditemukkan'
            ], 400);
        }
        if ($produk->order()->exists()) {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Tidak dapat menghapus produk karena masih memiliki data order'
            ], 400);
        }
        $produk->delete();
        return response()->json([
            'status' => 'Berhasil',
            'message' => 'Produk berhasil dihapus'
        ], 200);
    }
}

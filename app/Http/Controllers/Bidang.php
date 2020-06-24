<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Bidang extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $belum = \App\Komentar::where('admin_verified', 'no')->count();

        return view('admin.bidang', ['belum' => $belum]);
    }

    public function store(Request $request)
    {
        $validasi = $this->validate($request, [
            'nama_bidang' => 'required'
        ],[
            'nama_bidang.required' => 'nama bidang harus terisi'
        ]);

        $data = new \App\Bidang;
        $data->nama = $request->nama_bidang;
        $data->save();

        return $arrayName = array('status' => 'success' , 'pesan' => 'Berhasil Menambah Data' );
    }

    public function update(Request $request, $id)
    {
        $validasi = $this->validate($request, [
            'nama_bidang' => 'required'
        ],[
            'nama_bidang.required' => 'nama bidang harus terisi'
        ]);

        $data = \App\Bidang::findOrFail($id);
        $data->nama = $request->nama_bidang;
        $data->save();

        return $arrayName = array('status' => 'success' , 'pesan' => 'Berhasil Mengubah Data' );
    }

    public function destroy($id)
    {
        $data = \App\Bidang::findOrFail($id);
        $data->delete();

        return $arrayName = array('status' => 'success' , 'pesan' => 'Berhasil Menghapus Data' );

    }
}

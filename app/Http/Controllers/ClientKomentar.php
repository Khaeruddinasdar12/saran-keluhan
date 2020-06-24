<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientKomentar extends Controller
{
    public function store(Request $request)
    {	
    	$validasi = $this->validate($request, [
            'pesan' => 'required',
            'bidang_id' => 'required'
        ],[
        	'bidang_id.required' => 'Wajib memilih bagian/departmen',
        	'pesan.required' => 'Kolom pesan harus terisi'
        	
        ]);

    	$data = new \App\Komentar;
    	$data->nama 	= $request->nama;
    	$data->email 	= $request->email;
    	$data->nohp 	= $request->nohp;
    	$data->alamat 	= $request->alamat;
    	$data->jenis_kelamin = $request->jkel;
    	$data->bidang_id = $request->bidang_id;
    	$data->pesan = $request->pesan;
    	$data->admin_verified = 'no';
    	$data->save();

    	return $arrayName = array('status' => 'success' , 'pesan' => 'Berhasil Mengirim Pesan' );
    }
}

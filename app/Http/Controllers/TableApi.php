<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

class TableApi extends Controller
{
    public function test()
    {
        // $data  = array(
        //     'name' => 'Angelica Akiang',
        //     'pesan'=> 'Terima Kasih telah memberikan saran kepada kami. kami akan segera meninjau departmen kami sesuai dengan komentar Anda');

        return view('feedback', ['name' => 'Angelica Akiang', 'pesan' => 'Terima Kasih telah memberikan saran kepada kami. kami akan segera meninjau departmen kami sesuai dengan komentar Anda.', 'bidang' => ' 
Bidang Pemasaran Bisnis 1']);
    }


    public function komentar()
    {
        $data = \App\Komentar::all();

        return $data;
    }

    public function detail_komentar($id)
    {
        $data = \App\Komentar::find($id);

        return $data;
    }
    public function tabel_komentar_terbaca()
    {
    	$data = \App\Komentar::select('id', 'nama', 'email')->where('admin_verified', '=', 'yes')->get();

        // return $data;
    	return Datatables::of($data)
        ->addColumn('status', function () {
        return " <span class='badge badge-warning'> Terbaca </span>";
        })
    	->addColumn('action', function ($data) {
        return "
                <button class='btn btn-outline-info btn-xs'
                        title='Detail Komentar' id='detail'
                        href='".$data->id."/detail'
                        data-id='".$data->id."' onclick='detail()'>
                        <i class='fa fa-eye'></i>
                </button>

                <button class='btn btn-outline-danger btn-xs' title='Hapus Data' id='del_id' 
                        href='".$data->id."' onclick='hapus()'>
                        <i class='fa fa-trash'></i>
                </button>";
        })
        ->rawColumns(['status', 'action'])
        ->addIndexColumn() 
        ->make(true);
    	// return view('admin.dashboard');
    }

    public function tabel_komentar_belum_dibaca()
    {
        $data = \App\Komentar::select('id', 'nama', 'email')->where('admin_verified', '=', 'no')->get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
        return "<button class='btn btn-outline-info btn-xs'
                        title='Detail & Reply' id='detail'
                        href='".$data->id."/detail'
                        data-id='".$data->id."' onclick='detail()'>
                        <i class='fa fa-eye'></i>
                </button>";
        })
        ->addIndexColumn() 
        ->make(true);
    }

    public function bidang()
    {
        $data = \App\Bidang::select('id', 'nama')->get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
        return "<button class='btn btn-outline-info btn-xs'
                        title='Edit Departmen' data-toggle='modal' data-target='#modal-edit' 
                        data-id_bidang='".$data->id."' data-nama='".$data->nama."'>
                        <i class='fa fa-pen'></i>
                </button>

                <button class='btn btn-outline-danger btn-xs' title='Hapus Departmen' id='del_bidang' href='manage-bidang/".$data->id."' onclick='hapus()'>
                        <i class='fa fa-trash'></i>
                </button>";
        })
        ->addIndexColumn() 
        ->make(true);
    }

    public function detail($id)
    {
    	$data = \App\Komentar::where('id', $id)->with('bidang:id,nama')->first();
        return $data;
// return $data->id;
    	// return $data->created_at->format('Y-m-d');
    	if($data->jenis_kelamin == 'P'){
    		$jkel = 'Perempuan';
    	} else {
    		$jkel = 'Laki-laki';
    	}
    	 $arrayName = 
    		array(
                'id' =>$data->id,
    			'nama' => $data->nama,
    			'email' => $data->email,
    			'nohp' => $data->nohp,
    			'alamat' => $data->alamat,
    			'jkel' => $jkel,
    			'pesan' => $data->pesan,
    			'waktu' => $data->created_at->format('Y-m-d'),
    			'bidang' => $data->bidang->nama
    		);

    	return response()->json($arrayName);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
class Komentar extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() 
    {
        $all = \App\Komentar::count();

        $belum = \App\Komentar::where('admin_verified', 'no')->count();
        $terbaca = \App\Komentar::where('admin_verified', 'yes')->count();
        $bidang = \App\Bidang::count();
        // return $terbaca;

    	return view('admin.dashboard',['all' => $all, 'belum' => $belum, 'terbaca' => $terbaca, 'bidang' => $bidang]);
    }

    public function komentar_terbaca()
    {
        $belum = \App\Komentar::where('admin_verified', 'no')->count();
    	return view('admin.komentar_terbaca', ['belum' => $belum]);
    }

    public function komentar_belumterbaca()
    {
        $belum = \App\Komentar::where('admin_verified', 'no')->count();
        return view('admin.komentar_belumterbaca', ['belum' => $belum]);
    }

    

    public function feedback(Request $request)
    {
        // return $request;
        $data = \App\Komentar::findOrFail($request->id);

        if($data->email == '') {
            $data->admin_verified = 'yes';
            $data->save();
            return $arrayName = array('status' => 'success' , 'pesan' => 'Berhasil baca data');
        } else {
            if($data->nama != '') {
                $nama = $data->nama;
            } else {
                $nama = "Sahabat Mib-Ade'Pitue";
            }
            $email = $data->email;
            $judul= $request->judul;
            
            $data_send = array(
                    'name' => $nama,
                    'pesan' => $request->pesan,
                    'bidang' => $data->bidang->nama
                );

            Mail::send('feedback', $data_send, function($mail) use($email, $judul) {
                    $mail->to($email, 'no-reply')
                    ->subject($judul);
                    $mail->from('mibadepituedp@gmail.com', "Mib-Ade'Pitue");        
                });
                if (Mail::failures()) {
                    return $arrayName = array('status' => 'error' , 'pesan' => 'Gagal menigirim email' );
                }
            
        }
        $data->admin_verified = 'yes';
        $data->save();
        return $arrayName = array('status' => 'success' , 'pesan' => 'Berhasil, email terkirim ke '.$nama );
    }

    public function delete($id) 
    {
    	$data = \App\Komentar::find($id);
    	$data->delete();

    	return $arrayName = array('status' => 'success' , 'pesan' => 'Berhasil Menghapus Data' );
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class KaryawanController extends Controller
{
    public function index(Request $request){

        $query = Karyawan::query();
        $query->select('karyawan_bkkpgk.*', 'namawilker');
        $query->join('wilayah_kerja', 'karyawan_bkkpgk.kodewilker', '=', 'wilayah_kerja.kodewilker');
        $query->orderBy('nama_lengkap');
        if(!empty($request->nama_karyawan)){
            $query->where('nama_lengkap','like','%'.$request->nama_karyawan.'%');
        }
        if(!empty($request->kodewilker)){
            $query->where('karyawan_bkkpgk.kodewilker', $request->kodewilker);
        }
        $karyawan = $query->paginate(25);


        $wilker = DB::table('wilayah_kerja')->get();
        return view('karyawan.index', compact('karyawan', 'wilker'));
    }

    public function store(Request $request){
        $nik = $request->nik;
        $username = $request->username;
        $nama_lengkap = $request->nama_lengkap;
        $pangkat = $request->pangkat;
        $jabatan = $request->jabatan;
        $ket = $request->ket;
        $password =  Hash::make('bkkpgk2024');
        $kodewilker = $request->kodewilker;

        try {
            $data = [
                "nik" => $nik,
                "username" => $username,
                "nama_lengkap" => $nama_lengkap,
                "pangkat" => $pangkat,
                "jabatan" => $jabatan,
                "ket" => $ket,
                "password" => $password,
                "kodewilker" => $kodewilker,
            ];
            $simpan = DB::table('karyawan_bkkpgk')->insert($data);
            if($simpan){
                return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
            }
        } catch (\Exception $e) {
            //dd($e);
            if($e->getCode() == 23000){
                $message ="(Data dengan NIP ".$nik." atau Username ".$username." sudah ada, periksa kembali)";
            }
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan '.$message]);
        }
    }

    public function edit(Request $request){
        $nik = $request->nik;
        $wilker = DB::table('wilayah_kerja')->get();
        $karyawan = DB::table('karyawan_bkkpgk')->where('nik', $nik)->first();
        return view('karyawan.edit', compact('wilker', 'karyawan'));
    }

    public function update($nik, Request $request){
        $nik = $request->nik;
        $username = $request->username;
        $nama_lengkap = $request->nama_lengkap;
        $pangkat = $request->pangkat;
        $jabatan = $request->jabatan;
        $ket = $request->ket;
        $password =  $request->password;
        $kodewilker = $request->kodewilker;

        try {
            $data = [
                "username" => $username,
                "nama_lengkap" => $nama_lengkap,
                "pangkat" => $pangkat,
                "jabatan" => $jabatan,
                "ket" => $ket,
                "password" => $password,
                "kodewilker" => $kodewilker,
            ];
            $update = DB::table('karyawan_bkkpgk')->where('nik',$nik)->update($data);
            if($update){
                return Redirect::back()->with(['success' => 'Update Data Berhasil']);
            }
        } catch (\Exception $e) {
            //dd($e);
            return Redirect::back()->with(['warning' => 'Update Data Gagal']);
        }
    }

    public function delete($nik){
        $delete = DB::table('karyawan_bkkpgk')->where('nik',$nik)->delete();
        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }
}

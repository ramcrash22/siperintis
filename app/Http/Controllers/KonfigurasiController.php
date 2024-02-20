<?php

namespace App\Http\Controllers;

use App\Models\Jamkerja;
use App\Models\Setjamkerja;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
    public function lokasikantor(){
        $lok_kantor = DB::table('konfigurasi_lokasi')
        ->where('id',1)
        ->first();
        return view('konfigurasi.lokasikantor', compact('lok_kantor'));
    }

    public function updatelokasikantor(Request $request){
        $lokasi_kantor = $request->lokasi_kantor;
        $radius = $request->radius;

        $update = DB::table('konfigurasi_lokasi')
        ->where('id',1)
        ->update([
            'lokasi_kantor' => $lokasi_kantor,
            'radius' => $radius
        ]);

        if($update){
            return Redirect::back()->with(['success'=>'Data Berhasil Diupdate']);
        }else{
            return Redirect::back()->with(['warning'=>'Data Gagal Diupdate']);
        }
    }

    public function jamkerja(Request $request){
        //$jam_kerja = DB::table('jam_kerja')->orderBy('kode_jam_kerja')->get();
        //return view('konfigurasi.jamkerja', compact('jam_kerja'));
        $nama_jam_kerja = $request->nama_jam_kerjacari;
        $query = Jamkerja::query();
        $query->select('*');
        if(!empty($nama_jam_kerja)){
            $query->where('nama_jam_kerja', 'like','%'.$nama_jam_kerja.'%');
        }
        $jam_kerja = $query->orderBy('kode_jam_kerja')->get();
        return view('konfigurasi.jamkerja', compact('jam_kerja'));
    }

    public function jamkerjastore(Request $request){
        $kode_jam_kerja = $request->kode_jam_kerja;
        $nama_jam_kerja = $request->nama_jam_kerja;
        $awal_jam_masuk = $request->awal_jam_masuk;
        $jam_in = $request->jam_masuk;
        $akhir_jam_masuk = $request->akhir_jam_masuk;
        $jam_out = $request->jam_pulang;
        $akhir_jam_pulang = $request->akhir_jam_pulang;
        $data = [
            'kode_jam_kerja' => $kode_jam_kerja,
            'nama_jam_kerja' => $nama_jam_kerja,
            'awal_jam_masuk' => $awal_jam_masuk,
            'jam_in' => $jam_in,
            'akhir_jam_masuk' => $akhir_jam_masuk,
            'jam_out' => $jam_out,
            'akhir_jam_pulang' => $akhir_jam_pulang
        ];

        $cek = DB::table('jam_kerja')->where('kode_jam_kerja', $kode_jam_kerja)->count();
        if($cek>0){
            return Redirect::back()->with(['warning'=>'Data dengan nama '.$nama_jam_kerja.' sudah ada.']);
        }

        $simpan = DB::table('jam_kerja')->insert($data);
        if ($simpan) {
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function editjamkerja(Request $request){
        $kode_jam_kerja = $request->kode_jam_kerja;
        $jam_kerja = DB::table('jam_kerja')->where('kode_jam_kerja',$kode_jam_kerja)->first();
        return view('konfigurasi.editjamkerja',compact('jam_kerja'));
    }

    public function updatejamkerja($kode_jam_kerja, Request $request){
        $nama_jam_kerja = $request->nama_jam_kerja;
        $awal_jam_masuk = $request->awal_jam_masuk;
        $jam_in = $request->jam_masuk;
        $akhir_jam_masuk = $request->akhir_jam_masuk;
        $jam_out = $request->jam_pulang;
        $akhir_jam_pulang = $request->akhir_jam_pulang;
        $data = [
            'nama_jam_kerja' => $nama_jam_kerja,
            'awal_jam_masuk' => $awal_jam_masuk,
            'jam_in' => $jam_in,
            'akhir_jam_masuk' => $akhir_jam_masuk,
            'jam_out' => $jam_out,
            'akhir_jam_pulang' => $akhir_jam_pulang
        ];

        $update = DB::table('jam_kerja')->where('kode_jam_kerja', $kode_jam_kerja)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    public function deletejamkerja($kode_jam_kerja){
        $hapus = DB::table('jam_kerja')->where('kode_jam_kerja',$kode_jam_kerja)->delete();
        if($hapus){
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function setjamkerja($nik){
        $karyawan = DB::table('karyawan_bkkpgk')->where('nik', $nik)->first();
        $jamkerja = DB::table('jam_kerja')->orderBy('nama_jam_kerja')->get();

        $cekjamkerja = DB::table('konfigurasi_jamkerja')->where('nik', $nik)->count();

        if($cekjamkerja>0){
            $setjamkerja = DB::table('konfigurasi_jamkerja')->where('nik', $nik)->get();
            return view('konfigurasi.editsetjamkerja', compact('karyawan', 'jamkerja', 'setjamkerja'));
        }else{
            return view('konfigurasi.setjamkerja', compact('karyawan', 'jamkerja'));
        }
    }

    public function storesetjamkerja(Request $request){
        $nik = $request->nik;
        $hari = $request->hari;
        $kode_jam_kerja = $request->kode_jam_kerja;

        for($i=0; $i<count($hari); $i++){
            $data[] = [
                'nik' => $nik,
                'hari' => $hari[$i],
                'kode_jam_kerja' => $kode_jam_kerja[$i]
            ];
        }

        try{
            Setjamkerja::insert($data);
            return redirect('/konfigurasi/'.$nik.'/setjamkerja')->with(['success' => 'Jam Kerja Berhasil di Setting']);
        } catch(\Throwable $e){
            return redirect('/konfigurasi/'.$nik.'/setjamkerja')->with(['warning' => 'Jam Kerja Gagal di Setting']);
        }
    }

    public function updatesetjamkerja(Request $request){
        $nik = $request->nik;
        $hari = $request->hari;
        $kode_jam_kerja = $request->kode_jam_kerja;

        for($i=0; $i<count($hari); $i++){
            $data[] = [
                'nik' => $nik,
                'hari' => $hari[$i],
                'kode_jam_kerja' => $kode_jam_kerja[$i]
            ];
        }

        DB::beginTransaction();
        try{
            DB::table('konfigurasi_jamkerja')->where('nik',$nik)->delete();
            Setjamkerja::insert($data);
            DB::commit();
            return redirect('/konfigurasi/'.$nik.'/setjamkerja')->with(['success' => 'Jam Kerja Berhasil di Update']);
        } catch(\Throwable $e){
            DB::rollBack();
            return redirect('/konfigurasi/'.$nik.'/setjamkerja')->with(['warning' => 'Jam Kerja Gagal di Update']);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pengajuanizin;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PresensiController extends Controller
{
    public function gethari(){
        $hari = date("D");

        switch($hari){
            case 'Sun' :
                $hari_ini = "Minggu";
                break;

            case 'Mon' :
                $hari_ini = "Senin";
                break;

            case 'Tue' :
                $hari_ini = "Selasa";
                break;

            case 'Wed' :
                $hari_ini = "Rabu";
                break;

            case 'Thu' :
                $hari_ini = "Kamis";
                break;

            case 'Fri' :
                $hari_ini = "Jumat";
                break;

            case 'Sat' :
                $hari_ini = "Sabtu";
                break;
        }

        return $hari_ini;
    }
    public function create()
    {
        $namahari_m =[1=>'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
        $namahari = $this->gethari();
        $hari = date("N");
        $hariini = date("Y-m-d");
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi_karyawan')
        ->where('tgl_presensi', $hariini)
        ->where('nik', $nik)->count();
        $kodewilker = Auth::guard('karyawan')->user()->kodewilker;
        $lok_kantor = DB::table('wilayah_kerja')
        ->where('kodewilker',$kodewilker)
        ->first();
        $jamkerja = DB::table('konfigurasi_jamkerja')
        ->join('jam_kerja','konfigurasi_jamkerja.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
        ->where('nik',$nik)->where('hari',$namahari)->first();
        return view('presensi.create', compact('cek','lok_kantor','namahari_m','hari', 'jamkerja'));
    }

    public function store(Request $request){
        $nik = Auth::guard('karyawan')->user()->nik;
        $kodewilker = Auth::guard('karyawan')->user()->kodewilker;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lok_kantor = DB::table('wilayah_kerja')->where('kodewilker',$kodewilker)->first();
        $lok = explode(",", $lok_kantor->lokasikantor);
        $latitudekantor = $lok[0];
        $longitudekantor = $lok[1];
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);
        $namahari = $this->gethari();
        $jamkerja = DB::table('konfigurasi_jamkerja')
        ->join('jam_kerja','konfigurasi_jamkerja.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
        ->where('nik',$nik)->where('hari',$namahari)->first();
        $cek = DB::table('presensi_karyawan')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();

        if($cek > 0){
            $ket = "pulang";
        }else{
            $ket = "masuk";
        }
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $nik."-".$tgl_presensi."-".$ket;
        $image_parts = explode(";base64",$image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;


        if($radius > $lok_kantor->radius){
            echo "error|Maaf Anda Berada Diluar Radius, Jarak Anda ".$radius." Meter Dari Kantor|radius";
        }else{
            if($cek > 0){
                if($jam < $jamkerja->jam_out){
                    echo "error|Maaf, belum waktunya pulang, silahkan tunggu.|out";
                }else if($jam > $jamkerja->akhir_jam_pulang){
                    echo "error|Maaf, batas terakhir melalukan presensi pulang telah habis.|out";
                }else{
                    $data_pulang = [
                        'jam_pulang' => $jam,
                        'foto_pulang' => $fileName,
                        'lokasi_pulang' => $lokasi
                    ];
                    $update = DB::table('presensi_karyawan')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
                    if($update){
                        echo "success|Terimakasih, Hati-Hati Di Jalan|out";
                        Storage::put($file,$image_base64);
                    } else{
                        echo "error|Maaf Gagal Absen, Hubungi Tim IT|out";
                    }
                }
            }else{
                if($jam < $jamkerja->awal_jam_masuk){
                    echo "error|Maaf, belum waktunya melakukan presensi, silahkan tunggu.|in";
                }else if($jam > $jamkerja->akhir_jam_masuk){
                    echo "error|Maaf, batas terakhir melalukan presensi masuk telah habis.|in";
                }else{
                    $data = [
                        'nik' => $nik,
                        'tgl_presensi' => $tgl_presensi,
                        'jam_masuk' => $jam,
                        'foto_masuk' => $fileName,
                        'lokasi_masuk' => $lokasi,
                        'kode_jam_kerja' => $jamkerja->kode_jam_kerja
                    ];
                    $simpan = DB::table('presensi_karyawan')->insert($data);
                    if($simpan){
                        echo "success|Terimakasih, Selamat Bekerja|in";
                        Storage::put($file,$image_base64);
                    } else{
                        echo "error|Maaf Gagal Absen, Hubungi Tim IT|in";
                    }
                }
            }
        }

    }

    public function editprofile()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan_bkkpgk')->where('nik', $nik)->first();
        return view('presensi.editprofile', compact('karyawan'));
    }

    public function gantipassword()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan_bkkpgk')->where('nik', $nik)->first();
        return view('presensi.gantipassword', compact('karyawan'));
    }

    public function updatepassword(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $password = Hash::make($request->password);
        $karyawan = DB::table('karyawan_bkkpgk')->where('nik', $nik)->first();

        $request->validate([
            'password_current' => 'required',
            'password' => 'min:6',
            'konfirmasi' => 'same:password'
        ]);

        if(Hash::check($request->password_current, $karyawan->password)){
            $data = [
                'password' => $password
            ];
        }else{
            return Redirect::back()->with(['error' => 'Password saat ini salah']);
        }

        $update = DB::table('karyawan_bkkpgk')->where('nik', $nik)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Update']);
        }
    }


    public function updateprofile(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $karyawan = DB::table('karyawan_bkkpgk')->where('nik', $nik)->first();

        $request->validate([
            'foto' => 'image|mimes:png,jpg|max:1500'
        ]);

        if(Hash::check($request->password_current, $karyawan->password)){
            if($request->hasFile('foto')){
                $foto = $nik.".".$request->file('foto')->getClientOriginalExtension();
                $password = Hash::make($request->password_current);
            $data = [
                'foto' => $foto,
                'password' => $password
            ];
            }else{
                $foto = $karyawan->foto;
            }
        }else{
            return Redirect::back()->with(['error' => 'Password saat ini salah']);
        }

        $update = DB::table('karyawan_bkkpgk')->where('nik', $nik)->update($data);
        if($update){
            if($request->hasFile('foto')){
                $folderPath = "public/uploads/karyawan/profil/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Update']);
        }
    }

    //menghitung jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function histori(){
        $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober",
        "November","Desember"];
        return view('presensi.histori',compact('namabulan'));
    }

    public function gethistori(Request $request){
        $namahari =[1=>'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        $histori = DB::table('presensi_karyawan')
        ->leftJoin('jam_kerja', 'presensi_karyawan.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
        ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
        ->where('nik', $nik)
        ->orderBy('tgl_presensi')
        ->get();

        return view('presensi.gethistori', compact('histori', 'namahari'));
    }

    public function izin(){
        $hariini = date("Y-m-d");
        $bulanini = date("m") * 1;
        $tahunini = date("Y");
        $namahari =[1=>'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
        $nik = Auth::guard('karyawan')->user()->nik;
        $dataizin = DB::table('pengajuan_izin')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_pengajuanizin)="'.$bulanini.'"')
        ->whereRaw('YEAR(tgl_pengajuanizin)="'.$tahunini.'"')
        ->orderByDesc('tgl_pengajuanizin')
        ->get();
        return view('presensi.izin', compact('dataizin','namahari'));
    }

    public function pengajuanizin(){
        return view('presensi.pengajuanizin');
    }

    public function storeizin(Request $request){
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_pengajuanizin = $request->tgl_pengajuanizin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'nik' => $nik,
            'tgl_pengajuanizin' => $tgl_pengajuanizin,
            'status' => $status,
            'keterangan' => $keterangan
        ];

        $simpan = DB::table('pengajuan_izin')->insert($data);

        if($simpan){
            return redirect('/presensi/izin')->with(['success' => 'Data Berhasil Disimpan']);
        }else{
            return redirect('/presensi/izin')->with(['error' => 'Data Gagal Disimpan']);
        }
    }

    public function monitoring(){
        return view('presensi.monitoring');
    }

    public function getpresensi(Request $request){
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensi_karyawan')
        ->select('presensi_karyawan.*','nama_lengkap','namawilker', 'jam_in', 'nama_jam_kerja', 'jam_in', 'jam_out')
        ->leftJoin('jam_kerja','presensi_karyawan.kode_jam_kerja','=','jam_kerja.kode_jam_kerja')
        ->join('karyawan_bkkpgk','presensi_karyawan.nik','=','karyawan_bkkpgk.nik')
        ->join('wilayah_kerja','karyawan_bkkpgk.kodewilker','=','wilayah_kerja.kodewilker')
        ->where('tgl_presensi',$tanggal)
        ->get();

        return view('presensi.getpresensi', compact('presensi'));
    }

    public function showmap(Request $request){
        $id = $request->id;
        $presensi = DB::table('presensi_karyawan')->where('id',$id)
        ->join('karyawan_bkkpgk', 'presensi_karyawan.nik','=','karyawan_bkkpgk.nik')
        ->first();
        return view('presensi.showmap', compact('presensi'));
    }

    public function laporan (){
        $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober",
        "November","Desember"];
        $karyawan = DB::table('karyawan_bkkpgk')->orderBy('nama_lengkap')->get();
        return view('presensi.laporan', compact('namabulan', 'karyawan'));
    }

    public function cetaklaporan(Request $request){
        $nik = $request->nik;
        $bulan = $request-> bulan;
        $tahun = $request->tahun;
        $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober",
        "November","Desember"];
        $namahari =[1=>'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
        $karyawan = DB::table('karyawan_bkkpgk')->where('nik',$nik)
        ->join('wilayah_kerja','karyawan_bkkpgk.kodewilker','=','wilayah_kerja.kodewilker')
        ->first();

        $presensi = DB::table('presensi_karyawan')
        ->leftJoin('jam_kerja','presensi_karyawan.kode_jam_kerja','=','jam_kerja.kode_jam_kerja')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
        ->orderBy('tgl_presensi')
        ->get();

        $data = [
            'bulan' => $bulan,
            'tahun'=>$tahun,
            'namabulan' => $namabulan,
            'presensi' => $presensi,
            'karyawan' => $karyawan,
            'namahari' => $namahari
        ];
        if(isset($_POST['downloadpdf'])){
            $pdf = Pdf::loadView('presensi.cetaklaporanpdf',$data);
            return $pdf->download('Presensi Karyawan.pdf');
        }
        return view('presensi.cetaklaporan', $data);

        //return view('presensi.cetaklaporan', compact('bulan','tahun',
       // 'namabulan','karyawan', 'presensi'));
    }

    public function rekap (){
        $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober",
        "November","Desember"];
        return view('presensi.rekap', compact('namabulan'));
    }

    public function cetakrekap(Request $request){
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober",
        "November","Desember"];
        $rekap = DB::table('presensi_karyawan')
        ->selectRaw('presensi_karyawan.nik, nama_lengkap,
            MAX(IF(DAY(tgl_presensi) = 1, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_1,
            MAX(IF(DAY(tgl_presensi) = 2, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_2,
            MAX(IF(DAY(tgl_presensi) = 3, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_3,
            MAX(IF(DAY(tgl_presensi) = 4, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_4,
            MAX(IF(DAY(tgl_presensi) = 5, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_5,
            MAX(IF(DAY(tgl_presensi) = 6, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_6,
            MAX(IF(DAY(tgl_presensi) = 7, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_7,
            MAX(IF(DAY(tgl_presensi) = 8, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_8,
            MAX(IF(DAY(tgl_presensi) = 9, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_9,
            MAX(IF(DAY(tgl_presensi) = 10, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_10,
            MAX(IF(DAY(tgl_presensi) = 11, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_11,
            MAX(IF(DAY(tgl_presensi) = 12, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_12,
            MAX(IF(DAY(tgl_presensi) = 13, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_13,
            MAX(IF(DAY(tgl_presensi) = 14, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_14,
            MAX(IF(DAY(tgl_presensi) = 15, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_15,
            MAX(IF(DAY(tgl_presensi) = 16, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_16,
            MAX(IF(DAY(tgl_presensi) = 17, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_17,
            MAX(IF(DAY(tgl_presensi) = 18, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_18,
            MAX(IF(DAY(tgl_presensi) = 19, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_19,
            MAX(IF(DAY(tgl_presensi) = 20, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_20,
            MAX(IF(DAY(tgl_presensi) = 21, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_21,
            MAX(IF(DAY(tgl_presensi) = 22, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_22,
            MAX(IF(DAY(tgl_presensi) = 23, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_23,
            MAX(IF(DAY(tgl_presensi) = 24, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_24,
            MAX(IF(DAY(tgl_presensi) = 25, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_25,
            MAX(IF(DAY(tgl_presensi) = 26, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_26,
            MAX(IF(DAY(tgl_presensi) = 27, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_27,
            MAX(IF(DAY(tgl_presensi) = 28, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_28,
            MAX(IF(DAY(tgl_presensi) = 29, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_29,
            MAX(IF(DAY(tgl_presensi) = 30, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_30,
            MAX(IF(DAY(tgl_presensi) = 31, CONCAT(jam_masuk,"-",IFNULL(jam_pulang, "00:00:00")),"")) as tgl_31')
        ->join('karyawan_bkkpgk','presensi_karyawan.nik','=','karyawan_bkkpgk.nik')
        ->leftJoin('jam_kerja','presensi_karyawan.kode_jam_kerja','=','jam_kerja.kode_jam_kerja')
        ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
        ->groupByRaw('presensi_karyawan.nik,nama_lengkap')
        ->get();
        $data = [
            'bulan' => $bulan,
            'tahun'=>$tahun,
            'namabulan' => $namabulan,
            'rekap' => $rekap,
        ];
        if(isset($_POST['downloadpdf'])){
            $pdf = Pdf::loadView('presensi.pdffile-download',$data)->setPaper('a3', 'landscape');
            return $pdf->download('Rekap Presensi All Karyawan.pdf');
        }
        return view('presensi.pdffile', $data);
    }

    public function sakitizin(Request $request){
        $query = Pengajuanizin::query();
        $query->select('id', 'tgl_pengajuanizin', 'pengajuan_izin.nik', 'nama_lengkap', 'jabatan', 'status', 'status_approved', 'keterangan');
        $query->join('karyawan_bkkpgk','pengajuan_izin.nik', '=', 'karyawan_bkkpgk.nik');
        if(!empty($request->dari) && !empty($request->sampai)){
            $query->whereBetween('tgl_pengajuanizin', [$request->dari, $request->sampai]);
        }

        if(!empty($request->nik)){
            $query->where('pengajuan_izin.nik', $request->nik);
        }

        if(!empty($request->nama_lengkap)){
            $query->where('nama_lengkap','like','%' .$request->nama_lengkap.'%');
        }

        if($request->status_approved === '0' || $request->status_approved === '1' || $request->status_approved === '2' ){
            $query->where('status_approved', $request->status_approved);
        }

        $query->orderBy('tgl_pengajuanizin','desc');
        $sakitizin = $query->paginate(10);
        $sakitizin->appends($request->all());
        return view('presensi.sakitizin', compact('sakitizin'));
    }

    public function approvesakitizin(Request $request){
        $status_approved = $request->status_approved;
        $id_sakitizin_form = $request->id_sakitizin_form;
        $update = DB::table('pengajuan_izin')->where('id',$id_sakitizin_form)->update([
            'status_approved' => $status_approved
        ]);
        if($update){
            return Redirect::back()->with(['success'=>'Data berhasil diupdate']);
        }else{
            return Redirect::back()->with(['warning'=>'Data gagal diupdate']);
        }
    }

    public function batalkansakitizin($id){
        $update = DB::table('pengajuan_izin')->where('id', $id)->update([
            'status_approved' => 0
        ]);
        if($update){
            return Redirect::back()->with(['success'=>'Data berhasil diupdate']);
        }else{
            return Redirect::back()->with(['warning'=>'Data gagal diupdate']);
        }
    }

    public function cekpengajuanizin(Request $request){
        $tgl_pengajuanizin = $request->tgl_pengajuanizin;
        $nik = Auth::guard('karyawan')->user()->nik;

        $cek = DB::table('pengajuan_izin')->where('nik',$nik)->where('tgl_pengajuanizin', $tgl_pengajuanizin)->count();
        return $cek;
    }

    public function lokasi(){
        $nik = Auth::guard('karyawan')->user()->nik;
        $hariini = date("Y-m-d");
        $cek = DB::table('presensi_karyawan')
        ->where('tgl_presensi', $hariini)
        ->where('nik', $nik)->count();
        $kodewilker = Auth::guard('karyawan')->user()->kodewilker;
        $lok_kantor = DB::table('wilayah_kerja')
        ->where('kodewilker',$kodewilker)
        ->first();
        return view('presensi.lokasi', compact('lok_kantor', 'cek'));
    }

    public function cuti(){
        return view('presensi.cuti');
    }
    public function lembur(){
        return view('presensi.lembur');
    }
}

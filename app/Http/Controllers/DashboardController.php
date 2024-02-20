<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $hariini = date("Y-m-d");
        $bulanini = date("m") * 1;
        $tahunini = date("Y");
        $namahari =[1=>'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
        $nik = Auth::guard('karyawan')->user()->nik;
        $kodewilker = Auth::guard('karyawan')->user()->kodewilker;
        $wilker = DB::table('wilayah_kerja')
        ->where('kodewilker',$kodewilker)
        ->first();

        $presensitoday = DB::table('presensi_karyawan')
        ->where('nik' , $nik)
        ->where('tgl_presensi', $hariini)
        ->first();

        $historibulanini = DB::table('presensi_karyawan')
        ->leftJoin('jam_kerja', 'presensi_karyawan.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_presensi)="'.$bulanini.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahunini.'"')
        ->orderByDesc('tgl_presensi')
        ->get();

        $rekappresensi = DB::table('presensi_karyawan')
        -> selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_masuk > jam_in,1,0)) as jmltelat ')
        ->leftJoin('jam_kerja','presensi_karyawan.kode_jam_kerja','=','jam_kerja.kode_jam_kerja')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_presensi)="'.$bulanini.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahunini.'"')
        ->first();

        $leaderboard = DB::table('presensi_karyawan')
        ->leftJoin('jam_kerja', 'presensi_karyawan.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
        ->join('karyawan_bkkpgk', 'presensi_karyawan.nik', '=', 'karyawan_bkkpgk.nik')
        ->where('tgl_presensi', $hariini)
        ->orderBy('jam_masuk')
        ->get();

        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ];

        $rekapizin = DB::table('pengajuan_izin')
        ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin, SUM(IF(status="s",1,0)) as jmlsakit')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_pengajuanizin)="'.$bulanini.'"')
        ->whereRaw('YEAR(tgl_pengajuanizin)="'.$tahunini.'"')
        ->where('status_approved', 1)
        ->first();

        return view('dashboard.dashboard', compact('presensitoday', 'historibulanini',
         'namabulan', 'bulanini', 'tahunini',
          'rekappresensi', 'leaderboard', 'rekapizin', 'wilker','namahari'));
    }

    public function dashboardadmin(){
        $hariini = date("Y-m-d");
        $rekappresensi = DB::table('presensi_karyawan')
        -> selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_masuk > "07:30",1,0)) as jmltelat ')
        ->where('tgl_presensi', $hariini)
        ->first();

        $rekapizin = DB::table('pengajuan_izin')
        ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin, SUM(IF(status="s",1,0)) as jmlsakit')
        ->where('tgl_pengajuanizin', $hariini)
        ->where('status_approved', 1)
        ->first();

        $count = DB::table('karyawan_bkkpgk')->count();

        return view('dashboard.dashboardadmin',compact('rekappresensi', 'rekapizin','count'));
    }
}

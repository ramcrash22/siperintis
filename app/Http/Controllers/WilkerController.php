<?php

namespace App\Http\Controllers;

use App\Models\Wilker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class WilkerController extends Controller
{
    public function index(Request $request){
        //$wilker = DB::table('wilayah_kerja')->orderBy('kodewilker')->get();
        $namawilker = $request->namawilkercari;
        $query = Wilker::query();
        $query->select('*');
        if(!empty($namawilker)){
            $query->where('namawilker', 'like','%'.$namawilker.'%');
        }
        $wilker = $query->get();
        return view('wilker.index', compact('wilker'));
    }

    public function store(Request $request){
        $kodewilker = $request->kodewilker;
        $namawilker = $request->namawilker;
        $lokasikantor = $request->lokasikantor;
        $radius = $request->radius;
        $data = [
            'kodewilker' => $kodewilker,
            'namawilker' => $namawilker,
            'lokasikantor' => $lokasikantor,
            'radius' => $radius
        ];

        $cek = DB::table('wilayah_kerja')->where('kodewilker', $kodewilker)->count();
        if($cek>0){
            return Redirect::back()->with(['warning'=>'Data dengan nama wilker '.$namawilker.' sudah ada.']);
        }

        $simpan = DB::table('wilayah_kerja')->insert($data);
        if ($simpan) {
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function edit(Request $request){
        $kodewilker = $request->kodewilker;
        $wilker = DB::table('wilayah_kerja')->where('kodewilker',$kodewilker)->first();
        return view('wilker.edit',compact('wilker'));
    }

    public function update($kodewilker, Request $request){
        $namawilker = $request->namawilker;
        $lokasikantor = $request->lokasikantor;
        $radius = $request->radius;
        $data = [
            'namawilker' => $namawilker,
            'lokasikantor' => $lokasikantor,
            'radius' => $radius
        ];

        $update = DB::table('wilayah_kerja')->where('kodewilker', $kodewilker)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    public function delete($kodewilker){
        $hapus = DB::table('wilayah_kerja')->where('kodewilker',$kodewilker)->delete();
        if($hapus){
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }
}

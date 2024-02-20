@extends('layouts.presensi')
@section('header')
<div class="appHeader">
    <div class="pageTitle">PENGAJUAN IZIN & SAKIT</div>
</div>
@endsection
@section('content')
<div class="row" style="margin-top: 70px">
    <div class="col">
        @php
            $messagesuccess = Session::get('success');
            $messageerror = Session::get('error');
        @endphp
        @if (Session::get('success'))
        <div class="alert alert-success">
            {{$messagesuccess}}
        </div>
        @endif
        @if (Session::get('error'))
        <div class="alert alert-danger">
            {{$messageerror}}
        </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col">
        @foreach ($dataizin as $d)
    <ul class="listview image-listview">
        <li>
            <div class="item">
                <div class="in">
                    <div class="datasakitizin">
                        @php
                        $hari = date("N", strtotime($d->tgl_pengajuanizin));
                        @endphp
                        <b class="kemenkescolor">{{$namahari[$hari]}}<br>{{date("d-m-Y", strtotime($d->tgl_pengajuanizin))}}</b>
                        <br>
                        <span class="badge badge-kemenkescolor2"><b style="color: white">{{$d->status=="s" ? "Sakit" : "Izin"}}</b></span>
                        <small class="text-muted">: {{$d->keterangan}}</small>
                    </div>
                    @if ($d->status_approved == 0)
                        <span class="badge bg-warning" style="padding: 20px">Menunggu<br>Persetujuan</span>
                    @elseif ($d->status_approved == 1)
                        <span class="badge bg-success"style="padding: 20px">Pengajuan<br>Disetujui</span>
                    @elseif ($d->status_approved == 2)
                        <span class="badge bg-danger"style="padding: 20px">Pengajuan<br>Ditolak</span>
                    @endif
                </div>
            </div>
        </li>
    </ul>
    @endforeach
    </div>
</div>
<div class="fab-buttonkemenkes bottom-right" style="margin-bottom: 70px">
    <a href="/presensi/pengajuanizin" class="fab" style="font-size: 30px">
        <ion-icon name="add"></ion-icon>
    </a>
</div>
@endsection

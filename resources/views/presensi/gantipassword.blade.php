@extends('layouts.presensi')
@section('header')
<div class="appHeader">
    <div class="pageTitle" style="text-transform: uppercase">Edit Profile</div>
</div>
@endsection

@section('content')
<form action="/presensi/{{$karyawan->nik}}/updatepassword" method="POST" enctype="multipart/form-data" class="mt-9">
    <div class="row">
        <div class="col">
            @php
                $messagesuccess = Session::get('success');
                $messageerror = Session::get('error');
            @endphp
            @if (Session::get('success'))
            <div class="alert alert-success" style="border-radius: 10px; margin-bottom: 20px">
                <p style="font-size: 16px; text-transform:uppercase; text-align: center; padding-top: 15px">{{$messagesuccess}}</p>
            </div>
            @endif
            @if (Session::get('error'))
            <div class="alert alert-warning" style="border-radius: 10px; margin-bottom: 20px">
                <p style="font-size: 16px; text-transform:uppercase; text-align: center; padding-top: 15px">{{$messageerror}}</p>
            </div>
            @endif
            @error('password')
            <div class="alert alert-warning" style="border-radius: 10px; margin-bottom: 20px">
                <p style="font-size: 16px; text-transform:uppercase; text-align: center; padding-top: 15px">{{$message}}</p>
            </div>
            @enderror
        </div>
    </div>
    @csrf
    <div class="col">
        <div class="form-group">
            <div class="input-wrapper">
                <h4 class="kemenkescolor" style="text-transform: uppercase">Password Baru</h4>
                <input type="password" class="form-control" name="password" placeholder="Password Baru" autocomplete="off">
            </div>
        </div>
        <div class="form-group">
            <div class="input-wrapper">
                <h4 class="kemenkescolor" style="text-transform: uppercase">Konfirmasi Password</h4>
                <input type="password" class="form-control" name="konfirmasi" placeholder="Ulangi Password Baru" autocomplete="off">
            </div>
        </div>
        <div class="form-group" style="margin-top: 20px">
            <div class="input-wrapper">
                <h5 class="bkkcolor" style="text-transform: uppercase">*untuk melanjutkan update masukan password saat ini pada form dibawah</h5>
            </div>
        </div>
        <div class="form-group">
            <div class="input-wrapper">
                <input type="password" class="form-control" name="password_current" placeholder="Masukan Password" autocomplete="off">
            </div>
        </div>
        <div class="form-group boxed" style="margin-bottom: 70px; margin-top: 20px;">
            <div class="input-wrapper">
                <button type="submit" class="btn" style="font-size: 18px; text-transform:uppercase">
                    Update
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

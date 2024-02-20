@extends('layouts.presensi')
@section('header')
<div class="appHeader">
    <div class="pageTitle" style="text-transform: uppercase">Edit Profile</div>
</div>
@endsection

@section('content')
<div class="form-group boxed" style="margin-top: 25%">
    <div class="input-wrapper">
        <a href="/gantipassword"class="btn" style="font-size: 18px; text-transform:uppercase; background-color: #CCDB39 !important; border-radius: 0 !important">
        GANTI PASSWORD
        </a>
    </div>
</div>
<form action="/presensi/{{$karyawan->nik}}/updateprofile" method="POST" enctype="multipart/form-data" class="mt-2">
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
                <h4 class="kemenkescolor" style="text-transform: uppercase">Nama Lengkap</h4>
                <input type="text" class="form-control" readonly value="{{$karyawan->nama_lengkap}}" name="nama_lengkap" placeholder="Nama Lengkap" autocomplete="off">
            </div>
        </div>
        <div class="form-group">
            <div class="input-wrapper">
                <h4 class="kemenkescolor" style="text-transform: uppercase">Username</h4>
                <input type="text" class="form-control" readonly value="{{$karyawan->username}}" name="username" placeholder="Username" autocomplete="off">
            </div>
        </div>
        <div class="custom-file-upload" id="fileUpload1" style="margin-top: 30px">
            <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
            <label for="fileuploadInput">
                <span>
                    <strong style="text-transform:uppercase">
                        <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                        <i>Tap untuk Upload <br> Foto Profil</i>
                    </strong>
                </span>
            </label>
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

@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
                <a href="/konfigurasi/{{$karyawan->nik}}/setjamkerja" class="btn btn-ghost-primary">
                    <h1 class="page-title">
                    Set Jam Kerja Karyawan
                    </h1>
                </a>
          </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                    @if (Session::get('success'))
                                        <div class="alert alert-important alert-success alert-dismissible" role="alert">
                                            <div class="d-flex">
                                              <div>
                                                <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
                                              </div>
                                              <div>
                                                {{Session::get('success')}}
                                              </div>
                                            </div>
                                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                        </div>
                                    @endif
                                    @if (Session::get('warning'))
                                        <div class="alert alert-important alert-warning alert-dismissible" role="alert">
                                            <div class="d-flex">
                                              <div>
                                                <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z"></path><path d="M12 9v4"></path><path d="M12 17h.01"></path></svg>
                                              </div>
                                              <div>
                                                {{Session::get('warning')}}
                                              </div>
                                            </div>
                                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                    @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <table class="table">
                                    <tr>
                                        <th>NIP</th>
                                        <th> : </th>
                                        <td>{{$karyawan->nik}}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Karyawan</th>
                                        <th> : </th>
                                        <td>{{$karyawan->nama_lengkap}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <form action="/konfigurasi/updatesetjamkerja" method="POST">
                                    @csrf
                                    <input type="hidden" name="nik" value="{{$karyawan->nik}}">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Hari</th>
                                        <th>Jam Kerja</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($setjamkerja as $sk)
                                        <tr>
                                            <td>
                                                {{$sk->hari}}
                                                <input type="hidden" name="hari[]" value="{{$sk->hari}}">
                                            </td>
                                            <td>
                                                <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                                    <option value="">Pilih Jam Kerja</option>
                                                    @foreach ($jamkerja as $jk)
                                                        <option {{$jk->kode_jam_kerja==$sk->kode_jam_kerja?'selected' : ''}} value="{{$jk->kode_jam_kerja}}">{{$jk->nama_jam_kerja}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button class="btn btn-primary w-100" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                                    Simpan
                                </button>
                            </form>
                            </div>
                            <div class="col-6">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="6">Master Jam Kerja</th>
                                        </tr>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Awal <br>Jam Masuk</th>
                                            <th>Jam Masuk</th>
                                            <th>Akhir <br>Jam Masuk</th>
                                            <th>Jam Pulang</th>
                                            <th>Akhir <br>Jam Pulang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jamkerja as $d)
                                            <tr>
                                                <td>{{$d->nama_jam_kerja}}</td>
                                                <td>{{$d->awal_jam_masuk}}</td>
                                                <td>{{$d->jam_in}}</td>
                                                <td>{{$d->akhir_jam_masuk}}</td>
                                                <td>{{$d->jam_out}}</td>
                                                <td>{{$d->akhir_jam_pulang}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

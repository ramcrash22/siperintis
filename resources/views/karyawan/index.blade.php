@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
                <a href="/karyawan" class="btn btn-ghost-primary">
                    <h1 class="page-title">
                    Data Karyawan
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
                            <div class="col-12">
                                <a href="#" class="btn btn-primary" id="btnTambahkaryawan">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                    Tambah Data</a>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <form action="/karyawan" method="GET">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" name="nama_karyawan" id="nama_karyawan" class="form-control" placeholder="Nama Karyawan" value="{{Request('nama_karyawan')}}">
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <select name="kodewilker" id="kodewilker" class="form-select">
                                                    <option value="">Wilayah Kerja</option>
                                                    @foreach ($wilker as $wk)
                                                        <option {{Request('kodewilker')==$wk->kodewilker ? 'selected' : ''}} value="{{$wk->kodewilker}}">{{$wk->namawilker}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                                Cari
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIP</th>
                                            <th>Pangkat</th>
                                            <th>Jabatan</th>
                                            <th>Ket.</th>
                                            <th>Wilayah Kerja</th>
                                            <th>username</th>
                                            {{--
                                            <th>Foto</th>
                                            --}}
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $karyawan as $k)
                                        {{-- untuk pemanggil foto
                                        @foreach ( $karyawan as $k)
                                        @php
                                            $path = Storage::url('uploads/karyawan/profil/'.$k->foto);
                                        @endphp
                                        --}}
                                        <tr>
                                            <td>{{$loop->iteration + $karyawan->firstItem()-1}}</td>
                                            <td>{{$k->nama_lengkap}}</td>
                                            <td>{{$k->nik}}</td>
                                            <td>{{$k->pangkat}}</td>
                                            <td>{{$k->jabatan}}</td>
                                            <td>{{$k->ket}}</td>
                                            <td>{{$k->namawilker}}</td>
                                            <td>{{$k->username}}</td>
                                            {{--
                                            <td>
                                                @if (empty($k->foto))
                                                <img src="{{asset('assets/img/photo-off.png')}}" class="avatar" alt="">
                                                @else
                                                <img src="{{url($path)}}" class="avatar" alt="">
                                                @endif
                                            </td>
                                            --}}
                                            <td>
                                                <div class="btn-group">
                                                    <a href="#" class="editDatakaryawan btn btn-yellow btn-icon" style="margin-right: 5px" aria-label="Edit Data" nik="{{$k->nik}}">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/brand-pinterest -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                                    </a>
                                                    <a href="/konfigurasi/{{$k->nik}}/setjamkerja" class="btn btn-primary btn-icon" style="margin-right: 5px" aria-label="Tambah Setting">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/brand-pinterest -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>
                                                    </a>
                                                    <form action="/karyawan/{{$k->nik}}/delete" method="POST">
                                                        @csrf
                                                        <a href="#" class="btn btn-red btn-icon delete-confirm" aria-label="Hapus Data">
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/brand-pinterest -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eraser" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 20h-10.5l-4.21 -4.3a1 1 0 0 1 0 -1.41l10 -10a1 1 0 0 1 1.41 0l5 5a1 1 0 0 1 0 1.41l-9.2 9.3" /><path d="M18 13.3l-6.3 -6.3" /></svg>
                                                        </a>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$karyawan->links('vendor.pagination.bootstrap-5')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Karyawan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/karyawan/store" method="POST" id="frmKaryawan">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7v-1a2 2 0 0 1 2 -2h2" /><path d="M4 17v1a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v1" /><path d="M16 20h2a2 2 0 0 0 2 -2v-1" /><path d="M5 11h1v2h-1z" /><path d="M10 11l0 2" /><path d="M14 11h1v2h-1z" /><path d="M19 11l0 2" /></svg>
                        </span>
                        <input type="text" id="nik" value="" class="form-control" name="nik" placeholder="NIP">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" /><path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M15 8l2 0" /><path d="M15 12l2 0" /><path d="M7 16l10 0" /></svg>
                        </span>
                        <input type="text" id="username" value="" class="form-control" name="username" placeholder="Username">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-typography" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20l3 0" /><path d="M14 20l7 0" /><path d="M6.9 15l6.9 0" /><path d="M10.2 6.3l5.8 13.7" /><path d="M5 20l6 -16l2 0l7 16" /></svg>
                        </span>
                        <input type="text" id="nama_lengkap" value="" class="form-control" name="nama_lengkap" placeholder="Nama Lengkap">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-military-rank" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7v13h-10v-13l5 -3z" /><path d="M10 13l2 -1l2 1" /><path d="M10 17l2 -1l2 1" /><path d="M10 9l2 -1l2 1" /></svg>                        </span>
                        <input type="text" id="pangkat" value="" class="form-control" name="pangkat" placeholder="Pangkat">
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-tournament" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M20 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M4 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M4 20m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M6 12h3a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-3" /><path d="M6 4h7a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-2" /><path d="M14 10h4" /></svg>                        </span>
                        <input type="text" id="jabatan" value="" class="form-control" name="jabatan" placeholder="Jabatan">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-square" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9h.01" /><path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z" /><path d="M11 12h1v4h1" /></svg>                        </span>
                        <input type="text" id="ket" value="" class="form-control" name="ket" placeholder="JFT/JFU">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <select name="kodewilker" id="kodewilker" class="form-select">
                            <option value="">Wilayah Kerja</option>
                            @foreach ($wilker as $wk)
                                <option {{Request('kodewilker')==$wk->kodewilker ? 'selected' : ''}} value="{{$wk->kodewilker}}">{{$wk->namawilker}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-primary w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 14l11 -11" /><path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" /></svg>
                            Simpan</button>
                    </div>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
    {{--edit data--}}
    <div class="modal modal-blur fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Data Karyawan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="loadeditform">

            </div>
          </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function(){
            $("#btnTambahkaryawan").click(function(){
                $("#modal-add").modal("show");
            });

            $(".editDatakaryawan").click(function(){
                var nik = $(this).attr('nik');
                $.ajax({
                    type:'POST',
                    url:'/karyawan/edit',
                    cache:false,
                    data:{
                        _token:"{{csrf_token();}}",
                        nik:nik
                    },
                    success: function(respond){
                        $("#loadeditform").html(respond);
                    }
                });
                $("#modal-edit").modal("show");
            });

            $(".delete-confirm").click(function(e){
                var form = $(this).closest('form');
                e.preventDefault();
                Swal.fire({
                        title: "Peringatan !",
                        text: "Apakah anda yakin untuk menghapus data ini ?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Hapus !",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire({
                        title: "Berhasil !",
                        text: "Data berhasil di hapus.",
                        icon: "success"
                        });
                    }
                });
            });

            $("#frmKaryawan").submit(function(){
                var nik = $("#nik").val();
                var username = $("#username").val();
                var nama_lengkap = $("#nama_lengkap").val();
                var pangkat = $("#pangkat").val();
                var jabatan = $("#jabatan").val();
                var ket = $("#ket").val();
                var kodewilker = $("frmKaryawan").find("#kodewilker").val();
                if(nik==""){
                    //alert('NIP tidak boleh kosong');
                    Swal.fire({
                        title: 'Peringatan !',
                        text: 'NIP tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Mengerti'
                    }).then((result)=>{
                        $("#nik").focus();
                    });
                    return false;
                }else if(username==""){
                    Swal.fire({
                        title: 'Peringatan !',
                        text: 'Username tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Mengerti'
                    }).then((result)=>{
                        $("#username").focus();
                    });
                    return false;
                }else if(nama_lengkap==""){
                    Swal.fire({
                        title: 'Peringatan !',
                        text: 'Nama tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Mengerti'
                    }).then((result)=>{
                        $("#nama_lengkap").focus();
                    });
                    return false;
                }else if(pangkat==""){
                    Swal.fire({
                        title: 'Peringatan !',
                        text: 'Pangkat tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Mengerti'
                    }).then((result)=>{
                        $("#pangkat").focus();
                    });
                    return false;
                }else if(jabatan==""){
                    Swal.fire({
                        title: 'Peringatan !',
                        text: 'Jabatan tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Mengerti'
                    }).then((result)=>{
                        $("#jabatan").focus();
                    });
                    return false;
                }else if(ket==""){
                    Swal.fire({
                        title: 'Peringatan !',
                        text: 'Keterangan tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Mengerti'
                    }).then((result)=>{
                        $("#ket").focus();
                    });
                    return false;
                }else if(kodewilker==""){
                    Swal.fire({
                        title: 'Peringatan !',
                        text: 'Wilayah kerja belum dipilih',
                        icon: 'warning',
                        confirmButtonText: 'Mengerti'
                    }).then((result)=>{
                        $("#kodewilker").focus();
                    });
                    return false;
                }
            });
        });
    </script>
@endpush

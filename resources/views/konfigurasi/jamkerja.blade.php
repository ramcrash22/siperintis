@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
                <a href="/konfigurasi/jamkerja" class="btn btn-ghost-primary">
                    <h1 class="page-title">
                    Konfigurasi Jam Kerja
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
                                <a href="#" class="btn btn-primary" id="btnTambahjamkerja">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                    Tambah Data</a>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <form action="/konfigurasi/jamkerja" autocomplete="off" method="GET">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" name="nama_jam_kerjacari" id="nama_jam_kerjacari" class="form-control" placeholder="Nama Jam Kerja" value="{{Request('nama_jam_kerja')}}">
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
                                            <th>Kode Jam Kerja</th>
                                            <th>Nama Jam Kerja</th>
                                            <th>Awal Jam Masuk</th>
                                            <th>Jam Masuk</th>
                                            <th>Akhir Jam Masuk</th>
                                            <th>Jam Pulang</th>
                                            <th>Akhir Jam Pulang</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jam_kerja as $jk)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$jk->kode_jam_kerja}}</td>
                                                <td>{{$jk->nama_jam_kerja}}</td>
                                                <td>{{$jk->awal_jam_masuk}}</td>
                                                <td>{{$jk->jam_in}}</td>
                                                <td>{{$jk->akhir_jam_masuk}}</td>
                                                <td>{{$jk->jam_out}}</td>
                                                <td>{{$jk->akhir_jam_pulang}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="#" class="editDatajamkerja btn btn-yellow btn-icon" style="margin-right: 5px" aria-label="Edit Data" kode_jam_kerja="{{$jk->kode_jam_kerja}}">
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/brand-pinterest -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                                        </a>
                                                        <form action="/konfigurasi/{{$jk->kode_jam_kerja}}/deletejamkerja" method="POST">
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
          <h5 class="modal-title">Tambah Data Jam Kerja</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/konfigurasi/jamkerjastore" method="POST" id="frmJamkerja" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7v-1a2 2 0 0 1 2 -2h2" /><path d="M4 17v1a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v1" /><path d="M16 20h2a2 2 0 0 0 2 -2v-1" /><path d="M5 11h1v2h-1z" /><path d="M10 11l0 2" /><path d="M14 11h1v2h-1z" /><path d="M19 11l0 2" /></svg>
                        </span>
                        <input type="text" id="kode_jam_kerja" value="" class="form-control" name="kode_jam_kerja" placeholder="Kode Jam Kerja">
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
                        <input type="text" id="nama_jam_kerja" value="" class="form-control" name="nama_jam_kerja" placeholder="Nama Jam Kerja">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-record" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 12.3a9 9 0 1 0 -8.683 8.694" /><path d="M12 7v5l2 2" /><path d="M19 19m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /></svg>
                        </span>
                        <input type="time" id="awal_jam_masuk" value="" class="form-control" name="awal_jam_masuk" placeholder="Awal Jam Masuk">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-up" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.983 12.548a9 9 0 1 0 -8.45 8.436" /><path d="M19 22v-6" /><path d="M22 19l-3 -3l-3 3" /><path d="M12 7v5l2.5 2.5" /></svg>
                        </span>
                        <input type="time" id="jam_masuk" value="" class="form-control" name="jam_masuk" placeholder="Jam Masuk">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-cancel" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.997 12.25a9 9 0 1 0 -8.718 8.745" /><path d="M19 19m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M17 21l4 -4" /><path d="M12 7v5l2 2" /></svg>
                        </span>
                        <input type="time" id="akhir_jam_masuk" value="" class="form-control" name="akhir_jam_masuk" placeholder="Akhir Jam Masuk">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-down" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.984 12.535a9 9 0 1 0 -8.431 8.448" /><path d="M12 7v5l3 3" /><path d="M19 16v6" /><path d="M22 19l-3 3l-3 -3" /></svg>
                        </span>
                        <input type="time" id="jam_pulang" value="" class="form-control" name="jam_pulang" placeholder="Jam Pulang">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-down" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.984 12.535a9 9 0 1 0 -8.431 8.448" /><path d="M12 7v5l3 3" /><path d="M19 16v6" /><path d="M22 19l-3 3l-3 -3" /></svg>
                        </span>
                        <input type="time" id="akhir_jam_pulang" value="" class="form-control" name="akhir_jam_pulang" placeholder="Akhir Jam Pulang">
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
              <h5 class="modal-title">Edit Data Jam Kerja</h5>
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
            $("#btnTambahjamkerja").click(function(){
                $("#modal-add").modal("show");
            });

            $(".editDatajamkerja").click(function(){
                var kode_jam_kerja = $(this).attr('kode_jam_kerja');
                $.ajax({
                    type:'POST',
                    url:'/konfigurasi/editjamkerja',
                    cache:false,
                    data:{
                        _token:"{{csrf_token();}}",
                        kode_jam_kerja:kode_jam_kerja
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

            $("#frmJamkerja").submit(function(){
                var kode_jam_kerja = $("#kode_jam_kerja").val();
                var nama_jam_kerja = $("#nama_jam_kerja").val();
                var awal_jam_masuk = $("#awal_jam_masuk").val();
                var jam_masuk = $("#jam_masuk").val();
                var akhir_jam_masuk = $("#akhir_jam_masuk").val();
                var jam_pulang = $("#jam_pulang").val();
                var akhir_jam_pulang = $("#akhir_jam_pulang").val();
                if(kode_jam_kerja==""){
                    //alert('NIP tidak boleh kosong');
                    Swal.fire({
                        title: 'Peringatan !',
                        text: 'Kode jam kerja tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Mengerti'
                    }).then((result)=>{
                        $("#kode_jam_kerja").focus();
                    });
                    return false;
                }else if(nama_jam_kerja==""){
                    Swal.fire({
                        title: 'Peringatan !',
                        text: 'Nama jam kerja tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Mengerti'
                    }).then((result)=>{
                        $("#nama_jam_kerja").focus();
                    });
                    return false;
                }else if(awal_jam_masuk==""){
                    Swal.fire({
                        title: 'Peringatan !',
                        text: 'Awal jam masuk tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Mengerti'
                    }).then((result)=>{
                        $("#awal_jam_masuk").focus();
                    });
                    return false;
                }else if(jam_masuk==""){
                    Swal.fire({
                        title: 'Peringatan !',
                        text: 'Jam masuk tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Mengerti'
                    }).then((result)=>{
                        $("#jam_masuk").focus();
                    });
                    return false;
                }else if(akhir_jam_masuk==""){
                    Swal.fire({
                        title: 'Peringatan !',
                        text: 'Akhir jam masuk tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Mengerti'
                    }).then((result)=>{
                        $("#akhir_jam_masuk").focus();
                    });
                    return false;
                }else if(jam_pulang==""){
                    Swal.fire({
                        title: 'Peringatan !',
                        text: 'Jam pulang tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Mengerti'
                    }).then((result)=>{
                        $("#jam_pulang").focus();
                    });
                    return false;
                }else if(akhir_jam_pulang==""){
                    Swal.fire({
                        title: 'Peringatan !',
                        text: 'Akhir Jam pulang tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Mengerti'
                    }).then((result)=>{
                        $("#akhir_jam_pulang").focus();
                    });
                    return false;
                }
            });
        });
    </script>
@endpush

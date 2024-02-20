@extends('layouts.admin.tabler')
@section('content')

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
                <a href="/presensi/monitoring" class="btn btn-ghost-primary">
                    <h1 class="page-title">
                    Monitoring Presensi Karyawan
                    </h1>
                </a>
          </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                      <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-month" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M7 14h.013" /><path d="M10.01 14h.005" /><path d="M13.01 14h.005" /><path d="M16.015 14h.005" /><path d="M13.015 17h.005" /><path d="M7.01 17h.005" /><path d="M10.01 17h.005" /></svg>
                                    </span>
                                    <input type="text" value="{{date("Y-m-d")}}" id="tanggal" name="tanggal" class="form-control" placeholder="Tanggal Presensi">
                                  </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Wilker</th>
                                        <th>Jadwal</th>
                                        <th>Jam <br> Pres. Masuk</th>
                                        <th>Foto Masuk</th>
                                        <th>Jam <br> Pres. Pulang</th>
                                        <th>Foto Pulang</th>
                                        <th>Keterangan</th>
                                        <th>Lokasi Presensi</th>
                                    </tr>
                                </thead>
                                <tbody id="loadpresensi">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--show map absen--}}
<div class="modal modal-blur fade" id="modal-showmap" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Lokasi Presensi Karyawan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="loadmap">

        </div>
      </div>
    </div>
</div>
@endsection
@push('myscript')
    <script>
        $(function () {
             $("#tanggal").datepicker({
                autoclose: true,
                todayHighlight: true,
                format:'yyyy-mm-dd'
            }).datepicker('update', new Date());

            function loadpresensi(){
                var tanggal = $("#tanggal").val();
                $.ajax({
                    type:'POST',
                    url:'/getpresensi',
                    data:{
                        _token : " {{ csrf_token() }} ",
                        tanggal : tanggal
                    },
                    cache : false,
                    success: function(respond){
                        $("#loadpresensi").html(respond);
                    }
                });
            }
            $("#tanggal").change(function(e){
                loadpresensi();
            });

            loadpresensi();
        });
    </script>
@endpush

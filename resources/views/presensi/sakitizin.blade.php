@extends('layouts.admin.tabler')
@section('content')

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
                <a href="/presensi/sakitizin" class="btn btn-ghost-primary">
                    <h1 class="page-title">
                    Data Izin / Sakit
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
                            <form action="/presensi/sakitizin" method="GET" autocomplete="off">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                              <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-month" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M7 14h.013" /><path d="M10.01 14h.005" /><path d="M13.01 14h.005" /><path d="M16.015 14h.005" /><path d="M13.015 17h.005" /><path d="M7.01 17h.005" /><path d="M10.01 17h.005" /></svg>
                                            </span>
                                            <input type="text" id="dari" value="{{Request ('dari')}}" class="form-control" name="dari" placeholder="Dari Tanggal">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                              <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-month" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M7 14h.013" /><path d="M10.01 14h.005" /><path d="M13.01 14h.005" /><path d="M16.015 14h.005" /><path d="M13.015 17h.005" /><path d="M7.01 17h.005" /><path d="M10.01 17h.005" /></svg>
                                            </span>
                                            <input type="text" id="sampai" value="{{Request ('sampai')}}" class="form-control" name="sampai" placeholder="Sampai Tanggal">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                              <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7v-1a2 2 0 0 1 2 -2h2" /><path d="M4 17v1a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v1" /><path d="M16 20h2a2 2 0 0 0 2 -2v-1" /><path d="M5 11h1v2h-1z" /><path d="M10 11l0 2" /><path d="M14 11h1v2h-1z" /><path d="M19 11l0 2" /></svg>
                                            </span>
                                            <input type="text" id="nik" value="{{Request ('nik')}}" class="form-control" name="nik" placeholder="NIP">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                              <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                                            </span>
                                            <input type="text" id="nama_lengkap" value="{{Request ('nama_lengkap')}}" class="form-control" name="nama_lengkap" placeholder="Nama Karyawan">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group mb-3">
                                            <select name="status_approved" id="status_approved" class="form-select">
                                                <option value="">Pilih Status Peninjauan</option>
                                                <option value="0" {{Request('status_approved') === '0' ? 'selected' : ''}}>Menunggu Persetujuan</option>
                                                <option value="1" {{Request('status_approved') == 1 ? 'selected' : ''}}>Disetujui</option>
                                                <option value="2" {{Request('status_approved') == 2 ? 'selected' : ''}}>Ditolak</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <button class="btn btn-primary w-100" type="submit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                                Cari Data
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>TANGGAL</th>
                                        <th>NIP</th>
                                        <th>NAMA</th>
                                        <th>JABATAN</th>
                                        <th>Status <br> Izin/Sakit</th>
                                        <th>KETERANGAN</th>
                                        <th>Status <br> Approve </th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sakitizin as $d)
                                        <tr>
                                            <td>{{$loop->iteration+ $sakitizin->firstItem()-1}}</td>
                                            <td>{{date('d-m-Y', strtotime($d->tgl_pengajuanizin))}}</td>
                                            <td>{{$d->nik}}</td>
                                            <td>{{$d->nama_lengkap}}</td>
                                            <td>{{$d->jabatan}}</td>
                                            <td>{{$d->status == "i" ? "Izin" : "Sakit"}}</td>
                                            <td>{{$d->keterangan}}</td>
                                            <td valign="middle" >
                                                @if ($d->status_approved==1)
                                                    <span class="badge bg-success w-100" style="color: white">Disetujui</span>
                                                @elseif ($d->status_approved==2)
                                                    <span class="badge bg-danger w-100" style="color: white">Ditolak</span>
                                                @else
                                                <span class="badge bg-warning w-100" style="color: white">Menunggu</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->status_approved==0)
                                                <a href="#" class="btn btn-blue btn-sm" id="approve" id_sakitizin="{{$d->id}}">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/brand-pinterest -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-external-link" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" /><path d="M11 13l9 -9" /><path d="M15 4h5v5" /></svg>
                                                    Meninjau
                                                </a>
                                                @else
                                                <a href="/presensi/{{$d->id}}/batalkansakitizin" class="btn btn-red btn-sm">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/brand-pinterest -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-square-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z" /><path d="M9 9l6 6m0 -6l-6 6" /></svg>
                                                    Batalkan
                                                </a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$sakitizin->links('vendor.pagination.bootstrap-5')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modal-sakitizin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Peninjauan Izin / Sakit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/presensi/approvesakitizin" method="POST">
                @csrf
                <input type="hidden" id="id_sakitizin_form" name="id_sakitizin_form">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <select name="status_approved" id="status_approved" class="form-select">
                                <option value="1">Disetujui</option>
                                <option value="2">Ditolak</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-primary w-100" type="submit" style="margin-top: 20px">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 14l11 -11" /><path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" /></svg>
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@endsection

@push('myscript')
    <script>
        $(function(){
            $("#approve").click(function(e){
                e.preventDefault();
                var id_sakitizin = $(this).attr("id_sakitizin");
                $("#id_sakitizin_form").val(id_sakitizin);
                $("#modal-sakitizin").modal("show");
            });

            $("#dari, #sampai").datepicker({
                autoclose: true,
                todayHighlight: true,
                format:'yyyy-mm-dd'
            });
        });
    </script>
@endpush

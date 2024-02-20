@extends('layouts.presensi')
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<style>
    .datepicker-modal{
        max-height: 430px !important;
    }

    .datepicker-date-display{
        background: #14B8AD !important;
    }
</style>
<div class="appHeader">
    <div class="pageTitle">FORM PENGAJUAN SAKIT & IZIN</div>
</div>
@endsection
@section('content')
<div class="row" style="margin-top: 70px">
    <div class="col">
        <form method="POST" action="/presensi/storeizin" id="frmIzin">
            @csrf
            <div class="form-group">
                 <input type="text" id="tgl_pengajuanizin" name="tgl_pengajuanizin" class="form-control datepicker" placeholder="Pilih Tanggal Pengajuan">
            </div>
            <div class="form-group">
                 <select name="status" id="status" class="form-control">
                     <option value="">Pilih Jenis Pengajuan</option>
                    <option value="i">Izin</option>
                    <option value="s">Sakit</option>
                </select>
            </div>
            <div class="form-group">
                <textarea name="keterangan" style="border-radius: 20px" id="keterangan" cols="30" rows="7" class="form-control" placeholder="keterangan"></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-block" style="border-radius: 20px; font-size:18px">BUAT PENGAJUAN</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('myscript')
<script>
    var currYear = (new Date()).getFullYear();

$(document).ready(function() {
  $(".datepicker").datepicker({
    format: "yyyy-mm-dd"
  });

  $("#tgl_pengajuanizin").change(function(e){
    var tgl_pengajuanizin = $(this).val();
    $.ajax({
        type:'POST',
        url:'/presensi/cekpengajuanizin',
        data:{
            _token:"{{ csrf_token() }}",
            tgl_pengajuanizin : tgl_pengajuanizin
        },
        cache:false,
        success:function(respond){
            if(respond==1){
                Swal.fire({
                title: 'Oops !',
                text: 'Anda sudah melakukan input pengajuan pada tanggal tersebut.',
                icon: 'warning'
            }).then((result) => {
                $("#tgl_pengajuanizin").val("");
            });
            }
        }
    });
  });

  $("#frmIzin").submit(function(){
    var tgl_pengajuanizin = $("#tgl_pengajuanizin").val();
    var status = $("#status").val();
    var keterangan = $("#keterangan").val();
    if(tgl_pengajuanizin==""){
        Swal.fire({
            title: 'Oops !',
            text: 'Tanggal tidak boleh kosong',
            icon: 'warning'
        });
        return false;
    }else if (status == ""){
        Swal.fire({
            title: 'Oops !',
            text: 'Jenis pengajuan tidak boleh kosong',
            icon: 'warning'
        });
        return false;
    }else if (keterangan == ""){
        Swal.fire({
            title: 'Oops !',
            text: 'Keterangan tidak boleh kosong',
            icon: 'warning'
        });
        return false;
    }
  });
});
</script>
@endpush

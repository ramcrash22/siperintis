<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Laporan Presensi</title>

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>
    body{
        background-color: #fff;
    }
    h3{
        font-family: Arial, Helvetica, sans-serif;
    }

    .tabeldatakaryawan{
        margin-top: 20px;
        margin-left: 2cm;
        margin-right: 2cm;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11pt;
    }
    .tabeldatakaryawan td{
        padding: 5px;
    }

    .tabelpresensi{
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
        font-family: Arial, Helvetica, sans-serif;
    }

    .tabelpresensi > tr,th{
        border: 1px solid #171717;
        background-color: #0095ff;
        padding: 8px;
        font-size: 10pt;

    }

    .tabelpresensi td{
        border: 1px solid #171717;
        font-size: 9pt;

    }

    .ukfoto{
        height: 50px;
    }

    .ttd{
        width: 100%;
        margin-top: 3rem;
        margin-left: 200px;
        margin-right: 200px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11pt;
    }

    .ttdka{
        margin-top: 20px;
        width: 100%;
        padding-left: 600px;
        padding-right: 600px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11pt;
    }

  </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body>
    @php
     function selisih($jam_masuk, $jam_pulang)
        {
            list($h, $m, $s) = explode(":", $jam_masuk);
            $dtAwal = mktime($h, $m, $s, "1", "1", "1");
            list($h, $m, $s) = explode(":", $jam_pulang);
            $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
            $dtSelisih = $dtAkhir - $dtAwal;
            $totalmenit = $dtSelisih / 60;
            $jam = explode(".", $totalmenit / 60);
            $sisamenit = ($totalmenit / 60) - $jam[0];
            $sisamenit2 = $sisamenit * 60;
            $jml_jam = $jam[0];
            return "(".$jml_jam . " jam : " . round($sisamenit2)." menit)";
        }
    @endphp

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->


    <!-- Write HTML just like a web page -->
    {{--<article>This is an A4 document.</article>--}}

    <table style="width: 100%">
        <tr>
            <td>
                <img src="{{asset('assets/img/kemenkesbkk.png')}}" width="200" alt="">
            </td>
        </tr>
        <tr>
            <td align="center"><h3 style="margin-top: 50px"><u>LAPORAN PRESENSI PERIODE {{ strtoupper($namabulan[$bulan])}} {{$tahun}} </u></h3></td>
        </tr>
    </table>
    <table class="tabeldatakaryawan">
        <tr>
            <td>NIP</td>
            <td>:</td>
            <td>{{$karyawan->nik}}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{$karyawan->nama_lengkap}}</td>
        </tr>
        <tr>
            <td>Golongan</td>
            <td>:</td>
            <td>{{$karyawan->pangkat}}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{$karyawan->jabatan}} ( {{$karyawan->ket}} )</td>
        </tr>
        <tr>
            <td>Wilayah Kerja</td>
            <td>:</td>
            <td>{{$karyawan->namawilker}}</td>
        </tr>
    </table>
    <table class="tabelpresensi">
        <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Foto Masuk</th>
            <th>Jam Pulang</th>
            <th>Foto Pulang</th>
            <th>Keterangan</th>
            <th>Total Jam Kerja</th>

        </tr>
        @foreach ( $presensi as $p )
        @php
            $path_in = Storage::url('uploads/absensi/'.$p->foto_masuk);
            $path_out = Storage::url('uploads/absensi/'.$p->foto_pulang);
            $jamterlambat = selisih($p->jam_in,$p->jam_masuk);
        @endphp
            <tr>
                <td align="center" >{{$loop->iteration}}</td>
                <td align="center" >
                    @php
                        $hari = date("N", strtotime($p->tgl_presensi));
                    @endphp
                    {{$namahari[$hari]}}{{date(", d-M-Y", strtotime($p->tgl_presensi))}}</td>
                <td align="center" >{{$p->jam_masuk != null ? $p->jam_masuk : 'Tidak Absen'}}</td>
                <td align="center" >
                    @if ($p->jam_masuk != null)
                    <img src="{{ url($path_in)}}" alt="" class="ukfoto">
                    @else
                    <span style="color: red">Tidak Ada Foto</span>
                    @endif
                </td>
                <td align="center" >
                    @if ($p->jam_pulang != null)
                    {{$p->jam_pulang}}
                    @else
                    <span style="color: red">Tidak Absen</span>
                    @endif
                </td>
                <td align="center" >
                    @if ($p->jam_pulang != null)
                    <img src="{{ url($path_out)}}" alt="" class="ukfoto">
                    @else
                    <span style="color: red">Tidak Ada Foto</span>
                    @endif
                </td>
                <td align="center" >
                    @if ($p->jam_masuk > $p->jam_in)
                        <span style="color: red"><b>Terlambat<br>
                        {{$jamterlambat}}</b></span>
                    @else
                        <b>Tepat Waktu</b>
                    @endif
                </td>
                <td align="center">
                    <b>
                    @if ($p->jam_pulang != null)
                        @php
                            $jmljamkerja = selisih($p->jam_masuk, $p->jam_pulang);
                        @endphp
                    @else
                    <span style="color: red">
                       @php
                           $jmljamkerja = '0 Jam';
                       @endphp
                    @endif
                    {{$jmljamkerja}}
                    </b>
                </span>
                </td>
            </tr>
        @endforeach
    </table>
    <table class="ttd">
        <tr>
            <td>
                <br>
                Kepala Subbag Administrasi dan Umum<br>
                <br><br><br><br><br>
                <b>Jhonson Simarmata, SKM</b><br>
                <b>NIP 197705272005011002</b>
            </td>
            <td>
                @php
                $tanggal = date("j");
                $bulan = date("n");
                $tahun = date("Y")
                @endphp
                Pangkalpinang, {{$tanggal}} {{$namabulan[$bulan]}} {{$tahun}}<br>
                Analisis Kepegawaian Mahir<br>
                <br><br><br><br><br>
                <b>Fitra</b><br>
                <b>NIP 198210142010122002</b>
            </td>
        </tr>
    </table>
    <table  class="ttdka">
        <tr>
            <td>
                <br>
                Mengetahui,<br>
                Kepala Balai Kekarantinaan Kesehatan<br>
                Kelas II Pangkalpinang<br><br><br><br><br>
                <b>Agus Syah Fiqhi Haerullah, SKM, MKM</b><br>
                <b>NIP 197207081998031002</b>
            </td>
        </tr>
    </table>

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Laporan Rekap Presensi Karyawan</title>
  <style>
    body{
        background-color: white;
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
        font-size: 8pt;

    }

    .tabelpresensi td{
        border: 1px solid #171717;
        font-size: 8pt;

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
        padding-left: 630px;
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

    <!-- Write HTML just like a web page -->
    {{--<article>This is an A4 document.</article>--}}
    <table style="width: 100%">
        <tr>
            <td>
                <img src="{{public_path('assets/img/kemenkesbkk.png')}}" width="200" alt="">
            </td>
        </tr>
        <tr>
            <td align="center"><h3 style="margin-top: 50px"><u>LAPORAN REKAP PRESENSI KARYAWAN <br> PERIODE {{ strtoupper($namabulan[$bulan])}} {{$tahun}} </u></h3></td>
        </tr>
    </table>
    <table class="tabelpresensi">
        <tr>
            <th rowspan="2">NIP</th>
            <th rowspan="2">NAMA</th>
            <th colspan="31">TANGGAL</th>
            <th rowspan="2">TOTAL <br> HADIR</th>
            <th rowspan="2">TOTAL <br> TELAT</th>

        </tr>
        <tr>
            <?php
                for($i=1; $i<=31; $i++){
            ?>
            <th>{{ $i }}</th>
            <?php
                }
            ?>
        </tr>
        @foreach ($rekap as $r)
            <tr>
                <td>{{$r->nik}}</td>
                <td>{{$r->nama_lengkap}}</td>

                <?php
                $totalhadir = 0;
                $totalterlambat = 0;
                for($i=1; $i<=31; $i++){
                    $tgl = "tgl_".$i;

                    if(empty($r->$tgl)){
                        $hadir = ['',''];
                    }else {
                        $hadir = explode("-",$r->$tgl);
                        $totalhadir += 1;
                        if ($hadir[0] > "07:30:00") {
                            $totalterlambat += 1;
                        }
                    }
                ?>
                <td align="center">
                    <span style="color: {{ $hadir[0]>"07:30:00" ? "red" : ""  }}" >{{ $hadir[0] }}</span><br>
                    <span style="color: {{ $hadir[1]<"16:00:00" ? "red" : ""  }}" >{{ $hadir[1] }}</span><br>
                </td>
                <?php
                    }
                ?>
                <td align="center">{{$totalhadir}}</td>
                <td align="center">{{$totalterlambat}}</td>
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
                Kelas II Pangkalpinang<br><br><br><br><br><br><br>
                <b>Agus Syah Fiqhi Haerullah, SKM, MKM</b><br>
                <b>NIP 197207081998031002</b>
            </td>
        </tr>
    </table>

</body>

</html>

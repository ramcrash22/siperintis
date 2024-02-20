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
            return "( ".$jml_jam . " jam : " . round($sisamenit2)." menit )";
        }
@endphp
@foreach ($presensi as $p)
@php
    $masuk = Storage::url('uploads/absensi/'.$p->foto_masuk);
    $pulang = Storage::url('uploads/absensi/'.$p->foto_pulang);
@endphp
<tr style="vertical-align: middle">
    <td>{{$loop->iteration}}</td>
    <td>{{$p->nik}}</td>
    <td>{{$p->nama_lengkap}}</td>
    <td>{{$p->namawilker}}</td>
    <td>{{$p->nama_jam_kerja}} <br> <small>({{$p->jam_in}} s/d {{$p->jam_out}})</small></td>
    <td>{{$p->jam_masuk}}</td>
    <td><img src="{{url($masuk)}}" class="avatar" alt=""></td>
    <td>{!! $p->jam_pulang != null ? $p->jam_pulang : '<span class="badge bg-warning" style="color: white !important">Belum Absen</span>' !!}</td>
    <td>
        @if ($p->jam_pulang != null)
        <img src="{{url($pulang)}}" class="avatar" alt="">
        @else
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-hourglass-high" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6.5 7h11" /><path d="M6 20v-2a6 6 0 1 1 12 0v2a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1z" /><path d="M6 4v2a6 6 0 1 0 12 0v-2a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1z" /></svg>
        @endif
    </td>
    <td>
        @if ($p->jam_masuk> $p->jam_in)
        @php
            $jamterlambat = selisih($p->jam_in,$p->jam_masuk);
        @endphp
        <span class="badge bg-danger" style="color: white !important">Terlambat {{$jamterlambat}} </span>
        @else
        <span class="badge bg-success" style="color: white !important">Tepat Waktu</span>
        @endif
    </td>
    <td>
        <a href="#" class="btn btn-primary showmap" id="{{$p->id}}">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7" /><path d="M9 4v13" /><path d="M15 7v5" /><path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" /><path d="M19 18v.01" /></svg>
        </a>
    </td>
</tr>

@endforeach

<script>
    $(function(){
        $(".showmap").click(function(e){
            var id = $(this).attr("id");
            $.ajax({
                type:'POST',
                url:'/showmap',
                data:{
                    _token:"{{ csrf_token() }}",
                    id:id
                },
                cache:false,
                success:function(respond){
                    $("#loadmap").html(respond);
                }
            });
            $("#modal-showmap").modal("show");
        });
    })
</script>

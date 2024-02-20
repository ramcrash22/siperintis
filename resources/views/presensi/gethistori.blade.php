@if ($histori -> isEmpty())
    <div class="alert alert-warning" style="text-transform:uppercase; text-align:center; font-size:16px">
        <p>belum ada data untuk ditampilkan</p>
    </div>
@endif
@foreach ($histori as $d)
<ul class="listview image-listview">
    <li>
        <div class="item">
            @php
                $path = Storage::url('uploads/absensi/'.$d->foto_masuk);
            @endphp
            <img src="{{url($path)}}" alt="image" class="image">
            <div class="row">
                <div class="col-12">
                    <div class="in">
                        <div>
                            @php
                            $hari = date("N", strtotime($d->tgl_presensi));
                            @endphp
                            <b style="color: #14B8AD">{{$namahari[$hari]}}, {{date("d-m-Y", strtotime($d->tgl_presensi))}}</b>
                            <br>
                            {{--<small class="text-muted">{{$d->jabatan}}</small>--}}
                        </div>
                        <span class="badge {{$d->jam_masuk < $d->jam_in ? "bg-success" : "bg-danger"}} ">
                            {{$d->jam_masuk}}
                        </span>
                        <span class="badge bg-primary">{{$d->jam_pulang}}</span>
                    </div>
                </div>
                <div class="col-12">
                    <div id="keterangan" style="font-size: 12px">
                        @php
                            $jam_masuk = date("H:i",strtotime($d->jam_masuk));
                            $jam_in = date("H:i",strtotime($d->jam_in));

                            $jadwal_jam_masuk = $d->tgl_presensi."".$jam_in;
                            $jam_presensi = $d->tgl_presensi."".$jam_masuk;
                        @endphp
                        @if ($jam_masuk > $jam_in)
                            @php
                                $jmlterlambat = hitungjamterlambat($jadwal_jam_masuk,$jam_presensi);
                            @endphp
                            <span class="bkkcolor">TERLAMBAT {{$jmlterlambat}}</span>
                        @else
                            <span class="kemenkescolor">TEPAT WAKTU</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </li>
</ul>
@endforeach

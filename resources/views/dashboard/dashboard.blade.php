@extends('layouts.presensi')
@section('content')
<div class="section" id="user-section">
            <div>
                <img src="{{ asset('assets/img/kemenkesbkk.png')}}" style="width: 40%" class="mb-4">
            </div>
            <div id="user-detail">
                <div class="avatar circular--portrait">
                    @if (!empty(Auth::guard('karyawan')->user()->foto))
                    @php
                        $path = Storage::url('uploads/karyawan/profil/'.Auth::guard('karyawan')->user()->foto);
                    @endphp
                    <img src="{{ url($path) }}" alt="avatar">
                    @else
                    <center><img src="assets/img/sample/avatar/usernophoto.png" alt="avatar" style="width:75px"></center>
                    @endif
                </div>
                <div id="user-info">
                    <h4 id="user-name">{{ strtoupper(Auth::guard('karyawan')->user()->nama_lengkap)}}</h4>
                    <h5 id="user-role">{{ strtoupper(Auth::guard('karyawan')->user()->jabatan)}}</h5>
                    <h5 id="user-location">{{ strtoupper($wilker->namawilker)}}</h5>
                </div>
            </div>
        </div>
        <div class="section mt-6" id="presence-section">
            <div class="carddash">
                <div class="card-body text-center">
                    <div class="list-menu">
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/editprofile" class="kemenkescolor" style="font-size: 25px;">
                                    <ion-icon name="person-sharp"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                PROFIL
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/presensi/cuti" class="kemenkescolor" style="font-size: 25px;">
                                    <ion-icon name="airplane"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                CUTI
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/presensi/histori" class="kemenkescolor" style="font-size: 25px;">
                                    <ion-icon name="document-text"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                HISTORI
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/presensi/lokasi" class="kemenkescolor" style="font-size: 25px;">
                                    <ion-icon name="location"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                LOKASI
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="todaypresence" style="margin-top:5%">
                <div class="row">
                    <div class="col-6">
                        <div class="card masukcolor">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="iconpresence">
                                            @if ($presensitoday != null)
                                                @php
                                                    $path = Storage::url('uploads/absensi/'.$presensitoday->foto_masuk)
                                                @endphp
                                                <img src="{{ url($path)}}" alt="" class="imaged w100"><br>
                                            @else
                                                <ion-icon name="image"></ion-icon>
                                            @endif
                                        </div>
                                        <div class="presencedetail">
                                            <p class="presencetitle">ABSEN MASUK</p><br><br>
                                            @if ($presensitoday != null)
                                            <span class="jammasuk">{{$presensitoday -> jam_masuk}}</span>
                                            @else
                                            <span class="jammasuk2">BELUM ABSEN</span>
                                            @endif
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card pulangcolor">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="iconpresence">
                                            @if ($presensitoday != null && $presensitoday -> jam_pulang != null)
                                                @php
                                                    $path = Storage::url('uploads/absensi/'.$presensitoday->foto_pulang)
                                                @endphp
                                                <img src="{{ url($path)}}" alt="" class="imaged w100"><br>
                                            @else
                                                <ion-icon name="image"></ion-icon>
                                            @endif
                                        </div>
                                        <div class="presencedetail">
                                            <p class="presencetitle">ABSEN PULANG</p><br><br>
                                            @if ($presensitoday != null && $presensitoday -> jam_pulang != null)
                                            <span class="jampulang">{{$presensitoday -> jam_pulang}}</span>
                                            @else
                                            <span class="jampulang2">BELUM ABSEN</span>
                                            @endif
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="carddash" style="margin-top: 20px">
                    <div class="card-body">
                        <div class="col-12 text-center">
                            <a href="/presensi/lembur" class="kemenkescolor" style="font-size: 25px">
                                <ion-icon name="time" style="vertical-align: middle"></ion-icon>
                                <span style="font-size: 20px">LEMBUR</span>
                            </a>
                        </div>
                    </div>
                </div>
            <div id="rekappresensi">
                <div class="row rekaptitle" style="margin-top:15px">
                    <p>Rekap Presensi {{$namabulan[$bulanini] }} {{$tahunini}}</p>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="cardrekap">
                            <div class="card-body text-center" style="padding: 12px 12px !important; line-height:1rem">
                                <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; font-size:0.7rem;
                                z-index : 999 ">{{$rekappresensi->jmlhadir}}</span>
                                <ion-icon name="accessibility" style="font-size:1.5rem" class="kemenkescolor"></ion-icon><br>
                                <span style="font-size : 0.8rem; font-weight: lighter " class="kemenkescolor">Hadir</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="cardrekap">
                            <div class="card-body text-center" style="padding: 12px 12px !important; line-height:1rem">
                                <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; font-size:0.7rem;
                                z-index : 999 ">{{$rekapizin->jmlizin}}</span>
                                <ion-icon name="calendar" style="font-size:1.5rem" class="kemenkescolor"></ion-icon><br>
                                <span style="font-size : 0.8rem; font-weight: lighter " class="kemenkescolor">Izin</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="cardrekap">
                            <div class="card-body text-center" style="padding: 12px 12px !important; line-height:1rem">
                                <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; font-size:0.7rem;
                                z-index : 999 ">{{$rekapizin->jmlsakit}}</span>
                                <ion-icon name="medkit" style="font-size:1.5rem" class="kemenkescolor"></ion-icon><br>
                                <span style="font-size : 0.8rem; font-weight: lighter " class="kemenkescolor">Sakit</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="cardrekap">
                            <div class="card-body text-center" style="padding: 12px 12px !important; line-height:1rem">
                                <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; font-size:0.7rem;
                                z-index : 999 ">{{$rekappresensi->jmltelat}}</span>
                                <ion-icon name="alarm" style="font-size:1.5rem" class="kemenkescolor"></ion-icon><br>
                                <span style="font-size : 0.8rem; font-weight: lighter " class="kemenkescolor">Telat</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="presencetab mt-2">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                Bulan Ini
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                Leaderboard
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        {{--<ul class="listview image-listview">
                        @foreach($historibulanini as $d)
                        @php
                            $path = Storage::url('uploads/absensi/'.$d->foto_masuk)
                        @endphp
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="finger-print"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>
                                            @php
                                            $hari = date("N", strtotime($d->tgl_presensi));
                                            @endphp
                                            <b>{{$namahari[$hari]}}<br>{{ date("d-m-Y",strtotime($d->tgl_presensi)) }}</b>
                                        </div>
                                        <span class="badge badge-primary">{{ $d->jam_masuk}}</span>
                                        <span class="badge badge-danger">{{ $presensitoday != null && $d->jam_pulang != null
                                            ? $d->jam_pulang : 'Belum Absen'}}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        </ul>--}}
                        @foreach ($historibulanini as $d)
                            <div class="cardpresensi">
                                <div class="card-body">
                                    <div class="historicontent">
                                        <div class="iconpresensi">
                                            <ion-icon name="finger-print" style="font-size: 40px;" class="kemenkescolor"></ion-icon>
                                        </div>
                                        <div class="datapresensi" style="font-style: normal !important">
                                            <h4 class="kemenkescolor" style="line-height: 3px">Jadwal {{$d->nama_jam_kerja}}</h4>
                                            @php
                                            $hari = date("N", strtotime($d->tgl_presensi));
                                            @endphp
                                            <h5 class="bkkcolor" style="margin: 0px !important">{{$namahari[$hari]}}, {{ date("d-m-Y",strtotime($d->tgl_presensi)) }}</h5>
                                            <span class="kemenkescolor" style="font-size: 12px">
                                                {!! $d->jam_masuk != null ? date("H:i",strtotime($d->jam_masuk)) : '<span
                                                class="bkkcolor" style="font-size: 11px"> - BELUM ABSEN</span>' !!}
                                            </span>
                                            <span class="kemenkescolor" style="font-size: 12px">
                                                {!! $d->jam_pulang != null ? " - ".date("H:i",strtotime($d->jam_pulang)) : '<span
                                                class="bkkcolor" style="font-size: 11px"> - BELUM ABSEN</span>' !!}
                                            </span>
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
                                                    <span class="text-danger" style="font-size: 9px">( TERLAMBAT {{$jmlterlambat}} )</span>
                                                @else
                                                    <span class="kemenkescolor" style="font-size: 9px">( TEPAT WAKTU )</span>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ($leaderboard as $d)
                            <li>
                                <div class="item">
                                    <img src="assets/img/sample/avatar/user.png" alt="image" class="image">
                                    <div class="in">
                                        <div>
                                            <b class="kemenkescolor">{{$d -> nama_lengkap}}</b>
                                            <br>
                                            <small class="text-muted bkkcolor">{{$d->jabatan}}</small>
                                        </div>
                                        <span class="badge {{$d->jam_masuk < $d->jam_in ? "bg-success" : "bg-danger"}} ">
                                            {{$d->jam_masuk}}
                                        </span>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
@endsection

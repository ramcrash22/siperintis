@extends('layouts.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader" style="position: relative">
        <div class="pageTitle">FOTO PRESENSI</div>
    </div>
    <!-- * App Header -->
    <style>
        .webcam-capture,
        .webcam-capture video{
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 20px;
        }

        #map { height: 245px; }

    .jam-digital-malasngoding {

        background-color: #27272783;
        position: absolute;
        top: 80px;
        right: 15px;
        z-index: 9999;
        width: 150px;
        border-radius: 10px;
        padding: 5px;
    }



    .jam-digital-malasngoding p {
        color: #fff;
        font-size: 11px;
        text-align: left;
        margin-top: 0;
        margin-bottom: 0;
    }
</style>
    </style>
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection
@section('content')
        <div class="row" style="margin-top: 15px">
            <div class="col">
                <input type="hidden" id="lokasi">
                <div class="webcam-capture"></div>
            </div>
        </div>
        <div class="jam-digital-malasngoding">
            <p style="text-align: center">Wajah Wajib Terlihat</p>
            <p id="jam"></p>
            <p class="tanggalhariini">{{$namahari_m[$hari]}}, {{date("d-m-y")}}</p>
            <p>Ket. Presensi : {{$jamkerja->nama_jam_kerja}}</p>
            <p>Mulai Presensi : {{date("H:i",strtotime($jamkerja->awal_jam_masuk))}}</p>
            <p>Jam Masuk : {{date("H:i",strtotime($jamkerja->jam_in))}}</p>
            <p>Akhir Pre. Masuk : {{date("H:i",strtotime($jamkerja->akhir_jam_masuk))}}</p>
            <p>Jam Pulang : {{date("H:i",strtotime($jamkerja->jam_out))}}</p>
            <p>Akhir Pre. Pulang : {{date("H:i",strtotime($jamkerja->akhir_jam_pulang))}}</p>
        </div>
        <div class="row" style="margin-top: 20px">
            <div class="col">
                @if($cek > 0)
                <button id="takeabsen" class="btn btn-bkkcolor" style="text-transform: uppercase">
                    <ion-icon name="camera-outline" style="vertical-align: middle"></ion-icon>
                        ABSEN PULANG
                </button>
                @else
                <button id="takeabsen" class="btn btn-kemenkescolor">
                    <ion-icon name="camera-outline" style="vertical-align: middle"></ion-icon>
                        ABSEN MASUK
                </button>
                @endif
            </div>
        </div>
        <div class="row mt-2" style="margin-bottom: 100px">
            <div class="col">
                <div id="map"></div>
            </div>
        </div>
        <audio id="notifikasi_masuk">
            <source src="{{ asset('assets/sound/notifikasi_masuk.mp3')}}" type="audio/mpeg">
        </audio>
        <audio id="notifikasi_pulang">
            <source src="{{ asset('assets/sound/notifikasi_pulang.mp3')}}" type="audio/mpeg">
        </audio>
        <audio id="radius_sound">
            <source src="{{ asset('assets/sound/notifikasi_radius.mp3')}}" type="audio/mpeg">
        </audio>
@endsection

@push('myscript')
    <script type="text/javascript">
        window.onload = function() {
            jam();
        }

        function jam() {
            var e = document.getElementById('jam')
                , d = new Date()
                , h, m, s;
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());

            e.innerHTML = h + ':' + m + ':' + s;

            setTimeout('jam()', 1000);
        }

        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }

    </script>
    <script>
        var notifikasi_masuk = document.getElementById('notifikasi_masuk');
        var notifikasi_pulang = document.getElementById('notifikasi_pulang');
        var radius_sound = document.getElementById('radius_sound');
        Webcam.set({
            height:480,
            width:640,
            image_format:'jpeg',
            jpeg_quality: 70
        });

        Webcam.attach('.webcam-capture')

        var lokasi = document.getElementById('lokasi');
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(position){
            lokasi.value=position.coords.latitude+","+position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 17);
            var lokasi_kantor = "{{ $lok_kantor->lokasikantor }}"
            var lok = lokasi_kantor.split(",");
            var lat_kantor = lok[0];
            var long_kantor = lok[1];
            var radius = "{{$lok_kantor->radius}}"
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                 maxZoom: 23,
                 attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            var circle = L.circle([lat_kantor,long_kantor], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: radius
            }).addTo(map);
        }

        function errorCallback(){

        }

        $("#takeabsen").click(function(e){
            Webcam.snap(function(uri){
                image = uri;
            });
            var lokasi = $("#lokasi").val();
            $.ajax({
                type:'POST',
                url:'/presensi/store',
                data:{
                    _token:"{{csrf_token()}}",
                    image:image,
                    lokasi:lokasi,
                },
                cache:false,
                success:function(respond){
                    var status = respond.split("|");
                    if(status[0] == "success"){
                        if (status[2] == "in"){
                            notifikasi_masuk.play();
                        }else{
                            notifikasi_pulang.play();
                        }
                        Swal.fire({
                                title: 'Berhasil !',
                                text: status[1],
                                icon: 'success'
                        })
                        setTimeout("location.href='/dashboard'", 3000);
                    }else{
                        if (status[2] == "radius"){
                            radius_sound.play();
                        }
                        Swal.fire({
                                title: 'Error !',
                                text: status[1],
                                icon: 'error'
                        })
                    }
                }
            });
        });

    </script>
@endpush

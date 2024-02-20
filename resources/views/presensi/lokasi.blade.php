@extends('layouts.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader" style="position: relative">
        <div class="pageTitle">LOKASI SEKARANG</div>
    </div>
    <!-- * App Header -->
    <style>
        #map { height: 480px; }
    </style>
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection
@section('content')
        <div class="row" style="margin-top: 15px">
            <div class="col">
                <input type="hidden" id="lokasi">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <div id="map"></div>
            </div>
        </div>
@endsection

@push('myscript')
    <script>
        var notifikasi_masuk = document.getElementById('notifikasi_masuk');
        var notifikasi_pulang = document.getElementById('notifikasi_pulang');
        var radius_sound = document.getElementById('radius_sound');

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

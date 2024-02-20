<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>SIPERINTIS BALAI KARKES PGK</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png')}}" sizes="32x32">
    <link rel="shortcut icon" href="{{ asset('assets/img/logosiperintis.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/logosiperintis.png')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/loginsiperintis.css')}}">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link rel="manifest" href="{{ asset('assets/js/manifest.json')}}" crossorigin="use-credentials">
</head>

<body>
    <img src="{{ asset('assets/img/login/supergrafis-pojok.png')}}" alt="image" class="supergrafis">
    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->


    <!-- App Capsule -->
    <div id="appCapsule" class="pt-0">
        <div class="login-form" style="margin-top: 3.5rem">
            <div class="section">
                <div class="siperintisform">
                    <div class="section mb-4">
                        <form action="/proseslogin" method="POST">
                            @csrf
                                <div class="container">
                                    <img src="{{ asset('assets/img/login/logo.png')}}" alt="image" class="form-image" style="margin-top: 1rem">
                                    <div class="section mt-1">
                                        <h3 style="margin-top: 20px; margin-bottom: 20px;"><p style="color: #14B8AD">SISTEM INFORMASI</p> <p style="color: #CCDB39">PRESENSI, IZIN, CUTI DAN SAKIT</p></h3>
                                    </div>
                                    @php
                                    $messagewarning = Session::get('warning')
                                    @endphp
                                    @if (Session::get('warning'))
                                    <div class="alert alert-warning" style="margin-bottom: 20px; color:orange;">
                                        <b>*{{$messagewarning}}*</b>
                                    </div>
                                    @endif
                                    <input type="text" id="username" name="username" placeholder="Username" autocomplete="off">
                                    <input type="password" id="password" name="password" placeholder="Password">
                                    <button type="submit" id="login">Login</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
</body>

<!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="{{ asset('assets/js/lib/jquery-3.4.1.min.js')}}"></script>
    <!-- Bootstrap-->
    <script src="{{ asset('assets/js/lib/popper.min.js')}}"></script>
    <script src="{{ asset('assets/js/lib/bootstrap.min.js')}}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="{{ asset('assets/js/plugins/owl-carousel/owl.carousel.min.js')}}"></script>
    <!-- jQuery Circle Progress -->
    <script src="{{ asset('assets/js/plugins/jquery-circle-progress/circle-progress.min.js')}}"></script>
    <!-- Base Js File -->
    <script src="{{ asset('assets/js/base.js')}}"></script>

</html>

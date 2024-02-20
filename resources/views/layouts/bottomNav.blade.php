<div class="appBottomMenu">
        <a href="/dashboard" class="item {{request()->is('dashboard')?'active':''}}">
            <div class="col">
            <ion-icon name="home" class="text-light"></ion-icon>
                <strong class="text-light">Home</strong>
            </div>
        </a>
        <a href="/presensi/histori" class="item {{request()->is('presensi/histori')?'active':''}}">
            <div class="col">
                <ion-icon name="document-text" role="img" class="text-light md hydrated"
                    aria-label="document text"></ion-icon>
                <strong class="text-light">Histori</strong>
            </div>
        </a>
        <a href="/presensi/create" class="item {{request()->is('presensi/create')?'active':''}}">
            <div class="col">
                <div class="action-button large">
                    <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                </div>
            </div>
        </a>
        <a href="/presensi/izin" class="item {{request()->is('presensi/izin')?'active':''}}">
            <div class="col">
                <ion-icon name="calendar" role="img" class="text-light md hydrated"
                    aria-label="calendar"></ion-icon>
                <strong class="text-light">Izin</strong>
            </div>
        </a>
        <a href="/editprofile" class="item {{request()->is('editprofile')?'active':''}}">
            <div class="col">
                <ion-icon name="people" role="img" class="text-light md hydrated" aria-label="people"></ion-icon>
                <strong class="text-light">Profil</strong>
            </div>
        </a>
    </div>

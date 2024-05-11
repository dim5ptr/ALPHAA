<nav class="navbar shadow-xl" style="background-color: #00008B;">
    <div class="container-fluid">
        <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
            <i class="bi bi-list"></i>
        </button>
        <div style="color: white; margin-left: 10px;">Sarastya Technology Integrata</div>
        <div style="background-color: white; width: 60px; height: 60px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
            <img width="80px" src="{{ asset('img/logo_sarastya.png') }}" style="padding: 5px;">
        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
    <div class="offcanvas-header" style="background-color: #00008B; color: white;">
        <h3 class="offcanvas-title" id="offcanvasScrollingLabel">
            Dashboard
        </h3>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" style="background-color: #202340;">
        <div class="text-light">
            <h6>MENU</h6>
        </div>
        <div class="grid gap-4 text-light">
            <div class="p-2">
                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">
                    <h6><i class="bi bi-house-door"></i> Home</h6>
                </a>
            </div>
            <div class="p-2">
                <a href="{{ route('tes_pkl') }}" class="list-group-item list-group-item-action">
                    <h6><i class="bi bi-tags-fill"></i> Tes Prakerin/PKL </h6>
                </a>
            </div>
            <div class="p-2">
                <a href="{{ route('about') }}" class="list-group-item list-group-item-action">
                    <h6><i class="bi bi-info-circle-fill"></i> About Us </h6>
                </a>
            </div>
            <div class="p-2">
                <a href="{{ route('profil') }}" class="list-group-item list-group-item-action">
                    <h6><i class="bi bi-person-fill"></i> Profil</h6>
                </a>
            </div>
            <div class="p-2">
                <a href="{{ route('login') }}" class="list-group-item list-group-item-action">
                    <h6><i class="bi bi-box-arrow-left"></i> Logout</h6>
                </a>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer" style="background-color: #8D99AE; color: white;">
        <div class="grid ps-4 m-3">
            <h6>Logged In As :</h6>
            <h6>
                <i class="bi bi-person-lines-fill"></i> {{ Auth::user()->user_fullname }}
            </h6>
        </div>
    </div>
</div>

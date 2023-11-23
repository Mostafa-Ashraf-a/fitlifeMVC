<nav class="navbar navbar-expand-lg ftco-navbar-light">
    <div class="container-xl">

        <a class="navbar-brand align-items-center fs-4" href="{{ route('web.indexen') }}">
            Fit<span>Life</span>
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link fs-6 fw-bold active"
                        href="{{ route('web.indexen') }}#home">Home</a>
                </li>
                <li class="nav-item"><a class="nav-link fs-6 fw-bold active" href="{{ route('web.indexen') }}#services">Our
                        Services</a></li>
                <li class="nav-item"><a class="nav-link fs-6 fw-bold active" href="{{ route('web.indexen') }}#about">About
                        FitLife</a></li>
                <li class="nav-item"><a class="nav-link fs-6 fw-bold active" href="{{ route('web.indexen') }}#how_to_start">How to Get Started ?</a></li>
                <li class="nav-item"><a class="nav-link fs-6 fw-bold active"
                        href="{{ route('web.indexen') }}#vision_mission">Our
                        Vision & Mission</a></li>
                <li class="nav-item"><a class="nav-link fs-6 fw-bold active" href="{{ route('web.indexen') }}#contact">Contact
                        Us</a></li>
            </ul>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="fa fa-bars"></span> Menu
        </button>


        <div class="dropdown">
            <a href="{{ route('web.index') }}">
                <button class="btn btn-secondary" type="button" id="languageDropdown">
                    عربي
                </button>
            </a>
        </div>
    </div>
</nav>

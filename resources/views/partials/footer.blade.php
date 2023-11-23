<footer class="ftco-footer">
    <div class="container-xl">
        <div class="row mb-5 pb-5 justify-content-between">
            <div class="col-md-6 col-lg">
                <div class="ftco-footer-widget mb-4">


                    <h2 class="ftco-heading-2 logo d-flex">
                        <img src="{{ asset('web/images/logo.png') }}" width="100" height="100" alt="logo">

                        <a class="navbar-brand align-items-center ms-4 fs-1 mt-3" href="{{ route('web.index') }}">
                            Fit<span>Life</span>
                        </a>
                    </h2>
                    <p>
                        Transform your health and fitness journey with our innovative mobile app, empowering you to
                        achieve your goals and live a vibrant, active lifestyle.
                    </p>
                    <ul class="ftco-footer-social list-unstyled mt-2">
                        <li><a target="_blank" href="https://www.instagram.com/fitlife_ar/"><span
                                    class="fa fa-twitter"></span></a></li>
                        <li><a target="_blank" href="https://www.instagram.com/fitlife_ar/"><span
                                    class="fa fa-facebook"></span></a></li>
                        <li><a target="_blank" href="https://www.instagram.com/fitlife_ar/"><span
                                    class="fa fa-instagram"></span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">Usage Policy</h2>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="ftco-footer-widget mb-4">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="{{ route('web.privacy') }}">
                                        <span class="fa fa-chevron-right me-2"></span>
                                        Privacy Policy
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('web.resources') }}">
                                        <span class="fa fa-chevron-right me-2"></span>
                                        Resources
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">Have a Questions?</h2>
                    <div class="block-23 mb-3">
                        <ul>

                            <li>
                                <a href="#">
                                    <span class="icon fa fa-map marker"></span>
                                    <span class="text">2690, Fatuh Al Buldan St. Nahdah Dist, Jeddah, SA</span>
                                </a>

                            </li>

                            <li>
                                <a href="#">
                                    <span class="icon fa fa-phone"></span><span class="text">
                                        +966 56 078 4061
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <span class="icon fa fa-paper-plane pr-4"></span>
                                    <span class="text">info@fitlifesa.com</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid px-0 py-5 bg-darken">
        <div class="container-xl">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="mb-0 fs-6" style="color: rgba(255,255,255,.5); font-size: 13px;">Copyright &copy;
                        <script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved by
                        <a href="{{ route('web.index') }}" rel="nofollow noopener">
                            FitLife Company
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

@include('partials.scripts')
</body>

</html

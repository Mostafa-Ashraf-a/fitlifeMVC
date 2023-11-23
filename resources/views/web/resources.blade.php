@include('partials.head')


<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-xl">
        <a class="navbar-brand align-items-center fs-4" href="{{ route('web.index') }}">
            Fit<span>Life</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="fa fa-bars"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link text-white active" href="{{ route('web.index') }}#home">Home</a>
                </li>
                <li class="nav-item"><a class="nav-link text-white"
                        href="{{ route('web.index') }}#services">Services</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('web.index') }}#about">About</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('web.index') }}#how_to_start">How to
                        Start!?</a></li>
                <li class="nav-item"><a class="nav-link text-white"
                        href="{{ route('web.index') }}#vision_mission">Vision & Mission</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('web.index') }}#contact">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="ftco-section ftco-about-section" id="privacy_policy" style="padding-top: 4rem;">
    <div class="container-xl">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Warning!</strong> {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Info!</strong> {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-xl-5">
            <div class="col-md-12 heading-section d-flex align-items-center" data-aos="fade-up" data-aos-delay="200"
                data-aos-duration="1000">
                <div class="mt-md-0">

                    <span class="subheading fs-3">Welcome to FitLife Resources:</span>
                    <h3 class="text-white ms">Your Ultimate Health and Fitness Guide</h3>
                    <p>
                        At FitLife Resources, we are dedicated to providing you with a comprehensive collection of
                        resources to help you achieve your health and fitness goals. Our team of experts, including
                        dietitians, personal trainers, and professionals from the health and fitness sectors, have
                        collaborated with programmers to develop an innovative algorithm that automates the process of
                        creating personalized diet and exercise plans.
                    </p>

                    <p>
                        We understand that navigating the vast world of health and fitness can be overwhelming, which is
                        why we have also curated a selection of articles designed to increase your awareness and
                        knowledge in these areas.
                    </p>

                    <p>
                        What sets FitLife Resources apart is our unwavering commitment to accuracy and reliability.
                        Every piece of content available on our platform undergoes meticulous validation by our experts
                        to ensure that the information provided to you is correct and up-to-date. Our team of experts
                        combines their extensive knowledge with certified resources to create reliable content and the
                        algorithm that suggests tailored programs for you.
                    </p>

                    <p>
                        On this web page, you will find a wealth of resources to support your journey towards a
                        healthier lifestyle. From expert articles to certifications and references, we have compiled
                        everything you need to make informed decisions about your well-being.
                    </p>

                    <p>
                        We invite you to explore FitLife Resources and take advantage of the valuable information and
                        materials at your fingertips. Empower yourself with the knowledge and tools necessary to live a
                        fit and healthy life.
                    </p>

                    <h4 class="text-white">
                        <strong>
                            Start your journey today with FitLife Resources!
                        </strong>
                    </h4>
                </div>
            </div>
        </div>

        <div class="row g-xl-5 mt-5 mb-5">
            <div class="col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100"
                data-aos-duration="1000">
                <div class="img w-100 section-counter"
                    style="background-image: url('{{ asset('web/images/certificate.PNG') }}');">
                </div>

            </div>

            <div class="col-md-6 heading-section d-flex align-items-center" data-aos="fade-up" data-aos-delay="200"
                data-aos-duration="1000">
                <div class="mt-5 mt-md-0">
                    <span class="subheading">Raghad Malibari (Suggestion Plan Algorithm Dietitian):</span>
                    <p>
                        FitLife team have a wide experience in the health and fitness sectors. It consists of dietitian,
                        personal trainer and other expertise in the health and fitness sector that worked along with
                        programmers to develop an algorithm that automates the process of creating diet and exercise
                        plans. Also, the team worked to create a list of articles that increases the users’ awareness on
                        health and fitness.
                    </p>
                    <p>
                        All of the content in the application is validated by the experts to assure that the information
                        provided to the users’ is correct and accurate. Our experts used their knowledge along with
                        certified resources to create the app content and the algorithm that suggests the the users’
                        programs. Below will be attached the experts’ certificates and resources used to build the app
                        content and automated service.
                    </p>

                </div>
            </div>
        </div>

        <div class="row g-xl-5 mt-5 mb-5">
            <div class="col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100"
                data-aos-duration="1000">
                <div class="img w-100 section-counter"
                    style="background-image: url('{{ asset('web/images/suhail.PNG') }}');">
                </div>

            </div>

            <div class="col-md-6 heading-section d-flex align-items-center" data-aos="fade-up" data-aos-delay="200"
                data-aos-duration="1000">
                <div class="mt-5 mt-md-0">
                    <span class="subheading">Suhail Mulla (Personal trainer):</span>
                    <p>
                        FitLife team have a wide experience in the health and fitness sectors. It consists of dietitian,
                        personal trainer and other expertise in the health and fitness sector that worked along with
                        programmers to develop an algorithm that automates the process of creating diet and exercise
                        plans. Also, the team worked to create a list of articles that increases the users’ awareness on
                        health and fitness.
                    </p>
                    <p>
                        All of the content in the application is validated by the experts to assure that the information
                        provided to the users’ is correct and accurate. Our experts used their knowledge along with
                        certified resources to create the app content and the algorithm that suggests the the users’
                        programs. Below will be attached the experts’ certificates and resources used to build the app
                        content and automated service.
                    </p>

                </div>
            </div>
        </div>

        <div class="row g-xl-5 mt-5 mb-5">
            <div class="col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100"
                data-aos-duration="1000">
                <div class="img w-100 section-counter"
                    style="background-image: url('{{ asset('web/images/kaki.PNG') }}');">
                </div>

            </div>

            <div class="col-md-6 heading-section d-flex align-items-center" data-aos="fade-up" data-aos-delay="200"
                data-aos-duration="1000">
                <div class="mt-5 mt-md-0">
                    <span class="subheading">Mohammed Kaki (Sports Nutrition):</span>
                    <p>
                        FitLife team have a wide experience in the health and fitness sectors. It consists of dietitian,
                        personal trainer and other expertise in the health and fitness sector that worked along with
                        programmers to develop an algorithm that automates the process of creating diet and exercise
                        plans. Also, the team worked to create a list of articles that increases the users’ awareness on
                        health and fitness.
                    </p>
                    <p>
                        All of the content in the application is validated by the experts to assure that the information
                        provided to the users’ is correct and accurate. Our experts used their knowledge along with
                        certified resources to create the app content and the algorithm that suggests the the users’
                        programs. Below will be attached the experts’ certificates and resources used to build the app
                        content and automated service.
                    </p>

                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-8 heading-section text-center mb-5" data-aos="fade-up" data-aos-duration="1000">
                {{-- <span class="subheading">Our Team</span> --}}
                <h3 class="mb-4 text-white">Our Team</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 text-center d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100"
                data-aos-duration="1000">

                <div class="services-2">
                    <div class="img" style="background-image: url('{{ asset('web/images/steve.jpg') }}');">
                    </div>
                    <div class="text">
                        <h2 class="text-white">Steve Jobs</h2>
                        <p class="mb-4">Experience the power of our app by downloading it from the App Store or
                            Google
                            Play.</p>
                        {{-- <p>
                            <a target="_blank" href="https://google.com" class="btn-custom">
                                <img src="{{ asset('web/images/app-store.png') }}" width="20" height="20"
                                    alt="">
                                App Store</a>

                            <a target="_blank" href="https://google.com" class="btn-custom">
                                <img src="{{ asset('web/images/google-play.png') }}" width="20" height="20"
                                    alt="">
                                Google Play
                            </a>
                        </p> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100"
                data-aos-duration="1000">
                <div class="services-2">
                    <div class="img" style="background-image: url('{{ asset('web/images/steve.jpg') }}' );">
                    </div>
                    <div class="text">
                        <h2 class="text-white">Steve Jobs</h2>
                        <p class="mb-4">Get started on your fitness journey by easily registering and logging in to
                            our app.</p>
                        {{-- <p>
                            <a href="https://vimeo.com/115041822" class="glightbox btn-custom">Watch Video</a>
                        </p> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100"
                data-aos-duration="1000">
                <div class="services-2">
                    <div class="img" style="background-image: url('{{ asset('web/images/steve.jpg') }}');">
                    </div>
                    <div class="text">
                        <h2 class="text-white">Steve Jobs</h2>
                        <p class="mb-4">Create a customized meal schedule that aligns with your unique dietary needs
                            and preferences.</p>
                        {{-- <p>
                            <a href="https://vimeo.com/115041822" class="glightbox btn-custom">Watch Video</a>
                        </p> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100"
                data-aos-duration="1000">
                <div class="services-2">
                    <div class="img" style="background-image: url('{{ asset('web/images/steve.jpg') }}' );">
                    </div>
                    <div class="text">
                        <h2 class="text-white">Steve Jobs</h2>
                        <p class="mb-4">Design a personalized workout plan tailored to your fitness goals and skill
                            level.</p>
                        {{-- <p>
                            <a href="https://vimeo.com/115041822" class="glightbox btn-custom">Watch Video</a>
                        </p> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-8 heading-section text-center mb-5" data-aos="fade-up" data-aos-duration="1000">
                {{-- <span class="subheading">Our Team</span> --}}
                <h3 class="mb-4 text-white">Other Resources</h3>
            </div>
        </div>

        <div class="row justify-content-center">


            <div class="col-md-6 col-lg-4 d-flex">
                <div class="blog-entry bg-dark text-white justify-content-end" data-aos="fade-up"
                    data-aos-duration="1000" data-aos-delay="100">
                    <a href="blog-single.html" class="block-20 img d-flex align-items-end"
                        style="background-image: url({{ asset('web/images/image_1.jpg') }});">
                    </a>
                    <div class="text">
                        <h5 class="text-white mb-3">
                            Krause's Food & the Nutrition Care Process 12th
                            Edition
                            <a href="#">by L. Kathleen Mahan MS RD CDE</a>
                        </h5>

                    </div>
                </div>
            </div>


            <div class="col-md-6 col-lg-4 d-flex">
                <div class="blog-entry bg-dark text-white justify-content-end" data-aos="fade-up"
                    data-aos-duration="1000" data-aos-delay="100">
                    <a href="blog-single.html" class="block-20 img d-flex align-items-end"
                        style="background-image: url({{ asset('web/images/image_1.jpg') }});">
                    </a>
                    <div class="text">
                        <h5 class="text-white mb-3">
                            The Complete Guide to Sports Nutrition: 8th edition (Complete Guides)
                            Paperback – November 7, 2017 by
                            <a href="#"> Anita Bean
                            </a>
                        </h5>
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-lg-4 d-flex">
                <div class="blog-entry bg-dark text-white justify-content-end" data-aos="fade-up"
                    data-aos-duration="1000" data-aos-delay="100">
                    <a href="blog-single.html" class="block-20 img d-flex align-items-end"
                        style="background-image: url({{ asset('web/images/image_1.jpg') }});">
                    </a>
                    <div class="text">
                        <h5 class="text-white mb-3">The Essential Pocket Guide for Clinical
                            Nutrition
                            by<a href="#"> Mary Width</a></h5>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>




@include('partials.footer')

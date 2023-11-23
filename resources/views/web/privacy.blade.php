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

                    <span class="subheading fs-3">Privacy Policy</span>
                    <h3 class="text-white ms">About Your Privacy</h3>
                    <p>
                        At Fit Life, we are committed to protecting your privacy. This
                        Privacy Policy outlines how we collect, use, and safeguard your
                        personal information when you use our website and services.
                    </p>
                    <p>
                        <strong class="text-white">1. Information We Collect</strong>
                        <br />
                        We may collect personal information from you, including your
                        name, email address, and demographic information. This
                        information is collected when you voluntarily provide it to us
                        through our contact forms or when you register for an account.
                    </p>
                    <p>
                        <strong class="text-white">2. Use of Your Information</strong>
                        <br />
                        We may use the personal information we collect to improve our
                        services, provide customer support, and send you promotional
                        materials. We will not sell, rent, or share your personal
                        information with third parties without your consent.
                    </p>
                    <p>
                        <strong class="text-white">3. Security Measures</strong>
                        <br />
                        We take reasonable precautions to protect your personal
                        information from unauthorized access, use, or disclosure.
                        However, no data transmission over the internet or electronic
                        storage is completely secure, and we cannot guarantee the
                        absolute security of your information.
                    </p>
                    <p>
                        <strong class="text-white">4. Cookies</strong>
                        <br />
                        Our website uses cookies to enhance your browsing experience.
                        These cookies may collect information such as your IP address,
                        browser type, and browsing history. You can disable cookies in
                        your browser settings if you prefer not to have them stored on
                        your device.
                    </p>
                    <p>
                        <strong class="text-white">5. Third-Party Links</strong>
                        <br />
                        Our website may contain links to third-party websites. We are
                        not responsible for the privacy practices or content of those
                        websites. We encourage you to review the privacy policies of any
                        third-party sites you visit.
                    </p>
                    <p>
                        <strong class="text-white">6. Changes to This Policy</strong>
                        <br />
                        We reserve the right to update or modify this Privacy Policy at
                        any time. Any changes will be posted on this page, and the
                        revised version will be effective immediately.
                    </p>
                    <h4 class="text-white">
                        <strong>
                            If you have any questions or concerns about our Privacy Policy,
                            please contact us.
                        </strong>
                    </h4>
                </div>
            </div>
        </div>


        <div class="row g-lg-5">


            <div class="col-md-12 d-flex align-items-center">
                <form action="{{ route('web.contact-us') }}" method="POST" class="appointment" data-aos="fade-up"
                    data-aos-duration="1000" data-aos-delay="200">
                    @csrf
                    <span class="subheading">Drop A Message</span>
                    <h2 class="mb-4 appointment-head">Make An Appointment</h2>
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="form-group">
                                <label for="name">Your Full Name</label>
                                <input type="text" class="form-control" name="full_name"
                                    placeholder="Your Full Name">
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="text" class="form-control" name="email" placeholder="Email">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Message</label>
                                <textarea cols="30" rows="7" name="message" class="form-control" placeholder="Message"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="submit" value="Send message" class="btn btn-primary py-3 px-4 rounded">
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

</section>

@include('partials.footer')

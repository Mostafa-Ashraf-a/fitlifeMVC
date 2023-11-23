@extends('partials.layout')
@section('content')
    <section class="hero-wrap imagebackground" id="home">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center">
                <div class="col-lg-6">

                    <span class="subheading">YOUR LIFE, YOUR BODY, YOUR HEALTH</span>

                    <h2 class="mb-4 text-white">
                        Achieve your body goals with FitLife’s fitness programs built in accordance
                        with your convenience.
                    </h2>

                    <p>
                        <a href="{{ route('web.indexen') }}#contact" class="btn btn-primary p-4 py-3">Contact us
                            <span class="ion-ios-arrow-round-forward"></span></a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-services" id="services">
        <div class="container services-wrap">
            <div class="row">
                <div class="col-md-12">
                    <div class="row g-lg-1">

                        <div class="col-md d-flex align-items-stretch">
                            <div class="services text-center" style="color: white;">
                                <div class="icon"><span class="flaticon-plan"></span></div>
                                <div class="text">
                                    <h2 style="color: white;">FitLife Nutrition</h2>
                                    <p>
                                        FitLife offers the most accurate nutrition plan built especially for your goal
                                        through machine learning algorithms using the food exchange method.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md d-flex align-items-stretch">
                            <div class="services text-center" style="color: white;">
                                <div class="icon"><span class="flaticon-dumbbell"></span></div>
                                <div class="text">
                                    <h2 style="color: white;">FitLife Workout</h2>

                                    <p>
                                        FitLife builds a comprehensive exercise plan that fits your body goal and daily
                                        routine conveniently and accurately, whether at home or the gym.
                                    </p>

                                </div>
                            </div>
                        </div>
                        <div class="col-md d-flex align-items-stretch">
                            <div class="services text-center" style="color: white;">
                                <div class="icon"><span class="flaticon-team-support"></span></div>
                                <div class="text">
                                    <h2 style="color: white;">Exercise Library</h2>
                                    <p>
                                        FitLife offers a complete exercise library with 400+ exercises supported by
                                        instructions and videos for demonstration for all body muscles.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-about-section" id="about">
        <div class="container-xl">
            <div class="row g-xl-5">
                <div class="col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100"
                    data-aos-duration="1000">
                    <div class="img w-100 section-counter"
                        style="background-image: url('{{ asset('web/images/body_2.jpg') }}');">

                    </div>
                </div>
                <div class="col-md-6 heading-section d-flex align-items-center" data-aos="fade-up" data-aos-delay="200"
                    data-aos-duration="1000">
                    <div class="mt-5 mt-md-0">
                        <span class="subheading">About FitLife:</span>
                        <p>
                            FitLife is an app developed to make your fitness journey much easier and more convenient. Our
                            algorithms were developed to produce accurate programs with a full range of workouts and recipes
                            designed to fit your daily schedule and preferences.
                        </p>
                        <p>
                            The FitLife team consists of certified fitness professionals and nutritionists who have
                            developed special programs that cater to everyone's specific needs, regardless of their fitness
                            level, schedule, or preferred workout location.
                        </p>
                        <p>
                            At FitLife, we aim to guide your lifestyle towards a healthier, more efficient, and more
                            motivated path, where you can take your body to the next level with flexibility, easy
                            monitoring, and progress tracking.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section" id="how_to_start">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-8 heading-section text-center mb-5" data-aos="fade-up" data-aos-duration="1000">
                    <span class="subheading">Procedure</span>
                    <h2 class="mb-4 text-white">How to Get Started ?</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 text-center d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100"
                    data-aos-duration="1000">
                    <div class="services-2">
                        <div class="img" style="background-image: url('{{ asset('web/images/app.jpg') }}');">
                            <div class="num"><span>1</span></div>
                        </div>
                        <div class="text">
                            <h2 class="text-white">Download App</h2>
                            <p class="mb-4">Experience the power of our app by downloading it from the App Store or Google
                                Play.</p>
                            <p>
                                <a target="_blank" href="https://google.com" class="btn-custom">
                                    <img src="{{ asset('web/images/app-store.png') }}" width="20" height="20"
                                        alt="">
                                    App Store</a>

                                <a target="_blank" href="https://google.com" class="btn-custom">
                                    <img src="{{ asset('web/images/google-play.png') }}" width="20" height="20"
                                        alt="">
                                    Google Play
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100"
                    data-aos-duration="1000">
                    <div class="services-2">
                        <div class="img" style="background-image: url('{{ asset('web/images/register-login.jpg') }}' );">
                            <div class="num"><span>2</span></div>
                        </div>
                        <div class="text">
                            <h2 class="text-white">Register & Login</h2>
                            <p class="mb-4">Get started on your fitness journey by easily registering and logging in to
                                our app.</p>
                            <p>
                                <a href="#" class="glightbox btn-custom">Watch Video</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100"
                    data-aos-duration="1000">
                    <div class="services-2">
                        <div class="img" style="background-image: url('{{ asset('web/images/food.jpg') }}');">
                            <div class="num"><span>3</span></div>
                        </div>
                        <div class="text">
                            <h2 class="text-white">Feeding Schedule</h2>
                            <p class="mb-4">Create a customized meal schedule that aligns with your unique dietary needs
                                and preferences.</p>
                            <p>
                                <a href="#" class="glightbox btn-custom">Watch Video</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100"
                    data-aos-duration="1000">
                    <div class="services-2">
                        <div class="img" style="background-image: url('{{ asset('web/images/workout.jpg') }}' );">
                            <div class="num"><span>4</span></div>
                        </div>
                        <div class="text">
                            <h2 class="text-white">Customized Workout Plan</h2>
                            <p class="mb-4">Design a personalized workout plan tailored to your fitness goals and skill
                                level.</p>
                            <p>
                                <a href="#" class="glightbox btn-custom">Watch Video</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-about-section" id="vision_mission">
        <div class="container-xl">
            <div class="row g-xl-5">
                <div class="col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100"
                    data-aos-duration="1000">
                    <div class="img w-100 section-counter"
                        style="background-image: url('{{ asset('web/images/body_1.jpg') }}');">
                    </div>
                </div>

                <div class="col-md-6 heading-section d-flex align-items-center" data-aos="fade-up" data-aos-delay="200"
                    data-aos-duration="1000">
                    <div class="mt-5 mt-md-0">

                        <span class="subheading">Our Vision:</span>

                        <p>
                            At FitLife, our vision is to become the most reliable source of fitness and health by providing
                            the most useful health tips and instilling healthy habits, thus contributing to the creation of
                            a healthier society.
                        </p>

                        <p>
                            In alignment with Vision 2030, we envision a society where people of all age ranges have easy
                            and flexible access to reliable health and fitness services.
                        </p>

                        <p>
                            FitLife aims to become the most accurate health service provider, pushing individuals to reach
                            their fullest potential, whether they are beginners or experienced individuals in health and
                            fitness.
                        </p>

                        <span class="subheading">Our Mission:</span>

                        <p>
                            FitLife's mission is to simplify your journey towards a healthier lifestyle through an
                            all-user-friendly app that includes a wide range of health and fitness services. We offer
                            professional exercise and nutrition programs designed for your body type and goals, eliminating
                            the need for expensive gym coach subscriptions.
                        </p>

                        <p>
                            FitLife strives to fully harness the power of machine learning, maximizing its potential to
                            deliver the most accurate results and meet the highest standards, all at the lowest subscription
                            costs possible.
                        </p>

                        <p>
                            Our objective at FitLife is to foster growth and revolutionize the way people perceive health
                            and fitness. We aim to educate and simplify the path to becoming the best version of yourself.
                        </p>

                        <p>
                            The FitLife team understands that the journey to reach your full potential comes with
                            challenges.
                            We address these obstacles through continuous innovation and the expansion of our services,
                            ensuring ease and flexibility every step of the way.
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-appointment ftco-section img" id="contact">
        <div class="overlay"></div>
        <div class="container-xl">
            <div class="row g-lg-5">
                <div class="col-md-6 d-flex align-items-center order-lg-last pl-lg-5">
                    <div class="heading-section heading-section-white" data-aos="fade-up">
                        <!-- <span class="subheading">Who We Are</span> -->
                        <h2 class="mb-3">Welcome to Fit Life Nutrition</h2>
                        <p>Experience the power of nutrition and fitness for a healthier life. Our passion lies in providing
                            you with the tools and guidance to achieve your wellness goals and maintain a balanced
                            lifestyle.</p>
                        <div class="row mt-md-5">
                            <div class="col-lg-12">
                                <div class="services-3 d-flex w-100">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="flaticon-plan"></span>
                                    </div>
                                    <div class="text ps-4">
                                        <h2>Comprehensive Services</h2>
                                        <p>Unlock the full potential of your health with our comprehensive range of services
                                            tailored to your unique needs. From personalized meal plans to expert guidance,
                                            we have you covered.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="services-3 d-flex w-100">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="flaticon-dairy-products"></span>
                                    </div>
                                    <div class="text ps-4">
                                        <h2>Quality Products</h2>
                                        <p>Discover a wide selection of high-quality, nutritious products that support your
                                            health and wellness journey. We carefully source and curate our products to
                                            ensure your satisfaction.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="services-3 d-flex w-100">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="flaticon-diet-1"></span>
                                    </div>
                                    <div class="text ps-4">
                                        <h2>Natural &amp; Healthy Foods</h2>
                                        <p>Experience the goodness of natural and healthy foods that nourish your body and
                                            support your wellness goals. We believe in the power of wholesome ingredients
                                            for optimal nutrition.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <form action="{{ route('web.contact-us') }}" method="POST" class="appointment" data-aos="fade-up"
                        data-aos-duration="1000" data-aos-delay="200">
                        @csrf
                        <span class="subheading">Drop A Message</span>
                        <h2 class="mb-4  appointment-head ">Make An Appointment</h2>
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
@endsection

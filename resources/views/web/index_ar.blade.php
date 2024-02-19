<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <title>Fit Life</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('partials.styles')


    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo&family=Tajawal&display=swap');

        * {
            font-family: 'Cairo', sans-serif;
            font-family: 'Tajawal', sans-serif;

        }
    </style>



    <style>

    </style>
</head>

<body style="background:#1a1a1a; ">

    <nav class="navbar navbar-expand-lg ftco-navbar-light">
        <div class="container-xl">
            <a class="navbar-brand align-items-center fs-4" href="{{ route('web.index') }}">
                Fit<span>Life</span>
            </a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link fs-6 fw-bold active"
                            href="{{ route('web.index') }}#home">الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link fs-6 fw-bold active"
                            href="{{ route('web.index') }}#services">خدماتنا</a></li>
                    <li class="nav-item"><a class="nav-link fs-6 fw-bold active"
                            href="{{ route('web.index') }}#about">حول فت لايف</a></li>
                    <li class="nav-item"><a class="nav-link fs-6 fw-bold active"
                            href="{{ route('web.index') }}#how_to_start">كيف تبدأ رحلتك ؟</a></li>
                    <li class="nav-item"><a class="nav-link fs-6 fw-bold active"
                            href="{{ route('web.index') }}#vision_mission">رؤيتنا وهدفنا</a></li>
                    <li class="nav-item"><a class="nav-link fs-6 fw-bold active"
                            href="{{ route('web.index') }}#contact">اتصل بنا</a></li>
                </ul>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="fa fa-bars"></span> القائمة
            </button>

            <div class="dropdown">
                <a href="{{ route('web.indexen') }}">
                    <button class="btn btn-secondary" type="button" id="languageDropdown" aria-expanded="false">
                        English
                    </button>
                </a>
            </div>

        </div>
    </nav>


    <section class="hero-wrap imagebackground" id="home">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center">
                <div class="col-lg-6">

                    <span class="subheading fs-4 fw-bold">حياتك وجسمك وصحتك</span>

                    <h2 class="mb-4 text-white">
                        <span>
                            حقق أهداف جسمك مع برامج اللياقة البدنية من فت لايف المصممة وفقا لاحتياجك وراحتك.
                        </span>
                    </h2>

                    <p>
                        <a href="{{ route('web.index') }}#contact" class="btn btn-primary p-4 py-3 fs-6">
                            اتصل بنا
                            <span class="ion-ios-arrow-round-forward"></span>
                        </a>
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
                                    <h2 class="fw-bold" style="color: white;">برامج فت لايف للتغذية</h2>
                                    <p class="fs-6">
                                        تقدم فت لايف خطط تغذية عالية الدقة المصممة خصيصا لهدفك عن طريق خوارزميات الذكاء
                                        الاصطناعي باستخدام طريقة حصص الغذاء.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md d-flex align-items-stretch">
                            <div class="services text-center" style="color: white;">
                                <div class="icon"><span class="flaticon-dumbbell"></span></div>
                                <div class="text">
                                    <h2 class="fw-bold" style="color: white;">برامج فت لايف للتمارين</h2>

                                    <p class="fs-6">
                                        تقدم فت لايف جداول تمار ين شاملة تناسب هدف جسمك وروتينك اليومي بشكل مريح ودقيق،
                                        سواءفي المنزل أو في صالة الألعاب الرياضية.
                                    </p>

                                </div>
                            </div>
                        </div>


                        <div class="col-md d-flex align-items-stretch">
                            <div class="services text-center" style="color: white;">
                                <div class="icon"><span class="flaticon-team-support"></span></div>
                                <div class="text">
                                    <h2 class="fw-bold" style="color: white;">برامج فت لايف للتمارين</h2>
                                    <p class="fs-6">
                                        تقدم فت لايف مكتبة تمارين كاملة بأكثر من ٤٠٠ تمرين مدعوم بالتعليمات ومقاطع
                                        الفيديو بعرض التوضيحي لجميع عضلات الجسم.
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
                        style="height:450px; background-image: url('{{ asset('web/images/body_2.jpg') }}');">

                    </div>
                </div>

                <div class="col-md-6 heading-section d-flex align-items-center" data-aos="fade-up"
                    data-aos-delay="200" data-aos-duration="1000">
                    <div class="mt-5 mt-md-0">
                        <span class="subheading fs-5">عن فت لايف: </span>
                        <p class="fs-5">
                            فت لايف هو تطبيق تم تطويره لجعل رحلة لياقتك أسهل بكثير وأكثر ملاءمة تم تطوير خوارزمياتنا
                            لإنتاج برامج دقيقة مع مجموعة كاملة من التدريبات والوصفات المصممة لتناسب جدولك اليومي
                            وتفضيلاتك الغذائية.
                        </p>
                        <p class="fs-5">
                            يتكون فريق فت لايف من محترفي اللياقة البدنية وخبراء التغذية المعتمدين الذين طوروا برامج
                            مخصصة تلبي الاحتياجات الخاصة للجميع، بغض النظر عن مستوى لياقتهم أو جدولهم الزمني أو موقع
                            التمرين المفضل.
                        </p>
                        <p class="fs-5">
                            في فت لايف، نهدف إلى توجيه نمط حياتك نحو مسار أكثر صحة وكفاءة وتحفيزا، حيث يمكنك نقل جسمك
                            إلى المستوى التالي بمرونة عالية وتتبع دقيق.
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
                    <span class="subheading">طريقة العمل</span>
                    <h2 class="mb-4 text-white">كيف تبدأ رحلتك ؟</h2>
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
                            <h2 class="text-white">تحميل التطبيق</h2>
                            <p class="mb-4">
                                جرب قوة تطبيقنا من خلال تنزيله من App Store أو Google Play.
                            </p>
                            <p dir="ltr">
                                <a target="_blank"
                                    href="https://apps.apple.com/sa/app/fitlife-%D9%81%D8%AA-%D9%84%D8%A7%D9%8A%D9%81/id6450390199"
                                    class="btn-custom">
                                    <img src="{{ asset('web/images/app-store.png') }}" width="20" height="20"
                                        alt="">
                                    App Store</a>

                                <a target="_blank" href="https://google.com" class="btn-custom">
                                    <img src="{{ asset('web/images/google-play.png') }}" width="20"
                                        height="20" alt="">
                                    Google Play
                                </a>
                            </p>
                        </div>
                    </div>
                </div>


                <div class="col-md-3 text-center d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100"
                    data-aos-duration="1000">
                    <div class="services-2">
                        <div class="img"
                            style="background-image: url('{{ asset('web/images/register-login.jpg') }}' );">
                            <div class="num"><span>2</span></div>
                        </div>
                        <div class="text">
                            <h2 class="text-white">فتح حساب وتسجيل الدخول</h2>

                            <p class="mb-4">
                                ابدأ رحلة اللياقة الخاصة بك عن طريق التسجيل بسهولة وتسجيل الدخول إلى تطبيقنا.
                            </p>

                            <p>
                                <a href="#" class="glightbox btn-custom">شاهد الفيديو</a>
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
                            <h2 class="text-white">جدول التغذية</h2>
                            <p class="mb-4">
                                قم بإنشاء جدول وجبات مخصص يتماشى مع احتياجاتك الغذائية الفريدة وتفضيلاتك.
                            </p>
                            <p>
                                <a href="#" class="glightbox btn-custom">شاهد الفيديو</a>
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
                            <h2 class="text-white">خطة تمارين مخصصة</h2>
                            <p class="mb-4">
                                صمم خطة تمرين شخصية مصممة خصيصًا لتناسب أهداف لياقتك البدنية ومستوى مهارتك.
                            </p>
                            <p>
                                <a href="#" class="glightbox btn-custom">شاهد الفيديو</a>
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

                <div class="col-md-6 heading-section d-flex align-items-center" data-aos="fade-up"
                    data-aos-delay="200" data-aos-duration="1000">
                    <div class="mt-5 mt-md-0">

                        <span class="subheading fs-5">رؤيتنا: </span>

                        <p class="fs-6">
                            في فت لايف، تتمثل رؤيتنا في أن نصبح المصدر الأكثر موثوقية للصحة وللياقة البدنية من خلال
                            تقديمالنصائح الصحية الأكثر فائدة وغرس العادات الصحية، وبالتالي المساهمة في خلق مجتمع أكثر
                            صحة.
                        </p>

                        <p class="fs-6">
                            تماشيا مع رؤية ٢٠٣٠، نتصور مجتمعا يتمتع فيه الناس من جميع الفئات العمرية بوصول سهل ومرن إلى
                            خدمات الصحة واللياقة البدنية الموثوقة.
                        </p>

                        <p class="fs-6">
                            تهدف فت لايف إلى أن تصبح مقدم الخدمة الصحية الأكثر دقة، مما يدفع الأفراد للوصول إلى أقصى
                            إمكاناتهم، سواء كانوا مبتدئين أو أفرادا ذوي خبرة في الصحة واللياقة البدنية.
                        </p>

                        <span class="subheading fs-5">هدفنا: </span>

                        <p class="fs-6">
                            تتمثل مهمة فت لايف، في تبسيط رحلتك نحو نمط حياة أكثر صحة من خلال تطبيق سهل الاستخدام يتضمن
                            مجموعة واسعة من خدمات الصحة واللياقة البدنية. نحن نقدم برامج تمارين وتغذية احترافية مصممة
                            لنوع
                            جسمك وأهدافك، مما يلغي الحاجة للاشتراك مع مدربين الصالات الرياضية باهظين الثمن.
                        </p>

                        <p class="fs-6">
                            فت لايف تسعى جاهدة لتسخير قوة التعلم الآلي بشكل كامل، وتعظيم إمكاناتها لتقديم أكثر النتائج
                            دقة،
                            وتلبية أعلى المعايير، وكل ذلك بأقل تكاليف اشتراك ممكنة.
                        </p>

                        <p class="fs-6">
                            هدفنا في فت لايف هو تعزيز النمو وإحداث ثورة في الطريقة التي ينظر بها الناس إلى الصحة
                            واللياقة
                            البدنية. نحن نهدف إلى تثقيف وتبسيط الطريق لتصبح أفضل نسخة من نفسك.
                        </p>

                        <p class="fs-6">
                            يدرك فريق فت لايف أن الرحلة للوصول إلى إمكاناتك الكاملة تأتي مع التحديات. نعالج هذه العقبات
                            من
                            خلال الابتكار المستمر وتوسيع خدماتنا، مما يضمن السهولة والمرونة في كل خطوة في مسارنا.
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
                        <h2 class="mb-3">مرحبا بك في تغذية فت لايف</h2>
                        <p class="fs-5">
                            اختبر قوة التغذية واللياقة البدنية لحياة أكثر صحة يكمن شغفنا في تزويدك بالأدوات والإرشادات
                            لتحقيق أهدافك الصحية والحفاظ على نمط حياة متوازن.
                        </p>
                        <div class="row mt-md-5">
                            <div class="col-lg-12">
                                <div class="services-3 d-flex w-100">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="flaticon-plan"></span>
                                    </div>
                                    <div class="text ps-4">
                                        <h2>خدمات شاملة</h2>
                                        <p class="fs-5">
                                            أطلق العنان للإمكانات الكاملة لصحتك من خلال مجموعتنا الشاملة من الخدمات
                                            المصممة خصيصًا لاحتياجاتك الفريدة من خطط الوجبات الشخصية إلى إرشادات الخبراء
                                            ، قمنا بتغطيتك.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="services-3 d-flex w-100">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="flaticon-dairy-products"></span>
                                    </div>
                                    <div class="text ps-4">
                                        <h2>منتجات ذات جودة عالية</h2>
                                        <p class="fs-5">
                                            اكتشف مجموعة واسعة من المنتجات المغذية عالية الجودة التي تدعم رحلة صحتك
                                            وعافيتك نحن نصدر منتجاتنا بعناية وننظمها لضمان رضاك.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="services-3 d-flex w-100">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="flaticon-diet-1"></span>
                                    </div>
                                    <div class="text ps-4">
                                        <h2>أغذية صحية طبيعية</h2>
                                        <p class="fs-5">
                                            جرب جودة الأطعمة الطبيعية والصحية التي تغذي جسمك وتدعم أهدافك الصحية نحن
                                            نؤمن بقوة المكونات الصحية للتغذية المثلى.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <form action="{{ route('web.contact-us') }}" method="POST" class="appointment"
                        data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        @csrf
                        <span class="subheading fs-4 fw-bold">اترك لنا رأيك</span>
                        <h2 class="mb-4  appointment-head ">إحجز موعد</h2>
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label for="name">اسمك بالكامل</label>
                                    <input type="text" class="form-control" name="full_name"
                                        placeholder="Your Full Name">
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label for="email">البريد الالكتروني</label>
                                    <input type="text" class="form-control" name="email" placeholder="Email">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">الرسالة</label>
                                    <textarea cols="30" rows="7" name="message" class="form-control" placeholder="Message"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="submit" value="ارسل" class="btn btn-primary py-3 px-4 rounded fs-5">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="ftco-footer">
        <div class="container-xl">
            <div class="row mb-5 pb-5 justify-content-between">


                <div class="col-md-6 col-lg">
                    <div class="ftco-footer-widget mb-4">


                        <h2 class="ftco-heading-2 logo d-flex">

                            <img src="{{ asset('web/images/logo.png') }}" width="100" height="100"
                                alt="logo">

                            <a class="navbar-brand align-items-center ms-4 fs-1 mt-3"
                                href="{{ route('web.index') }}">
                                Fit<span>Life</span>
                            </a>

                        </h2>
                        <p>
                            غيّر رحلة صحتك ولياقتك من خلال تطبيقنا المبتكر للهاتف المحمول ، مما يمكّنك من تحقيق أهدافك
                            والعيش بأسلوب حياة مفعم بالحيوية والنشاط.
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
                        <h2 class="ftco-heading-2">سياسة الاستخدام</h2>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="ftco-footer-widget mb-4">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="{{ route('web.privacy') }}">
                                            <span class="fa fa-chevron-left me-2"></span>
                                            سياسة الخصوصية
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('web.resources') }}">
                                            <span class="fa fa-chevron-left me-2"></span>
                                            موارد
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-lg">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">لديك أسئلة؟</h2>
                    </div>

                    <div class="block-23 mb-3">
                        <ul>

                            <li>
                                <a href="#">
                                    <span class="icon fa fa-map marker"></span>
                                    <span class="text">2690، شارع فتوح البلدان، حى النهضة، جدة، SA</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <span class="icon fa fa-phone"></span>
                                    <span class="text">+966 56 078 4061 </span>
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
        <div class="container-fluid px-0 py-5 bg-darken">
            <div class="container-xl">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p class="mb-0 fs-6" style="color: rgba(255,255,255,.5); font-size: 13px;">حقوق النشر &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> جميع الحقوق محفوظة
                            <a href="{{ route('web.index') }}" rel="nofollow noopener">
                                شركة فت لايف للتغذية واللياقة البدنية
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

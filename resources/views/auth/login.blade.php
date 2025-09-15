<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="Brain Solve Pharmacy System" />
    <meta name="description" content="Pharmacy System Brain Solve" />
    <meta name="author" content="brainsolve.net" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <script async src="https://www.google.com/recaptcha/api.js"></script>
    <title>تسجيل الدخول</title>
    @include('layouts.head')

</head>

<body>

    <div class="wrapper">

        <!--=================================
    preloader -->
        <div id="pre-loader">
            <img src="{{ URL::asset('assets/images/pre-loader/loader-01.svg') }}" alt="">
        </div>
        <!--=================================
    preloader -->

        <!--=================================
    login-->
        <section class="height-100vh d-flex align-items-center page-section-ptb login"
            >
            <div class="container">
                <div class="row justify-content-center g-0 vertical-align">
                    <div class="col-lg-4 col-md-6 login-fancy-bg bg"
                        style="background-image: url({{ asset('assets/images/login-bg.jpg') }});">
                        <div class="login-fancy">
                            <h2 class="text-white mb-20" style="font-family: 'Cairo', sans-serif">مرحبا بك</h2>
                            <h5 class="mb-20 text-white" style="font-family: 'Cairo', sans-serif">سيستم نقاط البيع التجريبي</h5>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 bg-white">
                        <div class="login-fancy pb-40 clearfix">
                            <br>
                            @include('components.alerts')
                            <h3 class="mb-30" style="font-family: 'Cairo', sans-serif">تسجيل الدخول</h3>
                            <form action="{{ route('loginNow') }}" method="POST">
                                @csrf
                                <div class="section-field mb-20">
                                    <label class="mb-10" for="name">البريد الالكتروني او اسم المستخدم* </label>
                                    <input id="login" name="email" value="{{ old('login') }}" class="web form-control" type="text" placeholder="أكتب البريد الالكتروني او اسم المستخدم">
                                    @error('login')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="section-field mb-20">
                                    <label class="mb-10" for="Password">كلمة السر* </label>
                                    <input id="password" name="password" class="Password form-control" type="password"
                                        placeholder="أكتب كلمة السر">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <button class="button" type="submit"><span>تسجيل الدخول</span><i
                                        class="fa fa-check"></i></button>
                            </form>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--=================================
    login-->
    </div>
    @include('layouts.footer-script')
</body>
<script>


</script>
</html>

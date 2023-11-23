<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>FitLife - Login</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('dashboard/dist/img/fitlife-logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<style>
    .login-div{
        margin: 100px auto 30px;
        max-width: 400px;
        padding: 40px 30px 20px;
        background: #fff;
        border-radius: 6px;

    }
</style>
<body style="background-color: #5a656b">
<section>
    <div class="height-100-vh bg-primary-trans">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-4">
                    <!-- <img src="{{ asset('assets/files/logo-2.png') }}" style="margin-top: 70px; max-width: 200px; display: block; text-align: center; margin-left: auto; margin-right: auto;"> -->
                    <div class="login-div" style="padding-top: 20px;margin: 30px auto 30px; margin-bottom: 15px; padding-bottom: 60px;">
                        <form action="{{ route('manager.check') }}" method="post" name="login" id="needs-validation">
                            @if(\Session::get('fail'))
                                <div class="alert alert-danger">
                                    {{ \Session::get('fail') }}
                                </div>
                            @endif
                            @csrf
                            <div class="form-group my-3">
                            <img src="{{ asset('assets/files/logo-1.png') }}" style="margin-top: 10px; max-width: 200px; display: block; text-align: center; margin-left: auto; margin-right: auto;">
                                <label class="my-1">Login</label>
                                <input class="form-control input-lg" placeholder="Email" name="email" autocomplete="off" value="{{ old('email') }}" type="email" required>
                                <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                            </div>
                            <div class="form-group my-2">
                                <label class="my-1">Password</label>
                                <input class="form-control input-lg" placeholder="Password" name="password" autocomplete="off" id="password" value="{{ old('password') }}" type="password" required>
                                <span class="text-danger">@error('password') {{ $message }} @enderror</span>
                                <input type="checkbox" id="showPassword" />
                                <label for="showPassword">Show password</label>
                            </div>
                            <button class="btn btn-success mt-2" type="submit" style="width: 100% ; font-weight: 600;">Sign In</button>
                        </form>
                    </div>
                    <div style="text-align: center; color: #fff; text-transform: uppercase; font-size: 10px;">
                        Copyrights <a href="https://smart.sa/" target="_blank" style="color: #fff; font-weight: bold;">SMART</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script type="text/javascript">
    document.getElementById('showPassword').onclick = function() {
        if ( this.checked ) {
            document.getElementById('password').type = "text";
        } else {
            document.getElementById('password').type = "password";
        }
    };
</script>
</body>
</html>

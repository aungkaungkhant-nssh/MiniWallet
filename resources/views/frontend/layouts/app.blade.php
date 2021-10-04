<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title")</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    {{--custom css--}}
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    {{--font awesome--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
</head>
<body>
    <div class="header-menu">
        <div class="d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-2 text-center"></div>
                        <div class="col-8 text-center">
                            <h6 class="mb-0">Mini Wallet</h6>
                        </div>
                        <div class="col-2 text-cente"><i class="fas fa-bell"></i></div>
                    </div>
                </div>
        </div>
    </div>
    <div class="content">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                @yield('content')
            </div>
        </div>
     </div>  
    <div class="footer-menu">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-4 text-center">
                        <i class="fas fa-wallet"></i>
                        <p class="mb-3">Wallets</p>
                    </div>
                    <div class="col-4 text-center">
                        <i class="fas fa-exchange-alt"></i>
                        <p class="mb-3">Transcations</p>
                    </div>
                    <div class="col-4 text-center">
                        <i class="fas fa-user"></i>
                        <p class="mb-3">Profile</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
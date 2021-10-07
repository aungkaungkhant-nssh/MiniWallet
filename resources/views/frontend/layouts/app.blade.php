<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield("title")</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    {{--custom css--}}
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    {{--font awesome--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
    {{--dateranger--}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>
<body>
    <div class="header-menu">
        <div class="d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-2 text-center">
                            @if (!request()->is("/"))
                            <a href="" class="back">
                                <i class="fas fa-angle-left"></i>
                            </a>
                            @endif
                        </div>
                        <div class="col-8 text-center">
                            <h6 class="mb-0">@yield('name')</h6>
                        </div>
                        <div class="col-2 text-center"><i class="fas fa-bell"></i></div>
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
        <a href="" class="scan-tab">
            <div class="inside">
                <i class="fas fa-qrcode"></i>
            </div>
        </a>
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-3 text-center">
                        <a href="{{route('home')}}">
                            <i class="fas fa-home"></i>
                            <p>Home</p>
                        </a>
                    </div>
                    <div class="col-3 text-center">
                        <a href="{{route("wallets")}}">
                            <i class="fas fa-wallet"></i>
                            <p class="mb-3">Wallets</p>
                        </a>
                    </div>
                    <div class="col-3 text-center">
                        <a href="{{route("transcations")}}">
                            <i class="fas fa-exchange-alt"></i>
                            <p class="mb-3">Transcations</p>
                        </a>
                 
                    </div>
                    <div class="col-3 text-center">
                        <a href="{{url('/profile')}}">
                            <i class="fas fa-user"></i>
                            <p class="mb-3">Profile</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    {{-- sweet-alert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{--jscroll--}}
    <script src="{{asset('frontend/js/jscroll.js')}}"></script>
    {{--dateranger--}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type':'application/json',
                            'Accept':'application/json'
                        }
                    });
            })
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        @if(session("create")){
            Toast.fire({
            icon: 'success',
            title: '{{session('create')}}'
            })
        }
        @endif
        @if(session("update")){
            Toast.fire({
            icon: 'success',
            title: '{{session('update')}}'
            })
        }
        @endif
            $(".back").on("click",function(e){
                e.preventDefault();
                 window.history.back();
            })
            
    </script>
    @yield('scripts')
</body>
</html>
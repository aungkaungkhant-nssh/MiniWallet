@extends('frontend.layouts.app')
@section('title',"Profile")
@section('name',"Profile")
@section('content')
    <div class="account ">
        <div class="row">
            <div class="col-12 text-center mb-3">
                <img class="rounded-img" src="https://ui-avatars.com/api/?background=a29bfe&color=fff&name={{$user->name}}" alt="">
            </div>
            <div class="col-12 text-center">
                <div class="card">
                    <div class="card-body pr-0">
                        <div class="d-flex justify-content-between">
                            <span>UserName</span>
                            <span class="mr-3">{{$user->name}}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Email</span>
                            <span class="mr-3">{{$user->email}}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Phone</span>
                            <span class="mr-3">{{$user->phone}}</span>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <a class="d-flex justify-content-between" href="/password-update">
                            <span>Update Password</span>
                            <i class="fas fa-arrow-alt-circle-right"></i>
                        </a>
                        <hr>
                        <a class="d-flex justify-content-between logout">
                            <span>Logout</span>
                            <i class="fas fa-arrow-alt-circle-right"></i>
                        </a>
                    </div> 
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
           $('.logout').on("click",function(){
            Swal.fire({
                title: 'Are you sure want To logout?',
                showCancelButton: true,
                confirmButtonText: 'Logout',
                reverseButtons:true
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{route('logout')}}",
                        method:"post",
                        success:function(res){
                                window.location.replace("{{route('login')}}");
                            
                        }
                    })
                    }
                })
           })
        })
    </script>
@endsection
    

@extends('frontend.layouts.app')
@section('title',"Notifications Details")
@section('name',"Notifications Details")
@section('content')
    <div class="notifications">
            <div class="card mb-3 text-center">
                <div class="card-body">
                        <div class="">
                            <img src="{{asset("images/notification.png")}}" alt="" style="width: 250px">
                        </div>
                        <div>
                            <h6>{{$notification->data["title"],20}}</h6>
                            <p class="text-muted mb-1" style="font-size: 14px">{{$notification->data["message"],40}}</p>
                            <p>{{Carbon\Carbon::parse($notification->created_at)->format("Y-m-d H:i:s")}}</p>
                            <a href="{{$notification->data["web_link"]}}" class="btn btn-theme">Continue</a>
                        </div>
                </div>
            </div>
       
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            
        })
    </script>
@endsection
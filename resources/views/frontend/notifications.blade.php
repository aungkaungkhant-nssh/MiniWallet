@extends('frontend.layouts.app')
@section('title',"Notifications")
@section('name',"Notifications")
@section('content')
    <div class="notifications">
        @foreach ($notifications as $notification)
        <a href="{{route("notificationDetails",$notification->id)}}" >
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex">
                        <i class="fas fa-bell mr-3 @if(empty($notification->read_at))text-danger @endif"></i>
                        <div>
                            <h6>{{Str::limit($notification->data["title"],20)}}</h6>
                            <p class="text-muted mb-1" style="font-size: 14px">{{Str::limit($notification->data["message"],40)}}</p>
                            <p>{{Carbon\Carbon::parse($notification->created_at)->format("Y-m-d H:i:s")}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        
        @endforeach
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            
        })
    </script>
@endsection
    

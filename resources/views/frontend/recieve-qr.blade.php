@extends('frontend.layouts.app')
@section('title',"Recieve Qr")
@section('name',"Recieve Qr")
@section('content')
    <div class="recieve-qr">
        <div class="card">
            <div class="card-body">
                <p class="text-center">QR Scan to pay me</p>
                <div class="text-center">
                    {!! QrCode::size(100)->generate(auth()->user()->phone); !!}
                </div>
                <p class="text-center mb-0 text-muted">{{auth()->user()->name}}</p>
                <p class="text-center text-muted">{{auth()->user()->phone}}</p>
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
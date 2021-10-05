@extends('frontend.layouts.app')
@section('title',"Wallets")
@section('name',"Wallets")
@section('content')
    <div class="wallets ">
        <div class="card">
            <div class="card-body">
                <div>
                    <span>Balance</span>
                    <h6 class="text-muted">{{$user->wallets?number_format($user->wallets->amount):"0"}}(MMK)</h6>
                </div>
                <div>
                    <span >Account Number</span>
                    <h6 class="text-muted">{{$user->wallets->account_number}}</h6>
                </div>
                <div>
                   <p class="text-muted">{{$user->name}}</p>
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
    

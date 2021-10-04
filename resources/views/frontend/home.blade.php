@extends('frontend.layouts.app')
@section('title',"Mini Wallet")
@section('content')
    <div class="home">
        <div class="row">
            <div class="col-12 text-center">
                    <img class="rounded-img" src="https://ui-avatars.com/api/?background=a29bfe&color=fff&name={{$user->name}}" alt="">
                    <h5>{{$user->name}}</h5>
                    <p class="user_amount text-muted">{{number_format($user->wallets?$user->wallets->amount:"0")}} (MMK)</p>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body p-2">
                        <img src="{{asset("images/scan.png")}}" alt="">
                        <span>Scan And Pay</span>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body p-2">
                        <img src="{{asset("images/qr.png")}}" alt="">
                        <span>Recieve QR</span>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-body function-box">
                        <a href="" class="d-flex justify-content-between">
                            <div>
                                <img src="{{asset('images/transfer.png')}}" alt="">
                                <span>Transfer</span>
                            </div>
                            <i class="fas fa-arrow-alt-circle-right"></i>
                        </a>
                        <hr>
                        <a href="" class="d-flex justify-content-between">
                            <div>
                                <img src="{{asset('images/wallet.png')}}" alt="">
                                <span>Wallet</span>
                            </div>
                            <i class="fas fa-arrow-alt-circle-right"></i>
                        </a>
                        <hr>
                        <a href="" class="d-flex justify-content-between">
                            <div>
                                <img src="{{asset('images/transaction.png')}}" alt="">
                                <span>Transaction</span>
                            </div>
                            <i class="fas fa-arrow-alt-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
     
    </div>
@endsection
    

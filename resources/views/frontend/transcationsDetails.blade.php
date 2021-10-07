@extends('frontend.layouts.app')
@section('title',"Transcations Details")
@section('name',"Transcations Details")
@section('content')
    <div class="transcations-details">
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="{{asset('images/transaction.png')}}" alt="">
                </div>
                @if ($transcation->type===1)
                    <h6 class="text-center text-success mb-3">{{number_format($transcation->amount)}}<span>(MMK)</span></h6>
                @endif
                @if ($transcation->type===2)
                    <h6 class="text-center text-danger mb-3">{{number_format($transcation->amount)}} <span>(MMK)</span></h6>
                @endif
                <div class="d-flex justify-content-between">
                    <p class="mb-0 text-muted">Trx_id</p>
                    <p class="mb-0">{{$transcation->trx_id}}</p>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <p class="mb-0 text-muted">Ref_id</p>
                    <p class="mb-0">{{$transcation->ref_id}}</p>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <p class="mb-0 text-muted">Type</p>
                    @if ($transcation->type===1)
                        <span class="badge badge-success">Income</span>
                    @endif
                    @if ($transcation->type===2)
                    <span class="badge badge-danger">Expense</span>
                @endif
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <p class="mb-0 text-muted">Amount</p>
                    <p class="mb-0">{{number_format($transcation->amount)}} <span>(MMK)</span></p>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <p class="mb-0 text-muted">
                        @if ($transcation->type===1)
                            From
                        @endif
                        @if ($transcation->type===2)
                          To
                         @endif
                    </p>
                    <p class="mb-0">
                        {{$transcation->source? $transcation->source->name:""}}
                    </p>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <p class="mb-0 text-muted">Date</p>
                    <p class="mb-0">{{$transcation->created_at}}</p>
                </div>
                <hr>
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
    

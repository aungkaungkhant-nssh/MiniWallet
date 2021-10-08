@extends('frontend.layouts.app')
@section('title',"Scan And Pay Confirm")
@section('name',"Scan And Pay Confirm")
@section('content')
    <div class="scanandpayconfirm">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
              
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
              
                @endif
               <form action="{{route('scanAndPayComplete')}}" method="POST" class="scanandpay-complete">
                  @csrf
                  <input type="hidden" name="hash_value" value="{{$hash2_value}}">
                  <input type="hidden" name="to_phone" value="{{$to_user->phone}}">
                  <input type="hidden" name="amount" value="{{$amount}}">
                  <input type="hidden" name="description" value="{{$description}}">
                   <div class="form-group">
                       <label for="" class="mb-1">From</label>
                       <p class="mb-0 text-muted">{{$from_user->name}}</p>
                       <p class="mb-0 text-muted">{{$from_user->phone}}</p>
                   </div>
                   <div class="form-group">
                        <label for="" class="mb-1">To</label>
                        <p class="mb-0 text-muted">{{$to_user->name}}</p>
                        <p class="mb-0 text-muted">{{$to_user->phone}}</p>
                    </div>
                    <div class="form-group">
                        <label for="" class="mb-0">Amount</label>
                        <p class="mb-0 text-muted">{{number_format($amount)}}(MMK)</p>
                    </div>
                    <div class="form-group">
                        <label for="" class="mb-1">Desciption</label>
                        <p class="mb-0 text-muted">{{$description}}</p>
                    </div>
                    <button type="submit" class="btn btn-block btn-theme submit-btn confirm">Confirm</button>
               </form>
            </div>
        </div>
           
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $(".confirm").on("click",function(e){
                e.preventDefault();
                Swal.fire({
                        title: 'Please fill your password',
                        icon: 'info',
                        html:'<input type="password" class="form-control text-center password"></input>',
                        showCloseButton: true,
                        showCancelButton: true,
                        focusConfirm: false,
                        reverseButtons:true
                }).then((result)=>{
                    if(result.isConfirmed){
                        const password=$(".password").val();
                        $.ajax({
                            url:`/transfer/confirm/password-check?password=${password}`,
                            type:"GET",
                            success:function(res){
                                if(res.status==="success"){
                                    $(".scanandpay-complete").submit();
                                }else{
                                    Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Password Incorrect',
                                            footer: '<a href="">Why do I have this issue?</a>'
                                    })
                                }
                            }
                        })
                    }
                })
            })
        })
    </script>
@endsection
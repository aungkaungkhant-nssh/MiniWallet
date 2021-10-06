@extends('frontend.layouts.app')
@section('title',"Transfers")
@section('name',"Transfers")
@section('content')
    <div class="transfers ">
        <div class="card">
            <div class="card-body">
               
               <form action="{{route('transferConfirm')}}" class="transferConfirm" method="GET">
                    <input type="hidden" value="" class="form-control hash_value" name="hash_value">
                   <div class="form-group">
                       <label for="" class="mb-1">From</label>
                       <p class="mb-0 text-muted">{{$user->name}}</p>
                       <p class="mb-0 text-muted">{{$user->phone}}</p>
                   </div>
                   <div class="form-group">
                       <label for="" class="mb-1">To <span class="search_user"></span></label>
                       <div class="input-group">
                        <input type="text" class="form-control to_phone" name="to_phone" placeholder="phone number" value="{{old('to_phone')}}">
                        <div class="input-group-append check">
                          <span class="input-group-text" id="basic-addon2"><i class="fas fa-check-circle"></i></span>
                        </div>
                        </div>
                       @error('to_phone')
                           <span class="text-danger">{{$message}}</span>
                       @enderror
                   </div>
                   <div class="form-group">
                        <label for="" class="mb-1">Amount (MMK)</label>
                        <input type="number" name="amount" class="form-control amount" placeholder="Amount"
                        value="{{old("amount")}}"
                        >
                        @error('amount')
                           <span class="text-danger mt-1">{{$message}}</span>
                       @enderror
                  </div>
                  <div class="form-group">
                      <label for="">Descirption</label>
                      <textarea name="description" class="form-control description"></textarea>
                  </div>
                    <button type="submit" class="btn btn-block btn-theme continue">continue</button>
               </form>
            </div>
        </div>
           
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $(".continue").on("click",function(e){
                let description=$(".description").val();
                let amount=$(".amount").val();
                let phone=$(".to_phone").val();
                e.preventDefault();
                $.ajax({
                    url:`/transfer-hash?phone=${phone}&amount=${amount}&description=${description}`,
                    method:"get",
                    success:function(res){
                      if(res.status==="success"){
                          $(".hash_value").val(res.data);
                          $(".transferConfirm").submit();
                      }
                    }
                })
            })
            $("#basic-addon2").on("click",function(e){
              let to_phone=$(".to_phone").val();
               $.ajax({
                   url:`/phone-check?to_phone=${to_phone}`,
                   method:"GET",
                   success:function(res){
                       if(res.status==="success"){
                            $(".search_user").text(`(${res.data.name})`)
                       }else{
                        $(".search_user").text(`(phone number not found)`).addClass("warning")
                       }
                   }
               })
            })
        })
    </script>
@endsection
    

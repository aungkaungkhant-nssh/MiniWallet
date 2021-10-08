@extends('frontend.layouts.app')
@section('title',"Scan And Pay Form")
@section('name',"Scan And Pay Form")
@section('content')
    <div class="scanandpayform">
        <div class="card">
            <div class="card-body">
                @error('fails')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                @enderror
                <form action="{{route("scanAndPayConfirm")}}">
                    <input type="hidden" class="hash_value" value="" name="hash_value">
                    <input type="hidden" name="to_phone" value="{{$to_phone->phone}}" class="to_phone">
                    
                    <div class="form-group">
                        <label for="">From</label>
                        <p class="text-muted mb-0">{{$from_phone->name}}</p>
                        <p class="text-muted mb-0">{{$from_phone->phone}}</p>
                    </div>
                    <div class="form-group">
                        <label for="">To</label>
                        <p class="text-muted mb-0">{{$to_phone->name}}</p>
                        <p class="text-muted mb-0 to_phone">{{$to_phone->phone}}</p>
                    </div>
                    <div class="form-group">
                        <label for="">Amount</label>
                        <input type="text" class="form-control amount" name="amount">
                        @error('amount')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" id="" class="form-control description"></textarea>
                    </div>
                    <input type="submit" class="btn btn-theme btn-block scan-confirm" value="Confirm">
                </form>
            </div>
        </div>
           
    </div>
@endsection
@section('scripts')
    <script src="{{asset('frontend/js/Scanner.js')}}"></script>
    <script>
        $(document).ready(function(){
            $(".scan-confirm").on("click",function(e){
                e.preventDefault();
                let phone=$(".to_phone").val();
                let amount=$(".amount").val();
                let description=$(".description").val();
                $.ajax({
                    url:`/transfer-hash?phone=${phone}&amount=${amount}&description=${description}`,
                    method:"GET",
                    success:function(res){
                        if(res.status==="success"){
                           $(".hash_value").val(res.data);
                           $("form").submit();
                        }
                    }
                })
            })
        })
    </script>
@endsection
    

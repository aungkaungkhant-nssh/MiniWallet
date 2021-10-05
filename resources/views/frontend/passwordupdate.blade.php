@extends('frontend.layouts.app')
@section('title',"Password Update")
@section('name',"Password Update")
@section('content')
    <div class="password-update ">
      
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{asset("images/update-password.png")}}" alt="">
                        </div>
                       
                        <form action="{{route('password.update.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                 <label for="">Old Password</label>
                                 <input type="password" name="old_password" class="form-control 
                                 @error("old_password")
                                 is-invalid
                                 @enderror"
                                 value="{{old("old_password")}}"
                                 >
                                 @error('old_password')
                                     <span class="text-danger">{{$message}}</span>
                                 @enderror
                            </div>
                            <div class="form-group">
                                 <label for="">New Password</label>
                                 <input type="password" name="new_password"
                                 class="form-control
                                 @error("new_password")
                                 is-invalid
                                 @enderror
                                 "
                                 value="{{old("new_password")}}"
                                 >
                                 @error('new_password')
                                    <span class="text-danger">{{$message}}</span>
                                 @enderror
                             </div>
                             <input type="submit" class="btn btn-theme btn-block" value="Update Password">
                        </form>
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
    

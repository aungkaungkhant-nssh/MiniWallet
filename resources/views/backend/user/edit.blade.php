@extends("backend.layouts.app")
@section('title','Edit User')
@section('user_active',"mm-active")
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-note icon-display2 bg-mean-fruit">
                </i>
            </div>
            <div>Edit  User</div>
        </div>
        </div>
</div> 
<div class="content">
    <div class="card">
        <div class="card-body">
            <form action="{{route('admin.user.update',$user->id)}}" id="edit" method="post">
                @csrf
                @method("PATCH")
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" value="{{$user->name}}">
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" class="form-control" name="email" value="{{$user->email}}">
                </div>
                <div class="form-group">
                    <label for="">Phone</label>
                    <input type="text" class="form-control" name="phone" value="{{$user->phone}}">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="text-center">
                    <button class="btn btn-secondary mr-3" id="back">Cancel</button>
                    <button class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div> 
@endsection    
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\EditAdminUser',"#edit") !!}
    <script>
          $(document).ready(function(){
           
          })
    </script>
@endsection
@extends("backend.layouts.app")
@section('title','Create Admin_User')
@section('admin_user_active',"mm-active")
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-note icon-display2 bg-mean-fruit">
                </i>
            </div>
            <div>Create Admin User</div>
        </div>
        </div>
</div> 
<div class="content">
    <div class="card">
        <div class="card-body">
            <form action="{{route('admin.admin_user.store')}}" id="create" method="post">
                @csrf
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="form-group">
                    <label for="">Phone</label>
                    <input type="text" class="form-control" name="phone">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="text-center">
                    <button class="btn btn-secondary mr-3" id="back">Cancel</button>
                    <button class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div> 
@endsection    
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\StoreAdminUser',"#create") !!}
    <script>
          $(document).ready(function(){
           
          })
    </script>
@endsection
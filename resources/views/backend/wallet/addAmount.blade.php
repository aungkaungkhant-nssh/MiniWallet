@extends("backend.layouts.app")
@section('title','Wallets')
@section('wallets_active',"mm-active")
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-note icon-display2 bg-mean-fruit">
                </i>
            </div>
            <div>Add Amounts</div>
        </div>
        </div>
</div> 

<div class="content">
    <div class="card">
        <div class="card-body">
            <form action={{url("/admin/wallet/add/amount")}} method="POST">
                @csrf
                <div class="form-group">
                    <label for="">Name</label>
                    <select class="form-control" name="user_id" id="user">
                        <option value="">--select--</option>
                        @foreach ($users as $user)
                            <option value={{$user->id}}>{{$user->name}} {{$user->phone}}</option>
                        @endforeach
                     </select>
                     @error('user_id')
                         <span class="text-danger">{{$message}}</span>
                     @enderror
                </div>
                <div class="form-group">
                    <label for="">Amount</label>
                    <input type="text" name="amount" class="form-control">
                    @error('amount')
                         <span class="text-danger">{{$message}}</span>
                     @enderror
                </div>
                <div class="form-group">
                    <label for="">Description</label>
                   <textarea name="description" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-success btn-block">Add Amount</button>
            </form>
        </div>
    </div>
</div> 
@endsection    
@section('scripts')
    <script>
         $(document).ready(function(){
            $('#user').select2({
                placeholder: "Please Choose",
                allowClear: true,
           
                });
        
         })
    </script>
@endsection
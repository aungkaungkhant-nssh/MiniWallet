@extends("backend.layouts.app")
@section('title','Users')
@section('user_active',"mm-active")
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-note icon-display2 bg-mean-fruit">
                </i>
            </div>
            <div>Users</div>
        </div>
        </div>
</div> 
<div class="my-3">
    <a href="{{route('admin.user.create')}}" class="btn btn-primary"><i class="fas fa-plus-circle mr-2"></i>Create new users</a>
</div>
<div class="content">
    <div class="card">
        <div class="card-body">
            
            <table class="table table-striped data" id="users-table">
                <thead>
                    <th>Name</th>
                    <th class="searchable">Email</th>
                    <th class="searchable">Phone</th>
                    <th class="searchable">ip</th>
                    <th class="sortable">user_agent</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                    <th class="sortable">Action</th>
                </thead>
            </table>
        </div>
    </div>
</div> 
@endsection    
@section('scripts')
    <script>
          $(document).ready(function(){
            let table=$('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/admin/user/datable/ssd',
            order:[[6,"desc"]],
            columns: [
                    { 
                        data: 'name',
                        name: 'name' 
                    },
                    { 
                        data: 'email',
                        name: 'email' 
                    },
                    { 
                        data: 'phone', 
                        name: 'phone' 
                    },
                    { 
                        data: 'ip', 
                        name: 'ip' 
                    },
                    { 
                        data: 'user_agent', 
                        name: 'user_agent' 
                    },
                    {
                        data:"created_at",
                        name:"created_at",
                    },
                    {
                        data:"updated_at",
                        name:"updated_at"
                    },
                    { 
                        data: 'action', 
                        name: 'action'
                    },
                    
                ],

                "columnDefs": [
                    { "sortable": false, "targets": ["sortable"] },
                    { "searchable": false, "targets": ["searchable"] }
                ]
            });
            $(document).on("click","#delete",function(e){
                e.preventDefault();
                let id=e.target.dataset.id;
                Swal.fire({
                title: 'Are you sure want to delete?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'confirm',
                reverseButtons:true
                }).then((result) => {
                if (result.isConfirmed) {
                     $.ajax({
                    url:`/admin/user/${id}`,
                    type:"DELETE",
                    success:function(){
                        table.ajax.reload();
                    }
                    })
                }
                })
               
            })
          })
    </script>
@endsection
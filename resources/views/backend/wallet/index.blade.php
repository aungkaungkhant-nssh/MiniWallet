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
            <div>Wallets</div>
        </div>
        </div>
</div> 
<div class="my-3">
    <a href="{{url('/admin/wallet/add/amount')}}"  class="btn btn-success">
        <i class="fas fa-plus-circle"></i>
        Add Amount
    </a>
    <a href="{{url('/admin/wallet/reduce/amount')}}"  class="btn btn-warning">
        <i class="fas fa-minus-circle"></i>
        Reduce Amount
    </a>
</div>
<div class="content">
    <div class="card">
        <div class="card-body">
            
            <table class="table table-striped data" id="wallet-table">
                <thead>
                    <th>Account Number</th>
                    <th>Account Person</th>
                    <th>Amount (MMK)</th>
                    <th>Created_at</th>
                    <th>Updated_at</th>
                </thead>
            </table>
        </div>
    </div>
</div> 
@endsection    
@section('scripts')
    <script>
         $(document).ready(function(){
            let table=$('#wallet-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/admin/wallet/datable/ssd',
     
            columns: [
                    { 
                        data: 'account_number',
                        name: 'account_number' 
                    },
                    { 
                        data: 'account_person',
                        name: 'account_person' 
                    },
                    { 
                        data: 'amount', 
                        name: 'amount' 
                    },
                    
                    {
                        data:"created_at",
                        name:"created_at",
                    },
                    {
                        data:"updated_at",
                        name:"updated_at"
                    }
                    
                ],

                "columnDefs": [
                    { "sortable": false, "targets": ["sortable"] },
                    { "searchable": false, "targets": ["searchable"] }
                ]
            });
        
         })
    </script>
@endsection
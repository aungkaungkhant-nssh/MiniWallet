@extends('frontend.layouts.app')
@section('title',"Scan And Pay")
@section('name',"Scan And Pay")
@section('content')
    <div class="scanandpay">
        <div class="card">
            <div class="card-body text-center">
                @error('fails')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                @enderror
                <img src="{{asset("images/scanandpay.png")}}" alt="">
                <p class="">Click Button,put QR in the frame and pay</p>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-theme" data-toggle="modal" data-target="#scanModal">
                     Scan And Pay
                </button>
                <!-- Modal -->
                <div class="modal fade" id="scanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Scan And Pay</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div id="reader"></div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-theme">Save changes</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
           
    </div>
@endsection
@section('scripts')
    <script src="{{asset('frontend/js/Scanner.js')}}"></script>
    <script>
        $(document).ready(function(){
            var html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader", { fps: 10, qrbox: 150 });
                html5QrcodeScanner.render(onScanSuccess, onScanError);
                function onScanSuccess(qrCodeMessage) {
                        html5QrcodeScanner.clear();
                      
                       $("#scanModal").hide();
                       window.location.replace(`scan-and-pay-form?to_phone=${qrCodeMessage}`)
                    
                   
                }
                function onScanError(errorMessage) {
                  
                }
        })
    </script>
@endsection
    

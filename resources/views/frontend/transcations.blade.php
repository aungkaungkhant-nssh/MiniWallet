@extends('frontend.layouts.app')
@section('title',"Transcations")
@section('name',"Transcations")
@section('content')
    <div class="transcations">
        <div class="card mb-3">
            <div class="card-body p-1">
                <div class="row">
                    <div class="col-6">
                        <div class="input-group p-2">
                            <div class="input-group-prepend">
                              <label class="input-group-text p-1" for="inputGroupSelect01">Date</label>
                            </div>
                            <input type="text" class="form-control date" 
                            value="{{request()->date}}"
                            placeholder="All">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group p-2">
                            <div class="input-group-prepend">
                              <label class="input-group-text p-1" for="inputGroupSelect01">Type</label>
                            </div>
                            <select class="custom-select type">
                              <option value="">All</option>
                              <option value="1" 
                              @if(request()->type==1) 
                                    selected
                              @endif
                              >Income</option>
                              <option value="2" 
                              @if (request()->type==2)
                                selected
                                @endif
                              >Expense</option>
                            </select>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
        <div class="infinite-scroll">
            @foreach ($transcations as $transcation)
            <a href="{{route('transcationsDetails',$transcation->trx_id)}}">
                <div class="card mb-2">
                    <div class="card-body">
                       <div class="d-flex justify-content-between mb-0">
                          <h6 class="mb-0">{{$transcation->trx_id}}</h6>
                          <p
                          class="
                          @if($transcation->type===2)
                          text-danger
                          @else
                          text-success
                          @endif"
                          >{{number_format($transcation->amount)}}<span>(MMK)</span></p>
                       </div>
                       <p class="text-muted mb-1">
                           @if ($transcation->type===2)
                              To <span>{{$transcation->source->name}}</span>
                           @elseif($transcation->type===1)
                              From
                              <span>{{$transcation->source->name}}</span>
                           @endif
                       </p>
                       <p class="text-muted">
                           {{$transcation->created_at}}
                       </p>
                    </div>
                </div>
            </a>
            @endforeach
            {{$transcations->links()}}
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $('.infinite-scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<span>loading...</span>', // MAKE SURE THAT YOU PUT THE CORRECT IMG PATH
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function() {
                    $('ul.pagination').remove();
                }
            });
                $(".type").on("change",function(e){
                    e.preventDefault();
                    let type=$(this).val();
                    let date=$(".date").val();
                    history.pushState(null,"",`?type=${type}&date=${date}`)
                    window.location.reload();
                })
                $('.date').daterangepicker({
                                "singleDatePicker": true,
                                "autoApply": false,
                                "autoUpdateInput":false,
                                "locale": {
                                    "format": "YYYY-MM-DD",
                                    "separator": " - ",
                                    "applyLabel": "Apply",
                                    "cancelLabel": "Cancel",
                                    "fromLabel": "From",
                                    "toLabel": "To",
                                    "customRangeLabel": "Custom",
                                    "weekLabel": "W",
                                    "daysOfWeek": [
                                        "Su",
                                        "Mo",
                                        "Tu",
                                        "We",
                                        "Th",
                                        "Fr",
                                        "Sa"
                                    ],
                                    "monthNames": [
                                        "January",
                                        "February",
                                        "March",
                                        "April",
                                        "May",
                                        "June",
                                        "July",
                                        "August",
                                        "September",
                                        "October",
                                        "November",
                                        "December"
                                    ],
                                    "firstDay": 1
                                },
                                "opens": "left"
                            }, function(start, end, label) {
                            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                            });

                            $('.date').on('apply.daterangepicker', function(ev, picker) {
                            $(".date").val(picker.startDate.format("YYYY-MM-DD"))
                            let date=$(".date").val();
                            let type=$(".type").val();
                            history.pushState(null,"",`?type=${type}&date=${date}`);
                            window.location.reload();   
                        });
                        $('.date').on('cancel.daterangepicker', function(ev, picker) {
                            $(".date").val("")
                            let type=$(".type").val();
                            let date=$(".date").val();
                           history.pushState(null, '', `?type=${type}&date=${date}`)
                           window.location.reload()
                        });
        })
    </script>
@endsection
    

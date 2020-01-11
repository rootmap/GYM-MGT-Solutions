@extends('apps.layout.master')
@section('title','Dashboard')
@section('content')
    <!-- main menu-->
<?php 
    $dataMenuAssigned=array();
    $dataMenuAssigned=StaticDataController::dataMenuAssigned();
    //dd($dataMenuAssigned);
?>

<!-- fitness target -->
<div class="row">
    <div class="col-md-8">
            <div class="card">
                <div class="card-header card-success card-green bg-darken-2">
                    <h4 class="card-title" style="color: #fff;"><i class="icon-stats-dots"></i> System Summary</h4>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i style="color: #fff;" class="icon-minus4"></i></a></li>
                            <li><a data-action="expand"><i class="icon-expand2" style="color: #fff;"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in" style="padding-top: 20px;">
                   
                    <div class="col-xs-12">

                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-12 border-right-blue-grey border-right-lighten-5">
                        <div class="my-1  text-xs-center">
                            <div class="card-header mb-2 pt-0">
                                <span class="green">Total Member</span>
                                <h3 class="font-large-2 text-bold-200">{{$dash->totalMember}}</h3>
                            </div>
                            <div class="card-body">
                                <input type="text" value="65" class="knob hide-value responsive angle-offset" data-angleOffset="40" data-thickness=".15" data-linecap="round" data-width="130" data-height="130" data-inputColor="#4CAF50" data-readOnly="true" data-fgColor="#4CAF50" data-knob-icon="icon-mobile">
                                <ul class="list-inline clearfix mt-1 mb-0">
                                    <li>
                                        <h2 class="grey darken-1 text-bold-400">{{$dash->todayMember}}</h2>
                                        <span class="green">Today Added In System</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 border-right-blue-grey border-right-lighten-5">
                        <div class="my-1 text-xs-center">
                            <div class="card-header mb-2 pt-0">
                                <span class="green lighten-1">Total Admission</span>
                                <h3 class="font-large-2 text-bold-200">{{$dash->total_admission}}</h3>
                            </div>
                            <div class="card-body">
                                <input type="text" value="70" class="knob hide-value responsive angle-offset" data-angleOffset="0" data-thickness=".15" data-linecap="round" data-width="130" data-height="130" data-inputColor="#66BB6A" data-readOnly="true" data-fgColor="#66BB6A" data-knob-icon="icon-truck3">
                                <ul class="list-inline clearfix mt-1 mb-0">
                                    <li>
                                        <h2 class="grey darken-1 text-bold-400">{{$dash->total_admission}}</h2>
                                        <span class="green lighten-1">Today Stock In</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 border-right-blue-grey border-right-lighten-5">
                        <div class="my-1 text-xs-center">
                            <div class="card-header mb-2 pt-0">
                                <span class="green darken-1">Payment From Member</span>
                                <h3 class="font-large-2 text-bold-200">{{$dash->totalPayment}}</h3>
                            </div>
                            <div class="card-body">
                                <input type="text" value="81" class="knob hide-value responsive angle-offset" data-angleOffset="20" data-thickness=".15" data-linecap="round" data-width="130" data-height="130" data-inputColor="#43A047" data-readOnly="true" data-fgColor="#43A047" data-knob-icon="icon-users">
                                <ul class="list-inline clearfix mt-1 mb-0">
                                    <li>
                                        <h2 class="grey darken-1 text-bold-400">{{$dash->todayPayment}}</h2>
                                        <span class="green darken-1">Today Added in System</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12">
                        <div class="my-1 text-xs-center">
                            <div class="card-header mb-2 pt-0">
                                <span class="green accent-1">Total Punch</span>
                                <h3 class="font-large-2 text-bold-200">{{$dash->totalAttendance}}</h3>
                            </div>
                            <div class="card-body">
                                <input type="text" value="75" class="knob hide-value responsive angle-offset" data-angleOffset="20" data-thickness=".15" data-linecap="round" data-width="130" data-height="130" data-inputColor="#B9F6CA" data-readOnly="true" data-fgColor="#B9F6CA" data-knob-icon="icon-page-break">
                                <ul class="list-inline clearfix mt-1 mb-0">
                                    <li>
                                        <h2 class="grey darken-1 text-bold-400">{{$dash->todayAttendance}}</h2>
                                        <span class="green accent-1">Today Punch</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            
    </div>
                    <div class="clearfix"></div>
                    <br>
                </div>
            </div>
   </div>
   <div class="col-xl-4 col-lg-4 col-md-4">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title" style="color: green;"><i class="icon-users2"></i> Today GYM Member</h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body collapse in">
                
                <div class="table-responsive" style="overflow-y: scroll; height: 390px;">
                    <table class="table table-striped table-bordered" width="100%" cellspacing="0" id="report_table">
                        <thead>
                            <tr>
                                <th>PIN</th>
                                <th>Name</th>
                                <th>Punch </th>
                            </tr>
                        </thead>
                        <tbody id="attendance" style="color: green;">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


   </div>
    
</div>
<!--/ fitness target -->

<!-- friends & weather charts -->
<div class="row match-height">
    
    
</div>
<!-- friends & weather charts -->

<div class="row">



    <style type="text/css">
    	.list-group-item
    	{
    		    padding: 0.90rem 1.25rem !important;
    	}
    </style>

    <div class="col-xl-4 col-lg-6 col-md-12">
        {{-- <div class="card bg-green">
            <div class="card-body">
                <div class="card-block">
                    <h4 class="card-title">Product Sold Heighest Time</h4>
                    <p class="card-text">[{{count($product)}}] Products Showing out of [{{$dash->product_item_quantity}}].</p>
                </div>
                <ul class="list-group list-group-flush">
                    @if(isset($product))
                        @foreach($product as $pro)
                            <li class="list-group-item">
                                <span class="tag tag-default tag-pill bg-primary float-xs-right">{{$pro->sold_times}}</span> {{$pro->name}}
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div> --}}
        <div class="card" style="padding-bottom: 10px;">
            <div class="card-body collapse in" style="padding-top: 30px;">
                <div class="card-block">
                    <div id="pie-chart"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body text-xs-left">
                            <h3 class="green accent-2">${{$dash->totalTodayinAdmission}}</h3>
                            <span>Today Total Admission</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-users green accent-2 font-large-2 float-xs-right"></i>
                        </div>
                    </div>
                    <progress class="progress progress-sm progress-green bg-accent-2 mt-1 mb-0" value="80" max="100"></progress>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body text-xs-left">
                            <h3 class="green lighten-3">${{$dash->totalTodayMontly}}</h3>
                            <span>Today Total Monthly payment</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-money green lighten-3 font-large-2 float-xs-right"></i>
                        </div>
                    </div>
                    <progress class="progress progress-sm progress-green bg-lighten-3 mt-1 mb-0" value="35" max="100"></progress>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body text-xs-left">
                            <h3 class="green">${{$dash->totalallpayment}}</h3>
                            <span>Today Total Payment</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-cash green font-large-2 float-xs-right"></i>
                        </div>
                    </div>
                    <progress class="progress progress-sm progress-green mt-1 mb-0" value="35" max="100"></progress>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-4">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title" style="color: red;"><i class="icon-users2"></i> Due Payment Member</h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a class="loadAttendance"><i class="icon-spinner10 spinner"></i></a></li>
                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body collapse in">
                
                <div class="table-responsive" style="overflow-y: scroll; height: 350px;">
                    <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>PIN</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody style="color: green;">
                            @if(isset($payment_due))
                            @foreach($payment_due as $row)
                            <tr>
                                <td>{{$row->pin}}</td>
                                <td>{{$row->NAME}}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


   </div>
</div>

@endsection

@section('css')
    
    <link rel="stylesheet" type="text/css" href="{{url('theme/app-assets/vendors/css/forms/icheck/icheck.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('theme/app-assets/vendors/css/forms/icheck/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('theme/app-assets/vendors/css/extensions/unslider.css')}}">

    <!-- END VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('theme/app-assets/css/core/colors/palette-climacon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('theme/app-assets/css/pages/users.min.css')}}">
    <!-- END Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('theme/app-assets/vendors/css/charts/c3.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('theme/app-assets/css/plugins/charts/c3-chart.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{url('theme/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
    <style type="text/css">
        div.dataTables_length{
                padding-left: 10px;
                padding-top: 15px;
        }

        .dataTables_length>label{
            margin-bottom: 0px !important;
            display:block; !important;
        }

        div.dataTables_filter
        {
            padding-right: 10px;
        }

        div.dataTables_green{
            padding-left: 10px;
        }

        div.dataTables_paginate{
            padding-right: 10px;
            padding-top: 5px;
        }
    </style>
@endsection

@section('js')
     <!-- build:js app-assets/js/vendors.min.js-->
    <!-- /build-->
    <script src="{{url('theme/app-assets/vendors/js/tables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{url('theme/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}" type="text/javascript"></script>

    <!-- BEGIN PAGE LEVEL JS-->
    <script src="{{url('theme/app-assets/js/scripts/tables/datatables/datatable-basic.min.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="{{url('theme/app-assets/vendors/js/charts/d3.min.js')}}" type="text/javascript"></script>
    <script src="{{url('theme/app-assets/vendors/js/charts/c3.min.js')}}" type="text/javascript"></script>
    <!-- END PAGE VENDOR JS-->

    <!-- BEGIN PAGE LEVEL JS-->
    {{-- <script src="js/pie.js" type="text/javascript"></script> --}}
    <script type="text/javascript">

        function loadAttendance(){
            var loadAttanceURL="{{url('load/attendance/today')}}";
            $.ajax({

                'async': true,
                'type': "GET",
                'global': true,
                'dataType': 'json',
                'url': loadAttanceURL,
                'success': function (data) { 

                    console.log(data);

                }

            });
        }

        function TodayAttendance(){
            var loadAttanceURL="{{url('attendance/today')}}";
            $.ajax({

                'async': true,
                'type': "GET",
                'global': true,
                'dataType': 'json',
                'url': loadAttanceURL,
                'success': function (data) { 
                    var kHTML='';
                    $.each(data,function(key,row){
                        console.log(row);
                        //attendance
                        var htmlStr='';
                        htmlStr+='<tr>';
                        htmlStr+='<td style="font-size:8px;">'+row.pin+'</td>';
                        htmlStr+='<td style="font-size:8px;">'+row.name+'</td>';
                        htmlStr+='<td style="font-size:8px;">'+row.datetime+'</td>';
                        htmlStr+='</tr>';

                        kHTML+=htmlStr;
                    });

                    $("#attendance").html(kHTML);

                    //$('#report_table').DataTable();

                }

            });
        }

        $(document).ready(function(){
            loadAttendance();
            TodayAttendance();
            setInterval(function(){ loadAttendance(); TodayAttendance(); }, 50000);
            
        });

        $(window).on("load", function() {





            var pieChart = c3.generate({
                bindto: "#pie-chart",
                color: {
                    pattern: [
                                "#99B898", 
                                "#FECEA8", 
                                "#FF847C",
                                "#DC143C",
                                "#00FFFF",
                                "#00008B",
                                "#008B8B",
                                "#B8860B"
                            ]
                },
                data: {
                    columns: [
                        @if(isset($product))
                            @foreach($product as $pro)
                                ["{{$pro->NAME}}", {{$pro->total}}],
                            @endforeach
                        @endif
                    ],
                    type: "pie",
                    onclick: function(d, i) {},
                    onmouseover: function(d, i) {},
                    onmouseout: function(d, i) {}
                }
            });
            
        });
    </script>
    
    <!-- END PAGE LEVEL JS-->
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    
    <script src="{{url('theme/app-assets/vendors/js/charts/gmaps.min.js')}}" type="text/javascript"></script>
    <script src="{{url('theme/app-assets/vendors/js/forms/icheck/icheck.min.js')}}" type="text/javascript"></script>
    <script src="{{url('theme/app-assets/vendors/js/extensions/jquery.knob.min.js')}}" type="text/javascript"></script>
    <script src="{{url('theme/app-assets/vendors/js/charts/raphael-min.js')}}" type="text/javascript"></script>

    <script src="{{url('theme/app-assets/vendors/js/extensions/unslider-min.js')}}" type="text/javascript"></script>
    <script src="{{url('theme/app-assets/vendors/js/charts/echarts/echarts.js')}}" type="text/javascript"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN ROBUST JS-->
        <script src="{{url('theme/app-assets/vendors/js/charts/jvector/jquery-jvectormap-2.0.3.min.js')}}" type="text/javascript"></script>
    <script src="{{url('theme/app-assets/vendors/js/charts/jvector/jquery-jvectormap-world-mill.js')}}" type="text/javascript"></script>
    <script src="{{url('theme/app-assets/data/jvector/visitor-data.js')}}" type="text/javascript"></script>
    <!-- END ROBUST JS-->
    <!-- BEGIN PAGE LEVEL JS-->

    <script src="{{url('theme/app-assets/js/scripts/pages/dashboard-crm.min.js')}}" type="text/javascript"></script>

@endsection
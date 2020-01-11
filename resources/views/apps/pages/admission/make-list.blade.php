@extends('apps.layout.master')
@section('title','Member Admission Report')
@section('content')
<section id="form-action-layouts">
    <?php
    $userguideInit=StaticDataController::userguideInit();
    ?>
  <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-card-center"><i class="icon-filter_list"></i>  Member Admission Report Filter</h4>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block">
                        <form id="salesSu" method="post" action="{{url('admission/report')}}">
                            {{csrf_field()}}
                            <fieldset class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <h4>Start Date</h4>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="icon-calendar3"></i></span>
                                            <input
                                            @if(!empty($start_date))
                                            value="{{$start_date}}"
                                            @endif
                                            name="start_date" type="text" class="form-control DropDateWithformat" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <h4>End Date</h4>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="icon-calendar3"></i></span>
                                            <input
                                            @if(!empty($end_date))
                                            value="{{$end_date}}"
                                            @endif
                                            name="end_date" type="text" class="form-control DropDateWithformat" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <h4>PIN</h4>
                                        <div class="input-group">
                                            <input
                                            @if(!empty($pin))
                                            value="{{$pin}}"
                                            @endif
                                            type="text" id="eventRegInput1" class="form-control border-primary" placeholder="PIN" name="pin">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <h4>Filter Payment</h4>
                                        <div class="input-group">
                                            <select name="payment_id" class="select2 form-control">
                                                <option value="">Payment Method</option>
                                                @if(isset($tender))
                                                @foreach($tender as $cus)
                                                <option
                                                    @if(!empty($payment_id) && $payment_id==$cus->id)
                                                    selected="selected"
                                                    @endif
                                                value="{{$cus->id}}">{{$cus->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <h4>Filter Package</h4>
                                        <div class="input-group">
                                            <select name="package_id" class="select2 form-control">
                                                <option value="">Choose Package</option>
                                                @if(isset($package))
                                                @foreach($package as $cus)
                                                <option
                                                    @if(!empty($package_id) && $package_id==$cus->id)
                                                    selected="selected"
                                                    @endif
                                                value="{{$cus->id}}">{{$cus->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        
                                        <div class="input-group" style="margin-top:32px;">
                                            <button type="submit" id="salesSUSub" class="btn btn-green btn-darken-1 mr-1">
                                            <i class="icon-check2"></i> Generate Report
                                            </button>
                                            <a href="javascript:void(0);" data-url="{{url('admission/report/excel/report')}}" class="btn btn-green btn-darken-2 mr-1 change-action-export-sales">
                                                <i class="icon-file-excel-o"></i> Generate Excel
                                            </a>
                                            <a href="javascript:void(0);" data-url="{{url('admission/report/pdf/report')}}" class="btn btn-green btn-darken-3 mr-1 change-action-export-sales">
                                                <i class="icon-file-pdf-o"></i> Generate PDF
                                            </a>
                                            <a href="{{url('admission/report')}}" style="margin-left: 5px;" class="btn btn-green btn-darken-4">
                                                <i class="icon-refresh"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Both borders end-->
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="icon-users"></i> Member Admission Report</h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                    </ul>
                </div>
            </div>

                <div class="card-body collapse in">
                    <div class="table-responsive" style="min-height: 360px;">
                        <table class="table table-striped table-bordered" id="salesreturn_list">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Req ID / PIN </th>
                                <th>Name </th>
                                <th>Cell Phone</th>
                                <th>Package</th>
                                <th>Payment</th>
                                <th>Payment Amount</th>
                                <th>Admission Date </th>
                                <th>Expire Date</th>
                                <th width="300">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($dataTable))
                            @foreach($dataTable as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->req_no}}</td>
                                <td>{{$row->first_name.' '.$row->middle_name.' '.$row->last_name}}</td>
                                <td>{{$row->cell_phone}}</td>
                                <td>{{$row->package_name}}</td>
                                <td>{{$row->payment_name}}</td>
                                <td>{{$row->amount_paid}}</td>
                                <td>{{formatDate($row->admission_date)}}</td>
                                <td>{{formatDate($row->date_of_expiry)}}</td>
                                <td>
                                    <a class="btn btn-green" href="{{url('admission/edit/'.$row->id)}}"><i class="icon-edit"></i> Edit</a>
                                    <a class="btn btn-green" href="{{url('admission/view/'.$row->id)}}"><i class="icon-eye"></i> View</a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6">No Record Found</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Both borders end -->

</section>

@endsection


@include('apps.include.datatablecssjs',['selectTwo'=>1,'dateDrop'=>1])
@section('RoleWiseMenujs')
   <script>
    
    $(document).ready(function(e){

        var dataObj="";
        function replaceNull(valH){
            var returnHt='';

            if(valH !== null && valH !== '') {
                    returnHt=valH;
            }

            return returnHt;
        }

        @if(!empty($pin) || !empty($package_id) || !empty($payment_id) || !empty($start_date) || !empty($end_date))
            @if(isset($dataTable))
                @if(count($dataTable)>0)
                    $('#salesreturn_list').DataTable();
                @endif
            @endif
        @else

        var admisionURL="{{url('admission/edit')}}";
        var admisionViewURL="{{url('admission/view')}}";

        $('#salesreturn_list').dataTable({
            "bProcessing": true,
            "serverSide": true,
            "ajax":{
                url :"{{url('admission/report/json')}}",
                headers: {
                    'X-CSRF-TOKEN':'{{csrf_token()}}',
                },
                type: "POST",
                complete:function(data){
                    console.log(data.responseJSON);
                    var totalData=data.responseJSON;
                    console.log(totalData.data);
                    var strHTML='';
                    var totalPrice=0;
                    $.each(totalData.data,function(key,row){
                        console.log(row);

                        var actionButtons='<a class="btn btn-green" href="'+admisionURL+'/'+row.id+'"><i class="icon-edit"></i> Edit</a> <a class="btn btn-green" href="'+admisionViewURL+'/'+row.id+'"><i class="icon-eye"></i> View</a>';

                        strHTML+='<tr>';
                        strHTML+='      <td>'+row.id+'</td>';
                        strHTML+='      <td>'+row.req_no+'</td>';
                        strHTML+='      <td>'+replaceNull(row.first_name)+'</td>';
                        strHTML+='      <td>'+replaceNull(row.cell_phone)+'</td>';
                        strHTML+='      <td>'+replaceNull(row.package_name)+'</td>';
                        strHTML+='      <td>'+replaceNull(row.payment_name)+'</td>';
                        strHTML+='      <td>'+replaceNull(row.amount_paid)+'</td>';
                        strHTML+='      <td>'+formatDate(replaceNull(row.admission_date))+'</td>';
                        strHTML+='      <td>'+formatDate(replaceNull(row.date_of_expiry))+'</td>';
                        strHTML+='      <td>'+actionButtons+'</td>';
                        strHTML+='</tr>';

                        totalPrice+=replaceNull(row.price)-0;

                    });

                    $("#totalDataAmount").html(totalPrice);

                    $("tbody").html(strHTML);
                    $('#salesreturn_list').DataTable();
                },
                initComplete: function(settings, json) {
                    alert( 'DataTables has finished its initialisation.' );
                  },
                error: function(){
                  $("#salesreturn_list_processing").css("display","none");
                }
            }
        });

        @endif
    });


    </script>

@endsection
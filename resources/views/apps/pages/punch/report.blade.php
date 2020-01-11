@extends('apps.layout.master')
@section('title','Attendance Punch Report')
@section('content')
<section id="form-action-layouts">
    <?php 
        $userguideInit=StaticDataController::userguideInit();
        //dd($dataMenuAssigned);
    ?>
<div class="row">
    <div class="col-md-12" @if($userguideInit==1) data-step="1" data-intro="In this section, you can create a attendance punch report by date wise or employee id and generate excel or PDF" @endif>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" id="basic-layout-card-center"><i class="icon-filter_list"></i> Attendance Punch Report Filter</h4>
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
                    <form method="post" action="{{url('attendance/punch/report')}}">
                        {{csrf_field()}}
                        <fieldset class="form-group">
                            <div class="row">
                                <div class="col-md-3">
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
                                <div class="col-md-3">
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

                                <div class="col-md-3">
                                        <h4>Filter Employee</h4>
                                        <div class="input-group">
                                            <select name="user_id" class="select2 form-control">
                                                <option value="">Select a Employee</option>
                                                @if(isset($userL))
                                                    @foreach($userL as $ven)
                                                    <option 
                                                     @if(isset($user_id) && $user_id==$ven->pin)
                                                        selected="selected"  
                                                     @endif 
                                                    value="{{$ven->pin}}">{{$ven->pin}}-{{$ven->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                
                                <div class="col-md-12">
                                    
                                    <div class="input-group" style="margin-top:32px;">
                                        <button type="submit" class="btn btn-green btn-darken-1 mr-1">
                                            <i class="icon-check2"></i> Generate Report
                                        </button>
                                        <a href="javascript:void(0);" data-url="{{url('attendance/punch/excel')}}" class="btn btn-green btn-darken-2 mr-1 change-action">
                                            <i class="icon-file-excel-o"></i> Generate Excel
                                        </a>
                                        <a href="javascript:void(0);" data-url="{{url('attendance/punch/pdf')}}" class="btn btn-green btn-darken-3 mr-1 change-action">
                                            <i class="icon-file-pdf-o"></i> Generate PDF
                                        </a>
                                        <a href="{{url('attendance/punch/report')}}" style="margin-left: 5px;" class="btn btn-green btn-darken-4">
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
                <h4 class="card-title"><i class="icon-database"></i> Attendance Punch List</h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                    </ul>
                </div>
            </div>

                <div class="card-body collapse in">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="cashierPunch_list">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>PIN</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>In Time</th>
                                <th>Out Time</th>
                                <th>Elapsed Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($dataTable))
                            @foreach($dataTable as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->pin}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{formatDate($row->date)}}</td>
                                <td>{{$row->in_time}}</td>
                                <td>{{$row->out_time}}</td>
                                <td>{{($row->elapsed_time)}}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="7">No Record Found</td>
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

        var punchEdit="{{url('attendance/punch/edit')}}";

        function actionTemplate(id){
            var strHTML='';
                strHTML+='<a href="'+punchEdit+'/'+id+'" class="btn btn-green" ';
                @if($userguideInit==1) 
                    strHTML+='data-step="7" data-intro="Employee/user punch can be edit using this click on this button" ';
                @endif
                strHTML+='><i class="icon-edit"></i> Edit</a>';

                return strHTML;
        }

        @if(!empty($start_date) || !empty($end_date) || !empty($user_id))
            @if(isset($dataTable))
                @if(count($dataTable)>0)
                    $('#cashierPunch_list').DataTable();
                @endif
            @endif
        @else

        $('#cashierPunch_list').dataTable({
            "bProcessing": true,
            "serverSide": true,
            "ajax":{
                url :"{{url('attendance/punch/data/json')}}",
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

                        strHTML+='<tr>';
                        strHTML+='      <td>'+row.id+'</td>';
                        strHTML+='      <td>'+row.pin+'</td>';
                        strHTML+='      <td>'+row.name+'</td>';
                        strHTML+='      <td>'+formatDate(replaceNull(row.date))+'</td>';
                        strHTML+='      <td>'+replaceNull(row.in_time)+'</td>';
                        strHTML+='      <td>'+replaceNull(row.out_time)+'</td>';
                        strHTML+='      <td>'+replaceNull(row.elapsed_time)+'</td>';
                        strHTML+='</tr>';

                        //totalPrice+=replaceNull(row.price)-0;

                    });

                    //$("#totalDataAmount").html(totalPrice);

                    $("tbody").html(strHTML);
                    $('#cashierPunch_list').DataTable();
                },
                initComplete: function(settings, json) {
                    alert( 'DataTables has finished its initialisation.' );
                  },
                error: function(){
                  $("#cashierPunch_list_processing").css("display","none");
                }
            }
        });

        @endif
    });


    </script>

@endsection
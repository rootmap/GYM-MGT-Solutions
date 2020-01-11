@extends('apps.layout.master')
@section('title','Member')
@section('content')
<section id="file-exporaat">
<?php 
    $dataMenuAssigned=array();
    $dataMenuAssigned=StaticDataController::dataMenuAssigned();
	$userguideInit=StaticDataController::userguideInit();
    //dd($dataMenuAssigned);
?>

	<!-- Both borders end-->
<div class="row">
	<div class="col-xs-12" @if($userguideInit==1) data-step="1" data-intro="You are seeing all customer in this table and see customer report." @endif>
		<div class="card">
			<div class="card-header">
				<h4 class="card-title"><i class="icon-users2"></i> Member List</h4>
				<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
        		<div class="heading-elements">
					<ul class="list-inline mb-0">
						<li><a href="{{url('customer/excel/report')}}"><i class="icon-file-excel" style="font-size: 20px;"></i></a></li>
                        <li><a href="{{url('customer/pdf/report')}}"><i class="icon-file-pdf"  style="font-size: 20px;"></i></a></li>
                        <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
						<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-body collapse in">
				<div class="table-responsive">
					<table id="post_list" class="dataTable table table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>ID</th>
								<th width="500">Name</th>
								<th>PIN</th>
								<th>Password</th>
								<th>User Type</th>
								<th>User Account</th>
								@if(in_array('list_customer_report', $dataMenuAssigned))
									<th>Report</th>
								@endif
							</tr>
						</thead>
						<tbody>
							
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


@section('css')
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
	
    <script src="{{url('theme/app-assets/vendors/js/tables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{url('theme/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}" type="text/javascript"></script>

    <!-- BEGIN PAGE LEVEL JS-->
    <script src="{{url('theme/app-assets/js/scripts/tables/datatables/datatable-basic.min.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS-->
   <script>
	
	$(document).ready(function(e){
		var customerReportLink="{{url('customer/report')}}";
		var customerEditLink="{{url('customer/edit')}}";
		var customerDeleteLink="{{url('customer/delete')}}";

		function actionTemplate(id){
			var actHTml='';
				actHTml+='<a href="'+customerEditLink+'/'+id+'" class="btn btn-green mr-1 btn-darken-2">	<i class="icon-edit"></i> </a>';

				actHTml+='<a href="'+customerDeleteLink+'/'+id+'" class="btn btn-green mr-1 btn-darken-3">	<i class="icon-trash"></i> </a>';

				return actHTml;
		}

		function replaceNull(valH){
			var returnHt='';
			if(valH !== null && valH !== '') {
					returnHt=valH;
			}
			return returnHt;
		}

		$('#post_list').dataTable({
			"bProcessing": true,
         	"serverSide": true,
         	"ajax":{
	            url :"{{url('customer/data/json')}}",
	            headers: {
			        'X-CSRF-TOKEN':'{{csrf_token()}}',
			    },
	            type: "POST",
	            complete:function(data){
	            	console.log(data.responseJSON);
	            	var totalData=data.responseJSON;
	            	console.log(totalData.data);
	            	var strHTML='';
	            	var privilege='';
	            	$.each(totalData.data,function(key,row){
	            		console.log(row);

	            		privilege='';
	            		if(row.privilege==0){
	            			privilege='Normal User';
	            		}else{
	            			privilege='Staff / Admin';
	            		}

	            		strHTML+='<tr>';
						strHTML+='		<td>'+row.id+'</td>';
						strHTML+='		<td>'+row.name+'</td>';
						strHTML+='		<td>'+replaceNull(row.pin)+'</td>';
						strHTML+='		<td>'+replaceNull(row.password)+'</td>';
						strHTML+='		<td>'+replaceNull(privilege)+'</td>';
						strHTML+='		<td>'+replaceNull(row.user_status)+'</td>';
						@if(in_array('list_customer_report', $dataMenuAssigned))
							strHTML+='		<td width="550">'+actionTemplate(row.id)+'</td>';
						@endif
						strHTML+='</tr>';
	            	});

	            	$("tbody").html(strHTML);

	            	$('#post_list').DataTable();
	            },
	            initComplete: function(settings, json) {
				    alert( 'DataTables has finished its initialisation.' );
				  },
	            error: function(){
	              $("#post_list_processing").css("display","none");
	            }
          	}
        });
	});


    </script>

@endsection
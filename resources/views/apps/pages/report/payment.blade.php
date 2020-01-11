@extends('apps.layout.master')
@section('title','Payment Report')
@section('content')

	
<section id="form-action-layouts">
	<?php
	$userguideInit=StaticDataController::userguideInit();
	?>
		<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-card-center"><i class="icon-filter_list"></i> Payment Report Filter</h4>
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
						<form method="post" action="{{url('payment/report')}}">
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
	                                    <h4>Receipt No</h4>
	                                    <div class="input-group">
										<input 
										 @if(!empty($receipt_number))
	                                        	value="{{$receipt_number}}"  
	                                     @endif 
										 type="text" id="eventRegInput1" class="form-control border-green" placeholder="Receipt No" name="receipt_number">
	                                    </div>
	                                </div>
	                                <div class="col-md-3">
	                                    <h4>Member</h4>
	                                    <div class="input-group">
											<select name="pin" class="select2 form-control">
												<option value="">Choose Member</option>
												@if(isset($customer))
													@foreach($customer as $cus)
													<option 
													 @if(!empty($pin) && $pin==$cus->pin)
				                                        selected="selected"  
				                                     @endif 
													value="{{$cus->pin}}">{{$cus->pin}} - {{$cus->name}}</option>
													@endforeach
												@endif
											</select>
	                                    </div>
	                                </div>
	                                <div class="col-md-3">
	                                    <h4>Tender</h4>
	                                    <div class="input-group">
											<select name="tender_id" class="select2 form-control">
												<option value="">Select a tender</option>
												@if(isset($tenderData))
													@foreach($tenderData as $cus)
													<option 
													 @if(!empty($tender_id) && $tender_id==$cus->id)
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
	                                        <button type="submit" class="btn btn-green btn-darken-1 mr-1">
												<i class="icon-check2"></i> Generate
											</button>
											<a href="javascript:void(0);" data-url="{{url('payment/excel/report')}}" class="btn btn-green btn-darken-2 mr-1 change-action">
												<i class="icon-file-excel-o"></i> Generate Excel
											</a>
											<a href="javascript:void(0);" data-url="{{url('payment/pdf/report')}}" class="btn btn-green btn-darken-3 mr-1 change-action">
												<i class="icon-file-pdf-o"></i> Generate PDF
											</a>
											<a href="{{url('payment/report')}}" style="margin-left: 5px;" class="btn btn-green btn-darken-4">
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
				<h4 class="card-title"><i class="icon-clear_all"></i> Payment List</h4>
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
					<table class="table table-striped table-bordered" id="report_table">
						<thead>
							<tr>
								<th>Pay.Id</th>
								<th>Pay.Date</th>
								<th>Pay.Type</th>
								<th>PIN</th>
								<th width="200">Name</th>
								<th>Tender</th>
								<th>Paid Amount</th>
								<th>Receipt No</th>
								<th width="200">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$invoice_total=0;
							$cost_total=0;
							$paid_amount=0;
							?>
							@if(isset($invoice))
								@foreach($invoice as $inv)
								<tr>
	                                <td>{{$inv->id}}</td>
	                                <td>{{formatDate($inv->payment_date)}}</td>
	                                <td>{{$inv->month_fee_for}}</td>
	                                <td>{{$inv->pin}}</td>
	                                <td>{{$inv->member_name}}</td>
	                                <td>{{$inv->payment_method_name}}</td>
	                                <td>Tk {{number_format($inv->month_fee,2)}}</td>
	                                <td>{{$inv->receipt_number}}</td>
	                                <td>{{$inv->receipt_number}}</td>
	                            </tr>
	                            <?php 
								$paid_amount+=$inv->month_fee;
								?>
	                            @endforeach
							@endif

						</tbody>
					</table>
				</div>
			</div>
		</div>




						<div class="col-lg-4 col-sm-4 border-right-green bg-green border-right-lighten-4">
                            <div class="card-block text-xs-center">
                                <h1 class="display-4 white"><i class="icon-money font-large-2"></i> <span id="totalDataAmount">Tk {{number_format($paid_amount,2)}}</span></h1>
                                <span class="white">Total Paid Amount</span>
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

		@if(!empty($start_date) || !empty($end_date) || !empty($receipt_number) || !empty($pin) || !empty($tender_id))
			@if(isset($invoice))
        		@if(count($invoice)>0)
        			$('#report_table').DataTable();
        		@endif
        	@endif
        @else

        var paymentEditUrl="{{url('gympayment/edit')}}";
        var paymentViewUrl="{{url('gympayment/view')}}";

		$('#report_table').dataTable({
			"bProcessing": true,
         	"serverSide": true,
         	"ajax":{
	            url :"{{url('payment/data/report/json')}}",
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

	            		var actionButtons='<a class="btn btn-green" href="'+paymentEditUrl+'/'+row.id+'"><i class="icon-edit"></i> Edit</a> <a class="btn btn-green" href="'+paymentViewUrl+'/'+row.id+'"><i class="icon-eye"></i> View</a>';

	            		strHTML+='<tr>';
						strHTML+='		<td>'+row.id+'</td>';
						strHTML+='		<td>'+formatDate(replaceNull(row.payment_date))+'</td>';
						strHTML+='		<td>'+row.month_fee_for+'</td>';
						strHTML+='		<td>'+row.pin+'</td>';
						strHTML+='		<td>'+row.member_name+'</td>';
						strHTML+='		<td>'+row.payment_method_name+'</td>';
						strHTML+='		<td>Tk '+number_format(replaceNull(row.month_fee))+'</td>';
						strHTML+='		<td>'+replaceNull(row.receipt_number)+'</td>';						
						strHTML+='		<td>'+actionButtons+'</td>';						
						strHTML+='</tr>';

						totalPrice+=replaceNull(row.month_fee)-0;

	            	});

	            	$("#totalDataAmount").html('Tk '+number_format(totalPrice));

	            	$("tbody").html(strHTML);
	            	$('#report_table').DataTable();
	            },
	            initComplete: function(settings, json) {
				    alert( 'DataTables has finished its initialisation.' );
				  },
	            error: function(){
	              $("#report_table_processing").css("display","none");
	            }
          	}
        });

        @endif
	});


    </script>

@endsection
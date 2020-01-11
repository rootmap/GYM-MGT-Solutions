@extends('apps.layout.master')
@section('title','Today Payment Report')
@section('content')

	
<section id="form-action-layouts">
	<?php
	$userguideInit=StaticDataController::userguideInit();
	?>
		

	<!-- Both borders end-->
<div class="row">
	<div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title"><i class="icon-clear_all"></i> Today Payment List</h4>
				<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
        		<div class="heading-elements">
					<ul class="list-inline mb-0">
						<li><a href="{{url('today/payment/excel/report')}}"><i class="icon-file-excel" style="font-size: 20px;"></i></a></li>
                        <li><a href="{{url('today/payment/pdf/report')}}"><i class="icon-file-pdf"  style="font-size: 20px;"></i></a></li>
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
  

@endsection
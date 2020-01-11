@extends('apps.layout.master')
@section('title','Repair List')
@section('content')
<section id="form-action-layouts">
<?php 
    $userguideInit=StaticDataController::userguideInit();
?>
<!-- Both borders end-->
<div class="row">
	<div class="col-xs-12" @if($userguideInit==1) data-step="1" data-intro="You are seeing all the repair list in this table." @endif>
		<div class="card">
			<div class="card-header">
				<h4 class="card-title"><i class="icon-clear_all"></i> Repair List</h4>
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
					<table class="table table-striped table-bordered zero-configuration">
						<thead>
							<tr>
								<th>Id</th>
								<th>Date</th>
								<th>Customer</th>
								<th>Repair Detail</th>
								<th>Price</th>
								<th>Status</th>
								<th>Invoice ID</th>
								<th>Action</th>
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
	                                <td>{{formatDate($inv->created_at)}}</td>
	                                <td>{{$inv->customer_name}}</td>
	                                <td>{{$inv->product_name}}</td>
	                                <td>{{number_format($inv->price,2)}}</td>
	                                <td>
	                                	@if($inv->payment_status=="Pending" && $inv->invoice_status!="Paid")
	                                		<a href="{{url('pos/repair/'.$inv->id)}}" class="btn btn-green"> {{number_format($inv->price,2)}} To POS</i> </a>
	                                	@elseif($inv->payment_status=="Partial" && $inv->invoice_status!="Paid")
	                                		<a href="{{url('pos/repair/partial/'.$inv->id)}}" class="btn btn-green btn-darken-4"> PAY PARTIAL</i> </a>
	                                	@elseif($inv->payment_status=="Partial" && $inv->invoice_status=="Paid")
	                                		Paid
	                                	@else
	                                		Paid
	                                	@endif
	                                </td>
	                                <td>{{$inv->invoice_id}}</td>
	                                <td>
	                                	<span class="dropdown" @if($userguideInit==1) data-step="2" data-intro="In this button You see view repair info, print and  delete option." @endif>
                                        <button id="btnSearchDrop4" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-green dropdown-toggle dropdown-menu-right"><i class="icon-cog3"></i></button>
                                        <span aria-labelledby="btnSearchDrop4" class="dropdown-menu mt-1 dropdown-menu-right">
                                            <a href="{{url('repair/view/'.$inv->id)}}" title="View Invoice" class="dropdown-item"><i class="icon-file-text"></i> View Repair Info</a>
                                            <a href="{{url('repair/print/'.$inv->id)}}" title="Print" class="dropdown-item"><i class="icon-printer"></i> Print</a>
                                            <a href="{{url('repair/delete/'.$inv->id)}}" title="Delete" class="dropdown-item"><i class="icon-cross"></i> Delete</a>
                                        </span>
                                    </span>
	                                </td>
	                            </tr>
	                            <?php 
								$paid_amount+=$inv->price;
								?>
	                            @endforeach
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


@include('apps.include.datatable',['JDataTable'=>1,'selectTwo'=>1,'dateDrop'=>1])
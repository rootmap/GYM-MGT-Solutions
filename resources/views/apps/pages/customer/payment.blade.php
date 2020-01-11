@extends('apps.layout.master')
@section('title','Payment Slip')
@section('content')
<section id="file-exporaat">
	<?php 
	    $userguideInit=StaticDataController::userguideInit();

	    //dd($dataMenuAssigned);
	?>
		<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-card-center">
						@if(isset($edit))
						<i class="icon-user-plus"></i> Edit Payment Slip
						@else
						<i class="icon-user-plus"></i> Add Payment Slip
						@endif
					</h4>
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
						<form class="form" method="post" 
						@if(isset($edit))
							action="{{url('gympayment/modify/'.$edit->id)}}"
						@else
							action="{{url('gympayment/save')}}"
						@endif
						>
							<div class="form-body">
								{{ csrf_field() }}
								<div class="row">
									
										<div class="col-md-6 offset-md-3" style="text-align: center;">
													<div class="col-md-12">
														<img src="{{asset('gym/rec-logo.png')}}" class="img-responsive" alt="Multi GYM">
													</div>
													<div class="clearfix"></div>
													<hr />
													<div class="col-md-6 offset-md-3">
														<div class="alert alert-danger no-border" style="margin-bottom: 0px; text-align: center; font-weight: bolder; color:#fff !important;">Receipt Voucher</div>
													</div>
													<div class="clearfix"></div>
													<hr />

													<div class="col-md-4">
														<div class="form-group">
															<label for="eventRegInput1">Receipt No <span class="text-danger">*</span></label>
															<input type="text" 
															@if(isset($edit))
																value="{{$edit->receipt_number}}" 
															@endif 
															 id="eventRegInput1" class="form-control border-primary" placeholder="Receipt No" name="receipt_number">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="eventRegInput1">ID / PIN No <span class="text-danger">*</span></label>
															<input type="text" 
															@if(isset($edit))
																value="{{$edit->pin}}" 
															@endif 
															 id="eventRegInput1" class="form-control border-primary pintofield" placeholder="PIN No" name="pin">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="eventRegInput1">Payment Date <span class="text-danger">*</span></label>
															<input type="text" 
															@if(isset($edit))
																value="{{$edit->payment_date}}" 
															@endif 
															 id="eventRegInput1" class="form-control border-green DropDateWithformat" placeholder="Payment Date" name="payment_date">
														</div>
													</div>

													<div class="clearfix"></div>

													<div class="col-md-12">
														<div class="form-group">
															<label for="eventRegInput1">Receive with thanks from <span class="text-danger">*</span></label>
															<input type="text" 
															@if(isset($edit))
																value="{{$edit->member_name}}" 
															@endif 
															 id="eventRegInput1" class="form-control border-green DropDateWithformat" placeholder="Receive with thanks from" name="member_name">
														</div>
													</div>



													<div class="clearfix"></div>

													<div class="col-md-4">
														<div class="form-group">
															<label for="eventRegInput1">Fee / Amount for  <span class="text-danger">*</span></label>
															<select name="month_fee_for" class="form-control">
																<option 
																@if(isset($edit))
																	@if($edit->month_fee_for=="Monthly")
																		selected="selected" 
																	@endif  
																@endif 
																value="Monthly">Monthly</option>
																<option 
																@if(isset($edit))
																	@if($edit->month_fee_for=="Package")
																		selected="selected" 
																	@endif  
																@endif 
																value="Package">Package</option>
															</select>
														</div>
													</div>

													<div class="col-md-4">
														<div class="form-group">
															<label for="eventRegInput1">Fee / Amount <span class="text-danger">*</span></label>
															<input type="text" 
															@if(isset($edit))
																value="{{$edit->month_fee}}" 
															@endif 
															 id="eventRegInput1" class="form-control border-green amounttoword" placeholder="Member Month Fee" name="month_fee">
														</div>
													</div>

													<div class="col-md-4">
														<div class="form-group">
															<label for="eventRegInput1">Method of Payment</label>
															<select name="payment_method_id" class="form-control">
																@if(isset($tender))
																	@foreach($tender as $pack)
																		<option 
																		@if(isset($edit))
																			@if($edit->payment_method_id==$pack->id)
																				selected="selected" 
																			@endif  
																		@endif 
																		value="{{$pack->id}}">{{$pack->name}}</option>
																	@endforeach
																@endif
															</select>
														</div>
													</div>

													<div class="clearfix"></div>

													<div class="col-md-12">
														<div class="form-group">
															<label for="eventRegInput1">In Word <span class="text-danger">*</span></label>
															<input type="text" 
															@if(isset($edit))
																value="{{$edit->in_word}}" 
															@endif 
															 id="eventRegInput1" class="form-control border-green inwordtyped" placeholder="In Word" name="in_word">
														</div>
													</div>



													<div class="clearfix"></div>






										</div>

										<div class="clearfix"></div>

									</div>
							

									
								</div>




							<div class="form-actions center">
								<button type="button" class="btn btn-green btn-darken-2 mr-1" @if($userguideInit==1) data-step="3" data-intro="if you want clear all information then click the clear button." @endif>
									<i class="icon-cross2"></i> Cancel
								</button>
								@if(isset($edit))
								<button type="submit" class="btn btn-green btn-accent-2">
									<i class="icon-check2"></i> Update
								</button>
								@else
								<button type="submit" class="btn btn-green btn-accent-2">
									<i class="icon-check2"></i> Save
								</button>
								@endif
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>



</section>
<script>
	var memberJson=<?php echo json_encode($member); ?>;
</script>
@endsection

@include('apps.include.datatablecssjs',['selectTwo'=>1,'dateDrop'=>1])
@extends('apps.layout.master')
@section('title','Admission Info')
@section('content')
<section id="file-exporaat">
	<?php 
	    $userguideInit=StaticDataController::userguideInit();

	    //dd($dataMenuAssigned);
	?>
		<div class="row">
		<div class="col-md-12" @if($userguideInit==1) data-step="1" data-intro="In this section, you can add a new customer." @endif>
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-card-center">
						<i class="icon-user-plus"></i> View Admission Info
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
						<form class="form" method="post" action="javascript:void(0);">
							<div class="form-body">
								{{ csrf_field() }}
								<div class="row">
									
									<div class="col-md-3">
										<div class="row">
											<div class="col-md-12" style="text-align: center;">
												<img src="{{asset('gym/logo.png')}}" height="100" alt="Multi GYM">
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<table class="table table-bordered">
													<tbody>
														<tr>
															<td>SL No. </td><td>
																@if(isset($edit))
																	{{$dataRow->id}}
																@endif
															</td></tr>
														<tr>
															<td>Reg.No.</td>
															<td>
																<input type="text" 
																@if(isset($edit))
																	value="{{$dataRow->req_no}}" 
																@else
																	value="{{$regID}}" 
																@endif 
																 id="eventRegInput1" class="form-control border-green" disabled="disabled" placeholder="Req. No" name="req_no">
															</td>
														</tr>
														<tr>
															<td>Time.</td>
															<td>
																<select  disabled="disabled" name="timetable" class="form-control">
																	<option value="00:00">Select Time</option>
																	@for($i=1; $i<=12; $i++)
																		<?php 
																			$dd=strlen($i)==1?'0'.$i:$i; 
																			$dd=$dd.":00"; 
																		?>
																	<option 
																	@if(isset($edit))
																		@if($dataRow->timetable==$dd)
																			selected="selected" 
																		@endif
																	@endif
																	value="{{strlen($i)==1?'0'.$i:$i}}:00">{{strlen($i)==1?'0'.$i:$i}}:00</option>
																		<?php 
																			$dd=strlen($i)==1?'0'.$i:$i; 
																			$dd=$dd.":15"; 
																		?>
																	<option 
																	@if(isset($edit))
																		@if($dataRow->timetable==$dd)
																			selected="selected" 
																		@endif
																	@endif
																	value="{{strlen($i)==1?'0'.$i:$i}}:15">{{strlen($i)==1?'0'.$i:$i}}:15</option>
																		<?php 
																			$dd=strlen($i)==1?'0'.$i:$i; 
																			$dd=$dd.":30"; 
																		?>
																	<option 
																	@if(isset($edit))
																		@if($dataRow->timetable==$dd)
																			selected="selected" 
																		@endif
																	@endif 
																	value="{{strlen($i)==1?'0'.$i:$i}}:30">{{strlen($i)==1?'0'.$i:$i}}:30</option>
																		<?php 
																			$dd=strlen($i)==1?'0'.$i:$i; 
																			$dd=$dd.":45"; 
																		?>
																	<option 
																	@if(isset($edit))
																		@if($dataRow->timetable==$dd)
																			selected="selected" 
																		@endif
																	@endif 
																	value="{{strlen($i)==1?'0'.$i:$i}}:45">{{strlen($i)==1?'0'.$i:$i}}:45</option>
																	@endfor
																</select>
															</td>
														</tr>
													</tbody>
													
												</table>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-12" style="text-align: center;">
												<img src="{{asset('gym/cover.png')}}" height="200" alt="Multi GYM">
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class="row">
											<div class="col-md-12" style="text-align: center;">
												<img src="{{asset('gym/user-avatar.png')}}" height="200" alt="Multi GYM">
											</div>
										</div>
									</div>

								</div>

								<div class="row">
									<hr />
									<div class="col-md-5"></div>
									<div class="col-md-2">
										<div class="alert alert-danger no-border" style="margin-bottom: 0px; text-align: center; font-weight: bolder; color:#fff !important;">View Admission Form</div>
									</div>
									<div class="col-md-5"></div>
									<div class="clearfix"></div>
									<hr />
								</div>

								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1" class="pt-2" style="font-weight: bolder;">Member Name </label>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">First Name <span class="text-danger">*</span></label>
											<input type="text" 
											@if(isset($edit))
												value="{{$dataRow->first_name}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-green" placeholder="First Name"  disabled="disabled" name="first_name">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Middle Name</label>
											<input type="text" 
											@if(isset($edit))
												value="{{$dataRow->middle_name}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-green" placeholder="Middle Name"  disabled="disabled" name="middle_name">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Last Name</label>
											<input type="text" 
											@if(isset($edit))
												value="{{$dataRow->last_name}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-green" placeholder="Last Name"  disabled="disabled" name="last_name">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1" class="pt-2" style="font-weight: bolder;">Member Address </label>
										</div>
									</div>
									<div class="col-md-9">
										<div class="form-group">
											<label for="eventRegInput1">Present Address <span class="text-danger">*</span></label>
											<input type="text" 
											@if(isset($edit))
												value="{{$dataRow->present_address}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-green" placeholder="Present Address"  disabled="disabled" name="present_address">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Age <span class="text-danger">*</span></label>
											<select  disabled="disabled" name="age" class="form-control">
												<option value="0">Select Age</option>
												@for($i=10; $i<=100; $i++)
												<option 
												@if(isset($edit))
													@if($dataRow->age==$i)
														selected="selected" 
													@endif
												@endif 
												value="{{$i}}">{{$i}} Years</option>
												@endfor
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Date of Birth <span class="text-danger">*</span></label>
											<input type="text" 
											@if(isset($edit))
												value="{{$dataRow->first_name}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-green  DropDateWithformat"  disabled="disabled" placeholder="Date of Birth" name="dob">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Gender <span class="text-danger">*</span></label>
											<select  disabled="disabled" name="gender" class="form-control">
												<option value="">Select Gender</option>
												<option 
												@if(isset($edit))
													@if($dataRow->gender=="Male")
														selected="selected" 
													@endif
												@endif 
												value="Male">Male</option>
												<option 
												@if(isset($edit))
													@if($dataRow->gender=="Female")
														selected="selected" 
													@endif
												@endif 
												value="Female">Female</option>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Blood Group <span class="text-danger">*</span></label>
											<select  disabled="disabled" name="blood_group" class="form-control">
												<option value="">Select Blood Group</option>
												<option 
												@if(isset($edit))
													@if($dataRow->blood_group=="A+")
														selected="selected" 
													@endif
												@endif 
												value="A+">A+</option>
												<option 
												@if(isset($edit))
													@if($dataRow->blood_group=="A-")
														selected="selected" 
													@endif
												@endif 
												value="A-">A-</option>
												<option 
												@if(isset($edit))
													@if($dataRow->blood_group=="B+")
														selected="selected" 
													@endif
												@endif 
												value="B+">B+</option>
												<option 
												@if(isset($edit))
													@if($dataRow->blood_group=="B-")
														selected="selected" 
													@endif
												@endif 
												value="B-">B-</option>
												<option 
												@if(isset($edit))
													@if($dataRow->blood_group=="AB+")
														selected="selected" 
													@endif
												@endif 
												value="AB+">AB+</option>
												<option 
												@if(isset($edit))
													@if($dataRow->blood_group=="AB-")
														selected="selected" 
													@endif
												@endif 
												value="AB-">AB-</option>
												<option 
												@if(isset($edit))
													@if($dataRow->blood_group=="O+")
														selected="selected" 
													@endif
												@endif 
												value="O+">O+</option>
												<option 
												@if(isset($edit))
													@if($dataRow->blood_group=="O-")
														selected="selected" 
													@endif
												@endif 
												value="O-">O-</option>
											</select>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Weight <span class="text-danger">*</span></label>
											<input type="text" 
											@if(isset($edit))
												value="{{$dataRow->weight}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-green" placeholder="Weight"  disabled="disabled" name="weight">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Height <span class="text-danger">*</span></label>
											<input type="text" 
											@if(isset($edit))
												value="{{$dataRow->height}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-green" placeholder="Height"  disabled="disabled" name="height">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Home Phone</label>
											<input type="text" 
											@if(isset($edit))
												value="{{$dataRow->home_phone}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-green" placeholder="Home Phone"  disabled="disabled" name="home_phone">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Cell Phone</label>
											<input type="text" 
											@if(isset($edit))
												value="{{$dataRow->cell_phone}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-green" placeholder="Cell Phone"  disabled="disabled" name="cell_phone">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Profession <span class="text-danger">*</span></label>
											<input type="text" 
											@if(isset($edit))
												value="{{$dataRow->profession}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-green" placeholder="Profession"  disabled="disabled" name="profession">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Designation <span class="text-danger">*</span></label>
											<input type="text" 
											@if(isset($edit))
												value="{{$dataRow->designation}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-green" placeholder="Designation"  disabled="disabled" name="designation">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Personal Email</label>
											<input type="text" 
											@if(isset($edit))
												value="{{$dataRow->personal_email}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-green" placeholder="Personal Email"  disabled="disabled" name="personal_email">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Facebook ID</label>
											<input type="text" 
											@if(isset($edit))
												value="{{$dataRow->facebook_id}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-green" placeholder="Facebook ID"  disabled="disabled" name="facebook_id">
										</div>
									</div>
								</div>

								<div class="row">
									<hr />
									<div class="col-md-12">
										<h3 style="margin-bottom: 0px; text-align: center; font-weight: bolder; color: green;">
											Membership Privileges, Notices, Disclosure & Agreement
										</h3>
									</div>
									<div class="clearfix"></div>
									<hr />
								</div>

								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Admission Date <span class="text-danger">*</span></label>
											<input type="text" 
											@if(isset($edit))
												value="{{$dataRow->admission_date}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-green DropDateWithformat"  disabled="disabled" placeholder="Admission Date" name="admission_date">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Starting Date <span class="text-danger">*</span></label>
											<input type="text" 
											@if(isset($edit))
												value="{{$dataRow->starting_date}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-green DropDateWithformat"  disabled="disabled" placeholder="Starting Date" name="starting_date">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Date of Expiry</label>
											<input type="text" 
											@if(isset($edit))
												value="{{$dataRow->date_of_expiry}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-green DropDateWithformat"  disabled="disabled" placeholder="Date of Expiry" name="date_of_expiry">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Name of the Program / Package</label>
											<select  disabled="disabled" name="package_id" class="form-control">
												<option value="0">Select Package</option>
												@if(isset($package))
													@foreach($package as $pack)
														<option 
														@if(isset($edit))
															@if($dataRow->package_id==$pack->id)
																selected="selected" 
															@endif
														@endif 
														value="{{$pack->id}}">{{$pack->name}}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Amount Paid <span class="text-danger">*</span></label>
											<input type="text" 
											@if(isset($edit))
												value="{{$dataRow->amount_paid}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-green" placeholder="Amount Paid"  disabled="disabled" name="amount_paid">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Method of Payment</label>
											<select  disabled="disabled" name="payment_method_id" class="form-control">
												<option value="0">Receive Payment</option>
												@if(isset($tender))
													@foreach($tender as $pack)
														<option 
														@if(isset($edit))
															@if($dataRow->payment_id==$pack->id)
																selected="selected" 
															@endif
														@endif 
														value="{{$pack->id}}">{{$pack->name}}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Receipt Number</label>
											<input type="text" 
											@if(isset($edit))
												value="{{$dataRow->receipt_number}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-green" placeholder="Receipt Number"  disabled="disabled" name="receipt_number">
										</div>
									</div>
						
								</div>

								
							
							</div>

							<div class="form-actions center">
								<a href="{{url('admission/report')}}" class="btn btn-green btn-darken-2 mr-1">
									<i class="icon-cross2"></i> Back To Admission Report
								</a>
								
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>



</section>
@endsection

@include('apps.include.datatablecssjs',['selectTwo'=>1,'dateDrop'=>1])
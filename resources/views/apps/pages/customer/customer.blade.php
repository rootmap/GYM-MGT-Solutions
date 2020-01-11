@extends('apps.layout.master')
@section('title','User / Customer Info')
@section('content')
<section id="file-exporaat">
	<?php 
	    $userguideInit=StaticDataController::userguideInit();

	    //dd($dataMenuAssigned);
	?>
		<div class="row">
		<div class="col-md-6 offset-md-3" @if($userguideInit==1) data-step="1" data-intro="In this section, you can add a new customer." @endif>
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-card-center">
						@if(isset($edit))
						<i class="icon-user-plus"></i> Edit User / Customer
						@else
						<i class="icon-user-plus"></i> Add User / Customer
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
							action="{{url('customer/modify/'.$dataRow->id)}}"
						@else
							action="{{url('customer/save')}}"
						@endif
						>
							<div class="form-body">
								{{ csrf_field() }}
								<div class="form-group">
									<label for="eventRegInput1">Name <span class="text-danger">*</span></label>
									<input type="text" 
									@if(isset($edit))
										value="{{$dataRow->name}}" 
									@endif 
									 id="eventRegInput1" class="form-control border-green" placeholder="Customer Name" name="name">
								</div>

								<div class="form-group">
									<label for="eventRegInput1">PIN <span class="text-danger">*</span></label>
									<input type="text" 
									@if(isset($edit))
										value="{{$dataRow->pin}}" 
									@endif 
									 id="eventRegInput1" class="form-control border-green" placeholder="Customer PIN" name="pin">
								</div>

								<div class="form-group">
									<label for="eventRegInput1">Password <span class="text-danger">*</span></label>
									<input type="text" 
									@if(isset($edit))
										value="{{$dataRow->password}}" 
									@endif 
									 id="eventRegInput1" class="form-control border-green" placeholder="Customer Password" name="password">
								</div>

								<div class="form-group">
									<label for="eventRegInput1">Privilege <span class="text-danger">*</span></label>
									<select name="privilege" class="form-control">
										<option 
										@if(isset($edit))
										 @if($dataRow->privilege==0)
										 	selected="selected" 
										 @endif 
										@endif 
										 value="0">Normal User</option>
										<option 

										@if(isset($edit))
										 @if($dataRow->privilege==14)
										 	selected="selected" 
										 @endif 
										@endif 

										value="14">Staff / Admin</option>
									</select>
								</div>

								<div class="form-group">
									<label for="eventRegInput1">User Status <span class="text-danger">*</span></label>
									<select name="user_status" class="form-control">
										<option 

										@if(isset($edit))
										 @if($dataRow->user_status=='Active')
										 	selected="selected" 
										 @endif 
										@endif 

										value="Active">Active</option>
										<option 

										@if(isset($edit))
										 @if($dataRow->user_status=='Inactive')
										 	selected="selected" 
										 @endif 
										@endif 
										
										value="Inactive">Inactive</option>
									</select>
								</div>



										<input type="hidden" id="text" class="form-control border-green" 
										@if(isset($edit))
										value="{{$dataRow->address}}" 
										@endif 
										placeholder="address" name="address">

										<input type="hidden" 
										@if(isset($edit))
										value="{{$dataRow->phone}}" 
										@endif 
										 class="form-control border-green" placeholder="1-(555)-555-5555" name="phone">
								
										<input type="hidden" 
										@if(isset($edit))
										value="{{$dataRow->email}}" 
										@endif 										
										id="eventRegInput4" class="form-control border-green" placeholder="Email Address" name="email">

							
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
								<button type="submit" class="btn btn-green btn-accent-2" @if($userguideInit==1) data-step="2" data-intro="When you fill up all information then click save button." @endif>
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
@endsection

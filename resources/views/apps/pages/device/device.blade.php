@extends('apps.layout.master')
@section('title','Device Settings')
@section('content')
<section id="file-exporaat">
<?php 
    $dataMenuAssigned=array();
    $dataMenuAssigned=StaticDataController::dataMenuAssigned();
    $userguideInit=StaticDataController::userguideInit();
    //dd($dataMenuAssigned);
?>  

		<div class="row">
		<div class="col-md-6 offset-md-3" @if($userguideInit==1) data-step="1" data-intro="You can create/modify tender." @endif>
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-card-center">
						@if(isset($edit))
						<i class="icon-user-plus"></i> Edit Device Settings
						@else
						<i class="icon-user-plus"></i> Add New Device Settings
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
							action="{{url('device/settings/modify/'.$edit->id)}}"
						@else
							action="{{url('device/settings/save')}}"
						@endif
						>
							<div class="form-body">
								{{ csrf_field() }}

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="eventRegInput1">Device IP 
												@if(isset($edit))
													({{$edit->device_status}}) 
												@endif 
												<span class="text-danger">*</span></label>
											<input type="text" 
											@if(isset($edit))
												value="{{$edit->device_ip}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-primary" placeholder="Device IP" name="device_ip">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="eventRegInput1">Device IP Two 
												@if(isset($edit))
													({{$edit->device_two_status}}) 
												@endif 
												<span class="text-danger">*</span></label>
											<input type="text" 
											@if(isset($edit))
												value="{{$edit->device_ip_two}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-primary" placeholder="Device IP Two" name="device_ip_two">
										</div>
									</div>

									
								</div>

															
							</div>

							<div class="form-actions center">
								<button type="button" class="btn btn-green btn-accent-2 mr-1" @if($userguideInit==1) data-step="3" data-intro="if you want clear all information then click the clear button." @endif>
									<i class="icon-cross2"></i> Cancel
								</button>
								@if(isset($edit))
								<button type="submit" class="btn btn-green btn-darken-2">
									<i class="icon-check2"></i> Update
								</button>
								@else
								<button type="submit" class="btn btn-green btn-darken-2" @if($userguideInit==1) data-step="2" data-intro="When you fill up all information then click save button." @endif>
									<i class="icon-check2"></i> Save
								</button>
								@endif

								<a class="btn btn-green btn-darken-2" href="{{url('test/device')}}">
									<i class="icon-check2"></i> Check & Auto Configure
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
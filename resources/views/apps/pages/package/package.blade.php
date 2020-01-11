@extends('apps.layout.master')
@section('title','Package')
@section('content')
<section id="file-exporaat">
<?php 
    $dataMenuAssigned=array();
    $dataMenuAssigned=StaticDataController::dataMenuAssigned();
    $userguideInit=StaticDataController::userguideInit();
    //dd($dataMenuAssigned);
?>  

		<div class="row">
		<div class="col-md-8 offset-md-2" @if($userguideInit==1) data-step="1" data-intro="You can create/modify tender." @endif>
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-card-center">
						@if(isset($edit))
						<i class="icon-user-plus"></i> Edit Package
						@else
						<i class="icon-user-plus"></i> Add New Package
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
							action="{{url('gym/package/modify/'.$edit->id)}}"
						@else
							action="{{url('gym/package/save')}}"
						@endif
						>
							<div class="form-body">
								{{ csrf_field() }}

								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Name <span class="text-danger">*</span></label>
											<input type="text" 
											@if(isset($edit))
												value="{{$edit->name}}" 
											@endif 
											 id="eventRegInput1" class="form-control border-primary" placeholder="Package Name" name="name">
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Month <span class="text-danger">*</span></label>
											<select class="select2 form-control" name="month_id">
                                            <option 
                                                @if(!isset($edit->month_id))
                                                    @if(empty($edit->month_id))
                                                    selected="selected" 
                                                    @endif
                                                @endif

                                            value="">Select Month</option>
                                                @for($i=1; $i<=12; $i++)
                                                <option 
                                                    @if(isset($edit->month_id))
                                                        @if($edit->month_id==$i)
                                                        selected="selected" 
                                                        @endif
                                                    @endif 
                                                value="{{$i}}">{{$i}} Month</option>
                                                @endfor                    
                                        </select>
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1" style="border-bottom: 1px #ccc solid;">Admission Fee Required </label>
											<input type="checkbox" 
											@if(isset($edit))
												checked="checked" 
											@endif 
											 id="eventRegInput1" class="form-control border-primary" placeholder="Tender Name" name="admission_required" style="margin-top: 8px;">
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="eventRegInput1">Admission Fee / Total <span class="text-danger">*</span></label>
											<input type="text" 
											@if(isset($edit))
												value="{{$edit->fee}}" 
											@else
												value="0" 
											@endif 
											 id="eventRegInput1" class="form-control border-primary" placeholder="Admission Fee / Total" name="fee">
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
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Both borders end-->
<div class="row">
	<div class="col-xs-12" @if($userguideInit==1) data-step="4" data-intro="You are seeing all tender list in this table. You can edit and delete in this table." @endif>
		<div class="card">
			<div class="card-header">
				<h4 class="card-title"><i class="icon-users2"></i> Package List</h4>
				<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
        		<div class="heading-elements">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
						<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-body collapse in">
				<div class="card-block card-dashboard">
					<table class="table table-striped table-bordered zero-configuration">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Month</th>
								<th>Amission Fee Required</th>
								<th>Total</th>
								<th style="width: 100px;">Action</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($dataTable))
							@foreach($dataTable as $row)
							<tr>
								<td>{{$row->id}}</td>
								<td>{{$row->name}}</td>
								<td>{{$row->month_id}}</td>
								<td>
									@if($row->admission_required==1)
										Yes
									@else
										No
									@endif
								</td>
								<td>{{$row->fee}}</td>
								<td>
                                        @if(in_array('gym_package_Edit', $dataMenuAssigned)) 
                                        <a href="{{url('gym/package/edit/'.$row->id)}}" title="Edit" class="btn btn-sm btn-outline-green" @if($userguideInit==1) data-step="5" data-intro="If you want you can modify your information when you click this button." @endif><i class="icon-pencil22"></i></a>
                                        @endif
                                        @if(in_array('gym_package_Delete', $dataMenuAssigned)) 
                                        <a  href="{{url('gym/package/delete/'.$row->id)}}" title="Delete" class="btn btn-sm btn-outline-green btn-darken-1" @if($userguideInit==1) data-step="6" data-intro="If you want delect then click this button." @endif><i class="icon-cross"></i></a>
                                        @endif

                                </div>
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

@include('apps.include.datatable',['JDataTable'=>1])
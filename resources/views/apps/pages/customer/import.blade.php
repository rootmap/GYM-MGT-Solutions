@extends('apps.layout.master')
@section('title','Import Device customer')
@section('content')
<section id="form-action-layouts">
	<?php 
	    $userguideInit=StaticDataController::userguideInit();

	    //dd($dataMenuAssigned);
	?>
	<div class="row">
		<div class="col-md-12 ">
	        <div class="card">
	            <div class="card-header">
	                <h4 class="card-title" id="striped-label-layout-card-center">Import Device customer</h4>
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
						<form method="post" action="{{url('customer/import/save')}}" class="form form-horizontal striped-labels" enctype="multipart/form-data">
							{{csrf_field()}}
							
							<div class="form-body"> 
		                        <div class="form-group row last">
	                        		
	                        		<h2> DEVICE 1 STATUS : <span>{{$edit->device_status}}</span> </h2>
	                        		<h2> DEVICE 2 STATUS : <span>{{$edit->device_two_status}}</span> </h2>
	                        		
		                        </div>
							</div>
							<div class="form-actions center">
	                            <a href="{{url('member/import/device')}}" class="btn btn-green btn-accent-4 mr-1 change-action">
									<i class="icon-file-excel"></i> Import Device Member With SYSTEM
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

@section("css")
	<link rel="stylesheet" type="text/css" href="{{url('theme/app-assets/css/plugins/ui/jqueryui.min.css')}}">
@endsection

@section("js")
<script type="text/javascript">
	$(document).ready(function(){
		$("select[name=nav_class_name]").change(function(){ 
			var navData=$("#navChange").attr("data");
			$("#navChange").removeClass(navData);
			$("#navChange").addClass($(this).val());
			$("#navChange").attr("data",$(this).val());

		});
	});
</script>
<script src="{{url('theme/app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js')}}" type="text/javascript"></script>
<script src="{{url('theme/app-assets/js/scripts/ui/jquery-ui/buttons-selects.min.js')}}" type="text/javascript"></script>
@endsection
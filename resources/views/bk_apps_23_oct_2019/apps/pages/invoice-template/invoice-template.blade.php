@extends('apps.layout.master')
@section('title','Invoice Template')
@section('content')
<section id="form-action-layouts">
	<div class="content-body"><section class="card">
		<div id="invoice-template" class="card-block">
			<!-- Invoice Company Details -->
			<div id="invoice-company-details" class="row">
				<div class="col-md-6 col-sm-12 text-xs-center text-md-left">
					<img src="{{url('theme/app-assets/images/logo/robust-80x80.png')}}" alt="company logo" class="">
					<ul class="px-0 list-unstyled">
						<li class="text-bold-800">Robust Creative Studio</li>
						<li>4025 Oak Avenue,</li>
						<li>Melbourne,</li>
						<li>Florida 32940,</li>
						<li>USA</li>
					</ul>
				</div>
				<div class="col-md-6 col-sm-12 text-xs-center text-md-right">
					<h2>INVOICE</h2>
					<p class="pb-3"># INV-001001</p>
					<ul class="px-0 list-unstyled">
						<li>Balance Due</li>
						<li class="lead text-bold-800">$ 12,000.00</li>
					</ul>
				</div>
			</div>
			<!--/ Invoice Company Details -->

			<!-- Invoice Customer Details -->
			<div id="invoice-customer-details" class="row pt-2">
				<div class="col-sm-12 text-xs-center text-md-left">
					<p class="text-muted">Bill To</p>
				</div>
				<div class="col-md-6 col-sm-12 text-xs-center text-md-left">
					<ul class="px-0 list-unstyled">
						<li class="text-bold-800">Mr. Bret Lezama</li>
						<li>4879 Westfall Avenue,</li>
						<li>Albuquerque,</li>
						<li>New Mexico-87102.</li>
					</ul>
				</div>
				<div class="col-md-6 col-sm-12 text-xs-center text-md-right">
					<p><span class="text-muted">Invoice Date :</span> 06/05/2016</p>
					<p><span class="text-muted">Terms :</span> Due on Receipt</p>
					<p><span class="text-muted">Due Date :</span> 10/05/2016</p>
				</div>
			</div>
			<!--/ Invoice Customer Details -->

			<!-- Invoice Items Details -->
			<div id="invoice-items-details" class="pt-2">
				<div class="row">
					<div class="table-responsive col-sm-12">
						<table class="table">
						  <thead>
						    <tr>
						      <th>#</th>
						      <th>Item &amp; Description</th>
						      <th class="text-xs-right">Rate</th>
						      <th class="text-xs-right">Hours</th>
						      <th class="text-xs-right">Amount</th>
						    </tr>
						  </thead>
						  <tbody>
						    <tr>
						      <th scope="row">1</th>
						      <td>
						      	<p>Create PSD for mobile APP</p>
						      	<p class="text-muted">Simply dummy text of the printing and typesetting industry.</p>
						      </td>
						      <td class="text-xs-right">$ 20.00/hr</td>
						      <td class="text-xs-right">120</td>
						      <td class="text-xs-right">$ 2400.00</td>
						    </tr>
						    <tr>
						      <th scope="row">2</th>
						      <td>
						      	<p>iOS Application Development</p>
						      	<p class="text-muted">Pellentesque maximus feugiat lorem at cursus.</p>
						      </td>
						      <td class="text-xs-right">$ 25.00/hr</td>
						      <td class="text-xs-right">260</td>
						      <td class="text-xs-right">$ 6500.00</td>
						    </tr>
						    <tr>
						      <th scope="row">3</th>
						      <td>
						      	<p>WordPress Template Development</p>
						      	<p class="text-muted">Vestibulum euismod est eu elit convallis.</p>
						      </td>
						      <td class="text-xs-right">$ 20.00/hr</td>
						      <td class="text-xs-right">300</td>
						      <td class="text-xs-right">$ 6000.00</td>
						    </tr>
						  </tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-7 col-sm-12 text-xs-center text-md-left">
						<p class="lead">Payment Methods:</p>
						<div class="row">
							<div class="col-md-8">
							<table class="table table-borderless table-sm">
								<tbody>
									<tr>
										<td>Bank name:</td>
										<td class="text-xs-right">ABC Bank, USA</td>
									</tr>
									<tr>
										<td>Acc name:</td>
										<td class="text-xs-right">Amanda Orton</td>
									</tr>
									<tr>
										<td>IBAN:</td>
										<td class="text-xs-right">FGS165461646546AA</td>
									</tr>
									<tr>
										<td>SWIFT code:</td>
										<td class="text-xs-right">BTNPP34</td>
									</tr>
								</tbody>
							</table>
							</div>
						</div>
					</div>
					<div class="col-md-5 col-sm-12">
						<p class="lead">Total due</p>
						<div class="table-responsive">
							<table class="table">
							  <tbody>
							  	<tr>
							  		<td>Sub Total</td>
							  		<td class="text-xs-right">$ 14,900.00</td>
							  	</tr>
							  	<tr>
							  		<td>TAX (12%)</td>
							  		<td class="text-xs-right">$ 1,788.00</td>
							  	</tr>
							  	<tr>
							  		<td class="text-bold-800">Total</td>
							  		<td class="text-bold-800 text-xs-right"> $ 16,688.00</td>
							  	</tr>
							  	<tr>
							  		<td>Payment Made</td>
							  		<td class="pink text-xs-right">(-) $ 4,688.00</td>
							  	</tr>
							  	<tr class="bg-grey bg-lighten-4">
							  		<td class="text-bold-800">Balance Due</td>
							  		<td class="text-bold-800 text-xs-right">$ 12,000.00</td>
							  	</tr>
							  </tbody>
							</table>
						</div>
						<div class="text-xs-center">
							<p>Authorized person</p>
							<img src="{{url('theme/app-assets/images/pages/signature-scan.png')}}" alt="signature" class="height-100">
							<h6>Amanda Orton</h6>
							<p class="text-muted">Managing Director</p>
						</div>
					</div>
				</div>
			</div>

			<!-- Invoice Footer -->
			<div id="invoice-footer">
				<div class="row">
					<div class="col-md-7 col-sm-12">
						<h6>Terms &amp; Condition</h6>
						<p>You know, being a test pilot isn't always the healthiest business in the world. We predict too much for the next year and yet far too little for the next 10.</p>
					</div>
					<div class="col-md-5 col-sm-12 text-xs-center">
						<button type="button" class="btn btn-primary btn-lg my-1"><i class="icon-paperplane"></i> Send Invoice</button>
					</div>
				</div>
			</div>
			<!--/ Invoice Footer -->

		</div>
	</section>
	        </div>
</section>
@endsection
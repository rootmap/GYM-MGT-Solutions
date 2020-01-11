<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('backup', 'ActivityController@dbbackup');

Route::get('/', function () {
    return redirect('login');
});
Route::get('/test/device', 'DeviceSettingController@deviceIP');
Route::get('/get/device/ip/{ip}', 'DeviceSettingController@index');
Route::get('/check/device', 'DeviceSettingController@checknUpdateDevice');
Route::get('/load/attendance/today', 'DeviceSettingController@loadTodayAttendace');
Route::get('/attendance/today', 'RetailPosSummaryController@todaypunch');
Route::get('/check/attendance', 'DeviceSettingController@getAttendance');
Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

//customer pay url
Route::get('invoice/pay/{invoice_id}', 'InvoiceController@showCustomerInvoice');
Route::post('capture/pos/payment/publicpayment','InvoiceController@AuthorizenetCardPaymentPublic');
Route::post('/capture/inv/payment', 'InvoiceProductController@getPaidCartPublic');
Route::get('/capture/invoice/print/pdf/{invoice_id}', 'InvoiceController@captureInvoicePDF');
//customer pay url


//-----------------------bolt Start ----------------||

Route::get('bolt/ping', 'CardPointeeController@boltPing');
Route::post('bolt/capture', 'CardPointeeController@boltCaptureCard');
Route::post('bolt/token', 'CardPointeeController@boltGenarateNewToken');

//-----------------------bolt End ------------------||

//-----------------Cardpointe Start-----------------||
Route::get('/cardpointe/test', 'CardPointeeController@testM');
//-----------------Cardpointe End-------------------||

// Route::get('/form', 'HomeController@form')->name('form');
Route::get('/form', 'HomeController@form')->name('form');
Route::get('/paypal', 'InvoiceController@paypal');
Route::post('/paypal', 'InvoiceController@paywithpaypal');
Route::get('/paypal/{status}', 'InvoiceController@getPaymentStatus');
Route::get('invoice/payment/paypal/{invoice_id}/{status}', 'InvoiceController@getPaymentStatusPaypal');


Route::get('/invoice/paypal/{invoice_id}', 'InvoiceController@paywithpaypalInvoice');

Route::get('/reset', 'HomeController@reset')->name('reset');
//Route::get('/register', 'HomeController@register')->name('register');
Route::get('/product', 'HomeController@product')->name('product');
Route::get('/productinventory', 'HomeController@productinventory')->name('productinventory');
//Route::get('/customer', 'HomeController@customer')->name('customer');
Route::get('/addsales', 'HomeController@addsales')->name('addsales');
// Route::get('/calculatevariance', 'HomeController@calculatevariance')->name('calculatevariance');
Route::get('/invoice', 'HomeController@invoice')->name('invoice');
Route::get('/profitList', 'HomeController@profitList')->name('profitList');
Route::get('invoice/template', 'HomeController@invoicetemplate')->name('invoicetemplate');
Route::get('invoice/summary', 'HomeController@invoicesummary')->name('invoicesummary');
Route::get('invoice/template/print', 'HomeController@invoicetemplateprint')->name('invoicetemplateprint');
Route::get('setting', 'HomeController@setting')->name('setting');
Route::get('DemoDashboard', 'HomeController@DemoDashboard')->name('DemoDashboard');
Route::get('chart', 'HomeController@chart');
Route::get('coming-soon', 'HomeController@soon');
//Route::get('pdf', 'InvoiceProfitController@testPDF');

Route::get('pdf', 'InvoiceController@GenaratePDF');
Route::post('check/idle/user', 'ActivityController@idleCheck');

Route::group(['middleware' => 'auth'], function () { 

	
	Route::get('/member/import/device', 'CustomerController@importCustomerSave');
	Route::get('/login-activity', 'LoginActivityController@index');
	Route::get('/developer/console', 'InvoiceController@developer');
	Route::post('/developer/console/save', 'InvoiceController@developerStore');
	Route::get('/dashboard', 'RetailPosSummaryController@index');
    Route::get('/home', 'RetailPosSummaryController@index');
	Route::get('/dashboard_demo', 'HomeController@dashboard_demo')->name('dashboard_demo');

	//------------------------Package Start------------------------//
	Route::get('/gym/package', 'GymPackageController@create');
	Route::post('/gym/package/save', 'GymPackageController@store');
	Route::get('/gym/package/edit/{id}', 'GymPackageController@show');
	Route::get('/gym/package/delete/{id}', 'GymPackageController@destroy');
	Route::post('/gym/package/modify/{id}', 'GymPackageController@update');

	//====================== Device Settings Start ==========================//

	Route::get('/device/settings', 'DeviceSettingController@create');
	Route::post('/device/settings/save', 'DeviceSettingController@store');
	Route::post('/device/settings/modify/{id}', 'DeviceSettingController@update');
	//====================== Device Settings End ==========================//

	//======================= Admission Info Start======================//
	Route::get('/gympayment', 'PaymentController@create');
	Route::post('/gympayment/save', 'PaymentController@store');
	Route::get('/gympayment/edit/{id}', 'PaymentController@edit');
	Route::get('/gympayment/view/{id}', 'PaymentController@show');
	Route::post('/gympayment/modify/{id}', 'PaymentController@update');
	Route::get('/gympayment/report', 'PaymentController@makeSalesReturnShow');
	Route::post('/gympayment/report/json', 'PaymentController@datajsonsalesReturnList');
	Route::post('/gympayment/report', 'PaymentController@makeSalesReturnShow');
	Route::post('/gympayment/report/excel/report', 'PaymentController@exportExcelAdmission');
	Route::post('/gympayment/report/pdf/report', 'PaymentController@exportPDFAdmission');
	//======================= Admission Info End==============++========//

	//======================= Admission Info Start======================//
	Route::get('/admission', 'CustomerController@admission');
	Route::post('/admission/save', 'AdmissionController@store');
	Route::get('/admission/edit/{id}', 'AdmissionController@edit');
	Route::get('/admission/view/{id}', 'AdmissionController@show');
	Route::post('/admission/modify/{id}', 'AdmissionController@update');
	Route::get('/admission/report', 'AdmissionController@makeSalesReturnShow');
	Route::post('/admission/report/json', 'AdmissionController@datajsonsalesReturnList');
	Route::post('/admission/report', 'AdmissionController@makeSalesReturnShow');
	Route::post('/admission/report/excel/report', 'AdmissionController@exportExcelAdmission');
	Route::post('/admission/report/pdf/report', 'AdmissionController@exportPDFAdmission');
	//======================= Admission Info End==============++========//



	//------------------customer route start--------------------//
	Route::get('/customer', 'CustomerController@index')->name('customer');
	Route::post('/customer/data/json', 'CustomerController@datajson');
	Route::get('/customer/getInfo/json/{id}', 'CustomerController@getCustomer');
	Route::get('/customer/list', 'CustomerController@show');
	Route::post('/customer/save', 'CustomerController@store');
	Route::post('/systemtour/ajax/status', 'UserTourController@systemTour');
	Route::get('/tour/start/{seriURL}', 'UserTourController@index');
	Route::get('/customer/edit/{id}', 'CustomerController@edit');
	Route::get('/customer/delete/{id}', 'CustomerController@destroy');
	Route::post('/customer/modify/{id}', 'CustomerController@update');
	Route::get('/customer/excel/report', 'CustomerController@exportExcel');
	Route::get('/customer/pdf/report', 'CustomerController@invoicePDF');
	Route::post('/customer/pos/ajax/add', 'CustomerController@posCustomerAdd');
	Route::get('/customer/import', 'CustomerController@importCustomer');
	Route::post('/customer/import/save', 'CustomerController@importCustomerSave');
	Route::get('/customer/report/{id}', 'CustomerController@customerReport'); 
	Route::get('/customer/datatable', 'CustomerController@showCustomerDataTable'); 

	//customer lead
	Route::get('/customer/lead/new', 'CustomerLeadController@index');
	Route::get('/customer/lead/list', 'CustomerLeadController@show');
	Route::post('/customer/lead/save', 'CustomerLeadController@store');
	Route::get('/customer/lead/edit/{id}', 'CustomerLeadController@edit');
	Route::get('/customer/lead/delete/{id}', 'CustomerLeadController@destroy');
	Route::post('/customer/lead/modify/{id}', 'CustomerLeadController@update');
	Route::post('/customer/lead/data/json', 'CustomerLeadController@datajson');

	
	Route::get('/report/payout', 'InvoiceController@Payoutreport');
	Route::post('/report/payout/data/json', 'InvoiceController@payoutReportdatajson');
	Route::post('/report/payout', 'InvoiceController@Payoutreport');
	Route::post('/report/excel/payout', 'InvoiceController@exportPayoutExcel');
	Route::post('/report/pdf/payout', 'InvoiceController@exportPayoutPDF');

	Route::get('/lcd/status/report', 'InStoreRepairController@reportLCDStatus');
	Route::post('/lcd/status/data/report/json', 'InStoreRepairController@InstoreLCDRepairDRPjson');
	Route::post('/lcd/status/report', 'InStoreRepairController@reportLCDStatus');
	Route::post('/lcd/status/excel/report', 'InStoreRepairController@exportExcelLCDStatus');
	Route::post('/lcd/status/pdf/report', 'InStoreRepairController@exportPDFLCDStatus');

	Route::get('/salvage/report', 'InStoreRepairController@reportSalvage');
	Route::post('/salvage/data/report/json', 'InStoreRepairController@InstoreSalvageRepairDRPjson');
	Route::post('/salvage/report', 'InStoreRepairController@reportSalvage');
	Route::post('/salvage/excel/report', 'InStoreRepairController@exportExcelSalvage');
	Route::post('/salvage/pdf/report', 'InStoreRepairController@exportPDFSalvage');

	Route::get('/report/highestseller', 'HigherCashierSaleController@reporthighestCashierSales');
	Route::post('/report/highestseller/data/json', 'HigherCashierSaleController@datajson');
	Route::post('/report/highestseller', 'HigherCashierSaleController@reporthighestCashierSales');
	Route::post('/report/highestseller/excel/report', 'HigherCashierSaleController@exportExcelhighestCashierSales');
	Route::post('/report/highestseller/pdf/report', 'HigherCashierSaleController@exportPDFhighestCashierSales');

	Route::get('/report/highestseller/Summary', 'HigherCashierSaleSummaryController@reporthighestCashierSales');
	Route::post('/report/highestseller/Summary', 'HigherCashierSaleSummaryController@reporthighestCashierSales');
	Route::post('/report/highestseller/Summary/excel/report', 'HigherCashierSaleSummaryController@exportExcelhighestCashierSales');
	Route::post('/report/highestseller/Summary/pdf/report', 'HigherCashierSaleSummaryController@exportPDFhighestCashierSales');
	//Route::get('/special/parts/delete/{id}', 'SpecialPartsOrderController@destroy');


	//category 
	Route::get('/category', 'CategoryController@index');
	Route::post('/category/save', 'CategoryController@store');
	Route::get('/category/edit/{id}', 'CategoryController@edit');
	Route::get('/category/delete/{id}', 'CategoryController@destroy');
	Route::post('/category/modify/{id}', 'CategoryController@update');
	
	//user controller
	Route::get('user', 'CustomerController@user');
	Route::get('user/list', 'CustomerController@userList');
	Route::post('user/save', 'CustomerController@userSave');
	Route::get('user/edit/{id}', 'CustomerController@UserShow');
	Route::post('/user/modify/{id}', 'CustomerController@userUpdate');
	Route::get('/user/delete/{id}', 'CustomerController@Userdestroy');

	//store controller
	Route::get('store-shop', 'StoreController@create');
	Route::get('store-shop/list', 'StoreController@index');
	Route::post('store-shop/save', 'StoreController@store');
	Route::get('store-shop/edit/{id}', 'StoreController@show');
	Route::post('store-shop/modify/{id}', 'StoreController@update');
	Route::get('store-shop/delete/{id}', 'StoreController@destroy');
	//------------------customer route End--------------------//
	

	// ------------------------Role Wise Menu route start------------------//
	Route::get('/RoleWiseMenu', 'RoleWiseMenuController@index')->name('tender');
	Route::post('/RoleWiseMenu/ajax', 'RoleWiseMenuController@showAjax');
	Route::post('/RoleWiseMenu/save', 'RoleWiseMenuController@store');
	// ------------------------Role Wise Menu route end------------------//

	// ------------------------role route start------------------//
	Route::get('/role', 'RoleController@index')->name('role');
	Route::post('/role/save', 'RoleController@store');
	Route::get('/role/edit/{id}', 'RoleController@edit');
	Route::get('/role/delete/{id}', 'RoleController@destroy');
	Route::post('/role/modify/{id}', 'RoleController@update');
	Route::post('/add-to-repair/cart', 'InvoiceController@posRepairProduct');
	// ------------------------tender route end------------------//


	// ------------------------AssignUserRole route start------------------//
	Route::get('/AssignUserRole', 'AssignUserRoleController@index');
	Route::post('/AssignUserRole/save', 'AssignUserRoleController@store');
	Route::get('/AssignUserRole/edit/{id}', 'AssignUserRoleController@edit');
	Route::get('/AssignUserRole/delete/{id}', 'AssignUserRoleController@destroy');
	Route::post('/AssignUserRole/modify/{id}', 'AssignUserRoleController@update');
	// ------------------------AssignUserRole route end------------------//
	
	// ------------------------menu-item route start------------------//
	Route::get('/menu-item', 'MenuPageController@index');
	//Route::post('/menu-item/create', 'RoleWiseMenuController@create');
	Route::post('/menu-item/save', 'MenuPageController@store');
	Route::get('/menu-item/edit/{id}', 'MenuPageController@edit');
	Route::get('/menu-item/delete/{id}', 'MenuPageController@destroy');
	Route::post('/menu-item/modify/{id}', 'MenuPageController@update');
	// ------------------------tender route end------------------//

	// ------------------------tender route start------------------//
	Route::get('/expense/voucher', 'ExpenseController@index')->name('expense');
	Route::get('/expense/voucher/report', 'ExpenseController@show');
	Route::post('/expense/voucher/report/json', 'ExpenseController@datajsonExpenseReport');
	Route::post('/expense/voucher/report', 'ExpenseController@show');
	Route::post('/expense/voucher/save', 'ExpenseController@store');
	Route::get('/expense/voucher/edit/{id}', 'ExpenseController@edit');
	Route::get('/expense/voucher/delete/{id}', 'ExpenseController@destroy');
	Route::post('/expense/voucher/modify/{id}', 'ExpenseController@update');
	Route::get('/expense/voucher/excel/report', 'ExpenseController@Excelexport');
	Route::post('/expense/voucher/excel/report', 'ExpenseController@Excelexport');
	Route::get('/expense/voucher/pdf/report', 'ExpenseController@ExpensePDF');
	Route::post('/expense/voucher/pdf/report', 'ExpenseController@ExpensePDF');
	// ------------------------tender route end------------------//





	//------------------Sales route start--------------------//
	Route::get('/sales', 'InvoiceController@index');
	Route::post('/slide-menu/slide/status', 'InvoiceController@slide');
	Route::get('/pos', 'InvoiceController@pos');
	Route::get('/pos/clear', 'InvoiceController@posclear');
	Route::post('/open/store', 'InvoiceController@openStore');
	Route::post('/cart/pos/payout', 'InvoiceController@savePayout');
	Route::post('/cart/counter-payment/status', 'InvoiceProductController@changeCounterPayStatus');
	Route::post('/close/store', 'InvoiceController@closeStore');
	Route::post('/storeclose/detail', 'InvoiceController@closeStoreDetail');
	Route::get('/close/print/store/{closing_id}', 'InvoiceController@printCloseStore');
	Route::post('/transaction/store', 'InvoiceController@transactionStore');
	Route::get('/invoice/pos/pay/paypal', 'InvoiceController@posPayPaypal');
	Route::get('/partial/pay/paypal/{invoice_id}/{payment_id}/{paid_amount}', 'InvoiceController@partialPayPaypal');
	Route::get('/invoice/counter-pos/pay/paypal', 'InvoiceController@posCounterPayPaypal');
	Route::get('/pos/payment/paypal/{invoice_id}/{status}', 'InvoiceController@getPOSPaymentStatusPaypal');
	Route::get('/partial/payment/paypal/{invoice_id}/{payment_id}/{paid_amount}/{status}', 'InvoiceController@getPOSPartialPaymentStatusPaypal');
	Route::get('/counter-pos/payment/paypal/{invoice_id}/{status}', 'InvoiceController@getCounterPOSPaymentStatusPaypal');
	Route::get('/sales/report', 'InvoiceController@show');
	Route::post('/sales/data/report/json', 'InvoiceController@invoiceSalesReportjson');
	Route::get('/sales/invoice/{invoice_id}', 'InvoiceController@invoiceShow');
	Route::get('/sales/invoice/print/pdf/{invoice_id}', 'InvoiceController@invoicePDF');
	Route::get('/sales/invoice/print/media/pdf/{ptype}/{invoice_id}', 'InvoiceController@invoicePDFByMedia');
	Route::post('/sales/confirm', 'InvoiceController@create');
	Route::post('/sales/save', 'InvoiceController@store');
	Route::get('/sales/edit/{id}', 'InvoiceController@edit');
	Route::get('/sales/delete/{id}', 'InvoiceController@destroy');
	Route::post('/sales/modify/{id}', 'InvoiceController@update');
	Route::post('/sales/return/invoice/ajax', 'InvoiceController@loadCustomerInvoice');
	Route::get('/warranty/invoice/ajax', 'InvoiceController@loadInvoiceOnly');
	Route::get('/partialpay/invoice/ajax', 'InvoiceController@loadPartialPaidInvoiceOnly');
	Route::post('/partialpay/invoice/ajax', 'InvoiceController@savePartialPaidInvoice');
	Route::post('/warranty/invoice/product/ajax', 'InvoiceController@loadWarrantyProductInvoice');
	Route::post('/sales/return/save/ajax', 'InvoiceController@SaveSalesReturnInvoice');

	// Route::get('/sales/excel/report', 'InvoiceController@exportExcel');
	// Route::get('/sales/pdf/report', 'InvoiceController@salesPDF');

	Route::post('/sales/report', 'InvoiceController@show');
	Route::post('/sales/excel/report', 'InvoiceController@ExcelReport');
	Route::post('/sales/pdf/report', 'InvoiceController@PdfReport');


	Route::get('/sales/partial/payment', 'InvoiceController@salesPartialAdd');

	Route::get('/sales/partial/add/payment/{sales_id}', 'InvoiceController@salesPartialFromSalesReport');


	//------------------Sales route end--------------------//




	//---------------POS Route End-----------------------------//



	//------------------Report route start--------------------//

	Route::get('/payment', 'InvoicePaymentController@index');
	Route::get('/payment/report', 'InvoicePaymentController@index');
	Route::post('/payment/data/report/json', 'InvoicePaymentController@datajson');
	Route::post('/payment/report', 'InvoicePaymentController@index');
	Route::post('/payment/excel/report', 'InvoicePaymentController@exportExcel');
	Route::post('/payment/pdf/report', 'InvoicePaymentController@invoicePDF');

	Route::get('/today/payment/report', 'InvoicePaymentController@indexToday');
	Route::get('/today/payment/excel/report', 'InvoicePaymentController@todayExportExcel');
	Route::get('/today/payment/pdf/report', 'InvoicePaymentController@todayInvoicePDF');


	//----------------Card Info Start-----------------------------//
	Route::get('/attendance/punch/manual','CashierPunchController@create');
	Route::get('/attendance/punch/report','CashierPunchController@report');
	Route::post('/attendance/punch/data/json','CashierPunchController@datatableCashierPunchjson');
	Route::post('/attendance/punch/report','CashierPunchController@report');
	Route::post('/attendance/punch/excel','CashierPunchController@ExcelReport');
	Route::post('/attendance/punch/pdf','CashierPunchController@PdfReport');
	Route::post('/attendance/punch/save','CashierPunchController@saveattendance');
	Route::post('/attendance/punch/manual/save','CashierPunchController@store');
	Route::post('/attendance/punch/manual/modify/{id}','CashierPunchController@update');
	Route::get('/attendance/punch/json','CashierPunchController@attendanceJson');
	Route::get('/attendance/punch/edit/{id}','CashierPunchController@edit');
	//----------------Card Info End-----------------------------//



});

Route::get('send-mail/invoice/email/instant', 'SendSalesEmailController@instantMailSend');

//munira work
Route::get('stripe', 'StripePaymentController@stripe');

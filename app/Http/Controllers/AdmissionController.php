<?php

namespace App\Http\Controllers;

use App\Admission;
use App\GymPackage;
use App\Tender;
use App\DeviceSetting;
use Illuminate\Http\Request;

use TADPHP\TADFactory;
use TADPHP\TAD;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $moduleName="Admission";
    private $sdc;
    private $_api_content;
    public function __construct(){ 
        


        $this->sdc = new StaticDataController(); 



        
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    private function createandActivenInactiveUser($accountType=0,$pin=0,$name=''){

        $checkAtt=\DB::table('attendance_users')->where('pin',$pin)->count();
        if($checkAtt==0)
        {
            if($accountType==1){
                $array=array(
                    'pin'=>$pin,
                    'name'=>$name,
                    'password'=>"",
                    'group'=>1,
                    'privilege'=>0
                );
            }else{
                $array=array(
                    'pin'=>$pin,
                    'name'=>$name,
                    'password'=>"",
                    'group'=>1,
                    'privilege'=>0
                );
            }
            

            \DB::table('attendance_users')->insert($array);
        }

        $dataTable=DeviceSetting::find(1);
         
                if($dataTable->device_status=="Ready"){
                    $options = [
                        'ip' =>$dataTable->device_ip, 
                        'internal_id' => 1,  
                        'com_key' => 0,       
                        'description' => 'TAD1', 
                        'soap_port' => 80,    
                        'udp_port' => 4370,    
                        'encoding' => 'iso8859-1'   
                    ];
                  
                    $tad_factory = new TADFactory($options);
                    $tad = $tad_factory->get_instance(); 

                    $dt = $tad->get_date()->to_array();
                    if(count($dt)>0){

                        if($accountType==1)
                        {
                            $r = $tad->set_user_info([
                                    'pin' => $pin,
                                    'name'=> $name,
                                    'privilege'=> 0,
                                    'password' => 0
                            ]);

                            
                            $template1_data = [
                              'pin' => $pin,
                              'valid' => 1 //
                            ];

                            $tad->set_user_template($template1_data);
                        }
                        else
                        {
                            $tad->delete_user(['pin'=>$pin]);
                        }
                        
                    }

                }

                if($dataTable->device_two_status=="Ready"){
                     $options = [
                            'ip' =>$dataTable->device_ip_two, 
                            'internal_id' => 1,  
                            'com_key' => 0,       
                            'description' => 'TAD1', 
                            'soap_port' => 80,    
                            'udp_port' => 4370,    
                            'encoding' => 'iso8859-1'   
                      ];
                      
                      $tad_factory = new TADFactory($options);
                      $tad = $tad_factory->get_instance(); 

                      $dt = $tad->get_date()->to_array();
                      if(count($dt)>0){
                      
                            if($accountType==1)
                            {
                                $r = $tad->set_user_info([
                                        'pin' => $pin,
                                        'name'=> $name,
                                        'privilege'=> 0,
                                        'password' => 0
                                ]);

                                
                                $template1_data = [
                                  'pin' => $pin,
                                  'valid' => 1 //
                                ];

                                $tad->set_user_template($template1_data);
                            }
                            else
                            {
                                $tad->delete_user(['pin'=>$pin]);
                            }
                      }
                }



    }

    public function store(Request $request)
    {

        //dd($request);
        $this->validate($request,[
            'req_no'=>'required',
            'timetable'=>'required',
            'first_name'=>'required',
            'present_address'=>'required',
            'home_phone'=>'required',
            'admission_date'=>'required',
            'starting_date' => 'required',
            'package_id' => 'required',
            'payment_method_id' => 'required',
            'amount_paid' => 'required'
        ]);

        $package=GymPackage::find($request->package_id);
        $packageName=$package->name;

        $tenderInfo=Tender::find($request->payment_method_id);
        $tenderName=$tenderInfo->name;

        $tab=new Admission();
        $tab->req_no=$request->req_no;
        $tab->timetable=$request->timetable;
        $tab->first_name=$request->first_name;
        $tab->middle_name=$request->middle_name;
        $tab->last_name=$request->last_name;
        $tab->present_address=$request->present_address;
        $tab->age=$request->age;
        $tab->dob=$request->dob;
        $tab->gender=$request->gender;
        $tab->blood_group=$request->blood_group;
        $tab->weight=$request->weight;
        $tab->height=$request->height;
        $tab->home_phone=$request->home_phone;
        $tab->cell_phone=$request->cell_phone;
        $tab->profession=$request->profession;
        $tab->designation=$request->designation;
        $tab->personal_email=$request->personal_email;
        $tab->facebook_id=$request->facebook_id;
        $tab->admission_date=$request->admission_date;
        $tab->starting_date=$request->starting_date;
        $tab->date_of_expiry=$request->date_of_expiry;
        $tab->package_id=$request->package_id;
        $tab->package_name=$packageName;
        $tab->payment_id=$request->payment_method_id;
        $tab->payment_name=$tenderName;
        $tab->amount_paid=$request->amount_paid;
        $tab->receipt_number=$request->receipt_number;
        $tab->save();


        if(isset($tab->id)){

            $name=$request->first_name;
            if(!empty($request->middle_name)){
                $name.=" ".$request->first_name;
            }

            if(!empty($request->last_name)){
                $name.=" ".$request->last_name;
            }

            $pin=$request->req_no;
            $password="";
            $privilege="0";
            $group=1;

            $checkMember=Customer::where('pin',$pin)->count();

            if($checkMember==0){
                $tab=new Customer();
                $tab->pin=$pin;
                $tab->name=$name;
                $tab->password=$password;
                $tab->privilege=$privilege;
                $tab->user_status='Active';
                $tab->save();
            }

            $checkAtt=\DB::table('attendance_users')->where('pin',$pin)->count();
            if($checkAtt==0)
            {
                $array=array(
                    'pin'=>$pin,
                    'name'=>$name,
                    'password'=>$password,
                    'group'=>$group,
                    'privilege'=>$privilege
                );

                \DB::table('attendance_users')->insert($array);
            }

            //Create User Start
             $this->createandActiveUser(1,$pin,$name);
            //Create User End
            
        }


        return redirect(url('admission'))->with('status','Admission Info saved successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admission  $admission
     * @return \Illuminate\Http\Response
     */
    public function show($id=0)
    {
        $admission=Admission::find($id);

        $package=GymPackage::all();
        $tender=Tender::all();
        $orderID = Admission::max('id');
        $orderIDNew = $orderID+1;

        $regID = Admission::max('req_no');
        $regIDNew = $regID+1;

        return view('apps.pages.customer.admission_view',['package'=>$package,'tender'=>$tender,'orderID'=>$orderIDNew,'regID'=>$regIDNew,'dataRow'=>$admission,'edit'=>true]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admission  $admission
     * @return \Illuminate\Http\Response
     */
    public function edit(Admission $admission,$id=0)
    {
        $admission=Admission::find($id);

        $package=GymPackage::all();
        $tender=Tender::all();
        $orderID = Admission::max('id');
        $orderIDNew = $orderID+1;

        $regID = Admission::max('req_no');
        $regIDNew = $regID+1;

        return view('apps.pages.customer.admission',['package'=>$package,'tender'=>$tender,'orderID'=>$orderIDNew,'regID'=>$regIDNew,'dataRow'=>$admission,'edit'=>true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admission  $admission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=0)
    {
        //dd($request);
        $this->validate($request,[
            'req_no'=>'required',
            'timetable'=>'required',
            'first_name'=>'required',
            'present_address'=>'required',
            'home_phone'=>'required',
            'admission_date'=>'required',
            'starting_date' => 'required',
            'package_id' => 'required',
            'payment_method_id' => 'required',
            'amount_paid' => 'required'
        ]);

        $package=GymPackage::find($request->package_id);
        $packageName=$package->name;

        $tenderInfo=Tender::find($request->payment_method_id);
        $tenderName=$tenderInfo->name;

        $tab=Admission::find($id);
        $tab->req_no=$request->req_no;
        $tab->timetable=$request->timetable;
        $tab->first_name=$request->first_name;
        $tab->middle_name=$request->middle_name;
        $tab->last_name=$request->last_name;
        $tab->present_address=$request->present_address;
        $tab->age=$request->age;
        $tab->dob=$request->dob;
        $tab->gender=$request->gender;
        $tab->blood_group=$request->blood_group;
        $tab->weight=$request->weight;
        $tab->height=$request->height;
        $tab->home_phone=$request->home_phone;
        $tab->cell_phone=$request->cell_phone;
        $tab->profession=$request->profession;
        $tab->designation=$request->designation;
        $tab->personal_email=$request->personal_email;
        $tab->facebook_id=$request->facebook_id;
        $tab->admission_date=$request->admission_date;
        $tab->starting_date=$request->starting_date;
        $tab->date_of_expiry=$request->date_of_expiry;
        $tab->package_id=$request->package_id;
        $tab->package_name=$packageName;
        $tab->payment_id=$request->payment_method_id;
        $tab->payment_name=$tenderName;
        $tab->amount_paid=$request->amount_paid;
        $tab->receipt_number=$request->receipt_number;
        $tab->save();



        return redirect(url('admission'))->with('status','Admission Info updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admission  $admission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admission $admission)
    {
        //
    }

    public function makeSalesReturnShow(Request $request)
    {



        $pin='';
        if(isset($request->pin))
        {
            $pin=$request->pin;
        }



        $payment_id='';
        if(isset($request->payment_id))
        {
            //dd(1);
            $payment_id=$request->payment_id;
        }

        $package_id='';
        if(isset($request->package_id))
        {
            //dd(1);
            $package_id=$request->package_id;
        }

        $start_date='';
        if(isset($request->start_date))
        {
            $start_date=$request->start_date;
        }

        $end_date='';
        if(isset($request->end_date))
        {
            $end_date=$request->end_date;
        }

        if(empty($start_date) && !empty($end_date))
        {
            $start_date=$end_date;
        }

        if(!empty($start_date) && empty($end_date))
        {
            $end_date=$start_date;
        }

        $dateString='';
        if(!empty($start_date) && !empty($end_date))
        {
            $dateString="CAST(admission_date as date) BETWEEN '".$start_date."' AND '".$end_date."'";
        }

        if(empty($pin) && empty($package_id) && empty($payment_id) && empty($start_date) && empty($end_date) && empty($dateString))
        {
            /*$tab=SalesReturn::where('store_id',$this->sdc->storeID())
                         ->when($invoice_id, function ($query) use ($invoice_id) {
                                return $query->where('invoice_id','=', $invoice_id);
                         })
                         ->when($customer_id, function ($query) use ($customer_id) {
                                return $query->where('customer_id','=', $customer_id);
                         })
                         ->when($dateString, function ($query) use ($dateString) {
                                return $query->whereRaw($dateString);
                         })
                         ->orderBy("id","DESC")
                         ->take(100)
                         ->get();*/

            $tab=array();
        }
        else
        {
            $tab=Admission::when($pin, function ($query) use ($pin) {
                                return $query->where('req_no','=', $pin);
                         })
                         ->when($payment_id, function ($query) use ($payment_id) {
                                return $query->where('payment_id','=', $payment_id);
                         })
                         ->when($package_id, function ($query) use ($package_id) {
                                return $query->where('package_id','=', $package_id);
                         })
                         ->when($dateString, function ($query) use ($dateString) {
                                return $query->whereRaw($dateString);
                         })
                         ->orderBy("id","DESC")
                         ->get();

           //dd($tab);
        }


        $tender=Tender::all();
        $package=GymPackage::all();
        //$tab=Admission::orderBy("id","DESC")->get();
            //dd($tab);

        return view('apps.pages.admission.make-list',[
            'dataTable'=>$tab,
            'pin'=>$pin,
            'tender'=>$tender,
            'package'=>$package,
            'package_id'=>$package_id,
            'payment_id'=>$payment_id,
            'start_date'=>$start_date,
            'end_date'=>$end_date
        ]);
    }
    private function admissionListJsonCount($search=''){

        $tab=Admission::select('id')
                     //->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                        $query->orWhere('req_no','LIKE','%'.$search.'%');
                        $query->orWhere('first_name','LIKE','%'.$search.'%');
                        $query->orWhere('middle_name','LIKE','%'.$search.'%');
                        $query->orWhere('last_name','LIKE','%'.$search.'%');
                        $query->orWhere('cell_phone','LIKE','%'.$search.'%');
                        $query->orWhere('home_phone','LIKE','%'.$search.'%');
                        $query->orWhere('personal_email','LIKE','%'.$search.'%');
                        $query->orWhere('receipt_number','LIKE','%'.$search.'%');
                        $query->orWhere('facebook_id','LIKE','%'.$search.'%');

                        return $query;
                     })

                     ->count();
        return $tab;
    }

    private function admissionListJson($start, $length,$search=''){

        $tab=Admission::select('id','req_no','first_name','middle_name','last_name','cell_phone'
            ,'package_name','payment_name','amount_paid','admission_date','starting_date','date_of_expiry')
                     ->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                        $query->orWhere('req_no','LIKE','%'.$search.'%');
                        $query->orWhere('first_name','LIKE','%'.$search.'%');
                        $query->orWhere('middle_name','LIKE','%'.$search.'%');
                        $query->orWhere('last_name','LIKE','%'.$search.'%');
                        $query->orWhere('cell_phone','LIKE','%'.$search.'%');
                        $query->orWhere('home_phone','LIKE','%'.$search.'%');
                        $query->orWhere('personal_email','LIKE','%'.$search.'%');
                        $query->orWhere('receipt_number','LIKE','%'.$search.'%');
                        $query->orWhere('facebook_id','LIKE','%'.$search.'%');

                        return $query;
                     })
                     ->skip($start)->take($length)->get();
        return $tab;
    }
    public function datajsonsalesReturnList(Request $request){

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search');

        $search = (isset($search['value']))? $search['value'] : '';

        $total_members = $this->admissionListJsonCount($search); // get your total no of data;
        $members = $this->admissionListJson($start, $length,$search); //supply start and length of the table data

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_members,
            'recordsFiltered' => $total_members,
            'data' => $members,
        );

        echo json_encode($data);

    }



    public function exportAdmissionQuery($request)
    {
        $pin='';
        if(isset($request->pin))
        {
            $pin=$request->pin;
        }



        $payment_id='';
        if(isset($request->payment_id))
        {
            //dd(1);
            $payment_id=$request->payment_id;
        }

        $package_id='';
        if(isset($request->package_id))
        {
            //dd(1);
            $package_id=$request->package_id;
        }

        $start_date='';
        if(isset($request->start_date))
        {
            $start_date=$request->start_date;
        }

        $end_date='';
        if(isset($request->end_date))
        {
            $end_date=$request->end_date;
        }

        if(empty($start_date) && !empty($end_date))
        {
            $start_date=$end_date;
        }

        if(!empty($start_date) && empty($end_date))
        {
            $end_date=$start_date;
        }

        $dateString='';
        if(!empty($start_date) && !empty($end_date))
        {
            $dateString="CAST(admission_date as date) BETWEEN '".$start_date."' AND '".$end_date."'";
        }

   

        $tab=Admission::when($pin, function ($query) use ($pin) {
                                return $query->where('req_no','=', $pin);
                         })
                         ->when($payment_id, function ($query) use ($payment_id) {
                                return $query->where('payment_id','=', $payment_id);
                         })
                         ->when($package_id, function ($query) use ($package_id) {
                                return $query->where('package_id','=', $package_id);
                         })
                         ->when($dateString, function ($query) use ($dateString) {
                                return $query->whereRaw($dateString);
                         })
                         ->orderBy("id","DESC")
                         ->get();
        //dd($invoice);
        return $tab;
    }

    public function exportExcelAdmission(Request $request) 
    {
        //excel 
        $data=array();
        $array_column=array('SL','PIN','Name','Phone','Package','Payment','Payment Amount','Admission Date','Expiry Date');
        array_push($data, $array_column);
        $inv=$this->exportAdmissionQuery($request);

        $i=1;
        $totalSumAdmission=0;
        foreach($inv as $voi):
            $inv_arry=array($i,$voi->req_no,$voi->first_name,$voi->cell_phone,$voi->package_name,$voi->payment_name,$voi->amount_paid,formatDate($voi->admission_date),formatDate($voi->date_of_expiry));
            array_push($data, $inv_arry);

            $totalSumAdmission+=floatval($voi->amount_paid);

            $i++;
        endforeach;

            $array_column=array('','','','','','Total',$totalSumAdmission,'','');
            array_push($data, $array_column);

        $reportName="Member Admission Report";
        $report_title="Member Admission Report";
        $report_description="Member Admission Report Genarated : ".formatDateTime(date('d-M-Y H:i:s a'));
        /*$data = array(
            array('data1', 'data2'),
            array('data3', 'data4')
        );*/

        //array_unshift($data,$array_column);

       // dd($data);

        $excelArray=array(
            'report_name'=>$reportName,
            'report_title'=>$report_title,
            'report_description'=>$report_description,
            'data'=>$data
        );
        // dd($excelArray);
        $this->sdc->ExcelLayout($excelArray);
        
    }

    public function exportPDFAdmission(Request $request)
    {

        $data=array();
        
        $reportName="Member Admission  Report";
        $report_title="Member Admission  Report";
        $report_description="Member Admission Report Genarated : ".formatDateTime(date('d-M-Y H:i:s a'));

        $html='<table class="table table-bordered" style="width:100%;">
                <thead>
                <tr>
                <th class="text-center" style="font-size:12px;" >SL</th>
                <th class="text-center" style="font-size:12px;" >PIN</th>
                <th class="text-center" style="font-size:12px;" >Name</th>
                <th class="text-center" style="font-size:12px;" >Phone</th>
                <th class="text-center" style="font-size:12px;" >Package</th>
                <th class="text-center" style="font-size:12px;" >Payment</th>
                <th class="text-center" style="font-size:12px;" >Payment Amount</th>
                <th class="text-center" style="font-size:12px;" >Admission Date</th>
                <th class="text-center" style="font-size:12px;" >Expiry Date</th>
                </tr>
                </thead>
                <tbody>';

                    //$inv_arry=array($voi->invoice_id,$voi->created_at,$voi->customer_name,$voi->invoice_total,$voi->sales_return_amount,$voi->sales_return_note);
                    $inv=$this->exportAdmissionQuery($request);
                    $i=1;
                    $totalSumAdmission=0;
                    foreach($inv as $voi):
                        $html .='<tr>
                        <td style="font-size:12px;" class="text-center">'.$i.'</td>
                        <td style="font-size:12px;" class="text-center">'.$voi->req_no.'</td>
                        <td style="font-size:12px;" class="text-center">'.$voi->first_name.'</td>
                        <td style="font-size:12px;" class="text-center">'.$voi->cell_phone.'</td>
                        <td style="font-size:12px;" class="text-center">'.$voi->package_name.'</td>
                        <td style="font-size:12px;" class="text-center">'.$voi->payment_name.'</td>
                        <td style="font-size:12px;" class="text-center">'.$voi->amount_paid.'</td>
                        <td style="font-size:12px;" class="text-center">'.formatDate($voi->admission_date).'</td>
                        <td style="font-size:12px;" class="text-center">'.formatDate($voi->date_of_expiry).'</td>
                        </tr>';

                        $totalSumAdmission+=floatval($voi->amount_paid);

                        $i++;

                    endforeach;

                    $html .='<tr>
                        <td style="font-size:12px;" class="text-center"></td>
                        <td style="font-size:12px;" class="text-center"></td>
                        <td style="font-size:12px;" class="text-center"></td>
                        <td style="font-size:12px;" class="text-center"></td>
                        <td style="font-size:12px;" class="text-center"></td>
                        <td style="font-size:12px;" class="text-center">Total</td>
                        <td style="font-size:12px;" class="text-center">'.$totalSumAdmission.'</td>
                        <td style="font-size:12px;" class="text-center"></td>
                        <td style="font-size:12px;" class="text-center"></td>
                        </tr>';


                        

             
                /*html .='<tr style="border-bottom: 5px #000 solid;">
                <td style="font-size:12px;">Subtotal </td>
                <td style="font-size:12px;">Total Item : 4</td>
                <td></td>
                <td></td>
                <td style="font-size:12px;" class="text-right">00</td>
                </tr>';*/

                $html .='</tbody>
                
                </table>


                ';



                $this->sdc->PDFLayout($reportName,$html);


    }




}

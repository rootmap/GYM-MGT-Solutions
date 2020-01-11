<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Role;
use App\User;
use App\Store;
use App\RetailPosSummary;
use App\RetailPosSummaryDateWise;
use App\GymPackage;
use App\Admission;
use App\Tender;
use App\DeviceSetting;
use Illuminate\Http\Request;
use App\Invoice;
use Excel;
use Auth;

use TADPHP\TADFactory;
use TADPHP\TAD;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    private $moduleName="Customer";
    private $sdc;
    public function __construct(){ 
        $this->sdc = new StaticDataController(); 
    }

    public function admission(){

        $package=GymPackage::all();
        $tender=Tender::all();
        $orderID = Admission::max('id');
        $orderIDNew = $orderID+1;

        $regID = Admission::max('req_no');
        $regIDNew = $regID+1;
        //dd($orderIDNew);

        return view('apps.pages.customer.admission',['package'=>$package,'tender'=>$tender,'orderID'=>$orderIDNew,'regID'=>$regIDNew]);
    }

    public function admissionsave(Request $request){
        dd($request);
        echo 1; die();
    }

    public function user()
    {
        if(Auth::user()->user_type==1)
        {
            $storeList = Store::all();
            $role=\DB::table('roles')->select('id','name','store_id')->where('id','>',1)->orderBy('id','DESC')->get();
        }
        elseif(Auth::user()->user_type==2)
        {
            $role=\DB::table('roles')->select('id','name','store_id')->where('id','>',2)->orderBy('id','DESC')->get();
        }
        else
        {
            $role=\DB::table('roles')->select('id','name','store_id')->where('id','>',3)->get();
        }

        if(Auth::user()->user_type==1)
        {
            return view('apps.pages.user.index',['role'=>$role,'storeList'=>$storeList]);
        }
        else
        {
            return view('apps.pages.user.index',['role'=>$role]);
        }
        
    }

    public function getCustomer($id=0)
    {
        $cus=array();
        if($id>0)
        {
            $tab=Customer::find($id);
            $cus=$tab;
        }
        return response()->json($cus);
    }

    public function userList()
    {
        if(Auth::user()->user_type==1)
        {
            $user = User::leftjoin('roles','users.user_type','=','roles.id')
                        ->select('users.*','roles.name as user_type_name')
                        //->where('users.store_id',$this->sdc->storeID())
                        ->get();
        }
        else
        {
            $user = User::leftjoin('roles','users.user_type','=','roles.id')
                        ->select('users.*','roles.name as user_type_name')
                        ->where('users.store_id',$this->sdc->storeID())->get();
        }
        return view('apps.pages.user.userlist',['dataTable'=>$user]);
    }

    public function userSave(Request $request)
    {

       if(Auth::user()->user_type==1)
        {
           $this->validate($request,[
                'user_type'=>'required',
                'store_id'=>'required',
                'name'=>'required',
                'address'=>'required',
                'phone'=>'required',
                'email'=>'required|string|email|max:255',
                'password' => 'min:4',
                'password_confirmation' => 'required_with:password|same:password|min:4'
            ]);
        }
        else
        {
           $this->validate($request,[
                'user_type'=>'required',
                'name'=>'required',
                'address'=>'required',
                'phone'=>'required',
                'email'=>'required|string|email|max:255',
                'password' => 'min:4',
                'password_confirmation' => 'required_with:password|same:password|min:4'
            ]); 
        }


        $tab=new User;
        $tab->name=$request->name;
        $tab->user_type=$request->user_type;
        $tab->address=$request->address;
        $tab->phone=$request->phone;
        $tab->email=$request->email;
        $tab->password = \Hash::make($request->password);
        $tab->remember_token=$request->_token;
        if(Auth::user()->user_type==1)
        {
            $tab->store_id=$request->store_id;
        }
        else
        {
            $tab->store_id=$this->sdc->storeID();
        }
        
        $tab->created_by=$this->sdc->UserID();
        $tab->save();

        if(Auth::user()->user_type==1)
        {
            $this->sdc->log("User","User account created for shop #".$tab->store_id.".");
        }
        else
        {
            $this->sdc->log("User","User account created.");
        }
        

        return redirect('user')->with('status', $this->moduleName.' Added Successfully !');
    }
    public function UserShow($id)
    {
        
        
        $edit = User::find($id);
        if(Auth::user()->user_type==1)
        {
            $storeList = Store::all();
            $role=\DB::table('roles')->select('id','name','store_id')->where('id','>',1)->orderBy('id','DESC')->get();
            return view('apps.pages.user.index',['edit'=>$edit,'role'=>$role,'storeList'=>$storeList]);
        }
        elseif(Auth::user()->user_type==2)
        {
            $role=\DB::table('roles')->select('id','name','store_id')->where('id','>',2)->orderBy('id','DESC')->get();
            return view('apps.pages.user.index',['edit'=>$edit,'role'=>$role]);
        }
        else
        {
            $role=\DB::table('roles')->select('id','name','store_id')->where('id','>',3)->get();
            return view('apps.pages.user.index',['edit'=>$edit,'role'=>$role]);
        }        
    }

    public function UserEdit(Customer $customer,$id=0)
    {
        $tab=$customer::find($id);
        $tabData=$customer::where('store_id',$this->sdc->storeID())->get();
        return view('apps.pages.customer.customer',['dataRow'=>$tab,'dataTable'=>$tabData,'edit'=>true]);

    }

    public function userUpdate(Request $request, $id=0)
    {
        if(Auth::user()->user_type==1)
        {
            $this->validate($request,[
                'user_type'=>'required',
                'name'=>'required',
                'address'=>'required',
                'phone'=>'required',
                'store_id' => 'required',
                //'password_confirmation' => 'required_with:password|same:password|min:6'
            ]);


            if(!empty($request->password))
            {
                 $this->validate($request,[
                    'password' => 'min:4',
                    'password_confirmation' => 'required_with:password|same:password|min:4'
                ]);

            }
        }
        else
        {
            $this->validate($request,[
                'user_type'=>'required',
                'name'=>'required',
                'address'=>'required',
                'phone'=>'required',
                //'password' => 'min:6',
                //'password_confirmation' => 'required_with:password|same:password|min:6'
            ]);


            if(!empty($request->password))
            {
                 $this->validate($request,[
                    'password' => 'min:4',
                    'password_confirmation' => 'required_with:password|same:password|min:4'
                ]);

            }
        }

        $tab=User::find($id);
        $tab->name=$request->name;
        $tab->user_type=$request->user_type;
        $tab->address=$request->address;
        $tab->phone=$request->phone;
        $tab->email=$request->email;
        if(!empty($request->password))
        {
            $tab->password = \Hash::make($request->password);
        }
        $tab->remember_token=$request->_token;
        if(Auth::user()->user_type==1)
        {
            $tab->store_id=$request->store_id;
        }
        else
        {
            $tab->store_id=$this->sdc->storeID();
        }
        
        $tab->created_by=$this->sdc->UserID();
        $tab->save();
        $this->sdc->log("User","User account updated.");
        return redirect('user/list')->with('status', $this->moduleName.' Updated Successfully !');

    }
    public function Userdestroy($id)
    {
        $tab=User::find($id);
        $tab->delete();
        
        $this->sdc->log("User","User account deleted.");

        return redirect('user/list')->with('status', $this->moduleName.' Deleted Successfully !');
    }
    public function index()
    {
        return view('apps.pages.customer.customer');
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
    public function profitQuery($request)
    {
        $invoice=Customer::all();
        return $invoice;
    }

    public function exportExcel(Request $request) 
    {
        //echo "string"; die();
        //excel 
        $data=array();
        $array_column=array('SL','Name','PIN','Password','User Type','User Account');
        array_push($data, $array_column);
        $inv=$this->profitQuery($request);
        $sl=1;
        foreach($inv as $voi):

            $previliges=$voi->privilege;
            $userTY="Normal User";
            if($previliges==14){
                $userTY="Admin / Staff";
            }

            $inv_arry=array($sl,$voi->name,$voi->pin,$voi->password,$userTY,$voi->user_status);
            array_push($data, $inv_arry);
            $sl++;
        endforeach;

        $reportName="All Member Report";
        $report_title="All Member Report";
        $report_description="Report Genarated : ".date('d-M-Y H:i:s a');
        $excelArray=array(
            'report_name'=>$reportName,
            'report_title'=>$report_title,
            'report_description'=>$report_description,
            'data'=>$data
        );

        $this->sdc->ExcelLayout($excelArray);
        
    }

    public function invoicePDF(Request $request)
    {

        $data=array();      
        $reportName="All Member Report";
        $report_title="All Member Report";
        $report_description="Report Genarated : ".formatDateTime(date('d-M-Y H:i:s a'));

        $html='<table class="table table-bordered" style="width:100%;">
                <thead>
                <tr>
                <th class="text-center" style="font-size:12px;" >SL</th>
                <th class="text-center" style="font-size:12px;" >Name</th>
                <th class="text-center" style="font-size:12px;" >PIN</th>
                <th class="text-center" style="font-size:12px;" >password</th>
                <th class="text-center" style="font-size:12px;" >User Type</th>
                <th class="text-center" style="font-size:12px;" >User Status</th>
                </tr>
                </thead>
                <tbody>';

                    $inv=$this->profitQuery($request);
                    $i=1;
                    foreach($inv as $voi):

                        $previliges=$voi->privilege;
                        $userTY="Normal User";
                        if($previliges==14){
                            $userTY="Admin / Staff";
                        }
                        $html .='<tr>
                        <td style="font-size:12px;" class="text-center">'.$i.'</td>
                        <td style="font-size:12px;" class="text-center">'.$voi->name.'</td>
                        <td style="font-size:12px;" class="text-center">'.$voi->pin.'</td>
                        <td style="font-size:12px;" class="text-center">'.$voi->password.'</td>
                        <td style="font-size:12px;" class="text-center">'.$userTY.'</td>
                        <td style="font-size:12px;" class="text-center">'.$voi->user_status.'</td>
                        </tr>';

                        $i++;

                    endforeach;


                        

             
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

        $commands_list = TAD::commands_available();

        

        $this->validate($request,[
            'name'=>'required',
            'pin'=>'required',
        ]);


        $tab=new Customer;
        $tab->name=$request->name;
        $tab->pin=$request->pin;
        $tab->password=$request->password;
        $tab->privilege=$request->privilege;
        $tab->user_status=$request->user_status;
        $tab->store_id=$this->sdc->storeID();
        $tab->created_by=$this->sdc->UserID();
        $tab->save();

        $pin=$request->pin;
        $name=$request->name;

        if($request->user_status=="Active"){
            $this->createandActivenInactiveUser(1,$pin,$name);
        }else{
            $this->createandActivenInactiveUser(2,$pin,$name);
        }


        RetailPosSummary::where('id',1)->update(['customer_quantity' => \DB::raw('customer_quantity + 1')]);
        $Todaydate=date('Y-m-d');
        if(RetailPosSummaryDateWise::where('report_date',$Todaydate)->count()==0)
        {
            RetailPosSummaryDateWise::insert([
               'report_date'=>$Todaydate,
               'customer_quantity' => \DB::raw('1')
            ]);
        }
        else
        {
            RetailPosSummaryDateWise::where('report_date',$Todaydate)
            ->update([
               'customer_quantity' => \DB::raw('customer_quantity + 1')
            ]);
        }

        $this->sdc->log("customer","Customer account created (".$request->pin.").");

        return redirect('customer')->with('status', $this->moduleName.' Added Successfully !');
    }
    public function posCustomerAdd(Request $request)
    {

       //echo "string"; die();
        $tab=new Customer;
        $tab->name=$request->name;
        $tab->address=$request->address;
        $tab->phone=$request->phone;
        $tab->email=$request->email;
        $tab->store_id=$this->sdc->storeID();
        $tab->created_by=$this->sdc->UserID();
        $tab->save();

        

        return $tab->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    private function methodToGetMembersCount($search=''){

        $tab=Customer::select('id')
                     ->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                        $query->orWhere('name','LIKE','%'.$search.'%');
                        $query->orWhere('pin','LIKE','%'.$search.'%');
                        $query->orWhere('password','LIKE','%'.$search.'%');
                        $query->orWhere('privilege','LIKE','%'.$search.'%');
                        $query->orWhere('user_status','LIKE','%'.$search.'%');
                        $query->orWhere('last_invoice_no','LIKE','%'.$search.'%');
                        $query->orWhere('created_at','LIKE','%'.$search.'%');

                        return $query;
                     })

                     ->count();
        return $tab;
    }

    private function methodToGetMembers($start, $length,$search=''){

        $tab=Customer::select('id','name','pin','password','privilege','user_status')
                     ->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                        $query->orWhere('name','LIKE','%'.$search.'%');
                        $query->orWhere('pin','LIKE','%'.$search.'%');
                        $query->orWhere('password','LIKE','%'.$search.'%');
                        $query->orWhere('privilege','LIKE','%'.$search.'%');
                        $query->orWhere('user_status','LIKE','%'.$search.'%');
                        $query->orWhere('last_invoice_no','LIKE','%'.$search.'%');
                        $query->orWhere('created_at','LIKE','%'.$search.'%');

                        return $query;
                     })
                     ->skip($start)->take($length)->get();
        return $tab;
    }


    public function datajson(Request $request){

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search');

        $search = (isset($search['value']))? $search['value'] : '';

        $total_members = $this->methodToGetMembersCount($search); // get your total no of data;
        $members = $this->methodToGetMembers($start, $length,$search); //supply start and length of the table data

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_members,
            'recordsFiltered' => $total_members,
            'data' => $members,
        );

        echo json_encode($data);

    }

    public function show(Customer $customer)
    {


        

        //$tab=$customer::where('store_id',$this->sdc->storeID())->orderBy('id','DESC')->take(100)->get();
        //return view('apps.pages.customer.list',['dataTable'=>$tab]);
        return view('apps.pages.customer.list');
    }

    public function showCustomerDataTable(){
        //echo $this->ssp->test(); die();
        $dbDetails = array(
            'host' => env('DB_HOST', '127.0.0.1'),
            'user' => env('DB_USERNAME', '127.0.0.1'),
            'pass' => env('DB_PASSWORD', '127.0.0.1'),
            'db'   => env('DB_DATABASE', '127.0.0.1')
        );

        //dd($dbDetails);

        // DB table to use
        $table = 'lsp_customers';

        // Table's primary key
        $primaryKey = 'id';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database. 
        // The `dt` parameter represents the DataTables column identifier.
        $columns = array(
            array( 'db' => 'name', 'dt' => 0 ),
            array( 'db' => 'address',  'dt' => 1 ),
            array( 'db' => 'email',      'dt' => 2 ),
            array( 'db' => 'phone',     'dt' => 3 ),
            array( 'db' => 'last_invoice_no',    'dt' => 4 ),
            array(
                'db'        => 'created_at',
                'dt'        => 5,
                'formatter' => function( $d, $row ) {
                    return date( 'jS M Y', strtotime($d));
                }
            ),
            array(
                'db'        => 'store_id',
                'dt'        => 6,
                'formatter' => function( $d, $row ) {
                    return ($d == 1)?'Active':'Inactive';
                }
            )
        );

        // Include SQL query processing class

        // Output data as json format
        echo json_encode(
            $this->ssp->simple( $_GET, $dbDetails, $table, $primaryKey, $columns )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer,$id=0)
    {
        $tab=$customer::find($id);
        $tabData=$customer::where('store_id',$this->sdc->storeID())->get();
        return view('apps.pages.customer.customer',['dataRow'=>$tab,'dataTable'=>$tabData,'edit'=>true]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    

    public function update(Request $request, Customer $customer,$id=0)
    {

        $this->validate($request,[
            'name'=>'required',
            'pin'=>'required',
        ]);

        $tab=$customer::find($id);
        $tab->name=$request->name;
        $tab->pin=$request->pin;
        $tab->password=$request->password;
        $tab->privilege=$request->privilege;
        $tab->user_status=$request->user_status;
        $tab->updated_by=$this->sdc->UserID();
        $tab->save();

        $pin=$request->pin;
        $name=$request->name;

        if($request->user_status=="Active"){
            $this->createandActivenInactiveUser(1,$pin,$name);
        }else{
            $this->createandActivenInactiveUser(2,$pin,$name);
        }


        $this->sdc->log("customer","Customer account updated (".$request->pin.").");
        return redirect('customer')->with('status', $this->moduleName.' Updated Successfully !');

    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer,$id=0)
    {
        $tab=$customer::find($id);
        $invoice_date=date('Y-m-d',strtotime($tab->created_at));
        $Todaydate=date('Y-m-d');
        if((RetailPosSummaryDateWise::where('report_date',$Todaydate)->count()==1) && ($invoice_date==$Todaydate))
        {
            RetailPosSummaryDateWise::where('report_date',$Todaydate)
            ->update([
               'customer_quantity' => \DB::raw('customer_quantity - 1')
            ]);
        }
        RetailPosSummary::where('id',1)->update(['customer_quantity' => \DB::raw('customer_quantity - 1')]);
        $tab->delete();
        

        $this->sdc->log("customer","Customer account deleted.");

        return redirect('customer/list')->with('status', $this->moduleName.' Deleted Successfully !');
    }

    public function importCustomer(){

        $dataTable=DeviceSetting::find(1);

        return view('apps.pages.customer.import',['edit'=>$dataTable]);
    }

    private function memberImport($all_user_info){
        if(count($all_user_info)>0)
        {
            if(count($all_user_info['Row'])>0)
            {
                        foreach ($all_user_info['Row'] as $row) {
                                //dd($row);

                                if(!empty($row['PIN2']) && !empty($row['Name'])){
                                    $checkAtt=\DB::table('attendance_users')->where('pin',$row['PIN2'])->count();

                                    $pin=""; if(!empty($row['PIN2'])){ $pin=$row['PIN2']; }
                                    $name=""; if(!empty($row['Name'])){ $name=$row['Name']; }
                                    $password=""; if(!empty($row['Password'])){ $password=$row['Password']; }
                                    $group=""; if(!empty($row['Group'])){ $group=$row['Group']; }
                                    $privilege=""; if(!empty($row['Privilege'])){ $privilege=$row['Privilege']; }

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


                                }
                                
                        }
            }
        }

        return 1;
    }
    
    public function importCustomerSave(request $request){
         $dataTable=DeviceSetting::find(1);
         $device_status=0;
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
                  
                        $device_status=1;
                  
                        $all_user_info = $tad->get_all_user_info()->to_array();
                        $this->memberImport($all_user_info);
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
                  
                        $device_status=1;
                  
                        $all_user_info = $tad->get_all_user_info()->to_array();

                        dd($all_user_info);
                  }
         }

         if($device_status==0){
            return redirect('device/settings')->with('error', 'Device not ready please check your devices!');
         }
         else
         {
            return redirect('customer/import')->with('status', 'Device data import successfully!');
         }

    }
    public function customerReport(request $request, $id=0){
        $tab=customer::find($id);
        $tabData=invoice::join('customers','invoices.customer_id','=','customers.id')
                     ->select('invoices.*','customers.name as customer_name')
                     ->where('invoices.customer_id',$id)
                     ->get();
        return view('apps.pages.customer.report',['dataCus'=>$tab,'dataTable'=>$tabData]);
        
    }
}

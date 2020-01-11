<?php

namespace App\Http\Controllers;

use App\Payment;
use App\GymPackage;
use App\Tender;
use App\DeviceSetting;
use App\Customer;
use Illuminate\Http\Request;


use TADPHP\TADFactory;
use TADPHP\TAD;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $tender=Tender::select('id','name')->get();
        $customer=Customer::select('id','name','pin')->get();

        return view('apps.pages.customer.payment',['tender'=>$tender,'member'=>$customer]);

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
        $this->validate($request,[
            'receipt_number'=>'required',
            'pin'=>'required',
            'payment_date'=>'required',
            'member_name'=>'required',
            'month_fee_for'=>'required',
            'month_fee'=>'required',
            'payment_method_id'=>'required',
            'in_word'=>'required'
        ]);

        $tender=Tender::find($request->payment_method_id);
        $tenderName=$tender->name;

        $tab=new Payment();
        $tab->receipt_number=$request->receipt_number;
        $tab->pin=$request->pin;
        $tab->payment_date=$request->payment_date;
        $tab->member_name=$request->member_name;
        $tab->month_fee_for=$request->month_fee_for;
        $tab->month_fee=$request->month_fee;
        $tab->payment_method_id=$request->payment_method_id;
        $tab->payment_method_name=$tenderName;
        $tab->in_word=$request->in_word;
        $tab->save();

        $pin=$request->pin;
        $name=$request->member_name;

        $tabcus=Customer::where('pin',$pin)->first();
        //dd($tabcus);
        $tab=Customer::find($tabcus->id);
        $tab->user_status='Active';
        $tab->save();

        $this->createandActivenInactiveUser(1,$pin,$name);

        return redirect(url('gympayment'))->with('status','Payment receipt added successfully.');



        //dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show($id=0)
    {
        $tender=Tender::select('id','name')->get();
        $customer=Customer::select('id','name','pin')->get();

        $payment=Payment::find($id);

        //dd($payment);

        return view('apps.pages.customer.payment_view',['edit'=>$payment,'tender'=>$tender,'member'=>$customer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit($id=0)
    {
        $tender=Tender::select('id','name')->get();
        $customer=Customer::select('id','name','pin')->get();

        $payment=Payment::find($id);

        //dd($payment);

        return view('apps.pages.customer.payment',['edit'=>$payment,'tender'=>$tender,'member'=>$customer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=0)
    {
        $this->validate($request,[
            'receipt_number'=>'required',
            'pin'=>'required',
            'payment_date'=>'required',
            'member_name'=>'required',
            'month_fee_for'=>'required',
            'month_fee'=>'required',
            'payment_method_id'=>'required',
            'in_word'=>'required'
        ]);

        $tender=Tender::find($request->payment_method_id);
        $tenderName=$tender->name;

        $tab=Payment::find($id);
        $tab->receipt_number=$request->receipt_number;
        $tab->pin=$request->pin;
        $tab->payment_date=$request->payment_date;
        $tab->member_name=$request->member_name;
        $tab->month_fee_for=$request->month_fee_for;
        $tab->month_fee=$request->month_fee;
        $tab->payment_method_id=$request->payment_method_id;
        $tab->payment_method_name=$tenderName;
        $tab->in_word=$request->in_word;
        $tab->save();

        return redirect(url('payment/report'))->with('status','Payment receipt updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}

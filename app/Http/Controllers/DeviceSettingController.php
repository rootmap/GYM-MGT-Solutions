<?php

namespace App\Http\Controllers;

use App\DeviceSetting;
use Illuminate\Http\Request;

use TADPHP\TADFactory;
use TADPHP\TAD;

class DeviceSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function loadTodayAttendace(){

      $dataTable=DeviceSetting::find(1);
                  //die();
        $deviceReady=0;
        if($dataTable->device_status=="Ready")
        {
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
                  
                 // $all_user_info = $tad->get_all_user_info()->to_array();

                
                  
                  
                  //$dt = array(1);
                  $dt = $tad->get_date()->to_array();

                  //dd($dt);

                  if(count($dt)==0){
                        $dataTable->device_status="Not Ready";
                        $dataTable->save();
                  }
                  else
                  {

                        $deviceReady=1;
                        $logs = $tad->get_att_log();
                        $filtered_att_logs = $logs->filter_by_date(
                            ['start' =>date('Y-m-d'),'end' =>date('Y-m-d',strtotime('+1 Day'))]
                        )->to_array();


                        if(count($filtered_att_logs['Row'])>0){
                            foreach ($filtered_att_logs['Row'] as $row) {

                                //dd($row);

                                $pin=""; if(!empty($row['PIN'])){ $pin=$row['PIN']; }
                                $datetime=""; if(!empty($row['DateTime'])){ $datetime=$row['DateTime']; }
                                $verified=""; if(!empty($row['Verified'])){ $verified=$row['Verified']; }
                                $status=""; if(!empty($row['Status'])){ $status=$row['Status']; }
                                $workcode=""; if(!empty($row['WorkCode'])){ $workcode=$row['WorkCode']; }


                                $checkAtt=\DB::table('raw_attendances')->where('pin',$pin)->where('datetime',$datetime)->count();

                                if($checkAtt==0)
                                {

                                    $array=array(
                                        'pin'=>$pin,
                                        'datetime'=>$datetime,
                                        'verified'=>$verified,
                                        'status'=>$status,
                                        'workcode'=>$workcode
                                    );

                                    \DB::table('raw_attendances')->insert($array);


                                    //FInal Attendance Table

                                    $attendanceDate=date('Y-m-d',strtotime($datetime));
                                    $attendanceInOut=date('H:i:s',strtotime($datetime));

                                    $checkExIntime=\DB::table('attendances')->where('date',$attendanceDate)->where('pin',$pin)->count();
                                    if($checkExIntime==0){
                                        $atuser=\DB::table('attendance_users')->where('pin',$pin)->first();
                                        $array=array(
                                            'pin'=>$pin,
                                            'name'=>$atuser->name,
                                            'date'=>$attendanceDate,
                                            'in_time'=>date('H:i:s',strtotime($datetime))
                                        );

                                        \DB::table('attendances')->insert($array);
                                    }
                                    else
                                    {
                                        $array=array(
                                            'out_time'=>date('H:i:s',strtotime($datetime))
                                        );

                                        \DB::table('attendances')->where('pin',$pin)->where('date',$attendanceDate)->update($array);
                                    }

                                    //end final attendance
                                }
                                
                            }
                        }
                        

                        //dd($filtered_att_logs);
                  }
        }

        if($dataTable->device_two_status=="Ready")
        {
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
                  
                  //$all_user_info = $tad->get_all_user_info()->to_array();

                
                  
                  
                  //$dt = array(1);
                  $dt = $tad->get_date()->to_array();
                  if(count($dt)==0){
                        $dataTable->device_status="Not Ready";
                        $dataTable->save();
                  }
                  else
                  {
                        $deviceReady=1;
                        $logs = $tad->get_att_log();
                        $filtered_att_logs = $logs->filter_by_date(
                            ['start' =>date('Y-m-d'),'end' =>date('Y-m-d',strtotime('+1 Day'))]
                        )->to_array();


                        if(count($filtered_att_logs['Row'])>0){
                            foreach ($filtered_att_logs['Row'] as $row) {

                                //dd($row);

                                $pin=""; if(!empty($row['PIN'])){ $pin=$row['PIN']; }
                                $datetime=""; if(!empty($row['DateTime'])){ $datetime=$row['DateTime']; }
                                $verified=""; if(!empty($row['Verified'])){ $verified=$row['Verified']; }
                                $status=""; if(!empty($row['Status'])){ $status=$row['Status']; }
                                $workcode=""; if(!empty($row['WorkCode'])){ $workcode=$row['WorkCode']; }


                                $checkAtt=\DB::table('raw_attendances')->where('pin',$pin)->where('datetime',$datetime)->count();

                                if($checkAtt==0)
                                {

                                    $array=array(
                                        'pin'=>$pin,
                                        'datetime'=>$datetime,
                                        'verified'=>$verified,
                                        'status'=>$status,
                                        'workcode'=>$workcode
                                    );

                                    \DB::table('raw_attendances')->insert($array);


                                    //FInal Attendance Table

                                    $attendanceDate=date('Y-m-d',strtotime($datetime));
                                    $attendanceInOut=date('H:i:s',strtotime($datetime));

                                    $checkExIntime=\DB::table('attendances')->where('date',$attendanceDate)->where('pin',$pin)->count();
                                    if($checkExIntime==0){
                                        $atuser=\DB::table('attendance_users')->where('pin',$pin)->first();
                                        $array=array(
                                            'pin'=>$pin,
                                            'name'=>$atuser->name,
                                            'date'=>$attendanceDate,
                                            'in_time'=>date('H:i:s',strtotime($datetime))
                                        );

                                        \DB::table('attendances')->insert($array);
                                    }
                                    else
                                    {
                                        $array=array(
                                            'out_time'=>date('H:i:s',strtotime($datetime))
                                        );

                                        \DB::table('attendances')->where('pin',$pin)->where('date',$attendanceDate)->update($array);
                                    }

                                    //end final attendance
                                }
                                
                            }
                        }
                        

                        //dd($filtered_att_logs);
                  }
        }

        return response()->json($deviceReady);
    }

    public function getAttendance(){
        $dataTable=DeviceSetting::find(1);
                  //die();
        if($dataTable->device_status=="Not Ready"){
                   /* $options = [
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
                  
                  $all_user_info = $tad->get_all_user_info()->to_array();*/

                  $all_user_info=["Row" =>[
                                    0 =>[
                                      "PIN" => "1",
                                      "Name" => [],
                                      "Password" => [],
                                      "Group" => "1",
                                      "Privilege" => "0",
                                      "Card" => "0",
                                      "PIN2" => "1",
                                      "TZ1" => "0",
                                      "TZ2" => "1",
                                      "TZ3" => "0",
                                    ],
                                    1 =>[
                                      "PIN" => "2",
                                      "Name" => [],
                                      "Password" => [],
                                      "Group" => "1",
                                      "Privilege" => "0",
                                      "Card" => "0",
                                      "PIN2" => "2",
                                      "TZ1" => "0",
                                      "TZ2" => "1",
                                      "TZ3" => "0",
                                    ],
                                    2 =>[
                                      "PIN" => "3",
                                      "Name" => "MD MAHAMUDUR ZAMAN BHUYA",
                                      "Password" => [],
                                      "Group" => "1",
                                      "Privilege" => "14",
                                      "Card" => "0",
                                      "PIN2" => "118",
                                      "TZ1" => "0",
                                      "TZ2" => "1",
                                      "TZ3" => "0",
                                    ],
                                    3 =>[
                                      "PIN" => "19",
                                      "Name" => "Serijum Moneria",
                                      "Password" => "0",
                                      "Group" => "1",
                                      "Privilege" => "0",
                                      "Card" => "0",
                                      "PIN2" => "119",
                                      "TZ1" => "0",
                                      "TZ2" => "0",
                                      "TZ3" => "0"
                                    ]
                                  ]
                                ];

                    dd($all_user_info);

                  if(count($all_user_info['Row'])>0){
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
                                }
                                
                        }
                  }

                  
                  
                  //$dt = array(1);
                  $dt = $tad->get_date()->to_array();
                  if(count($dt)==0){
                        $dataTable->device_status="Not Ready";
                        $dataTable->save();
                  }
                  else
                  {
                        $logs = $tad->get_att_log();
                        $filtered_att_logs = $logs->filter_by_date(
                            ['start' =>date('Y-m-d'),'end' =>date('Y-m-d',strtotime('+1 Day'))]
                        )->to_array();

                        //dd($filtered_att_logs);


                        /*$filtered_att_logs=["Row" =>[
                            0 =>[
                              "PIN" => "118",
                              "DateTime" =>'2020-01-04 04:26:20',
                              "Verified" =>1,
                              "Status" =>0,
                              "WorkCode" =>0
                            ],
                            1 =>[
                              "PIN" => "118",
                              "DateTime" =>'2020-01-04 21:58:06',
                              "Verified" =>1,
                              "Status" =>0,
                              "WorkCode" =>0
                            ],
                            2 =>[
                               "PIN" => "118",
                              "DateTime" =>'2020-01-05 00:58:30',
                              "Verified" =>1,
                              "Status" =>0,
                              "WorkCode" =>0
                            ],
                            3 =>[
                               "PIN" => "118",
                              "DateTime" =>'2020-01-05 03:23:12',
                              "Verified" =>1,
                              "Status" =>0,
                              "WorkCode" =>0
                            ]
                          ]
                        ];*/

                        //dd($filtered_att_logs);

                        if(count($filtered_att_logs['Row'])>0){
                            foreach ($filtered_att_logs['Row'] as $row) {

                                //dd($row);

                                $pin=""; if(!empty($row['PIN'])){ $pin=$row['PIN']; }
                                $datetime=""; if(!empty($row['DateTime'])){ $datetime=$row['DateTime']; }
                                $verified=""; if(!empty($row['Verified'])){ $verified=$row['Verified']; }
                                $status=""; if(!empty($row['Status'])){ $status=$row['Status']; }
                                $workcode=""; if(!empty($row['WorkCode'])){ $workcode=$row['WorkCode']; }

                                
                                


                                $checkAtt=\DB::table('raw_attendances')->where('pin',$row['PIN'])->where('datetime',$row['DateTime'])->count();

                                if($checkAtt==0)
                                {

                                    $pin=""; if(!empty($row['PIN'])){ $pin=$row['PIN']; }
                                    $datetime=""; if(!empty($row['DateTime'])){ $datetime=$row['DateTime']; }
                                    $verified=""; if(!empty($row['Verified'])){ $verified=$row['Verified']; }
                                    $status=""; if(!empty($row['Status'])){ $status=$row['Status']; }
                                    $workcode=""; if(!empty($row['WorkCode'])){ $workcode=$row['WorkCode']; }

                                    $array=array(
                                        'pin'=>$pin,
                                        'datetime'=>$datetime,
                                        'verified'=>$verified,
                                        'status'=>$status,
                                        'workcode'=>$workcode
                                    );

                                    \DB::table('raw_attendances')->insert($array);


                                    //FInal Attendance Table

                                    $attendanceDate=date('Y-m-d',strtotime($datetime));
                                    $attendanceInOut=date('H:i:s',strtotime($datetime));

                                    $checkExIntime=\DB::table('attendances')->where('date',$attendanceDate)->where('pin',$pin)->count();
                                    if($checkExIntime==0){
                                        $atuser=\DB::table('attendance_users')->where('pin',$pin)->first();
                                        $array=array(
                                            'pin'=>$pin,
                                            'name'=>$atuser->name,
                                            'date'=>$attendanceDate,
                                            'in_time'=>date('H:i:s',strtotime($datetime))
                                        );

                                        \DB::table('attendances')->insert($array);
                                    }
                                    else
                                    {
                                        $array=array(
                                            'out_time'=>date('H:i:s',strtotime($datetime))
                                        );

                                        \DB::table('attendances')->where('pin',$pin)->where('date',$attendanceDate)->update($array);
                                    }

                                    //end final attendance
                                }
                                else{
                                    echo "Already Exists <br>";
                                }
                                
                            }
                        }
                        

                        //dd($filtered_att_logs);
                  }
        }
    }

    public function index($ip='')
    {

        $options = [
            'ip' => $ip,   // '169.254.0.1' by default (totally useless!!!).
            'internal_id' => 1,    // 1 by default.
            'com_key' => 0,        // 0 by default.
            'description' => 'TAD1', // 'N/A' by default.
            'soap_port' => 80,     // 80 by default,
            'udp_port' => 4370,      // 4370 by default.
            'encoding' => 'iso8859-1'    // iso8859-1 by default.
          ];
          
          $tad_factory = new TADFactory($options);
          $tad = $tad_factory->get_instance(); 
          


          
          $dt = $tad->get_date()->to_array();
          if(count($dt)==0){
                echo 2;
          }
          else
          {
                echo 1;
          }
    }


    public function checknUpdateDevice()
    {

        $dataTable=DeviceSetting::find(1);


        $options = [
            'ip' => $dataTable->device_ip,   // '169.254.0.1' by default (totally useless!!!).
            'internal_id' => 1,    // 1 by default.
            'com_key' => 0,        // 0 by default.
            'description' => 'TAD1', // 'N/A' by default.
            'soap_port' => 80,     // 80 by default,
            'udp_port' => 4370,      // 4370 by default.
            'encoding' => 'iso8859-1'    // iso8859-1 by default.
          ];
          
          $tad_factory = new TADFactory($options);
          $tad = $tad_factory->get_instance(); 
          


          
          $dt = $tad->get_date()->to_array();
          if(count($dt)==0){
                $dataTable->device_status="Not Ready";
                $dataTable->save();
          }

          $options = [
            'ip' => $dataTable->device_ip_two,   // '169.254.0.1' by default (totally useless!!!).
            'internal_id' => 1,    // 1 by default.
            'com_key' => 0,        // 0 by default.
            'description' => 'TAD1', // 'N/A' by default.
            'soap_port' => 80,     // 80 by default,
            'udp_port' => 4370,      // 4370 by default.
            'encoding' => 'iso8859-1'    // iso8859-1 by default.
          ];
          
          $tads_factory = new TADFactory($options);
          $tads = $tads_factory->get_instance(); 
          


          
          $dts = $tads->get_date()->to_array();
          if(count($dts)==0){
                $dataTable->device_two_status="Not Ready";
                $dataTable->save();
          }


          return response()->json(1);
    }


    



    public function deviceIP(){

        ini_set('max_execution_time', '0'); // for infinite time of execution 

        $myIp = getHostByName(getHostName());

       // dd($myIp);

        $genarateIPRange=explode(".",$myIp);

        $ipRangePartial=$genarateIPRange[0].".".$genarateIPRange[1].".".$genarateIPRange[2];



        $getTableIP=array();

        for($i=2; $i<=130; $i++){

             $iptable=$ipRangePartial.".".$i;

            if($iptable!=$myIp){
                if (count($getTableIP)==1) {
                    break;    /* You could also write 'break 1;' here. */
                }

               

                $curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => url('get/device/ip/'.$iptable),
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING =>'',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT =>2,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                  CURLOPT_HTTPHEADER => array(
                    "Content-Type: multipart/form-data; boundary=--------------------------584976640080042176705972"
                  ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                if($response==1){

                    array_push($getTableIP, $iptable);
                }

                //echo $response;
            }

            


        }

        if(count($getTableIP)>0){
            
            if(count($getTableIP)==1)
            {
                $dataTable=DeviceSetting::find(1);
                $dataTable->device_ip=$getTableIP[0];
                $dataTable->device_status="Ready";
                $dataTable->save();
            }

            if(count($getTableIP)==2)
            {
                $dataTable=DeviceSetting::find(1);
                $dataTable->device_ip=$getTableIP[0];
                $dataTable->device_status="Ready";
                $dataTable->device_ip_two=$getTableIP[1];
                $dataTable->device_two_status="Ready";
                $dataTable->save();
            }

            return redirect(url('device/settings'))->with('status','Available Device Configured Successfully.');
        }
        else
        {
            return redirect(url('device/settings'))->with('error','No Device Found.');
        }

        

        //echo $ipRangePartial;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dataTable=DeviceSetting::find(1);
        return view('apps.pages.device.device',['edit'=>$dataTable]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'device_ip'=>'required',
            'device_ip_two'=>'required',
        ]);

        $tab=new DeviceSetting();
        $tab->device_ip=$request->device_ip;
        $tab->device_ip_two=$request->device_ip_two;
        $tab->save();

        return redirect(url('device/settings'))->with('status','GYM Package saved successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DeviceSetting  $deviceSetting
     * @return \Illuminate\Http\Response
     */
    public function show(DeviceSetting $deviceSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DeviceSetting  $deviceSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(DeviceSetting $deviceSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DeviceSetting  $deviceSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=0)
    {
        $this->validate($request,[
            'device_ip'=>'required',
            'device_ip_two'=>'required',
        ]);

        $tab=DeviceSetting::find($id);
        $tab->device_ip=$request->device_ip;
        $tab->device_ip_two=$request->device_ip_two;
        $tab->save();

        return redirect(url('device/settings'))->with('status','GYM Package saved successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DeviceSetting  $deviceSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeviceSetting $deviceSetting)
    {
        //
    }
}

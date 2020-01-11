<?php

namespace App\Http\Controllers;

use App\RetailPosSummary;
use App\RetailPosSummaryDateWise;
use App\Product;
use App\LoginActivity;
use App\CashierPunch;
use Illuminate\Http\Request;
use Auth;
class RetailPosSummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $moduleName="Product";
    private $sdc;
    public function __construct(){ $this->sdc = new StaticDataController(); }


    public function index(RetailPosSummary $dashboard)
    {


            if(\Auth::check()){

            if(count($this->sdc->dataMenuAssigned())==0)
            {
                return redirect('login')->with(Auth::logout());
            }

            
            //print_r($dash); die();
            $Todaydate=date('Y-m-d');
            
            
            $tabToday=\DB::table('today_summary')->first();
           

            $product=\DB::table('package')->get();
            $payment_due=\DB::table('payment_due')->get();

            return view('apps.pages.dashboard.index',[
                'dash'=>$tabToday,
                'product'=>$product,
                'payment_due'=>$payment_due
            ]);

        }
        else
        {
            return redirect(url('login'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */




    public function todaypunch()
    {
        $CashierPunch=\DB::table('raw_attendances')
                         ->leftjoin('customers','raw_attendances.pin','=','customers.pin')
                         ->select('raw_attendances.id',
                                  'raw_attendances.pin',
                                  'raw_attendances.datetime',
                                   'customers.name')
                                    ->orderBy('id','DESC')
                                    ->limit(1000)
                                    ->get();

        return response()->json($CashierPunch);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RetailPosSummary  $retailPosSummary
     * @return \Illuminate\Http\Response
     */
    public function show(RetailPosSummary $retailPosSummary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RetailPosSummary  $retailPosSummary
     * @return \Illuminate\Http\Response
     */
    public function edit(RetailPosSummary $retailPosSummary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RetailPosSummary  $retailPosSummary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RetailPosSummary $retailPosSummary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RetailPosSummary  $retailPosSummary
     * @return \Illuminate\Http\Response
     */
    public function destroy(RetailPosSummary $retailPosSummary)
    {
        //
    }
}

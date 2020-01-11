<?php

namespace App\Http\Controllers;

use App\GymPackage;
use Illuminate\Http\Request;

class GymPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="GYM Package ";
    private $sdc;
    public function __construct(){ $this->sdc = new StaticDataController(); }


    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dataTable=GymPackage::all();
        //dd($dataTable);
        return view('apps.pages.package.package',['dataTable'=>$dataTable]);
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
            'name'=>'required',
            'month_id'=>'required'
        ]);

        $admission_required=$request->admission_required?1:0;

        $tab=new GymPackage();
        $tab->name=$request->name;
        $tab->month_id=$request->month_id;
        $tab->admission_required=$admission_required;
        $tab->fee=$request->fee;
        $tab->store_id=$this->sdc->storeID();
        $tab->created_by=$this->sdc->UserID();
        $tab->save();

        return redirect(url('gym/package'))->with('status','GYM Package saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GymPackage  $gymPackage
     * @return \Illuminate\Http\Response
     */
    public function show($id=0)
    {
        $edit=GymPackage::find($id);
        $dataTable=GymPackage::all();
        return view('apps.pages.package.package',['edit'=>$edit,'dataTable'=>$dataTable]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GymPackage  $gymPackage
     * @return \Illuminate\Http\Response
     */
    public function edit(GymPackage $gymPackage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GymPackage  $gymPackage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id=0)
    {
        $this->validate($request,[
            'name'=>'required',
            'month_id'=>'required'
        ]);

        $admission_required=$request->admission_required?1:0;

        $tab=GymPackage::find($id);
        $tab->name=$request->name;
        $tab->month_id=$request->month_id;
        $tab->admission_required=$admission_required;
        $tab->fee=$request->fee;
        $tab->updated_by=$this->sdc->UserID();
        $tab->save();

        return redirect(url('gym/package'))->with('status','GYM Package updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GymPackage  $gymPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=0)
    {
        $tab=GymPackage::find($id);
        $tab->delete();
        $this->sdc->log("Package","Package deleted");
        return redirect(url('gym/package'))->with('status', $this->moduleName.' Deleted Successfully !');
    }
}

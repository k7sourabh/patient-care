<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Medicine,Company,MedicineStockModel};
use Illuminate\Support\Facades\Validator;

class MedicineStockManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $userType = auth()->user()->role()->first()->name;
        
        $addUrl = (strtolower($userType)).'.medicine-stock-management.create';
        $breadcrumbs = [
            ['link' => "modern", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => __('locale.medicine-stock')], ['name' => __('locale.medicine-stock').' '.__('locale.List')]];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true];
        $pageTitle = __('locale.medicine-stock');

        // if($userType!=config('custom.superadminrole')){
        //     $addUrl = 'medicine-stock-management.create';
        // }
        

        return view('pages.medicine-stock-management.list',compact('breadcrumbs','pageConfigs','pageTitle','addUrl','userType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userType = auth()->user()->role()->first()->name;
        $formUrl = 'superadmin.medicine-stock-management.store';
        $addUrl = (strtolower($userType)).'.medicine-stock-management.create';
        $breadcrumbs = [
            ['link' => "modern", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => __('locale.medicine-stock')], ['name' => __('locale.medicine-stock').' '.__('locale.List')]];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true];
        $pageTitle = __('locale.medicine-stock');

        $medicine_result = Medicine::get();
        $getmedicine_ajax = 'superadmin.getMedicine';
        if($userType!=config('custom.superadminrole')){
            //     $addUrl = 'medicine-stock-management.create';
            $company_id = Helper::loginUserCompanyId();
            $medicine_result = $medicine_result->where('company',$company_id);
        }
        $companies = Company::get(["company_name", "id","company_code"]);
        // dd($medicine_result);
        $purchase_issue = config('custom.purchase_issue');
        // echo"<pre>"; print_r($purchase_issue); die;

        return view('pages.medicine-stock-management.create',compact('breadcrumbs','pageConfigs','pageTitle','addUrl','userType','purchase_issue','medicine_result','companies','getmedicine_ajax','formUrl'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'medicine_id' => 'required',
            'quantity' => 'required',
            'dates' => 'required',
            'purchase_issue_type' => 'required',
       ]);
        
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }

        $medicine = MedicineStockModel::create($request->all());
      
        if(auth()->user()->role()->first()->name=="superadmin")
        {
            $backUrl='superadmin.medicine-stock-management.list';
        }
        // if(auth()->user()->role()->first()->name=="Admin")
        // {
        //     $backUrl='admin-medicine-list';
        // }
        // if(auth()->user()->role()->first()->name=="Manager")
        // {
        //     $backUrl='manager-medicine-list';
        // }
        
        return redirect()->route($backUrl)->with('success',__('locale.created_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getMedicine(Request $request)
    {
        $data['medicine'] = Medicine::where("company",$request->id)->get(["medicine_name", "id"]);
        // echo"<pre>"; print_r($data); die;
        return response()->json($data);
    }
}

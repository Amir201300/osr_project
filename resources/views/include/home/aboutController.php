<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Data;
use App\Contact_us;
use App\privacy;
use Illuminate\Http\Request;
use Auth;

class aboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Data = Data::get();
        if ($Data->all() == null) {
            $checkd = 1;
        } else {
            $checkd = 0;
        }
        return view('dashboard.adout', compact('Data', 'checkd'));
    }
    public function indexprivacy()
    {
        $Data = privacy::get();
        if ($Data->all() == null) {
            $checkd = 1;
        } else {
            $checkd = 0;
        }
        return view('dashboard.privacy', compact('Data', 'checkd'));
    }
    public function indexContact()
    {
        $contact = Contact_us::orderBy('created_at','DESC')->paginate(10);
        if ($contact->all() == null) {
            $checkd = 1;
        } else {
            $checkd = 0;
        }
        return view('dashboard.contactus', compact('contact', 'checkd'));
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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'titleAR' => 'required',
            'desc' => 'required',
            'descar' => 'required',
            'logo' => 'mimes:jpg,jpeg,png,bmp',
            'image' => 'mimes:jpg,jpeg,png,bmp',
        ]);
        $service = new Service();
        $service->title = $request->title;
        $service->desc = $request->desc;
        $service->title_ar = $request->titleAR;
        $service->desc_ar = $request->descar;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . rand(11111, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/services'), $fileName);
            $service->image = $fileName;
        }
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = time() . rand(11111, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/services/logos'), $fileName);
            $service->icon = $fileName;
        }
        $service->save();
        alert()->success('Your Add New Service', 'Done');
        return redirect()->back();
    }

    public function details($id)
    {
        //
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function UpdateInstruc(Request $request)
    {

        $instru = Data::find(1);
        $instru->instructions = $request->instructions;
        $instru->update();
        alert()->success('Your instructions Updated', 'Done');
        return redirect()->back();
    }
    public function UpdateAbout(Request $request)
    {

        $instru = Data::find(1);
        $instru->about_us = $request->about;
        $instru->update();
        alert()->success('Your About Us Updated', 'Done');
        return redirect()->back();
    }
    public function Updatepriv(Request $request)
    {
        $instru = privacy::find(1);
        $instru->text = $request->text;
        $instru->update();
        alert()->success('Your Privacy Updated', 'Done');
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Service::find($id)->delete();
        alert()->success('Your Delete Has Been Done', 'Done');
        return redirect()->back();
    }

    public function login(Request $request){


        $credentials = [

            'email' => $request['email'],

            'password' => $request['password'],

        ];

        if (Auth::attempt($credentials)) {


            return 1;
            }

        return 2;

       }
}

<?php

namespace App\Http\Controllers\Manage;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator, Auth;
use App\Models\Jobs;

class JobsController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $cities = City::all();
        return view('manage.Jobs.index',compact('cities'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function view(Request $request)
    {
        $Jobs = Jobs::orderBY('created_at', 'desc')->get();
        return $this->dataFunction($Jobs);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|min:3',
                'image' => 'required',
                'job_type' => 'required',
                'city_id' => 'exists:cities,id',
            ],
            [
                'name.required' => 'من فضلك ادخل اسم الوظيفه',
                'image.required' => 'من فضلك ادخل صوره للوظيفه',
                'name.min' => 'يجب ان لا يقل عدد حروف اسم الوظيفه عن ثلاثة احرف',
                'job_type.required' => 'من فضلك ادخل نوع الوظيفه',
                'city_id.exists' => 'المحافظه المدخله غير موجوده',
            ]

        );

        $Jobs = new Jobs();
        $Jobs->name = $request->name;
        $Jobs->image = saveImage('Jobs',$request->image);
        $Jobs->link = $request->link;
        $Jobs->desc = $request->desc;
        $Jobs->job_type = $request->job_type;
        $Jobs->email = $request->email;
        $Jobs->phone = $request->phone;
        $Jobs->salary = $request->salary;
        $Jobs->city_id = $request->city_id;
        $Jobs->save();
        return response()->json(['errors' => false]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $Jobs = Jobs::find($id);
        if (is_null($Jobs)) {
            return BaseController::Error('Product not exist', 'الكلمة الدلالية غير موجودة');
        }

        return $Jobs;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $Jobs = Jobs::find($request->id);
        if (is_null($Jobs)) {
            return response()->json(['errors' => true]);
        }
        $this->validate(
            $request,
            [
                'name' => 'required|min:3',
                'job_type' => 'required',
                'city_id' => 'exists:cities,id',
            ],
            [
                'name.required' => 'من فضلك ادخل اسم الوظيفه الجديد',
                'name.min' => 'يجب ان لا يقل عدد حروف اسم الوظيفه عن ثلاثة احرف',
                'job_type.required' => 'من فضلك ادخل نوع الوظيفه الجديد',
                'city_id.exists' => 'المحافظه المدخله غير موجوده',
            ]

        );
        $Jobs->name = $request->name;
        $Jobs->link = $request->link;
        $Jobs->desc = $request->desc;
        $Jobs->job_type = $request->job_type;
        $Jobs->email = $request->email;
        $Jobs->phone = $request->phone;
        $Jobs->salary = $request->salary;
        $Jobs->city_id = $request->city_id;
        if($request->image){
            deleteFile('Jobs',$Jobs->image);
            $Jobs->image=saveImage('Jobs',$request->image);
        }
        $Jobs->save();

        return response()->json(['errors' => false]);

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function delete(Request $request, $id)
    {
        if ($request->type == 2) {
            $ids = explode(',', $id);
            $Ads = Jobs::whereIn('id', $ids)->delete();
        } else {
            $Ads = Jobs::find($id);
            if (is_null($Ads)) {
                return 5;
            }
            $Ads->delete();
        }
        return response()->json(['errors' => false]);

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getImage($id)
    {
        $type = 2;
        $array = Ads::find($id);
        return view('manage.Images.index', compact('array', 'type'));
    }


    private function dataFunction($data)
    {
        return Datatables::of($data)->addColumn('action', function ($data) {
            $options = '<td class="sorting_1"><button  class="btn btn-info waves-effect btn-circle waves-light" onclick="edit(' . $data->id . ')" type="button" ><i class="fa fa-spinner fa-spin" id="loadEdit_' . $data->id . '" style="display:none"></i><i class="fas fa-edit"></i></button>';
            $options .= '<button type="button" onclick="deleteFunction(' . $data->id . ',1)" class="btn btn-danger waves-effect btn-circle waves-light"><i class=" fas fa-trash"></i> </button></td>';
            return $options;
        })->addColumn('checkBox', function ($data) {
            $checkBox = '<td class="sorting_1">' .
                '<div class="custom-control custom-checkbox">' .
                '<input type="checkbox" class="mybox" id="checkBox_' . $data->id . '" onclick="check(' . $data->id . ')">' .
                '</div></td>';
            return $checkBox;
        })->editColumn('image',function($data){
            $image='<a href="/images/Jobs/'.$data->image.'" target="_blank">'.
                '<img src="/images/Jobs/'.$data->image.'" width="50" height="50"></a>';
            return $image;
        })->editColumn('link',function($data){
            $image='<a href="'.$data->link.'" target="_blank">اضغط هنا</a>';
            return $image;
        })->editColumn('city_id',function($data){
            return $data->city->name;
        })->editColumn('user_id',function($data){
            return $data->user ? $data->user->name : 'من قبل الادارة';
        })->editColumn('job_type',function ($data){
            if($data->job_type == 1)
                return 'دوام كلي';
            if($data->job_type == 2)
                return 'دوام جزئي';
            if($data->job_type == 3)
                return 'تدريب';
            if($data->job_type == 4)
                return 'تطوع';
        })->rawColumns(['action' => 'action', 'checkBox' => 'checkBox','link'=>'link','city_id'=>'city_id','user_id'=>'user_id','job_type'=>'job_type','image'=>'image'])->make(true);

    }
}

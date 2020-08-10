<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator, Auth;
use App\Models\Packages;

class PackagesController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('manage.Packages.index');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function view(Request $request)
    {
        $Packages = Packages::orderBY('created_at', 'desc')->get();
        return $this->dataFunction($Packages);
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
                'period' => 'required',
                'price' => 'required',
            ],
            [
                'name.required' => 'من فضلك ادخل اسم الباقه',
                'name.min' => 'يجب ان لا يقل عدد حروف اسم الوظيفه عن ثلاثة احرف',
                'period.required' => 'من فضلك ادخل مده الباقه',
                'price.required' => 'من فضلك ادخل سعر الباقه',
            ]

        );

        $Packages = new Packages();
        $Packages->name = $request->name;
        $Packages->desc = $request->desc;
        $Packages->period_type = $request->period_type;
        $Packages->price = $request->price;
        $Packages->period = $request->period;
        $Packages->image = saveImage('Packages',$request->image);
        $Packages->save();
        return response()->json(['errors' => false]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $Packages = Packages::find($id);
        if (is_null($Packages)) {
            return BaseController::Error('Product does not exist', 'الكلمة الدلالية غير موجودة');
        }

        return $Packages;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $Packages = Packages::find($request->id);
        if (is_null($Packages)) {
            return response()->json(['errors' => true]);
        }
        $this->validate(
            $request,
            [
                'name' => 'required|min:3',
                'period' => 'required',
                'price' => 'required',
            ],
            [
                'name.required' => 'من فضلك ادخل اسم الباقه الجديد',
                'name.min' => 'يجب ان لا يقل عدد حروف اسم الوظيفه عن ثلاثة احرف',
                'period.required' => 'من فضلك ادخل مده الباقه الجديده',
                'price.required' => 'من فضلك ادخل سعر الباقه الجديد',
            ]

        );
        $Packages->name = $request->name;
        $Packages->desc = $request->desc;
        $Packages->period_type = $request->period_type;
        $Packages->price = $request->price;
        $Packages->period = $request->period;
        if($request->image){
            deleteFile('Packages',$Packages->image);
            $Packages->image=saveImage('Packages',$request->image);
        }
        $Packages->save();

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
            $Ads = Packages::whereIn('id', $ids)->delete();
        } else {
            $Ads = Packages::find($id);
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
                $image='<a href="/images/Packages/'.$data->image.'" target="_blank">'.
                    '<img src="/images/Packages/'.$data->image.'" width="50" height="50"></a>';
                return $image;
        })->editColumn('period_type',function ($data){
            if($data->period_type == 1)
                return 'ايام';
            if($data->period_type == 2)
                return 'شهور';
            if($data->period_type == 3)
                return 'سنين';
        })->rawColumns(['action' => 'action', 'checkBox' => 'checkBox','period_type'=>'period_type','image'=>'image'])->make(true);

    }
}

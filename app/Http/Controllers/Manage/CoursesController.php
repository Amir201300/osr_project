<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator, Auth;
use App\Models\Cources;

class CoursesController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $courses = Cources::all();
        return view('manage.Courses.index',compact('courses'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function view(Request $request)
    {
        $courses = Cources::orderBY('created_at', 'desc')->get();
        return $this->dataFunction($courses);
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
                'link' => 'required',
            ],
            [
                'name.required' => 'من فضلك ادخل اسم الكورس',
                'link.required' => 'من فضلك ادخل رابط الكورس للوظيفه',
                'name.min' => 'يجب ان لا يقل عدد حروف اسم الكورس عن ثلاثة احرف',
            ]

        );

        $courses = new Cources();
        $courses->name = $request->name;
        $courses->link = $request->link;
        $courses->save();
        return response()->json(['errors' => false]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $courses = Cources::find($id);
        if (is_null($courses)) {
            return BaseController::Error('Product not exist', 'الكلمة الدلالية غير موجودة');
        }

        return $courses;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $courses = Cources::find($request->id);
        if (is_null($courses)) {
            return response()->json(['errors' => true]);
        }
        $this->validate(
            $request,
            [
                'name' => 'required|min:3',
                'link' => 'required',

            ],
            [
                'name.required' => 'من فضلك ادخل اسم الكورس الجديد',
                'name.min' => 'يجب ان لا يقل عدد حروف اسم الكورس عن ثلاثة احرف',
                'link.required' => 'من فضلك ادخل رابط الكورس الجديد',
                ]

        );
        $courses->name = $request->name;
        $courses->link = $request->link;
        $courses->save();

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
            $Ads = Cources::whereIn('id', $ids)->delete();
        } else {
            $Ads = Cources::find($id);
            if (is_null($Ads)) {
                return 5;
            }
            $Ads->delete();
        }
        return response()->json(['errors' => false]);

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

        })->editColumn('link',function($data){
            $link='<a href="'.$data->link.'" target="_blank">اضغط هنا</a>';
            return $link;

        })->rawColumns(['action' => 'action', 'checkBox' => 'checkBox','link'=>'link'])->make(true);

    }
}

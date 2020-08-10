<?php


namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator, Auth;
use App\Models\Slider;

class SliderController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('manage.Slider.index');
    }

    //View Function
    public function view(Request $request)
    {
        $Slider = Slider::orderBY('created_at', 'desc')->get();
        return $this->dataFunction($Slider);
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
                'link' => 'required',
                'image' => 'required'
            ],
            [
                'link.required' => 'من فضلك ادخل رابط الاعلان',
                'image.required' => 'من فضلك صوره للقسم',
            ]

        );
        $Slider = new Slider;
        $Slider->status = $request->status;
        $Slider->link = $request->link;
        $Slider->expire_date = $request->expire_date;
        $Slider->start_date = $request->start_date;
        $Slider->order = $request->order;
        $Slider->image=saveImage('Slider',$request->image);
        $Slider->save();
        return response()->json(['errors' => false]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $Slider = Slider::find($id);
        if (is_null($Slider)) {
            return BaseController::Error('Product not exist', 'الكلمة الدلالية غير موجودة');
        }

        return $Slider;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $Slider = Slider::find($request->id);
        if (is_null($Slider)) {
            return response()->json(['errors' => true]);
        }
        $this->validate(
            $request,
            [
                'link' => 'required',
            ],
            [
                'link.required' => 'من فضلك ادخل رابط الاعلان',
            ]

        );
        $Slider->status = $request->status;
        $Slider->link = $request->link;
        $Slider->expire_date = $request->expire_date;
        $Slider->start_date = $request->start_date;
        $Slider->order = $request->order;
        if($request->image){
            deleteFile('Slider',$Slider->image);
            $Slider->image=saveImage('Slider',$request->image);
        }
        $Slider->save();

        return response()->json(['errors' => false]);

    }


    public function delete(Request $request, $id)
    {
        if ($request->type == 2) {
            $ids = explode(',', $id);
            $Ads = Slider::whereIn('id', $ids)->delete();
        } else {
            $Ads = Slider::find($id);
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
        })->editColumn('status', function ($data) {
            $status = '<button class="btn waves-effect waves-light btn-rounded btn-success statusBut">' . trans('main.Active') . '</button>';
            if ($data->status == 0)
                $status = '<button class="btn waves-effect waves-light btn-rounded btn-danger statusBut">' . trans('main.inActive') . '</button>';
            return $status;

        })->editColumn('image',function($data){
            $image='<a href="/images/Slider/'.$data->image.'" target="_blank">'.
                '<img src="/images/Slider/'.$data->image.'" width="50" height="50"></a>';
            return $image;
        })->editColumn('link',function($data){
            $image='<a href="'.$data->link.'" target="_blank">اضغط هنا</a>';
            return $image;
        })->rawColumns(['action' => 'action', 'checkBox' => 'checkBox',
            'status' => 'status', 'image' => 'image','link'=>'link'])->make(true);

    }
}

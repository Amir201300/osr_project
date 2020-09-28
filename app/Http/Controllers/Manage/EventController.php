<?php

namespace App\Http\Controllers\Manage;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator, Auth;
use App\Models\Event;

class EventController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('manage.Event.index');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function view(Request $request)
    {
        $Event = Event::orderBY('created_at', 'desc')->get();
        return $this->dataFunction($Event);
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
            ],
            [
                'name.required' => 'من فضلك ادخل اسم الايفنت',
            ]

        );

        $Event = new Event();
        $Event->name = $request->name;
        $Event->image = saveImage('Event',$request->image);
        $Event->address = $request->address;
        $Event->phone = $request->phone;
        $Event->link = $request->link;
        $Event->date = $request->date;
        $Event->desc = $request->desc;
        $Event->lat = $request->lat;
        $Event->lng = $request->lng;
        $Event->status=$request->status;
        $Event->save();
        return response()->json(['errors' => false]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $Event = Event::find($id);
        if (is_null($Event)) {
            return BaseController::Error('Product not exist', 'الكلمة الدلالية غير موجودة');
        }

        return $Event;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $Event = Event::find($request->id);
        if (is_null($Event)) {
            return response()->json(['errors' => true]);
        }
        $this->validate(
            $request,
            [
                'name' => 'required|min:3',
            ],
            [
                'name.required' => 'من فضلك ادخل اسم الايفنت الجديد',
            ]

        );
        $Event->name = $request->name;
        $Event->address = $request->address;
        $Event->phone = $request->phone;
        $Event->link = $request->link;
        $Event->date = $request->date;
        $Event->desc = $request->desc;
        $Event->lat = $request->lat;
        $Event->lng = $request->lng;
        $Event->status=$request->status;
        if($request->image){
            deleteFile('Event',$Event->image);
            $Event->image=saveImage('Event',$request->image);
        }
        $Event->save();

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
            $Ads = Event::whereIn('id', $ids)->delete();
        } else {
            $Ads = Event::find($id);
            if (is_null($Ads)) {
                return 5;
            }
            $Ads->delete();
        }
        return response()->json(['errors' => false]);

    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ChangeStatus($id,Request $request)
    {
        $Event=Event::find($id);
        $Event->status=$request->status;
        $Event->save();
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
        })->editColumn('image',function($data){
            $image='<a href="'.getImageUrl('Event',$data->image).'" target="_blank">'.
                '<img src="'.getImageUrl('Event',$data->image).'" width="50" height="50"></a>';
            return $image;
        })->editColumn('link',function($data){
            $image='<a href="'.$data->link.'" target="_blank">اضغط هنا</a>';
            return $image;
        })->editColumn('status', function ($data) {
            $status = '<button class="btn waves-effect waves-light btn-rounded btn-success statusBut" style="cursor:pointer !important" onclick="ChangeStatus(0,'.$data->id.')" title="اضغط هنا لالغاء التفعيل">'
                . trans('main.Active') .
                '</button>';
            if ($data->status == 0)
                $status = '<button class="btn waves-effect waves-light btn-rounded btn-danger statusBut" onclick="ChangeStatus(1,'.$data->id.')" style="cursor:pointer !important" title="اضغط هنا للتفعيل">' . trans('main.inActive') . '</button>';
            return $status;
        })->rawColumns(['action' => 'action', 'checkBox' => 'checkBox','link'=>'link','image'=>'image','status'=>'status'])->make(true);

    }
}

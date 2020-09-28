<?php

namespace App\Http\Controllers\Manage;

use App\Interfaces\UserInterface;
use App\Models\Area;
use App\Models\Category;
use App\Models\City;
use App\Models\store_info;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator, Auth;

class UserController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $city = City::where('status',1)->get();
        $area = Area::all();
        $user_type = $request->user_type ;
        return view('manage.User.index', compact('city','users','area','user_type'));
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function view(Request $request)
    {
        $User = User::orderBY('created_at', 'desc');
        if ($request->status != null)
            $User = $User->where('status', $request->status);
        if ($request->city_id)
            $User = $User->where('city_id', $request->city_id);
        if ($request->dataFilter) {
            if ($request->dataFilter == 1)
                $User = $User->whereDay('created_at', now());
            if ($request->dataFilter == 2)
                $User = $User->whereMonth('created_at', now());
            if ($request->dataFilter == 3)
                $User = $User->whereYear('created_at', now());
        }
        if($request->user_type){
            $User = $User->where('user_type', $request->user_type);
        }
        $User = $User->get();
        return $this->dataFunction($User);
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
                'user_type' => 'required',
                'city_id' => 'exists:cities,id',
                'area_id' => 'exists:areas,id',
                'email' => 'unique:users',
                'phone' => 'unique:users',
            ],
            [
                'name.required' => 'من فضلك ادخل اسم العضو',
                'image.required' => 'من فضلك ادخل صوره للعضو',
                'name.min' => 'يجب ان لا يقل عدد حروف اسم العضو عن ثلاثة احرف',
                'user_type.required' => 'من فضلك ادخل نوع العضو',
                'city_id.exists' => 'المحافظه المدخله غير موجوده',
                'area_id.exists' => 'المنطقه المدخله غير موجوده',
                'phone.unique' => 'رقم الهاتف مسجل باسم عضو اخر',
                'email.unique' => 'البريد الالكتروني مسجل باسم عضو اخر',

            ]

        );

        $user = new User();
        $user->name = $request->name;
        $user->image = saveImage('Users',$request->image);
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->city_id = $request->city_id;
        $user->area_id = $request->area_id;
        $user->status = $request->status;
        $user->user_type = $request->user_type;
        $user->city_id = $request->city_id;
        $user->social = 0;
        $user->save();
        return response()->json(['errors' => false]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $User = User::find($id);
        if (is_null($User)) {
            return BaseController::Error('User does not exist', 'الكلمة الدلالية غير موجودة');
        }
        $User['city_name'] = $User->city ? $User->city->name : 'لم يتم التسجيل بعد';
        $User['area_name'] = $User->area ? $User->area->name : 'لم يتم التسجيل بعد';
        return $User;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $user = User::find($request->id);
        if (is_null($user)) {
            return response()->json(['errors' => true]);
        }
        $this->validate(
            $request,
            [
                'name' => 'required|min:3',
                'user_type' => 'required',
                'city_id' => 'exists:cities,id',
                'area_id' => 'exists:areas,id',
                'email' => 'unique:users,email,' . $request->id,
                'phone' => 'unique:users,phone,' . $request->id,
            ],
            [
                'name.required' => 'من فضلك ادخل اسم العضو الجديد',
                'name.min' => 'يجب ان لا يقل عدد حروف اسم العضو عن ثلاثة احرف',
                'user_type.required' => 'من فضلك ادخل نوع العضو الجديد',
                'city_id.exists' => 'المحافظه المدخله غير موجوده',
                'area_id.exists' => 'المنطقه المدخله غير موجوده',
                'phone.unique' => 'رقم الهاتف مسجل باسم عضو اخر',
                'email.unique' => 'البريد الالكتروني مسجل باسم عضو اخر',
            ]

        );
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->city_id = $request->city_id;
        $user->area_id = $request->area_id;
        $user->status = $request->status;
        $user->user_type = $request->user_type;
        if($request->image){
            deleteFile('Users',$user->image);
            $user->image=saveImage('Users',$request->image);
        }
        $user->save();

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
            $Ads = User::whereIn('id', $ids)->delete();
        } else {
            $Ads = User::find($id);
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
        $User=User::find($id);
        $User->status=$request->status;
        $User->save();
        return response()->json(['errors' => false]);
    }

    /**
     * @param $id
     * @return array
     */
    public function storeInfo($id)
    {
        $user=User::find($id);
        if($user->user_type !=2){
            return ['status'=>2];
        }
        $data=$user->store_info;
        if(is_null($data)){
            $info=new store_info();
            $info->user_id=$user->id;
            $info->save();
        }
        return $user->store_info;

    }

    /**
     * @param Request $request
     * @return array
     */
    public function storeInfoUpdate (Request $request)
    {
        $store_info = store_info::where('user_id',$request->id)->first();
        $store_info->facebook = $request->facebook;
        $store_info->whatsapp = $request->whatsapp;
        $store_info->youtube = $request->youtube;
        $store_info->twitter = $request->twitter;
        $store_info->snap = $request->snap;
        $store_info->instagram = $request->instagram;
        $store_info->about_info = $request->about_info;
        if($request->cover_photo){
            deleteFile('Users',$store_info->cover_photo);
            $store_info->cover_photo=saveImage('Users',$request->cover_photo);
        }
        $store_info->save();
        return ['errors'=>false];
    }
    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    private function dataFunction($data)
    {
        return Datatables::of($data)->addColumn('action', function ($data) {
            $options = '<td class="sorting_1"><button  class="btn btn-info waves-effect btn-circle waves-light" onclick="edit(' . $data->id . ')" type="button" ><i class="fa fa-spinner fa-spin" id="loadEdit_' . $data->id . '" style="display:none"></i><i class="fas fa-edit"></i></button>';
            $options .= ' <td class="sorting_1"><button title="رؤية التفاصيل" class="btn btn-success waves-effect btn-circle waves-light" onclick="UserInfo(' . $data->id . ')" type="button" ><i class="fa fa-spinner fa-spin" id="userInfo_' . $data->id . '" style="display:none"></i><i class="fas fa-eye"></i></button>';
            $options .= '<button type="button" onclick="deleteFunction(' . $data->id . ',1)" class="btn btn-danger waves-effect btn-circle waves-light"><i class=" fas fa-trash"></i> </button></td>';
           if($data->user_type == 2) {
               $options .= ' <a title="التقييمات" href="/manage/Rate/get_rates/' . $data->id . '?type=1" target="_blank" style="color: #fff" class="btn btn-warning waves-effect btn-circle waves-light"><i class=" fas fa-comment"></i> </a></td>';
               $options .= ' <button title="معلومات المتجر"  onclick="storeInfo(' . $data->id . ')" class="btn btn-secondary waves-effect btn-circle waves-light"><i class=" fas fa-info"></i><i class="fa fa-spinner fa-spin" id="loadStoreInfo_' . $data->id . '" style="display:none"></i> </a></td>';
           }
           return $options;
        })->addColumn('checkBox', function ($data) {
            $checkBox = '<td class="sorting_1">' .
                '<div class="custom-control custom-checkbox">' .
                '<input type="checkbox" class="mybox" id="checkBox_' . $data->id . '" onclick="check(' . $data->id . ')">' .
                '</div></td>';
            return $checkBox;
        })->editColumn('city_id', function ($data) {
            return $data->city ? $data->city->name : 'لم تسجل بعد';
        })->editColumn('area_id', function ($data) {
            return   $data->area ? $data->area->name  : 'لم تسجل بعد';
        })->editColumn('status', function ($data) {
            $status = '<button class="btn waves-effect waves-light btn-rounded btn-success statusBut" style="cursor:pointer !important" onclick="ChangeStatus(0,'.$data->id.')" title="اضغط هنا لالغاء التفعيل">'
                . trans('main.Active') .
                '</button>';
            if ($data->status == 0)
                $status = '<button class="btn waves-effect waves-light btn-rounded btn-danger statusBut" onclick="ChangeStatus(1,'.$data->id.')" style="cursor:pointer !important" title="اضغط هنا للتفعيل">' . trans('main.inActive') . '</button>';
            return $status;
        })->editColumn('image',function($data){
            $image='<a href="'.getImageUrl('Users',$data->image).'" target="_blank">'.
                '<img src="'.getImageUrl('Users',$data->image).'" width="50" height="50"></a>';
            return $image;
        })->editColumn('user_type',function($data){
            $user_type='عضو';
            if($data->user_type == 2)
                $user_type='متجر';
            if($data->user_type == 3)
                $user_type='مندوب';
            return $user_type;
        })->rawColumns(['action' => 'action', 'checkBox' => 'checkBox','image' => 'image',  'status' => 'status','user_type'=>'user_type'])->make(true);

    }


}

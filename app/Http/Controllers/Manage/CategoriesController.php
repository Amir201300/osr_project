<?php


namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator, Auth;
use App\Models\Category;

class CategoriesController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $main_cat=$request->id ? Category::find($request->id) : null;
        return view('manage.categories.index',compact('main_cat'));
    }

    //View Function
    public function view(Request $request)
    {
        $Category = Category::orderBY('created_at', 'desc')->where('parent_id',$request->parent_id)->get();
        return $this->dataFunction($Category);
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
                'name' => 'required',
                'image' => 'required'
            ],
            [
                'name.required' => 'من فضلك ادخل اسم القسم',
                'image.required' => 'من فضلك صوره للقسم',
            ]

        );
        $Category = new Category;
        $Category->status = $request->status;
        $Category->name = $request->name;
        $Category->level = $request->level;
        $Category->parent_id = $request->parent_id;
        $Category->image=saveImage('categories',$request->image);
        $Category->save();
        return response()->json(['errors' => false]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $Category = Category::find($id);
        if (is_null($Category)) {
            return BaseController::Error('Product not exist', 'الكلمة الدلالية غير موجودة');
        }

        return $Category;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $Category = Category::find($request->id);
        if (is_null($Category)) {
            return response()->json(['errors' => true]);
        }
        $this->validate(
            $request,
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'من فضلك ادخل الاسم الجديد',
            ]

        );
        $Category->status = $request->status;
        $Category->name = $request->name;
        if($request->image){
            deleteFile('categories',$Category->image);
            $Category->image=saveImage('categories',$request->image);
        }
        $Category->save();

        return response()->json(['errors' => false]);

    }


    public function delete(Request $request, $id)
    {
        if ($request->type == 2) {
            $ids = explode(',', $id);
            $Ads = Category::whereIn('id', $ids)->delete();
        } else {
            $Ads = Category::find($id);
            if (is_null($Ads)) {
                return 5;
            }
            $Ads->delete();
        }
        return response()->json(['errors' => false]);

    }

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
            if($data->parent_id ==0)
                $options .= '<a title="اضافة قسم فرعي" type="button" href="/manage/categories/index?id='.$data->id.'" class="btn btn-primary  waves-effect btn-circle waves-light"><i class=" fas fa-plus"></i> </a></td>';
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
            $image='<a href="/images/categories/'.$data->image.'" target="_blank">'.
                '<img src="/images/categories/'.$data->image.'" width="50" height="50"></a>';
            return $image;
        })->rawColumns(['action' => 'action', 'checkBox' => 'checkBox',
            'status' => 'status', 'image' => 'image'])->make(true);

    }
}

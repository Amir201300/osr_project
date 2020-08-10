<?php

namespace App\Http\Controllers\Manage;

use App\Interfaces\ProductInterface;
use App\Models\Category;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Validator, Auth;
use App\Models\Product;

class ProductController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $cat = Category::where('parent_id', '!=', 0)->where('status',1)->get();
        $users=User::where('user_type',2)->where('status',1)->get();
        return view('manage.Product.index', compact('cat','users'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function view(Request $request)
    {
        $Product = Product::orderBY('created_at', 'desc');
        if ($request->status != null)
            $Product = $Product->where('status', $request->status);
        if ($request->cat_id)
            $Product = $Product->where('cat_id', $request->cat_id);
        if ($request->dataFilter) {
            if ($request->dataFilter == 1)
                $Product = $Product->whereDay('created_at', now());
            if ($request->dataFilter == 2)
                $Product = $Product->whereMonth('created_at', now());
            if ($request->dataFilter == 3)
                $Product = $Product->whereYear('created_at', now());

        }
        $Product = $Product->get();
        return $this->dataFunction($Product);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request,ProductInterface $product)
    {
        $validate_product=$product->validate_product($request,0,0);
        if(isset($validate_product)){
            return $validate_product;
        }
        $product->save_or_update($request,0,0);
        return response()->json(['errors' => false]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $Product = Product::find($id);
        if (is_null($Product)) {
            return BaseController::Error('Product does not exist', 'الكلمة الدلالية غير موجودة');
        }
        $Product['rateNum'] = $Product->rateRelation->count();
        $Product['imageNum'] = $Product->Product_images->count();
        return $Product;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request,ProductInterface $product)
    {
        $validate_product=$product->validate_product($request,$request->id,0);
        if(isset($validate_product)){
            return $validate_product;
        }
        $product->save_or_update($request,$request->id,0);
        return response()->json(['errors' => false]);

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function delete(Request $request, $id,ProductInterface $productInterface)
    {
        if ($request->type == 2) {
            $ids = explode(',', $id);
            for($i=0;$i<count($ids);$i++){
                $productInterface->delete_product($ids[$i],0);
            }
        } else {
            $productInterface->delete_product($id,0);
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
        $product=Product::find($id);
        $product->status=$request->status;
        $product->save();
        return response()->json(['errors' => false]);
    }

    /**
     * @param $rate
     * @return string
     */
     private function rate_div($rate){
         $rate_icon='';
         for($i=0;$i<$rate;$i++) {
             $rate_icon.= '<i class="fa fa-star"></i>';
         }
         return $rate_icon;
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
            $options .= ' <td class="sorting_1"><button title="رؤية التفاصيل" class="btn btn-success waves-effect btn-circle waves-light" onclick="showData(' . $data->id . ')" type="button" ><i class="fa fa-spinner fa-spin" id="loadShow_' . $data->id . '" style="display:none"></i><i class="fas fa-eye"></i></button>';
            $options .= '<button type="button" onclick="deleteFunction(' . $data->id . ',1)" class="btn btn-danger waves-effect btn-circle waves-light"><i class=" fas fa-trash"></i> </button></td>';
            return $options;
        })->addColumn('checkBox', function ($data) {
            $checkBox = '<td class="sorting_1">' .
                '<div class="custom-control custom-checkbox">' .
                '<input type="checkbox" class="mybox" id="checkBox_' . $data->id . '" onclick="check(' . $data->id . ')">' .
                '</div></td>';
            return $checkBox;
        })->editColumn('cat_id', function ($data) {
            return $data->cat ? $data->cat->name : 'تم تمسح القسم';
        })->editColumn('user_id', function ($data) {
            return '<a onclick="UserInfo(' . $data->shop->id . ')" style="color : blue ; cursor:pointer">' . $data->shop->name . '</a>';
        })->editColumn('status', function ($data) {
            $status = '<button class="btn waves-effect waves-light btn-rounded btn-success statusBut" style="cursor:pointer !important" onclick="ChangeStatus(0,'.$data->id.')" title="اضغط هنا لالغاء التفعيل">'
                . trans('main.Active') .
                '</button>';
            if ($data->status == 0)
                $status = '<button class="btn waves-effect waves-light btn-rounded btn-danger statusBut" onclick="ChangeStatus(1,'.$data->id.')" style="cursor:pointer !important" title="اضغط هنا للتفعيل">' . trans('main.inActive') . '</button>';
            return $status;
        })->editColumn('rate',function($data){
            $rate= '<a href="/manage/Rate/get_rates/'.$data->id.'" title="اضغط لمشاهدة التقييمات" target="_blank">'.$this->rate_div($data->rate).'</a>';
            return $data->rate > 0 ? $rate : 'لا توجد تقييمات لهذا المنتج';
        })->rawColumns(['action' => 'action', 'checkBox' => 'checkBox', 'rate'=>'rate','cat_id' => 'cat_id', 'user_id' => 'user_id', 'status' => 'status'])->make(true);

    }


}

<?php

namespace App\Http\Controllers\Api;

use App\Models\store_info;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Auth,Artisan,Hash,File,Crypt;
use App\Http\Resources\UserResource;
use App\User;
use App\Http\Controllers\Manage\EmailsController;

class UserController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */

    public function register(Request $request)
    {

        $input = $request->all();
        $validationMessages = [
            'name.required'       => 'من فضلك ادخل اسم الحساب'  ,
            'name.min'            => 'اسم الحساب يجب ان يكون اكثر من 3 حروف'  ,
            'password.required'   =>  'من فضلك ادخل كلمة السر'  ,
            'password.confirmed'  =>  'كلمتا السر غير متطابقتان'   ,
            'email.required'      => 'من فضلك ادخل البريد الالكتروني'   ,
            'email.unique'        => 'هذا البريد الالكتروني موجود لدينا بالفعل' ,
            'email.regex'         =>'من فضلك ادخل بريد الكتروني صالح' ,
            'phone.required'      =>  'من فضلك ادخل رقم الهاتف'  ,
            'phone.unique'        =>  'رقم الهاتف موجود لدينا بالفعل'  ,
            'phone.min'           =>  'رقم الهاتف يجب ان لا يقل عن 7 ارقام'  ,
            'phone.numeric'       =>  'رقم الهاتف يجب ان يكون رقما' ,
            'city_id.exists'      =>' المحافظة المدخلة غير موجودة لدينا',
            'area_id.exists'      =>' المنطقة المدخلة غير موجودة لدينا',
        ];

        $validator = Validator::make($input, [
            'name'     => 'required|min:3',
            'user_type'=> 'required|in:1,2,3',
            'phone'    => 'required|unique:users|min:7|numeric',
            'email'    => 'required|unique:users|regex:/(.+)@(.+)\.(.+)/i',
            'password' => $request->social==1 ? '':'required|min:6|confirmed',
            'city_id'=>'exists:cities,id',
            'area_id'=>'exists:areas,id'
        ], $validationMessages);

        if ($validator->fails()) {
            return $this->apiResponseMessage(0,$validator->messages()->first(), 200);
        }

        $user = new User();
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->city_id = $request->city_id;
        $user->area_id = $request->area_id;
        $user->status  = 0;
        $user->user_type = $request->user_type;
        $user->password =$request->social ==1 ? null : Hash::make($request->password);
        $user->image = $request->image ? saveImage('users',$request->image): null;
        $user->social = $request->social ==1 ? 1 : 0;
        $user->save();
        $token = $user->createToken('TutsForWeb')->accessToken;
        $user['token']=$token;
        EmailsController::verify_email($user->id);
        if($request->user_type == 2){
            $info=new store_info();
            $info->user_id=$user->id;
            $info->save();
        }
        $msg=  'تم التسجيل بنجاح, برجاء تفعيل الحساب عن الطريق الكود المرسل الى بريدكم الالكتروني' ;
        return $this->apiResponseData(new UserResource($user),$msg,200);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */

    public function login(Request $request)
    {

        $user=User::where('phone',$request->eamilOrPhone)->first();
        if(is_null($user))
        {
            $user=User::where('email',$request->eamilOrPhone)->first();
            if(is_null($user))
            {
                $msg=  'البيانات المدخلة غير موجودة لدينا ';
                return $this->apiResponseMessage( 0,$msg, 404);
            }
        }
        $password=Hash::check($request->password,$user->password);
        if($password==true){
            $token = $user->createToken('TutsForWeb')->accessToken;
            $user['token']=$token;
            $user['image']=getImageUrl('users',$user->image);
            $msg= 'تم تسجيل الدخول بنجاح';
            return response()->json([ 'status'=>1,'message'=> $msg, 'data'=>$user]);
        }

        $msg= 'كلمة السر غير صحيحة'  ;
        return $this->apiResponseMessage( 0,$msg, 400);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function edit_profile(Request $request)
    {
        $user = Auth::user();
        $id=Auth::user()->id;

        $input = $request->all();
        $validationMessages = [
            'name.required'       => 'من فضلك ادخل اسم الحساب الجديد'  ,
            'name.min'            => 'اسم الحساب يجب ان يكون اكثر من 3 حروف'  ,
            'email.required'      => 'من فضلك ادخل البريد الالكتروني الجديد'   ,
            'email.unique'        => 'هذا البريد الالكتروني موجود لدينا بالفعل' ,
            'email.regex'         =>'من فضلك ادخل بريد الكتروني صالح' ,
            'phone.required'      =>  'من فضلك ادخل رقم الهاتف الجديد'  ,
            'phone.unique'        =>  'رقم الهاتف موجود لدينا بالفعل'  ,
            'phone.min'           =>  'رقم الهاتف يجب ان لا يقل عن 7 ارقام'  ,
            'phone.numeric'       =>  'رقم الهاتف يجب ان يكون رقما' ,
            'city_id.exists'      =>' المحافظة المدخلة غير موجودة لدينا',
            'area_id.exists'      =>' المنطقة المدخلة غير موجودة لدينا',
        ];

        $validator = Validator::make($input, [
            'name'     => 'required|min:3',
            'phone'    => 'required|unique:users,id,'.$id.'|min:7|numeric',
            'email'    => 'required|unique:users,id,'.$id.'|regex:/(.+)@(.+)\.(.+)/i',
            'city_id'=>'exists:cities,id',
            'area_id'=>'exists:areas,id'
        ], $validationMessages);
        if ($validator->fails()) {
            return $this->apiResponseMessage(0,$validator->messages()->first(), 200);
        }


        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->city_id = $request->city_id;
        $user->area_id = $request->area_id;
        $user->status  = 0;
        $user->image = $request->image ? saveImage('users',$request->image): null;
        $user->save();
        $user['token']=null;
        $msg= 'تم تعديل البيانات بنجاح  '  ;
        return $this->apiResponseData(  new UserResource($user),  $msg);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function my_info()
    {
        $user=Auth::user();
        $user['token']=null;
        $msg= 'تمت العملية بنجاح' ;
        return $this->apiResponseData(new UserResource($user),$msg);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function logout()
    {
        $user=Auth::user();
        $user->tokens->each(function($token, $key) {
            $token->delete();
        });
        $msg='تم تسجيل الخروج بنجاح' ;
        return $this->apiResponseMessage(1,$msg,200);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function view_user($id){

        $user=User::find($id);
        $user==null ? '' : $user['token']=null;
        if (is_null($user)){
            $msg = 'هذا العضو غير موجود';
            return $this->apiResponseMessage(1,$msg,200);
        }
        $msg = 'تمت العمليه بنجاح';
        return $this->apiResponseData(new UserResource($user),$msg);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function change_password(Request $request)
    {
        $user = Auth::user();
        $check=$this->not_found($user,'العضو');
        if(isset($check))
        {
            return $check;
        }
        if(!$request->newPassword){
            $msg='يجب ادخال كلمة السر الجديدة';
            return $this->apiResponseMessage(0,$msg,200);
        }
        $password=Hash::check($request->oldPassword,$user->password);
        if($password==true){
            $user->password=Hash::make($request->newPassword);
            $user->save();
            $msg= 'تم تغيير كلمة السر بنجاح' ;
            return $this->apiResponseMessage( 1,$msg, 200);

        }else{
            $msg='كلمة السر القديمة غير صحيحة';
            return $this->apiResponseMessage(0,$msg, 401);

        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function forget_password(Request $request){

        $user=User::where('email',$request->email)->first();
        $check=$this->not_found($user,'البريد الالكتروني');
        if(isset($check)){
            return $check;
        }
        $code=mt_rand(999,9999);
        $user->code=$code;
        $user->save();
        EmailsController::forget_password($user);
        $msg='تفحص بريدك الالكتروني';
        return $this->apiResponseMessage(1,$msg,200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function reset_password(Request $request)
    {
        if(!$request->code){
            $msg= 'من فضلك ادخل الكود' ;
            return $this->apiResponseMessage(0,$msg,200);
        }
        $user=User::where('code',$request->code)->first();
        if(is_null($user)){
            $msg='الكود غير صحيح' ;
            return $this->apiResponseMessage(0,$msg,200);
        }
        if(!$request->password){
            $msg='من فضلك ادخل كلمة السر الجديدة' ;
            return $this->apiResponseMessage(0,$msg,200);
        }
        $user->password=Hash::make($request->password);
        $user->code=null;
        $user->save();
        $msg='تم تغيير كلمة السر بنجاح' ;
        return $this->apiResponseMessage(1,$msg,200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function save_image(Request $request)
    {
        $user = Auth::user();
        if ($request->image) {
            deleteFile('users', $user->image);
            $name = saveImage('users', $request->file('image'));
            $user->image = $name;
        } else {
            $msg =  'من فضلك ارفع الصورة' ;
            return $this->apiResponseMessage(0, $msg, 200);
        }
        $user->save();
        $msg =  'تم رفع الصورة بنجاح' ;
        return $this->apiResponseMessage(1,$msg,200);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function check_code(Request $request)
    {
        $user=Auth::user();
        if($request->code == $user->code)
        {
            $user->code=null;
            $user->status=1;
            $user->save();
            $msg='تم التفعيل بنجاح' ;
            return $this->apiResponseMessage(1,$msg,200);
        }
        $msg='الكود غير مطابق';
        return $this->apiResponseMessage(0,$msg,200);

    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function resend_code()
    {
        $user=Auth::user();
        if($user->status == 1){
            $msg= 'الحساب مفعل';
            return $this->apiResponseMessage(0,$msg,200);
        }
        $send_mail=EmailsController::verify_email($user->id);
        if($send_mail == 1)
        {
            $msg='تم اعادة ارسال كود التفعيل بنجاح';
            return $this->apiResponseMessage(1,$msg,200);
        }
        $msg= 'حدث خطا حاول مجددا';
        return $this->apiResponseMessage(0,$msg,200);
    }

}
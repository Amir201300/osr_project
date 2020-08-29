<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AdvicesResource;
use App\Http\Resources\CityResource;
use App\Interfaces\HandleDataInterface;
use App\Models\Advices;
use App\Models\Area;
use App\Models\City;
use App\Models\Contact_us;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator, Auth, Artisan, Hash, File, Crypt;

class SettingsController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function contact_us(Request $request)
    {
        return $this->store_in_table($request, 1);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function complaint(Request $request)
    {
        return $this->store_in_table($request, 2);
    }

    /**
     * @param $request
     * @param $type
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    private function store_in_table($request, $type)
    {
        $lang = $request->header('lang');
        $input = $request->all();

        $validationMessages = [
            'message.required' => 'من فضلك ادخل الرسالة',
            'email.required' => 'من فضلك ادخل البريد الالكتروني',
            'email.regex' => 'من فضلك ادخل بريد الكتروني صالح',
            'phone.required' => 'من فضلك ادخل رقم الهاتف',
            'phone.min' => 'رقم الهاتف يجب ان لا يقل عن 7 ارقام',
            'phone.numeric' => ' الهاتف يجب ان يكون رقما',
        ];

        $validator = Validator::make($input, [
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'phone' => 'required|min:7|max:20',
            'message' => 'required',
        ], $validationMessages);

        if ($validator->fails()) {
            return $this->apiResponseMessage(0, $validator->messages()->first(), 200);
        }

        $Contact_us = new Contact_us();
        $Contact_us->phone = $request->phone;
        $Contact_us->email = $request->email;
        $Contact_us->message = $request->message;
        $Contact_us->name = $request->name;
        $Contact_us->title = $request->title;
        $Contact_us->type = $type;
        $Contact_us->save();
        return $this->apiResponseMessage(1, 'تم ارسال رسالتكم بنجاح....وسيقوم فريقنا بالرد عليكم', 200);

    }

}
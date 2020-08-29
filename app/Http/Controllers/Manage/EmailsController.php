<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth,File,Mail,Crypt;
use App\Models\Produc_view_user;

class EmailsController extends Controller
{

    /**
     * @param $user_id
     * @return int
     */

    public static function verify_email($user_id)
    {
        $user = User::find($user_id);
        $email = $user->email;
        $subject = "verify your account";
        $code = mt_rand(999, 9999);
        $user->code = $code;
        $user->save();
        $data = [];
        $data['code'] = $code;

        $name = $user->name;
        Mail::send('emails.verify_email', $data, function ($mail) use ($email, $name, $subject) {
            $mail->to($email, $name);
            $mail->subject($subject);
        });

        return 1;
    }


    /**
     * @param $user
     * @return int
     */
    public static function forget_password($user)
    {
        $subject=  'اعادة كلمة السر' ;
        $email=$user->email;
        $data=[];
        $data['code']=$user->code;
        $name=$user->name;
        Mail::send('emails.forget_password', $data, function ($mail) use ($email,$name, $subject) {
            $mail->to($email, $name);
            $mail->subject($subject);
        });

        return 1;
    }

}

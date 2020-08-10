<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth,File,Mail,Crypt;
use App\Models\Produc_view_user;

class EmailsController extends Controller
{

    /*
     * verify Email
     * send mail to custom user to  verify
     */

    public static function verify_email($user_id,$lang)
    {
        $user=User::find($user_id);
            $email=$user->email;
            $subject=$lang=='ar'? "verify your account" : 'تاكيد حسابك';

            $data=[];
            $data['id']=Crypt::encrypt($user_id);
            $data['language']=$lang;

            $name=$user->frist_name . $user->last_name;
            Mail::send('emails.verify_email', $data, function ($mail) use ($email,$name, $subject) {
                $mail->to($email, $name);
                $mail->subject($subject);
            });

            return $email;
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

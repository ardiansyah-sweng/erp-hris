<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{

    public function update(Request $request)
    {

        $user = Auth::user();


        $request->validate([
            'language'=>'required',
            'theme'=>'required',
        ]);


        $user->update([

            'language'=>$request->language,

            'theme'=>$request->theme,

            'email_notification'=>$request->has('email_notification'),

            'leave_notification'=>$request->has('leave_notification'),

            'payroll_notification'=>$request->has('payroll_notification'),

        ]);


        return back()
            ->with('success','Pengaturan berhasil diperbarui.');

    }



    public function updatePassword(Request $request)
    {

        $request->validate([

            'current_password'=>'required',

            'password'=>'required|min:8|confirmed',

        ]);


        $user = Auth::user();


        if(!Hash::check(
            $request->current_password,
            $user->password
        )){

            return back()
            ->withErrors([
                'current_password'=>'Password lama tidak sesuai.'
            ]);

        }


        $user->update([

            'password'=>Hash::make(
                $request->password
            )

        ]);


        return back()
        ->with('success','Password berhasil diubah.');

    }

}
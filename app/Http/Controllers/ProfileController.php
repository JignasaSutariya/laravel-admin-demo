<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Helper\GlobalHelper;
use Auth;
use Validator;
use Image;
use Session;
use File;
use App\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function adminProfile()
    {
        return view('admin.profile');
    }
    public function adminProfileUpdate(Request $request)
    {
        $user = Auth::user();

        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'profile_image' => 'nullable|image|max:100000',
            'email' => 'required|email|unique:users,email,'.$user->id.',id',
            'user_mobile' => 'required|numeric|unique:users,user_mobile,'.$user->id.',id',
        );
        $messages = [
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $editUser = User::find($user->id);
            $editUser->first_name = $request['first_name'];
            $editUser->last_name = $request['last_name'];
            $editUser->email = $request['email'];
            $editUser->user_mobile = $request['user_mobile'];
            $editUser->updated_at = date("Y-m-d H:i:s");
            if(!empty($request['profile_image']) || $request['profile_image'] != null){

                if(!empty($editUser->profile_image) || $editUser->profile_image != null){
                    $unlinkurl = $editUser->profile_image;
                    unlink('resources/uploads/profile/'.$unlinkurl);
                }
                $file = $request->file('profile_image');
                // Get File Name
                $file->getClientOriginalName();
                // Get File Extension
                $fileExtension = $file->getClientOriginalExtension();
                // Get File Real Path
                $file->getRealPath();
                // Get File Size
                $file->getSize();
                // Get File Mime Type
                $file->getMimeType();
                // Rename file name
                $fileName = md5(microtime() . $file->getClientOriginalName()) . "." . $fileExtension;

                $destinationPath = base_path().'/resources/uploads/profile/';
                $file->move($destinationPath, $fileName);

                $editUser->profile_image = $fileName;
            }

            if ($editUser->save()) {
                Session::flash('message', 'Profile information updated !!');
                Session::flash('alert-class', 'success');
                return redirect('admin/profile');
            } else {
                Session::flash('message', 'Oops !! Something went wrong please try again after some times');
                Session::flash('alert-class', 'error');
                return redirect('admin/profile');
            }
        }
    }
    public function updateAdminPassword(Request $request)
    {
        $rules = array(
            'old_password'  => 'required',
            'new_password'  => 'required',
            'confirm_password'  => 'required|same:new_password',
        );
        $messages = [

        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        } else {
            $user = User::find(Auth::user()->id);

            if (Hash::check($request['old_password'], $user->password)) {
                $user->password = bcrypt($request['new_password']);
                $user->save();
                Session::flash('message', 'Password updated successfully!!');
                Session::flash('alert-class', 'success');
                return redirect('admin/profile');
            } else {
                Session::flash('message', 'Oops !! current password is wrong, please try again.');
                Session::flash('alert-class', 'error');
                return redirect('admin/profile');
            }
        }
    }
}

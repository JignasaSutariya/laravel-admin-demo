<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;
use Image;
use Session;
use File;
use DB;
use URL;
use Yajra\DataTables\Facades\DataTables;
use App\Helper\GlobalHelper;
use Auth;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Notifications\UserRegistration;

class UserController extends Controller
{
    public function index()
    {
        $users = User::getAllUsers();
        return view('admin.users.users',['users'=> $users]);
    }

    public function ajaxUsers()
    {
       return DataTables::eloquent(User::select('*')
            ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->where(['role_user.role_id' => 2])
            ->where('users.user_status','!=', '-1'))
            ->addColumn('action', function ($users) {
               return '<a class="label label-primary" href="' . url('admin/users/view', ['id' => $users->id]) . '"  title="View / Update"><i class="fa fa-eye"></i>&nbsp</a>
                       <a class="label label-danger" href="javascript:;"  title="Delete" onclick="deleteConfirm('.$users->id.')"><i class="fa fa-trash"></i>&nbsp</a>';
            })
            ->addColumn('status', function ($users) {
               if ($users->user_status=='1'){
                   return'<a class="text-green actStatus" data-sid="'.$users->id.'" id="state'.$users->id.'">Active</a>';
               }
               else{
                   return '<a class="text-danger actStatus" data-sid="'.$users->id.'" id="state'.$users->id.'">Deactive</a>';
               }
            })
            ->addColumn('registeredUsing', function ($users) {
               if ($users->social_provider=='facebook'){
                   return'<span class="text-primary">Facebook</span>';
               }elseif ($users->social_provider=='google') {
                   return'<span class="text-red">Google</span>';
               } else{
                   return'<span>Normal</span>';
               }
            })
            ->editColumn('created_at', function($category) {
               return GlobalHelper::getFormattedDate($category->created_at);
            })

            ->rawColumns(['action','status','registeredUsing'])
            ->toJson();
    }

    public function store(Request $request)
    {
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'user_mobile' => 'required|numeric|unique:users,id',
            'email' => 'required|email|unique:users,id',
            'password' => 'required',
            'confirm_password' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'dob' => 'required',
        );
        $messages = [
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $adminUser = new User();
            $adminUser->first_name = $request['first_name'];
            $adminUser->last_name = $request['last_name'];
            $adminUser->email = $request['email'];
            $adminUser->user_mobile = $request['user_mobile'];
            $adminUser->city = $request['city'];
            $adminUser->state = $request['state'];
            $adminUser->country = $request['country'];
            $adminUser->dob = date('Y-m-d', strtotime($request['dob']));
            $adminUser->password = bcrypt($request['password']);
            $adminUser->user_status = '1';
            $adminUser->is_verified = '1';

            if ($adminUser->save()) {
                $adminUser->roles()->attach(2);
                Session::flash('message', 'User Added Succesfully !');
                Session::flash('alert-class', 'success');
                return redirect('admin/users');

            } else {
                Session::flash('message', 'Oops !! Something went wrong!');
                Session::flash('alert-class', 'error');
                return redirect('admin/users');
            }
        }
    }

    public function update(Request $request)
    {

        $rules = array(
            'user_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'user_mobile' => 'required|numeric|unique:users,user_mobile,'.$request->user_id.',id',
            'email' => 'required|email|unique:users,email,'.$request->user_id.',id',
            'password' => 'sometimes',
            'confirm_password' => 'sometimes',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'short_introduction' => 'required',
        );
        $messages = [
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        } else {

            $adminUser = User::find($request->user_id);
            $adminUser->first_name = $request['first_name'];
            $adminUser->last_name = $request['last_name'];
            $adminUser->email = $request['email'];
            $adminUser->user_mobile = $request['user_mobile'];
            $adminUser->city = $request['city'];
            $adminUser->state = $request['state'];
            $adminUser->country = $request['country'];
            $adminUser->education = $request['education'];
            $adminUser->work = $request['work'];
            $adminUser->short_introduction = $request['short_introduction'];
            $adminUser->dob = date('Y-m-d', strtotime($request['dob']));
            if($request['password']!= null || !empty($request['password'])){
                $adminUser->password = bcrypt($request['password']);
            }

            if(!empty($request->profile_image) || $request->profile_image != ''){

                if($adminUser->profile_image && file_exists(base_path().'/resources/uploads/profile/'.$adminUser->profile_image)){
                  unlink(base_path().'/resources/uploads/profile/'.$adminUser->profile_image); // correct
                }

                $file = $request->file('profile_image');
                $file->getClientOriginalName();
                $fileExtension = $file->getClientOriginalExtension();
                $file->getRealPath();
                $file->getSize();
                $file->getMimeType();
                $fileName = md5(microtime() . $file->getClientOriginalName()) . "." . $fileExtension;
                $destinationPath = base_path().'/resources/uploads/profile/';
                $file->move($destinationPath, $fileName);
                $adminUser->profile_image = $fileName;

            }

            $adminUser->updated_at = date("Y-m-d H:i:s");

            if ($adminUser->save()) {

                Session::flash('message', 'User Updated Succesfully !');
                Session::flash('alert-class', 'success');

                return redirect()->back();
            } else {
                Session::flash('message', 'Oops !! Something went wrong!');
                Session::flash('alert-class', 'error');
                return redirect()->back();
            }
        }
    }

    public function view($id)
    {
        $user = User::find($id);

        if(!empty($user)){
            return view('admin.users.usersView',['user' => $user]);
        }
        else{
            abort(404);
        }
    }

    public function destroy($id)
    {
        $dealerUser = User::find($id);
        $dealerUser->user_status= '-1';
        if ($dealerUser->save()) {
            Session::flash('message', 'User Deleted !!');
            Session::flash('alert-class', 'warning');
            return redirect('users');
        }
    }

    public function changeStatus(Request $request)
    {
        $dealerUser = User::find($request->id);
        $result = "";
        if($dealerUser->user_status == 0)
        {
            $dealerUser->user_status= '1';
            $result ="Active";
        }
        else {
            $dealerUser->user_status= '0';
            $result ="Deactive";
        }
        $dealerUser->save();
        return $result;
    }
}

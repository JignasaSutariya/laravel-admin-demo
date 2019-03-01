<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Helper\GlobalHelper;
use App\User;
use App\Category;
use App\TruckDetail;
use App\City;
use App\Notification;
use DB;
use App\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function adminindex()
    {
        return view('admin.dashboard');
    }

    public function setsidecookie(){
        // Check the current cookie value
        // If the cookie is empty or set to no, then add sidebar-collapse
        if (!isset($_COOKIE['sidebar-collapse']) || $_COOKIE['sidebar-collapse'] == "no") {
            // Set cookie value to yes
            setcookie('sidebar-collapse', 'yes', strtotime( '+30 days' ), "/");
        }
        // If the cookie was already set to yes then remove it
        else {
            setcookie('sidebar-collapse', 'no', strtotime( '+30 days' ), "/");
        }
    }

    public function dashboardFilterData(Request $request){

        $start_date = date("Y-m-d H:i:s", strtotime($request->start_date));
        $end_date = date("Y-m-d 23:59:59", strtotime($request->end_date));

        $totalUser = User::select((DB::raw('count(users.id) as totalCustomers')))
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->where('users.created_at','>=',$start_date)
                        ->where('users.created_at','<=',$end_date)
                        ->where('role_user.role_id','=','2')
                        ->where('users.user_status','=','1')
                        ->first();
        return $totalUser->totalCustomers;
    }
}

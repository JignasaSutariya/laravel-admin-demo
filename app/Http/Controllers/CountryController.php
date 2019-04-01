<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Country;
use App\State;
use App\City;
use Yajra\Datatables\Datatables;
use Validator;
use Session;

class CountryController extends Controller
{
    //Country CRUD
    public function index() {
        $countries = Country::where('status','1')->get();
        return view('admin.location.countries')->with(compact('countries'));
    }

    public function ajaxCountry() {
        $countries = Country::where('status','1')->get();
        return Datatables::of($countries)
        ->addColumn('action', function ($countries) {
        return '<a class="label label-primary" href="' . url('admin/countries/'.$countries->country_id) . '"  title="View"><i class="fa fa-eye"></i>&nbsp</a>
        <a class="label label-success" href="' . url('admin/countries/'.$countries->country_id.'/edit') . '"  title="Update"><i class="fa fa-edit"></i>&nbsp</a>
        <a class="label label-danger" href="javascript:;"  title="Delete" onclick="deleteConfirm('.$countries->country_id.')"><i class="fa fa-trash"></i>&nbsp</a>';
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function store(Request $request){
        $rules = [
          'short_code' => 'required|unique:countries,sortname',
          'country_name' => 'required|unique:countries,name',
          'phonecode' => 'required|unique:countries,phonecode',
        ];

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
          return redirect()->back()
          ->withErrors($validator)
          ->withInput();
        } else {
            $country = new Country;
            $country->sortname = $request->short_code;
            $country->name = $request->country_name;
            $country->phonecode = $request->phonecode;
            $country->status = '1';
            if ($country->save()) {
              Session::flash('message', 'Country Added Succesfully !');
              Session::flash('alert-class', 'success');
              return redirect()->back();
            } else {
              Session::flash('message', 'Oops !! Something went wrong!');
              Session::flash('alert-class', 'error');
              return redirect()->back();
            }
        }
    }

    public function edit($id) {
        $country = Country::findOrFail($id);
        return view('admin.location.editCountry')->with(compact('country'));
    }

    public function update(Request $request, $id){
      $rules = [
          'short_code' => 'required|unique:countries,sortname,'.$id.',country_id',
          'country_name' => 'required|unique:countries,name,'.$id.',country_id',
          'phonecode' => 'required|unique:countries,phonecode,'.$id.',country_id',
      ];

      $messages = [];

      $validator = Validator::make($request->all(), $rules, $messages);

      if($validator->fails()) {
          return redirect()->back()
          ->withErrors($validator)
          ->withInput();
      } else {
          $country = Country::find($id);
          $country->sortname = $request->short_code;
          $country->name = $request->country_name;
          $country->phonecode = $request->phonecode;
          $country->status = '1';
      }
      if ($country->save()) {
          Session::flash('message', 'Country Updated Succesfully !');
          Session::flash('alert-class', 'success');
          return redirect('admin/countries');
      } else {
          Session::flash('message', 'Oops !! Something went wrong!');
          Session::flash('alert-class', 'error');
          return redirect()->back();
      }
    }

    public function show($country_id) {
        $country = Country::findOrFail($country_id);
        return view('admin.location.states')->with(compact('country'));
    }

    public function destroy(Request $request) {
        $country = Country::find($request->id);

        foreach ($country->states as $state) {
          $state->cities()->delete();
        }

        $country->states()->delete();
        $country->delete();

        return '1';
    }

    // State CRUD
    public function ajaxState($id) {
      $states = State::where('country_id', $id)->where('status','1')->get();

      return Datatables::of($states)
      ->addColumn('action', function ($states) {
        return '<a class="label label-primary" href="' . url('admin/state/view', ['id' => $states->state_id]) . '"  title="View"><i class="fa fa-eye"></i>&nbsp</a>
        <a class="label label-success" href="' . url('admin/state/'.$states->state_id.'/edit') . '"  title="Update"><i class="fa fa-edit"></i>&nbsp</a>
        <a class="label label-danger" href="javascript:;"  title="Delete" onclick="deleteConfirm('.$states->state_id.')"><i class="fa fa-trash"></i>&nbsp</a>';
      })
      ->addColumn('country', function ($state) {
        return $state->country->name;
      })
      ->rawColumns(['action'])
      ->make(true);
    }

    public function storeState(Request $request) {
        $rules = [
            'state_name' => 'required',
            'state_country' => 'required|exists:countries,country_id'
        ];

        $messages = [
            'state_country.required' => 'Please select a Country.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        } else {
            $state = new State;
            $state->name = $request->state_name;
            $state->country_id = $request->state_country;
            $state->status = '1';
            if ($state->save()) {
              Session::flash('message', 'State Added Succesfully !');
              Session::flash('alert-class', 'success');
              return redirect()->back();
            } else {
              Session::flash('message', 'Oops !! Something went wrong!');
              Session::flash('alert-class', 'error');
              return redirect()->back();
            }
        }
    }

    public function editState($id) {
        $state = State::findOrFail($id);
        $country = Country::findOrFail($state->country_id);
        return view('admin.location.editState')->with(compact('state', 'country'));
    }

    public function updateState(Request $request, $id){
        $rules = [
          'state_name' => 'required',
          'state_country' => 'required|exists:countries,country_id',
        ];

        $messages = [
          'state_country.required' => 'Please select a Country.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
          return redirect()->back()
          ->withErrors($validator)
          ->withInput();
        } else {
          $state = State::find($id);
          $state->name = $request->state_name;
          $state->country_id = $request->state_country;
          $state->status = '1';
        }
        if ($state->save()) {
            Session::flash('message', 'State Updated Succesfully !');
            Session::flash('alert-class', 'success');
            return redirect('admin/countries/'.$request->state_country);
        } else {
            Session::flash('message', 'Oops !! Something went wrong!');
            Session::flash('alert-class', 'error');
            return redirect()->back();
        }
    }

    public function deleteState(Request $request) {
      $state = State::find($request->id);

      $state->cities()->delete();

      $state->delete();

      return '1';
    }

    // City CRUD
    public function getCity($state_id) {
        $state = State::findOrFail($state_id);
        $country =  Country::findOrFail($state->country_id);
        return view('admin.location.cities')->with(compact('country', 'state'));
      }

    public function ajaxCity($id) {
        $cities = City::where('state_id', $id)->where('status','1')->get();

        return Datatables::of($cities)
        ->addColumn('country', function ($city) {
          return $city->state->country->name;
        })
        ->addColumn('state', function ($city) {
          return $city->state->name;
        })
        ->addColumn('action', function ($cities) {
          return '<a class="label label-success" href="' . url('admin/city/'.$cities->city_id.'/edit') . '"  title="Update"><i class="fa fa-edit"></i>&nbsp</a>
          <a class="label label-danger" href="javascript:;"  title="Delete" onclick="deleteConfirm('.$cities->city_id.')"><i class="fa fa-trash"></i>&nbsp</a>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function storeCity(Request $request) {
        $rules = [
            'city_name' => 'required',
            'city_country' => 'required|exists:countries,country_id',
            'city_state' => 'required|exists:states,state_id'
        ];

        $messages = [
            'city_country.required' => 'Please select a Country.',
            'city_state.required' => 'Please select a State.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        } else {
            $city = new City;
            $city->name = $request->city_name;
            $city->state_id = $request->city_state;
            if ($city->save()) {
              Session::flash('message', 'City Added Succesfully !');
              Session::flash('alert-class', 'success');
              return redirect('admin/state/view/'.$request->city_state);
            } else {
              Session::flash('message', 'Oops !! Something went wrong!');
              Session::flash('alert-class', 'error');
              return redirect('admin/state/view/'.$request->city_state);
            }
        }
    }

    public function editCity($id) {
        $city = City::findOrFail($id);
        $state = State::findOrFail($city->state_id);
        $country =  Country::findOrFail($state->country_id);
        return view('admin.location.editCity')->with(compact('country', 'state', 'city'));
    }

    public function updateCity(Request $request, $id){
        // dd($request->city_country);
        $rules = [
            'city_name' => 'required',
            'city_country' => 'required|exists:countries,country_id',
            'city_state' => 'required|exists:states,state_id'
        ];

        $messages = [
            'city_country.required' => 'Please select a Country.',
            'city_state.required' => 'Please select a State.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
          return redirect()->back()
          ->withErrors($validator)
          ->withInput();
        } else {
          $state = City::find($id);
          $state->name = $request->city_name;
          $state->status = '1';
        }
        if ($state->save()) {
            Session::flash('message', 'City Updated Succesfully !');
            Session::flash('alert-class', 'success');
            return redirect('admin/state/view/'.$request->city_state);
        } else {
            Session::flash('message', 'Oops !! Something went wrong!');
            Session::flash('alert-class', 'error');
            return redirect()->back();
        }
    }

    public function deleteCity(Request $request) {
        City::find($request->id)->delete();

        return '1';
      }

    public function getCountry(Request $request){
      $countries = Country::where('status', '1')->get()->toArray();

      $option = '<option></option>';
      if(!empty($countries)) {
        foreach($countries as $country) {
          $option .= '<option value="'.$country['country_id'].'">'.$country['name'].'</option>';
        }
      }

      echo $option;
    }

    public function getState(Request $request){
      $state = new State();
      $states = $state->getState($request->id);
      $option = '<option></option>';
      if(isset($request->state) && !is_null($request->state)) {
        foreach($states as $state) {
          $option .= '<option value="'.$state['state_id'].'" '.(($request->state == $state['state_id']) ? 'selected': '').'>'.$state['name'].'</option>';
        }
      } else {
        foreach($states as $state) {
          $option .= '<option value="'.$state['state_id'].'">'.$state['name'].'</option>';
        }
      }

      echo $option;
    }

    public function getCities(Request $request){

      $model = new City();
      $cities = $model->getCity($request->id);
      $option = '<option></option>';
      if(isset($request->city) && !is_null($request->city)) {
        foreach($cities as $city) {
          $option .= '<option value="'.$city['city_id'].'"'.(($request->city == $city['city_id']) ? 'selected': '').'>'.$city['name'].'</option>';
        }
      } else {
        foreach($cities as $city) {
          $option .= '<option value="'.$city['city_id'].'">'.$city['name'].'</option>';
        }
      }

      echo $option;
    }
}

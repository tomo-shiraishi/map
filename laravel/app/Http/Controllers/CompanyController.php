<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Restaurant;
use Validator;
use DB;
use Config;

class CompanyController extends Controller
{
    public function index()
    {
        $blade['company'] = Company::first();
        return view('company.index', $blade);
    }

    public function add()
    {
        $company = Company::first();
        if (!is_null($company)) return redirect('/company');

        return view('company.add');
    }

    public function edit()
    {
        $blade['company'] = Company::first();
        return view('company.edit', $blade);
    }


    public function confirm(Request $request)
    {
        // バリデート
        $validator = Validator::make($request->all(), [
            'company' => 'required|max:20',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('company/add')
                        ->withErrors($validator)
                        ->withInput();
        }

        $blade['company'] = $request->company;
        $blade['address'] = $request->address;

        return view('company.confirm', $blade);
    }


    public function editconfirm(Request $request)
    {
        // バリデート
        $validator = Validator::make($request->all(), [
            'company' => 'required|max:20',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('company/edit?id='.$request->id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $blade['id'] = $request->id;
        $blade['company'] = $request->company;
        $blade['address'] = $request->address;

        return view('company.edit-confirm', $blade);
    }



    public function complete(Request $request)
    {
        // バリデート
        $validator = Validator::make($request->all(), [
            'company' => 'required|max:20',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('company/add')
                        ->withErrors($validator)
                        ->withInput();
        }

        $latlng = Company::getGpsFromAddress($request->address);

        $company = Company::create(['name'    => $request->company,
                                    'address' => $request->address,
                                    'lat'     => $latlng['lat'],
                                    'lng'     => $latlng['lng'],
                                  ]);

        $facilities = Company::searchFacilities($latlng);

        foreach ($facilities as $facility) {
            $restaurant = Restaurant::create(['category_id' => 1,
                                              'place_id'    => $facility['place_id'],
                                              'name'        => $facility['name'],
                                              'address'     => $facility['vicinity'],
                                              'lat'         => $facility['geometry']['location']['lat'],
                                              'lng'         => $facility['geometry']['location']['lng'],
                                            ]);
        }

        return redirect('/')->with('message', '会社を登録しました。');
    }



    public function editcomplete(Request $request)
    {
        // バリデート
        $validator = Validator::make($request->all(), [
            'company' => 'required|max:20',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('company/edit?id='.$request->id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $latlng = Company::getGpsFromAddress($request->address);

        DB::transaction(function () use ($request, $latlng) {
            $company = Company::find($request->id);
            $company->name = $request->company;
            $company->address = $request->address;
            $company->lat = $latlng['lat'];
            $company->lng = $latlng['lng'];
            $company->save();

            // restaurantsテーブル全削除
            DB::table('restaurants')->truncate();

            $facilities = Company::searchFacilities($latlng);

            foreach ($facilities as $facility) {
                $restaurant = Restaurant::create(['category_id' => 1,
                                                  'place_id'    => $facility['place_id'],
                                                  'name'        => $facility['name'],
                                                  'address'     => $facility['vicinity'],
                                                  'lat'         => $facility['geometry']['location']['lat'],
                                                  'lng'         => $facility['geometry']['location']['lng'],
                                                ]);
            }
        });

        return redirect('/company')->with('message', '会社を更新しました。');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\Company;
use Validator;
use DB;

class RestaurantController extends Controller
{

    public function index()
    {
        $blade['restaurants'] = Restaurant::get();
        $blade['categories'] = Category::get();

        return view('restaurants.index', $blade);
    }

    public function detail(Request $request)
    {
        $blade['restaurant'] = Restaurant::find($request->id);
        $blade['company'] = Company::first();
        if (is_null($blade['restaurant'])) redirect('/restaurants');

        return view('restaurants.detail', $blade);
    }

    // getで/restaurants/addにアクセスされた場合
    public function add()
    {
        $blade['categories'] = Category::pluck('name', 'id');
        return view('restaurants.add', $blade);
    }


    // getで/restaurants/editにアクセスされた場合
    public function edit(Request $request)
    {
        $blade['restaurant'] = Restaurant::find($request->id);
        $blade['open_time_h'] = (is_null($blade['restaurant']->open_time)) ? '' : date('H', strtotime($blade['restaurant']->open_time));
        $blade['open_time_m'] = (is_null($blade['restaurant']->open_time)) ? '' : date('i', strtotime($blade['restaurant']->open_time));
        if (is_null($blade['restaurant']->second_close_time)) {
            $blade['close_time_h'] = (is_null($blade['restaurant']->close_time)) ? '' : date('H', strtotime($blade['restaurant']->close_time));
            $blade['close_time_m'] = (is_null($blade['restaurant']->close_time)) ? '' : date('i', strtotime($blade['restaurant']->close_time));
        } else {
            $blade['close_time_h'] = (is_null($blade['restaurant']->second_close_time)) ? '' : date('H', strtotime($blade['restaurant']->second_close_time));
            $blade['close_time_m'] = (is_null($blade['restaurant']->second_close_time)) ? '' : date('i', strtotime($blade['restaurant']->second_close_time));
        }
        $blade['last_order_h'] = (is_null($blade['restaurant']->lo_time)) ? '' : date('H', strtotime($blade['restaurant']->lo_time));
        $blade['last_order_m'] = (is_null($blade['restaurant']->lo_time)) ? '' : date('i', strtotime($blade['restaurant']->lo_time));

        $blade['categories'] = Category::pluck('name', 'id');
        return view('restaurants.edit', $blade);
    }


    // postで/restaurants/add/confirmにアクセスされた場合
    public function confirm(Request $request)
    {

        $validator = Restaurant::validation($request);

        if ($validator->fails()) {
            return redirect('restaurants/add')
                        ->withErrors($validator)
                        ->withInput();
        }

        // requestのデータを直接変更したくない
        $input_data = $request->all();
        if (!is_null($request->open_time_h) && is_null($request->open_time_m)) $input_data['open_time_m'] = '00';
        if (!is_null($request->close_time_h) && is_null($request->close_time_m)) $input_data['close_time_m'] = '00';
        if (!is_null($request->last_order_h) && is_null($request->last_order_m)) $input_data['last_order_m'] = '00';

        if ($request->open_time_h > $request->close_time_h) $input_data['close_time_h'] += 24;

        $blade['input_data'] = $input_data;
        $blade['category'] = Category::find($request->category_id);

        return view('restaurants.confirm', $blade);
    }


    // postで/restaurants/edit/confirmにアクセスされた場合
    public function editconfirm(Request $request)
    {

        $validator = Restaurant::validation($request);

        if ($validator->fails()) {
            return redirect('restaurants/edit?id='.$request->id)
                        ->withErrors($validator)
                        ->withInput();
        }

        // requestのデータを直接変更したくない
        $input_data = $request->all();
        if (!is_null($request->open_time_h) && is_null($request->open_time_m)) $input_data['open_time_m'] = '00';
        if (!is_null($request->close_time_h) && is_null($request->close_time_m)) $input_data['close_time_m'] = '00';
        if (!is_null($request->last_order_h) && is_null($request->last_order_m)) $input_data['last_order_m'] = '00';

        if ($request->open_time_h > $request->close_time_h) $input_data['close_time_h'] += 24;

        $blade['input_data'] = $input_data;
        $blade['category'] = Category::find($request->category_id);

        return view('restaurants.edit-confirm', $blade);
    }


    // postで/restaurants/add/completeにアクセスされた場合
    public function complete(Request $request)
    {
        $validator = Restaurant::validation($request);

        if ($validator->fails()) {
            return redirect('restaurants/add')
                        ->withErrors($validator)
                        ->withInput();
        }


        // requestのデータを直接変更したくない
        $input_data = $request->all();
        $open_time = NULL;
        $second_open_time = NULL;
        $close_time = NULL;
        $second_close_time = NULL;
        $lo_time = NULL;
        if (!is_null($request->open_time_h)) {
            if (is_null($request->open_time_m)) $input_data['open_time_m'] = '00';
            $open_time = date('H:i', strtotime($input_data['open_time_h'].':'.$input_data['open_time_m']));
        }
        if (!is_null($request->close_time_h)) {
            if (is_null($request->close_time_m)) $input_data['close_time_m'] = '00';
            $close_time = date('H:i', strtotime($input_data['close_time_h'].':'.$input_data['close_time_m']));
        }
        if (!is_null($request->last_order_h)) {
            if (is_null($request->last_order_m)) $input_data['last_order_m'] = '00';
            $lo_time = date('H:i', strtotime($input_data['last_order_h'].':'.$input_data['last_order_m']));
        }

        // 営業時間が日付をまたいでいるか
        if ((!is_null($open_time) && !is_null($close_time)) && $open_time > $close_time) {
            $second_open_time = date('H:i:s', strtotime('00:00:00'));
            $second_close_time = $close_time;
            $close_time =  date('H:i:s', strtotime('23:59:59'));
        }

        // 住所から緯度経度取得
        $latlng = Restaurant::getGpsFromAddress($input_data['address']);

        $restaurant = Restaurant::create(['category_id'         => $input_data['category_id'],
                                          'name'                => $input_data['restaurant'],
                                          'address'             => $input_data['address'],
                                          'lat'                 => $latlng['lat'],
                                          'lng'                 => $latlng['lng'],
                                          'price'               => $input_data['price'],
                                          'open_time'           => $open_time,
                                          'close_time'          => $close_time,
                                          'second_open_time'    => $second_open_time,
                                          'second_close_time'   => $second_close_time,
                                          'lo_time'             => $lo_time,
                                          'remarks'             => $input_data['remarks'],
                                        ]);

        return redirect('restaurants')->with('message', 'お店を追加しました。');

    }


    // postで/restaurants/edit/completeにアクセスされた場合
    public function editcomplete(Request $request)
    {
        $validator = Restaurant::validation($request);

        if ($validator->fails()) {
            return redirect('restaurants/edit?id='.$request->id)
                        ->withErrors($validator)
                        ->withInput();
        }

        // requestのデータを直接変更したくない
        $input_data = $request->all();
        $times['open_time'] = NULL;
        $times['second_open_time'] = NULL;
        $times['close_time'] = NULL;
        $times['second_close_time'] = NULL;
        $times['lo_time'] = NULL;
        if (!is_null($request->open_time_h)) {
            if (is_null($request->open_time_m)) $input_data['open_time_m'] = '00';
            $times['open_time'] = date('H:i', strtotime($input_data['open_time_h'].':'.$input_data['open_time_m']));
        }
        if (!is_null($request->close_time_h)) {
            if (is_null($request->close_time_m)) $input_data['close_time_m'] = '00';
            $times['close_time'] = date('H:i', strtotime($input_data['close_time_h'].':'.$input_data['close_time_m']));
        }
        if (!is_null($request->last_order_h)) {
            if (is_null($request->last_order_m)) $input_data['last_order_m'] = '00';
            $times['lo_time'] = date('H:i', strtotime($input_data['last_order_h'].':'.$input_data['last_order_m']));
        }

        // 営業時間が日付をまたいでいるか
        if ((!is_null($times['open_time']) && !is_null($times['close_time'])) && $times['open_time'] > $times['close_time']) {
            $times['second_open_time'] = date('H:i:s', strtotime('00:00:00'));
            $times['second_close_time'] = $times['close_time'];
            $times['close_time'] =  date('H:i:s', strtotime('23:59:59'));
        }

        $latlng = Restaurant::getGpsFromAddress($input_data['address']);

        DB::transaction(function () use ($input_data, $latlng, $times) {
            // 差分見て更新
            $restaurant = Restaurant::find($input_data['id']);
            $restaurant->category_id = $input_data['category_id'];
            $restaurant->name = $input_data['restaurant'];
            $restaurant->address = $input_data['address'];
            $restaurant->lat = $latlng['lat'];
            $restaurant->lng = $latlng['lng'];
            $restaurant->price = $input_data['price'];
            $restaurant->open_time = $times['open_time'];
            $restaurant->close_time = $times['close_time'];
            $restaurant->second_open_time = $times['second_open_time'];
            $restaurant->second_close_time = $times['second_close_time'];
            $restaurant->lo_time = $times['lo_time'];
            $restaurant->remarks = $input_data['remarks'];

            $restaurant->save();
        });

        return redirect('restaurants')->with('message', 'お店を修正しました。');

    }

    // postで/restaurants/deleteにアクセスされた場合
    public function delete(Request $request)
    {
        $restaurant = Restaurant::find($request->id);
        if (is_null($restaurant)) redirect('/restaurants');

        $restaurant->delete();

        return redirect('restaurants')->with('message', 'お店を削除しました。');
    }

}

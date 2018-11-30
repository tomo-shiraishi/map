<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Restaurant extends Model
{
    /**
    * 複数代入する属性
    *
    * @var array
    */
    protected $fillable = ['category_id', 'name', 'address', 'lat', 'lng', 'price', 'open_time', 'close_time', 'second_open_time', 'second_close_time', 'lo_time', 'remarks'];
    protected $guarded = ['id'];

    //primaryKeyの変更
    // protected $primaryKey = "id";


    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }


    /* Restaurantクラスの登録、編集時の共通バリデーション
    ** 入力に対してのバリデーション後、営業時間の整合性のバリデーションをフック
    **
    **　return  Validator collection
    */
    public static function validation($request)
    {
        $input_data = $request->all();
        // バリデート
        $validator = Validator::make($request->all(), [
            'restaurant' => 'required|max:20',
            'address' => 'required',
            'price' => 'required|digits_between:1,5',
            'open_time_h' => 'required_with:open_time_m',
            'close_time_h' => 'required_with:close_time_m',
            'last_order_h' => 'required_with:last_order_m',
            'remarks' => 'max:200',
        ]);

        // 開店時間 > 閉店時間であればエラー表示してリダイレクト
        // if (!is_null($request->open_time_h) && !is_null($request->close_time_h)) {
        //     // requestのデータを直接変更したくない
        //     // nullのままデータを整形すると00:00になるためnull値は00に変更する
        //     if (is_null($request->open_time_m)) $input_data['open_time_m'] = '00';
        //     if (is_null($request->close_time_m)) $input_data['close_time_m'] = '00';
        //
        //     $open_time = date('H:i', strtotime($request->open_time_h.':'.$input_data['open_time_m']));
        //     $close_time = date('H:i', strtotime($request->close_time_h.':'.$input_data['close_time_m']));
        //
        //     if ($open_time > $close_time) {
        //         $validator->after(function ($validator) {
        //             $validator->errors()->add('open_close_time', '開店時間は閉店時間より早くしてください。');
        //         });
        //     }
        // }
        //
        // // 開店時間 > LOであればエラー表示してリダイレクト
        // if (!is_null($request->open_time_h) && !is_null($request->last_order_h)) {
        //     // requestのデータを直接変更したくない
        //     // nullのままデータを整形すると00:00になるためnull値は00に変更する
        //     if (is_null($request->open_time_m)) $input_data['open_time_m'] = '00';
        //     if (is_null($request->last_order_m)) $input_data['last_order_m'] = '00';
        //
        //     $open_time = date('H:i', strtotime($request->open_time_h.':'.$input_data['open_time_m']));
        //     $lo_time = date('H:i', strtotime($request->last_order_h.':'.$input_data['last_order_m']));
        //
        //     if ($open_time > $lo_time) {
        //         $validator->after(function ($validator) {
        //             $validator->errors()->add('open_lo_time', '開店時間はラストオーダーより早くしてください。');
        //         });
        //     }
        // }
        //
        // // 開店時間 > LOであればエラー表示してリダイレクト
        // if (!is_null($request->close_time_h) && !is_null($request->last_order_h)) {
        //     // requestのデータを直接変更したくない
        //     // nullのままデータを整形すると00:00になるためnull値は00に変更する
        //     if (is_null($request->close_time_m)) $input_data['close_time_m'] = '00';
        //     if (is_null($request->last_order_m)) $input_data['last_order_m'] = '00';
        //
        //     $close_time = date('H:i', strtotime($request->close_time_h.':'.$input_data['close_time_m']));
        //     $lo_time = date('H:i', strtotime($request->last_order_h.':'.$input_data['last_order_m']));
        //
        //     if ($close_time < $lo_time) {
        //         $validator->after(function ($validator) {
        //             $validator->errors()->add('close_lo_time', '閉店時間はラストオーダーより遅くしてください。');
        //         });
        //     }
        // }

        return $validator;
    }


    /**
    * 住所から緯度経度取得をする
    *
    * return @var array
    */
    public static function getGpsFromAddress( $address='' )
    {
        $res = array();
        $req = 'http://maps.google.com/maps/api/geocode/xml';
        $req .= '?address='.urlencode($address);
        $req .= '&sensor=false';
        $xml = simplexml_load_file($req) or die('XML parsing error');
        if ($xml->status == 'OK') {
            $location = $xml->result->geometry->location;
            $res['lat'] = (string)$location->lat[0];
            $res['lng'] = (string)$location->lng[0];
        }
        return $res;
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;

class Company extends Model
{
    /**
    * 複数代入する属性
    *
    * @var array
    */
    protected $fillable = ['name', 'address', 'lat', 'lng'];
    protected $guarded = ['id'];


    /**
    * 住所から緯度経度取得をする
    *
    * return @var array
    */
    public static function getGpsFromAddress( $address='' ){
        $res = array();
        $req = 'https://www.geocoding.jp/api';
        $req .= '?q='.urlencode($address);
        $xml = simplexml_load_file($req) or die('XML parsing error');
        $res['lat'] = $xml->coordinate->lat;
        $res['lng'] = $xml->coordinate->lng;
        return $res;
    }

    /**
    * 周辺施設を検索する
    *
    * return @var array
    */
    public static function searchFacilities($latlng){
        // 会社住所から周辺施設を取得しDBに格納する
        $array = [];

        // GoogleMapsApiのプレイス検索
        $baseUrl = 'https://maps.googleapis.com/maps/api/place/nearbysearch/';
        $fileType = 'json';

        // TODO: カテゴリを複数指定可能にする
        $query = [
            'location' => "".$latlng['lat'].",".$latlng['lng']."", // 登録した会社の緯度経度
            'radius'   => 500, // 半径
            'type'     => 'restaurant', // カテゴリ
            'key'      => Config::get('googleapikey'),
            'language' => 'ja'
        ];

        // curl用のオプション
        $options = [
          CURLOPT_HTTPGET => true,//GET
          CURLOPT_RETURNTRANSFER => true // fetch datum as strings
        ];

        $facilities = [];
        // 60件取得する
        for ($i = 0; $i < 3; $i++) {

            // next_page_tokenがあれば再度取得しにいくため、クエリパラムに追加する
            // 2回目以降でnext_page_tokenがなければ周辺に施設はないのでbreak
            if (!empty($array) && array_key_exists('next_page_token', $array)) {
                $query += ['next_page_token' => $array['next_page_token']];
            } else if (!empty($array) && !array_key_exists('next_page_token', $array)) {
                break;
            }

            $queryparam = http_build_query($query);
            $url   = $baseUrl.$fileType.'?'.$queryparam;

            $curl = curl_init($url);

            curl_setopt_array($curl, $options);
            $result = curl_exec($curl);
            curl_close ($curl);

            $array = json_decode($result, true);

            foreach ($array['results'] as $facility) {
                array_push($facilities, $facility);
            }
        }

        return $facilities;
    }
}

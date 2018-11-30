<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
    * 複数代入する属性
    *
    * @var array
    */
    protected $fillable = ['name', 'color'];
    protected $guarded = ['id'];


    public function restaurants() {
        return $this->hasMany('App\Models\Restaurant');
    }


    // 全データ取得
    public function getAllData()
    {
        $data = self::get();

        return $data;
    }


    // 特定のデータを1行取得
    public function getData($id)
    {
        $data = self::where('id', '=', $id)->first();

        return $data;
    }
}

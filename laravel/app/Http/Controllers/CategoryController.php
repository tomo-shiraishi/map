<?php

namespace App\Http\Controllers;

use Validator;
use DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\restaurant;

class CategoryController extends Controller
{

    /**
    * getで/categoryにアクセスされた場合
    *
    */
    public function index()
    {
        //モデルのインスタンス
        $model = new Category();

        // 全データ取得
        $categories = $model->getAllData();
        $blade['categories'] = $categories;

        return view('categories.index', $blade);
    }


    /**
    * getで/category/detail?id=*にアクセスされた場合
    *
    */
    public function detail(Request $request)
    {
        // idのみバリデート
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('category');
        }


        // インスタンス
        $model = new Category();
        $category = $model->getData($request->id);

        $blade['category'] = $category;

        return view('categories.detail', $blade);
    }


    /**
    * getで/category/addにアクセスされた場合
    *
    */
    public function add()
    {
        return view('categories.add');
    }


    /**
    * getで/category/editにアクセスされた場合
    *
    */
    public function edit(Request $request)
    {
        // idのみバリデート
        // methodはanyのため、ない場合はカテゴリ一覧に飛ばす
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('category');
        }

        $category = Category::find($request->id);
        $blade['category'] = $category;

        return view('categories.edit', $blade);
    }


    /**
    * postで/category/confirmにアクセスされた場合
    *
    */
    public function confirm(Request $request)
    {
        // バリデート
        $validator = Validator::make($request->all(), [
            'category' => 'required|max:10',
            'color' => 'required|max:7',
        ]);

        if ($validator->fails()) {
            return redirect('category/add')
                        ->withErrors($validator)
                        ->withInput();
        }

        $blade['category'] = $request->category;
        $blade['color'] = $request->color;

        return view('categories.confirm', $blade);
    }


    /**
    * postで/category/edit-confirmにアクセスされた場合
    *
    */
    public function editconfirm(Request $request)
    {
        // バリデート
        $validator = Validator::make($request->all(), [
            'category' => 'required|max:10',
            'color' => 'required|max:7',
        ]);

        if ($validator->fails()) {
            return redirect('category/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $blade['id' ] = $request->id;
        $blade['category'] = $request->category;
        $blade['color'] = $request->color;

        return view('categories.edit-confirm', $blade);
    }


    /**
    * postで/category/completeにアクセスされた場合
    *
    */
    public function complete(Request $request)
    {
        // バリデート
        $validator = Validator::make($request->all(), [
            'category' => 'required|max:10',
            'color' => 'required|max:7',
        ]);

        if ($validator->fails()) {
            return redirect('category/add')
                        ->withErrors($validator)
                        ->withInput();
        }

        $category = Category::create(['name'  => $request->category,
                                      'color' => $request->color
                                    ]);

        return redirect('category')->with('message', 'カテゴリを追加しました。');
    }


    /**
    * postで/category/completeにアクセスされた場合
    *
    */
    public function editcomplete(Request $request)
    {
        // バリデート
        $validator = Validator::make($request->all(), [
            'category' => 'required|max:10',
            'color' => 'required|max:7',
        ]);

        if ($validator->fails()) {
            return redirect('category/add')
                        ->withErrors($validator)
                        ->withInput();
        }

        DB::transaction(function () use ($request) {
            // 差分見て更新
            $category = Category::find($request->id);
            $category->name = $request->category;
            $category->color = $request->color;
            $category->save();
        });

        return redirect('category')->with('message', 'カテゴリを更新しました。');
    }


    /**
    * postで/category/deleteにアクセスされた場合
    *
    */
    public function delete(Request $request)
    {
        // 削除時に、削除するカテゴリをもつレストランに入れる仮のカテゴリを取得
        // エラーが発生する可能性も考え、カテゴリを入れ替えた後、削除を実行
        $temp_category = Category::where('id', '<>', $request->id)->first();
        $restaurants = Restaurant::where('category_id', '=', $request->id)->update(['category_id' => $temp_category->id]);

        $category = Category::find($request->id)->delete();

        return redirect('category')->with('message', 'カテゴリを削除しました。');
    }


}

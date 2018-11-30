<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Restaurant;

class IndexController extends Controller
{
    public function index()
    {
        $blade['company'] = Company::first();
        $blade['restaurants'] = json_encode(Restaurant::get(['id', 'name', 'lat', 'lng'])->toArray());
        return view('index.index', $blade);
    }

}

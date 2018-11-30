<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Company;

class ExistCompany
{
    /**
     * 拠点となる会社が登録されていなければ登録させる。初回時のみ通る
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $company = Company::first();
        $this_url = $request->getrequestUri();
        if (is_null($company) && (strpos($this_url, '/company/add') === false)) return redirect('company/add');

        return $next($request);
    }
}

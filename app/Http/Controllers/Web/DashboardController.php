<?php

namespace App\Http\Controllers\Web;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Libraries\Common;

class DashboardController extends Controller
{
    public $title   = 'Dashboard';
    public $link    = 'dashboard';
    protected $api  = 'api/dashboard';
    protected $common;

    public function __construct()
    {
        $this->middleware(
            function ($request, Closure $next) {
                if (Cookie::get('login') == 'true') {
                    $this->common = new Common();
                    return $next($request);
                } else {
                    return redirect('login');
                }
            }
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<i class="fa fa-home"></i> Dashboard';

        $bulan = $this->common->generate_integer_month();
        $tahun = $this->common->generate_year();

        $data = [];
        $data['breadcrumb'] = $breadcrumb;
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['api'] = url($this->api);
        return View::make('dashboard', $data);
    }
}

<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Kabkota;
use App\Models\Harian;
use App\Libraries\Access;
use Closure;

class HarianController extends Controller
{
    protected $title = 'Besaran Harian';
    protected $link  = 'harian';
    protected $api   = 'api/harian';
    protected $route = 'harian';
    protected $access;

    public function __construct()
    {
        $this->middleware(
            function ($request, Closure $next) {
                if (Cookie::get('login') == true) {
                    $access = new Access();
                    $this->access = $access->generateAccess(Cookie::get('level'));
                    return $next($request);
                } else {
                    return redirect('login');
                }
            }
        );
    }

    public function index()
    {
        $breadcrumb = array();
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<i class="fa fa-balance-scale"></i> ' . $this->title;

        $kabkota = Kabkota::all();

        $data = [];
        $data['breadcrumb'] = $breadcrumb;
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['api'] = url($this->api);
        $data['route'] = url($this->route);
        $data['access'] = $this->access;
        $data['kabkota'] = $kabkota;
        return View::make('harian.index', $data);
    }

    public function edit(Request $request)
    {
        $breadcrumb = array();
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-balance-scale"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data';

        $harian = Harian::find($request['id']);
        $kabkota = Kabkota::all();

        $data = array();
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['harian'] = $harian;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '?id=' . $harian->id);
        $data['act'] = 'edit';
        $data['kabkota'] = $kabkota;
        $data['route'] = url($this->route);
        return View::make('harian.form', $data);
    }
}

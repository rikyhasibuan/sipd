<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Anggaran;
use App\Models\Kegiatan;
use App\Models\Belanja;
use App\Libraries\Access;
use Closure;

class ReportController extends Controller
{
    protected $title = 'Report';
    protected $link  = 'report';
    protected $api   = 'api/report';
    protected $route = 'report';
    protected $access;

    public function __construct() {
        $this->middleware(
            function ($request, Closure $next) {
                if (Cookie::get('login') == true) {
                    $access = new Access();
                    $this->access = $access->generateAccess(Cookie::get('level'));
                    return $next($request);
                } else {
                    return redirect('admin');
                }
            }
        );
    }

    public function index() {
        $breadcrumb = array();
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<i class="fa fa-file-excel-o"></i> ' . $this->title;

        $kegiatan = Kegiatan::all();
        $belanja  = [];

        $data = array();
        $data['breadcrumb'] = $breadcrumb;
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['api'] = url($this->api);
        $data['route'] = url($this->route);
        $data['access'] = $this->access;
        $data['kegiatan'] = $kegiatan;
        $data['belanja'] = $belanja;
        return View::make('report', $data);
    }

}

<?php

namespace App\Http\Controllers\Web;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Irban;
use App\Models\IrbanKabkota;
use App\Models\Kabkota;
use App\Libraries\Access;

class IrbanKabkotaController extends Controller
{
    protected $title = 'Pembagian Wilayah Irban - Kabupaten / Kota';
    protected $link  = 'irbankabkota';
    protected $api   = 'api/irbankabkota';
    protected $route = 'irbankabkota';
    protected $user_cookies;
    protected $_nip;

    public function __construct() {
        $this->middleware(
            function ($request, Closure $next) {
                if (Cookie::get('login') == true) {
                    $access = new Access();
                    $this->access = $access->generateAccess(Cookie::get('level'));
                    $this->user_cookies = Cookie::get('nama');
                    $this->_nip = Cookie::get('nip');
                    return $next($request);
                } else {
                    return redirect('admin');
                }
            }
        );
    }

    public function index() {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="' . url('admin/dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<i class="fa fa-user"></i> '. $this->title;

        $irban = Irban::all();
        $kabkota = Kabkota::all();

        $data = [];
        $data['breadcrumb'] = $breadcrumb;
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['irban'] = $irban;
        $data['kabkota'] = $kabkota;
        $data['api'] = url($this->api);
        $data['route'] = url($this->route);
        $data['access'] = $this->access;

        return View::make('irbankabkota.index', $data);
    }

    public function create() {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="' . url('admin/dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-user"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data';

        $irbankabkota = IrbanKabkota::select('kabkota_id')->get();
        $irban = Irban::all();
        $kabkota = Kabkota::whereNotIn('id', $irbankabkota)->get();

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api.'?nip=' . $this->_nip);
        $data['route'] = url($this->route);
        $data['act'] = 'create';
        $data['irban'] = $irban;
        $data['kabkota'] = $kabkota;

        return View::make('irbankabkota.form', $data);
    }

    public function edit(Request $request) {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="' . url('admin/dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-user"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data';

        $irbankabkota = IrbanKabkota::find($request['id']);
        $irban = Irban::all();
        $kabkota = Kabkota::all();

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['irbankabkota'] = $irbankabkota;
        $data['irban'] = $irban;
        $data['kabkota'] = $kabkota;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '?nip='.$this->_nip.'&id=' . $irbankabkota->id);
        $data['route'] = url($this->route);
        $data['act'] = 'edit';

        return View::make('irbankabkota.form', $data);
    }
}

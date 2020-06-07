<?php

namespace App\Http\Controllers\Web;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Skpd;
use App\Models\Kabkota;
use App\Libraries\Access;

class PerangkatDaerahController extends Controller
{
    protected $title = 'Perangkat Daerah';
    protected $link  = 'perangkatdaerah';
    protected $api   = 'api/perangkatdaerah';
    protected $route = 'perangkatdaerah';
    protected $access;
    protected $user_cookies;
    protected $_nip;

    public function __construct()
    {
        $this->middleware(function ($request, Closure $next) {
            if (Cookie::get('login') == true) {
                $access = new Access();
                $this->access = $access->generateAccess(Cookie::get('level'));
                $this->_nip = Cookie::get('nip');
                return $next($request);
            } else {
                return redirect('admin');
            }
        });
    }

    public function index()
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<i class="fa fa-user"></i> '.$this->title;

        $data = [];
        $data['breadcrumb'] = $breadcrumb;
        $data['title'] = $this->title;
        $data['link'] = $this->link;
        $data['api'] = url($this->api);
        $data['route'] = url($this->route);
        $data['access'] = $this->access;

        return View::make('perangkatdaerah.index', $data);
    }

    public function create()
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-user"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data';

        $kabkota = Kabkota::all();

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api.'?nip=' . $this->_nip);
        $data['route'] = url($this->route);
        $data['kabkota'] = $kabkota;
        $data['act'] = 'create';
        return View::make('perangkatdaerah.form', $data);
    }

    public function edit(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-user"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data';

        $skpd = Skpd::find($request['id']);
        $kabkota = Kabkota::all();

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['skpd'] = $skpd;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '?nip='.$this->_nip.'&id=' . $perangkatdaerah->id);
        $data['route'] = url($this->route);
        $data['kabkota'] = $kabkota;
        $data['act'] = 'edit';

        return View::make('perangkatdaerah.form', $data);
    }
}

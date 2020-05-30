<?php

namespace App\Http\Controllers\Web;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Irban;
use App\Models\IrbanSkpd;
use App\Models\Skpd;
use App\Libraries\Access;

class IrbanSkpdController extends Controller
{
    protected $title = 'Pembagian Wilayah Irban';
    protected $link  = 'irbanskpd';
    protected $api   = 'api/irbanskpd';
    protected $route = 'irbanskpd';
    protected $user_cookies;
    protected $access;
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
        $skpd = Skpd::all();

        $data = [];
        $data['breadcrumb'] = $breadcrumb;
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['irban'] = $irban;
        $data['skpd'] = $skpd;
        $data['api'] = url($this->api);
        $data['route'] = url($this->route);
        $data['access'] = $this->access;

        return View::make('irbanskpd.index', $data);
    }

    public function create() {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="' . url('admin/dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-user"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data';

        $irbanskpd = IrbanSkpd::select('skpd_id')->get();
        $irban = Irban::all();
        $skpd = Skpd::whereNotIn('id', $irbanskpd)->get();

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api.'?nip=' . $this->_nip);
        $data['route'] = url($this->route);
        $data['act'] = 'create';
        $data['irban'] = $irban;
        $data['skpd'] = $skpd;

        return View::make('irbanskpd.form', $data);
    }

    public function edit(Request $request) {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="' . url('admin/dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-user"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data';

        $irbanskpd = IrbanSkpd::find($request['id']);
        $irban = Irban::all();
        $skpd = Skpd::all();

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['irbanskpd'] = $irbanskpd;
        $data['irban'] = $irban;
        $data['skpd'] = $skpd;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '?nip='.$this->_nip.'&id=' . $irbanskpd->id);
        $data['route'] = url($this->route);
        $data['act'] = 'edit';

        return View::make('irbanskpd.form', $data);
    }
}

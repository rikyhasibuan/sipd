<?php

namespace App\Http\Controllers\Web;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Irban;
use App\Models\Pegawai;
use App\Models\IrbanPokja;
use App\Libraries\Access;

class PokjaController extends Controller
{
    protected $title = 'Kelompok Kerja';
    protected $link  = 'pokja';
    protected $api   = 'api/pokja';
    protected $route = 'pokja';
    protected $access;
    protected $user_cookies;
    protected $_nip;

    public function __construct() {
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

    public function index() {
        $breadcrumb = array();
        $breadcrumb[0] = '<a href="' . url('admin/dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<i class="fa fa-file-user"></i> '. $this->title;

        $irban = Irban::all();

        $data = [];
        $data['breadcrumb'] = $breadcrumb;
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['api'] = url($this->api . '?nip=' . $this->_nip);
        $data['route'] = url($this->route);
        $data['irban'] = $irban;
        $data['access'] = $this->access;

        return View::make('pokja.index', $data);
    }

    public function create() {
        $breadcrumb = array();
        $breadcrumb[0] = '<a href="' . url('admin/dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-file-user"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data';

        $irban = Irban::all();
        $pokja = IrbanPokja::select('pegawai_id')->get();
        $pegawai = Pegawai::where('jabatan','<>', 'Sekretaris Daerah')->whereNotIn('id', $pokja)->get();

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api. '?nip='. $this->_nip);
        $data['route'] = url($this->route);
        $data['act'] = 'create';
        $data['irban'] = $irban;
        $data['pegawai'] = $pegawai;

        return View::make('pokja.form', $data);
    }

    public function edit(Request $request) {
        $breadcrumb = array();
        $breadcrumb[0] = '<a href="' . url('admin/dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-file-user"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data';

        $pokja = IrbanPokja::find($request['id']);
        $irban = Irban::all();
        $pegawai = Pegawai::all();

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['pokja'] = $pokja;
        $data['irban'] = $irban;
        $data['pegawai'] = $pegawai;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '?nip='.$this->_nip.'&id=' . $pokja->id);
        $data['route'] = url($this->route);
        $data['act'] = 'edit';

        return View::make('pokja.form', $data);
    }
}

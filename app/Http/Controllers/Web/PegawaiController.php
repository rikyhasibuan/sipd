<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Pangkat;
use App\Models\Jabatan;
use App\Libraries\Access;
use App\Libraries\Common;
use Closure;

class PegawaiController extends Controller
{
    protected $title = 'Pegawai Inspektorat';
    protected $link  = 'pegawai';
    protected $api   = 'api/pegawai';
    protected $route = 'pegawai';
    protected $access;
    protected $common;

    public function __construct()
    {
        $this->middleware(
            function ($request, Closure $next) {
                if (Cookie::get('login') == true) {
                    $access = new Access();
                    $this->common = new Common();
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
        $breadcrumb[1] = '<i class="fa fa-user"></i> ' . $this->title;

        $pangkat = Pangkat::all();
        $jabatan = Jabatan::all();

        $golongan = $this->common->generate_golongan_list();
        $eselon = $this->common->generate_eselon_list();
        
        $data = [];
        $data['breadcrumb'] = $breadcrumb;
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['api'] = url($this->api);
        $data['route'] = url($this->route);
        $data['access'] = $this->access;
        $data['pangkat'] = $pangkat;
        $data['golongan'] = $golongan;
        $data['jabatan'] = $jabatan;
        $data['eselon'] = $eselon;
        return View::make('pegawai.index', $data);
    }

    public function create()
    {
        $breadcrumb = array();
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-user"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data';

        $pangkat = Pangkat::all();
        $jabatan = Jabatan::all();
        $golongan = $this->common->generate_golongan_list();
        $eselon = $this->common->generate_eselon_list();

        $data = array();
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'create';
        $data['pangkat'] = $pangkat;
        $data['golongan'] = $golongan;
        $data['jabatan'] = $jabatan;
        $data['eselon'] = $eselon;
        $data['route'] = url($this->route);
        return View::make('pegawai.form', $data);
    }

    public function edit(Request $request)
    {
        $breadcrumb = array();
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-user"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data';

        $pangkat = Pangkat::all();
        $jabatan = Jabatan::all();

        $pegawai = Pegawai::find($request['id']);

        $golongan = $this->common->generate_golongan_list();
        $eselon = $this->common->generate_eselon_list();

        $data = array();
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['pegawai'] = $pegawai;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '?id=' . $pegawai->id);
        $data['act'] = 'edit';
        $data['pangkat'] = $pangkat;
        $data['golongan'] = $golongan;
        $data['jabatan'] = $jabatan;
        $data['eselon'] = $eselon;
        $data['route'] = url($this->route);
        return View::make('pegawai.form', $data);
    }
}

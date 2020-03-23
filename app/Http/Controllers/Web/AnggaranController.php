<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Program;
use App\Models\Belanja;
use App\Models\Anggaran;
use App\Libraries\Access;
use App\Libraries\Common;
use Closure;

class AnggaranController extends Controller
{
    protected $title = 'Anggaran Kas Bulanan';
    protected $link  = 'anggaran';
    protected $api   = 'api/anggaran';
    protected $route = 'anggaran';
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
        $breadcrumb[1] = '<i class="fa fa-database"></i> ' . $this->title;

        $program = Program::all();
        $kegiatan = [];
        $belanja = [];

        $bulan = $this->common->generate_integer_month();
        $tahun = $this->common->generate_year();
        
        $data = [];
        $data['breadcrumb'] = $breadcrumb;
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['api'] = url($this->api);
        $data['route'] = url($this->route);
        $data['access'] = $this->access;
        $data['program'] = $program;
        $data['kegiatan'] = $kegiatan;
        $data['belanja'] = $belanja;
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        return View::make('anggaran.index', $data);
    }

    public function create()
    {
        $breadcrumb = array();
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data';

        $program = Program::all();
        $kegiatan = [];
        $belanja = [];
        
        $bulan = $this->common->generate_integer_month();
        $tahun = $this->common->generate_year();

        $data = array();
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'create';
        $data['program'] = $program;
        $data['kegiatan'] = $kegiatan;
        $data['belanja'] = $belanja;
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['route'] = url($this->route);
        return View::make('anggaran.form', $data);
    }

    public function edit(Request $request)
    {
        $breadcrumb = array();
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data';

        $anggaran = Anggaran::find($request['id']);
        
        $program = Program::all();
        $kegiatan = Kegiatan::all();
        $belanja = Belanja::all();
        
        $bulan = $this->common->generate_integer_month();
        $tahun = $this->common->generate_year();

        $data = array();
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['anggaran'] = $anggaran;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '?id=' . $anggaran->id);
        $data['act'] = 'edit';
        $data['program'] = $program;
        $data['kegiatan'] = $kegiatan;
        $data['belanja'] = $belanja;
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['route'] = url($this->route);
        return View::make('anggaran.form', $data);
    }
}

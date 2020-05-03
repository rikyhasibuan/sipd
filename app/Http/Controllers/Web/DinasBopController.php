<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Pegawai;
use App\Models\DinasBop;
use App\Models\DinasBopTim;
use App\Models\DinasBopDriver;
use App\Models\Irban;
use App\Libraries\Access;
use Closure;

class DinasBopController extends Controller
{
    protected $title = 'Perjalanan Dinas BOP';
    protected $link  = 'dinasbop';
    protected $api   = 'api/dinasbop';
    protected $route = 'dinasbop';
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
        $breadcrumb[1] = '<i class="fa fa-database"></i> ' . $this->title;

        $program = Program::all();
        $kegiatan = [];
        $belanja = [];
        
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
        return View::make('dinasbop.index', $data);
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

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'create';
        $data['program'] = $program;
        $data['kegiatan'] = $kegiatan;
        $data['belanja'] = $belanja;
        $data['route'] = url($this->route);
        return View::make('dinasbop.form', $data);
    }

    public function edit(Request $request)
    {
        $breadcrumb = array();
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data';

        $dinasbop = DinasBop::find($request['id']);
        
        $program = Program::all();
        $kegiatan = [];
        $belanja = [];

        $data = array();
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasbop'] = $dinasbop;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '?id=' . $dinasbop->id);
        $data['act'] = 'edit';
        $data['program'] = $program;
        $data['kegiatan'] = $kegiatan;
        $data['belanja'] = $belanja;
        $data['route'] = url($this->route);
        return View::make('dinasbop.form', $data);
    }

    public function detail(Request $request)
    {
        $breadcrumb = array();
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-search"></i> Detail';

        $dinasbop = DinasBop::with('program', 'kegiatan', 'belanja')->find($request['id']);
        $dinasboptim = DinasBopTim::where('dinasbop_id', $dinasbop->id)->get();
        $dinasbopdriver = DinasBopDriver::where('dinasbop_id', $dinasbop->id)->get();
        
        $data = array();
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasbop'] = $dinasbop;
        $data['dinasboptim'] = $dinasboptim;
        $data['dinasbopdriver'] = $dinasbopdriver;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['route'] = url($this->route);
        return View::make('dinasbop.detail', $data);
    }

    public function create_tim(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data Tim';

        $irban = Irban::all();
        $auditan = [];
        
        $driver = Pegawai::where('jabatan', 'Pengemudi')->get();
        
        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'create';
        $data['irban'] = $irban;
        $data['auditan'] = $auditan;
        $data['driver'] = $driver;
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        $data['dinasbop'] = $request['dinasbop'];
        return View::make('dinasbop.form_tim', $data);
    }

    public function edit_tim(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data';

        $dinasboptim = DinasBopTim::find($request['id']);
        
        $irban = Irban::all();
        $auditan = [];
        
        $driver = Pegawai::where('jabatan', 'Pengemudi')->get();

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasboptim'] = $dinasboptim;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'edit';
        $data['irban'] = $irban;
        $data['auditan'] = $auditan;
        $data['driver'] = $driver;
        $data['dinasbop'] = $request['dinasbop'];
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        return View::make('dinasbop.form_tim', $data);
    }

    public function create_driver(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data Pengemudi';
        
        $driver = Pegawai::where('jabatan', 'Pengemudi')->get();
        
        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'create';
        $data['driver'] = $driver;
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        $data['dinasbop'] = $request['dinasbop'];
        return View::make('dinasbop.form_driver', $data);
    }

    public function edit_driver(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data Pengemudi';

        $dinasbopdriver = DinasBopDriver::find($request['id']);
        
        $driver = Pegawai::where('jabatan', 'Pengemudi')->get();

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasbopdriver'] = $dinasbopdriver;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'edit';
        $data['driver'] = $driver;
        $data['dinasbop'] = $request['dinasbop'];
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        return View::make('dinasbop.form_driver', $data);
    }

    public function create_inspektur(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data';
        
        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'create';
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        $data['dinasbop'] = $request['dinasbop'];
        return View::make('dinasbop.form_inspektur', $data);
    }

    public function edit_inspektur(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data';

        $dinasbopinspektur = DinasBopInspektur::find($request['id']);

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasbopdriver'] = $dinasbopdriver;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'edit';
        $data['dinasbop'] = $request['dinasbop'];
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        return View::make('dinasbop.form_inspektur', $data);
    }
}

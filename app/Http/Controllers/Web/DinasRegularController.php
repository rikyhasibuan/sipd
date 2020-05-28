<?php

namespace App\Http\Controllers\Web;

use App\Models\DinasRegularApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Program;
use App\Models\Belanja;
use App\Models\DinasRegular;
use App\Models\DinasRegularTim;
use App\Models\Pegawai;
use App\Models\Kabkota;
use App\Models\Bbm;
use App\Libraries\Access;
use Closure;

class DinasRegularController extends Controller
{
    protected $title = 'Perjalanan Dinas Regular';
    protected $link  = 'dinasregular';
    protected $api   = 'api/dinasregular';
    protected $route = 'dinasregular';
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
        return View::make('dinasregular.index', $data);
    }

    public function create()
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data';

        $program = Program::all();

        $kegiatan = [];
        $belanja = [];
        $auditan = Kabkota::all();
        $anggota = Pegawai::all();

        $data = array();
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'create';
        $data['program'] = $program;
        $data['kegiatan'] = $kegiatan;
        $data['belanja'] = $belanja;
        $data['auditan'] = $auditan;
        $data['anggota'] = $anggota;
        $data['route'] = url($this->route);
        return View::make('dinasregular.form', $data);
    }

    public function edit(Request $request)
    {
        $breadcrumb = array();
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data';

        $dinasregular = DinasRegular::find($request['id']);

        $program = Program::all();
        $auditan = Kabkota::all();
        $anggota = Pegawai::all();

        $kegiatan = [];
        $belanja = [];

        $data = array();
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasregular'] = $dinasregular;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '?id=' . $dinasregular->id);
        $data['act'] = 'edit';
        $data['program'] = $program;
        $data['kegiatan'] = $kegiatan;
        $data['belanja'] = $belanja;
        $data['auditan'] = $auditan;
        $data['anggota'] = $anggota;
        $data['route'] = url($this->route);
        return View::make('dinasregular.form', $data);
    }

    public function detail(Request $request)
    {
        $breadcrumb = array();
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-search"></i> Detail';

        $dinasregular = DinasRegular::with('program', 'kegiatan', 'belanja')->find($request['id']);

        $jenistransportasi = ['BBM','Sewa Kendaraan','Tiket'];
        $kabkota = Kabkota::where('nama_kabkota', $dinasregular->auditan)->first();

        $takaran = Bbm::where('kabkota_id', $kabkota['id'])->first();
        $range = explode("-", $takaran['liter']);

        $takaranliter = [];
        for ($i=$range[0]; $i <= $range[1]; $i++) {
            $takaranliter[$i] = $i;
        }

        $dinasregularapproval = DinasRegularApproval::where('dinasregular_id', $request['id'])->first();

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasregular'] = $dinasregular;
        $data['dinasregularapproval'] = $dinasregularapproval;
        $data['jenistransportasi'] = $jenistransportasi;
        $data['takaranliter'] = $takaranliter;
        $data['breadcrumb'] = $breadcrumb;
        $data['access'] = $this->access;
        $data['api'] = url($this->api);
        $data['route'] = url($this->route);
        return View::make('dinasregular.detail', $data);
    }

    public function transportasi(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasregular'].'"><i class="fa fa-database"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data';

        $dinasregular = DinasRegular::find($request['id']);
        $jenistransportasi = ['BBM','Sewa Kendaraan','Tiket'];
        $kabkota = Kabkota::where('nama_kabkota', $dinasregular->auditan)->first();

        $takaran = Bbm::where('kabkota_id', $kabkota['id'])->first();
        $range = explode("-", $takaran['liter']);

        $takaranliter = [];
        for ($i=$range[0]; $i <= $range[1]; $i++) {
            $takaranliter[$i] = $i;
        }

        $data = array();
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'edit';
        $data['jenistransportasi'] = $jenistransportasi;
        $data['dinasregular'] = $dinasregular;
        $data['takaranliter'] = $takaranliter;
        $data['route'] = url($this->route.'/detail?id='.$request['dinasregular']);
        return View::make('dinasregular.form_transportasi', $data);
    }
}

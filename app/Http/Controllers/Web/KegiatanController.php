<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Program;
use App\Models\Pegawai;
use App\Libraries\Access;
use Closure;

class KegiatanController extends Controller
{
    protected $title = 'Kegiatan';
    protected $link  = 'kegiatan';
    protected $api   = 'api/kegiatan';
    protected $route = 'kegiatan';
    protected $access;
    protected $_nip;

    public function __construct()
    {
        $this->middleware(
            function ($request, Closure $next) {
                if (Cookie::get('login') == true) {
                    $access = new Access();
                    $this->access = $access->generateAccess(Cookie::get('level'));
                    $this->_nip = Cookie::get('nip');
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
        $bendahara = Pegawai::where('jabatan', 'Pengelola Keuangan')->get();

        $data = [];
        $data['breadcrumb'] = $breadcrumb;
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['api'] = url($this->api);
        $data['route'] = url($this->route);
        $data['access'] = $this->access;
        $data['program'] = $program;
        $data['bendahara'] = $bendahara;
        return View::make('kegiatan.index', $data);
    }

    public function create()
    {
        $breadcrumb = array();
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data';

        $program = Program::all();
        $bendahara = Pegawai::where('jabatan', 'Pengelola Keuangan')->get();

        $data = array();
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api.'?nip=' . $this->_nip);
        $data['act'] = 'create';
        $data['program'] = $program;
        $data['bendahara'] = $bendahara;
        $data['route'] = url($this->route);
        return View::make('kegiatan.form', $data);
    }

    public function edit(Request $request)
    {
        $breadcrumb = array();
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data';

        $kegiatan = Kegiatan::find($request['id']);
        $program = Program::all();
        $bendahara = Pegawai::where('jabatan', 'Pengelola Keuangan')->get();

        $data = array();
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['kegiatan'] = $kegiatan;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '?nip='.$this->_nip.'&id=' . $kegiatan->id);
        $data['act'] = 'edit';
        $data['program'] = $program;
        $data['bendahara'] = $bendahara;
        $data['route'] = url($this->route);
        return View::make('kegiatan.form', $data);
    }
}

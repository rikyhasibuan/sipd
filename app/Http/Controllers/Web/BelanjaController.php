<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Program;
use App\Models\Belanja;
use App\Libraries\Access;
use Closure;

class BelanjaController extends Controller
{
    protected $title = 'Belanja';
    protected $link  = 'belanja';
    protected $api   = 'api/belanja';
    protected $route = 'belanja';
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

        $data = [];
        $data['breadcrumb'] = $breadcrumb;
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['api'] = url($this->api);
        $data['route'] = url($this->route);
        $data['access'] = $this->access;
        $data['program'] = $program;
        $data['kegiatan'] = $kegiatan;
        return View::make('belanja.index', $data);
    }

    public function create()
    {
        $breadcrumb = array();
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data';

        $program = Program::all();
        $kegiatan = [];

        $data = array();
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'create';
        $data['program'] = $program;
        $data['kegiatan'] = $kegiatan;
        $data['route'] = url($this->route);
        return View::make('belanja.form', $data);
    }

    public function edit(Request $request)
    {
        $breadcrumb = array();
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data';

        $belanja = Belanja::find($request['id']);
        $program = Program::all();
        $kegiatan = Kegiatan::all();

        $data = array();
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['belanja'] = $belanja;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'edit';
        $data['program'] = $program;
        $data['kegiatan'] = $kegiatan;
        $data['route'] = url($this->route);
        return View::make('belanja.form', $data);
    }
}

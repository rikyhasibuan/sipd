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
use App\Models\DinasBopCustomTim;
use App\Models\DinasBopDriver;
use App\Models\DinasBopInspektur;
use App\Models\DinasBopSekretaris;
use App\Models\DinasBopReviu;
use App\Models\DinasBopSupervisi;
use App\Models\DinasBopPengumpulData;
use App\Models\DinasBopPengumpulDataTim;
use App\Models\DinasBopAdministrasi;
use App\Models\DinasBopAdministrasiTim;
use App\Models\DinasBopApproval;
use App\Models\Irban;
use App\Models\IrbanKabkota;
use App\Models\IrbanSkpd;
use App\Libraries\Access;
use Closure;

class DinasBopController extends Controller
{
    protected $title = 'Perjalanan Dinas BOP';
    protected $link  = 'dinasbop';
    protected $api   = 'api/dinasbop';
    protected $route = 'dinasbop';
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
        $breadcrumb = [];
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
        $breadcrumb = [];
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
        $data['api'] = url($this->api.'?nip=' . $this->_nip);
        $data['act'] = 'create';
        $data['program'] = $program;
        $data['kegiatan'] = $kegiatan;
        $data['belanja'] = $belanja;
        $data['route'] = url($this->route);
        return View::make('dinasbop.form', $data);
    }

    public function edit(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data';

        $dinasbop = DinasBop::find($request['id']);

        $program = Program::all();
        $kegiatan = [];
        $belanja = [];

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasbop'] = $dinasbop;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '?nip='.$this->_nip.'&id=' . $dinasbop->id);
        $data['act'] = 'edit';
        $data['program'] = $program;
        $data['kegiatan'] = $kegiatan;
        $data['belanja'] = $belanja;
        $data['route'] = url($this->route);
        return View::make('dinasbop.form', $data);
    }

    public function detail(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-search"></i> Detail Dinas BOP';

        $dinasbop = DinasBop::with('program', 'kegiatan', 'belanja')->find($request['id']);
        $dinasboptim = DinasBopTim::where('dinasbop_id', $dinasbop->id)->get();
        $dinasbopdriver = DinasBopDriver::where('dinasbop_id', $dinasbop->id)->get();
        $dinasbopinspektur = DinasBopInspektur::where('dinasbop_id', $dinasbop->id)->get();
        $dinasbopsekretaris = DinasBopSekretaris::where('dinasbop_id', $dinasbop->id)->get();
        $dinasbopreviu = DinasBopReviu::where('dinasbop_id', $dinasbop->id)->first();
        $dinasbopsupervisi = DinasBopSupervisi::where('dinasbop_id', $dinasbop->id)->first();
        $dinasbopapproval = DinasBopApproval::where('dinasbop_id', $dinasbop->id)->get();
        $dinasbopcustom = DinasBopCustomTim::where('dinasbop_id', $dinasbop->id)->get();
        $dinasboppengumpuldata_count = DinasBopPengumpulData::where('dinasbop_id', $dinasbop->id)->count();
        $dinasbopadministrasi_count = DinasBopAdministrasi::where('dinasbop_id', $dinasbop->id)->count();

        $lock = 0;
        foreach ($dinasbopapproval as $v) {
            if ($v->lock == 1) {
                $lock++;
            }
        }

        if ($dinasboppengumpuldata_count > 0) {
            $dinasboppengumpuldata = DinasBopPengumpulData::with('dinasbop')->where('dinasbop_id', $dinasbop->id)->first();
            $dinasboptimpengumpuldata = DinasBopPengumpulDataTim::where('dinasbop_pengumpuldata_id', $dinasboppengumpuldata->id)->get();
        } else {
            $dinasboppengumpuldata = [];
            $dinasboptimpengumpuldata = [];
        }

        if ($dinasbopadministrasi_count > 0) {
            $dinasbopadministrasi = DinasBopAdministrasi::with('dinasbop')->where('dinasbop_id', $dinasbop->id)->first();
            $dinasboptimadministrasi = DinasBopAdministrasiTim::where('dinasbop_administrasi_id', $dinasbopadministrasi->id)->get();
        } else {
            $dinasbopadministrasi = [];
            $dinasboptimadministrasi = [];
        }

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasbop'] = $dinasbop;
        $data['dinasboptim'] = $dinasboptim;
        $data['dinasbopdriver'] = $dinasbopdriver;
        $data['dinasbopinspektur'] = $dinasbopinspektur;
        $data['dinasbopsekretaris'] = $dinasbopsekretaris;
        $data['dinasbopreviu'] = $dinasbopreviu;
        $data['dinasbopsupervisi'] = $dinasbopsupervisi;
        $data['dinasboppengumpuldata'] = $dinasboppengumpuldata;
        $data['dinasboptimpengumpuldata'] = $dinasboptimpengumpuldata;
        $data['dinasbopadministrasi'] = $dinasbopadministrasi;
        $data['dinasboptimadministrasi'] = $dinasboptimadministrasi;
        $data['dinasbopcustom'] = $dinasbopcustom;
        $data['dinasbopapproval'] = $dinasbopapproval;
        $data['lock'] = $lock;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['route'] = url($this->route);
        $data['access'] = $this->access;
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
        $dinasbop_data = DinasBop::find($request['dinasbop']);

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
        $data['dinasbop_data'] = $dinasbop_data;
        return View::make('dinasbop.form_tim', $data);
    }

    public function edit_tim(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data Tim';

        $dinasboptim = DinasBopTim::find($request['id']);

        $irban = Irban::all();
        $auditan = [];

        $driver = Pegawai::where('jabatan', 'Pengemudi')->get();

        $dinasbop_data = DinasBop::find($request['dinasbop']);

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
        $data['dinasbop_data'] = $dinasbop_data;
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        return View::make('dinasbop.form_tim', $data);
    }

    public function create_driver(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data Driver';

        $driver = Pegawai::where('jabatan', 'Pengemudi')->get();
        $dinasbop_data = DinasBop::find($request['dinasbop']);

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'create';
        $data['driver'] = $driver;
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        $data['dinasbop'] = $request['dinasbop'];
        $data['dinasbop_data'] = $dinasbop_data;
        return View::make('dinasbop.form_driver', $data);
    }

    public function edit_driver(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data Driver';

        $dinasbopdriver = DinasBopDriver::find($request['id']);
        $driver = Pegawai::where('jabatan', 'Pengemudi')->get();
        $dinasbop_data = DinasBop::find($request['dinasbop']);

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasbopdriver'] = $dinasbopdriver;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'edit';
        $data['driver'] = $driver;
        $data['dinasbop'] = $request['dinasbop'];
        $data['dinasbop_data'] = $dinasbop_data;
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        return View::make('dinasbop.form_driver', $data);
    }

    public function create_inspektur(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data Inspektur';

        $dinasbop_data = DinasBop::find($request['dinasbop']);

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'create';
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        $data['dinasbop'] = $request['dinasbop'];
        $data['dinasbop_data'] = $dinasbop_data;
        return View::make('dinasbop.form_inspektur', $data);
    }

    public function edit_inspektur(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data Inspektur';

        $dinasbopinspektur = DinasBopInspektur::find($request['id']);
        $dinasbop_data = DinasBop::find($request['dinasbop']);

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasbopinspektur'] = $dinasbopinspektur;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'edit';
        $data['dinasbop'] = $request['dinasbop'];
        $data['dinasbop_data'] = $dinasbop_data;
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        return View::make('dinasbop.form_inspektur', $data);
    }

    public function create_sekretaris(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data Sekretaris';

        $dinasbop_data = DinasBop::find($request['dinasbop']);

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'create';
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        $data['dinasbop'] = $request['dinasbop'];
        $data['dinasbop_data'] = $dinasbop_data;
        return View::make('dinasbop.form_sekretaris', $data);
    }

    public function edit_sekretaris(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data Sekretaris';

        $dinasbopsekretaris = DinasBopSekretaris::find($request['id']);
        $dinasbop_data = DinasBop::find($request['dinasbop']);

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasbopsekretaris'] = $dinasbopsekretaris;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'edit';
        $data['dinasbop'] = $request['dinasbop'];
        $data['dinasbop_data'] = $dinasbop_data;
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        return View::make('dinasbop.form_sekretaris', $data);
    }

    public function create_reviu(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data Reviu & Monitoring';

        $dinasbop_data = DinasBop::find($request['dinasbop']);

        $jabatan_anggota = [
            'Analis Perencanaan, Evaluasi dan Pelaporan',
            'Pengelola Evaluasi Tindak Lanjut Laporan Hasil Pemeriksaan',
            'Analis Laporan Hasil Pengawasan',
            'Perencana Pertama',
            'Pengolah Data Perencanaan dan Penganggaran',
            'Pengadministrasi Perencanaan dan Program',
            'Pengelola Keuangan',
            'Verifikatur',
            'Analis Laporan Keuangan',
            'Bendahara',
            'Pengadministrasi Keuangan',
            'Pengelola Gaji',
            'Pengadministrasi Umum',
            'Pengelola Barang Milik Negara',
            'Pengelola Kepegawaian',
            'Analis Sumber Daya Manusia Aparatur',
            'Pengelola Barang Milik Negara (Penyimpan Barang)'
        ];

        $jabatan_ketua = [
            'Kepala Sub Bagian Perencanaan dan Pelaporan',
            'Kepala Sub Bagian Keuangan dan Aset',
            'Kepala Sub Bagian Kepegawaian dan Umum'
        ];

        $anggota = Pegawai::whereIn('jabatan', $jabatan_anggota)->get();
        $ketua = Pegawai::whereIn('jabatan', $jabatan_ketua)->get();

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'create';
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        $data['dinasbop'] = $request['dinasbop'];
        $data['anggota'] = $anggota;
        $data['ketua'] = $ketua;
        $data['dinasbop_data'] = $dinasbop_data;
        return View::make('dinasbop.form_reviu', $data);
    }

    public function edit_reviu(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data Reviu & Monitoring';

        $dinasbopreviu = DinasBopReviu::find($request['id']);
        $dinasbop_data = DinasBop::find($request['dinasbop']);

        $jabatan_anggota = [
            'Analis Perencanaan, Evaluasi dan Pelaporan',
            'Pengelola Evaluasi Tindak Lanjut Laporan Hasil Pemeriksaan',
            'Analis Laporan Hasil Pengawasan',
            'Perencana Pertama',
            'Pengolah Data Perencanaan dan Penganggaran',
            'Pengadministrasi Perencanaan dan Program',
            'Pengelola Keuangan',
            'Verifikatur',
            'Analis Laporan Keuangan',
            'Bendahara',
            'Pengadministrasi Keuangan',
            'Pengelola Gaji',
            'Pengadministrasi Umum',
            'Pengelola Barang Milik Negara',
            'Pengelola Kepegawaian',
            'Analis Sumber Daya Manusia Aparatur',
            'Pengelola Barang Milik Negara (Penyimpan Barang)'
        ];

        $jabatan_ketua = [
            'Kepala Sub Bagian Perencanaan dan Pelaporan',
            'Kepala Sub Bagian Keuangan dan Aset',
            'Kepala Sub Bagian Kepegawaian dan Umum'
        ];

        $anggota = Pegawai::whereIn('jabatan', $jabatan_anggota)->get();
        $ketua = Pegawai::whereIn('jabatan', $jabatan_ketua)->get();

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasbopreviu'] = $dinasbopreviu;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'edit';
        $data['dinasbop'] = $request['dinasbop'];
        $data['dinasbop_data'] = $dinasbop_data;
        $data['anggota'] = $anggota;
        $data['ketua'] = $ketua;
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        return View::make('dinasbop.form_reviu', $data);
    }

    public function create_supervisi(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data Supervisi';

        $dinasbop_data = DinasBop::find($request['dinasbop']);

        $jabatan_anggota = [
            'Analis Perencanaan, Evaluasi dan Pelaporan',
            'Pengelola Evaluasi Tindak Lanjut Laporan Hasil Pemeriksaan',
            'Analis Laporan Hasil Pengawasan',
            'Perencana Pertama',
            'Pengolah Data Perencanaan dan Penganggaran',
            'Pengadministrasi Perencanaan dan Program',
            'Pengelola Keuangan',
            'Verifikatur',
            'Analis Laporan Keuangan',
            'Bendahara',
            'Pengadministrasi Keuangan',
            'Pengelola Gaji',
            'Pengadministrasi Umum',
            'Pengelola Barang Milik Negara',
            'Pengelola Kepegawaian',
            'Analis Sumber Daya Manusia Aparatur',
            'Pengelola Barang Milik Negara (Penyimpan Barang)'
        ];

        $jabatan_ketua = [
            'Kepala Sub Bagian Perencanaan dan Pelaporan',
            'Kepala Sub Bagian Keuangan dan Aset',
            'Kepala Sub Bagian Kepegawaian dan Umum'
        ];

        $anggota = Pegawai::whereIn('jabatan', $jabatan_anggota)->get();
        $ketua = Pegawai::whereIn('jabatan', $jabatan_ketua)->get();

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'create';
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        $data['dinasbop'] = $request['dinasbop'];
        $data['anggota'] = $anggota;
        $data['ketua'] = $ketua;
        $data['dinasbop_data'] = $dinasbop_data;
        return View::make('dinasbop.form_supervisi', $data);
    }

    public function edit_supervisi(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data Supervisi';

        $dinasbopsupervisi = DinasBopSupervisi::find($request['id']);
        $dinasbop_data = DinasBop::find($request['dinasbop']);

        $jabatan_anggota = [
            'Analis Perencanaan, Evaluasi dan Pelaporan',
            'Pengelola Evaluasi Tindak Lanjut Laporan Hasil Pemeriksaan',
            'Analis Laporan Hasil Pengawasan',
            'Perencana Pertama',
            'Pengolah Data Perencanaan dan Penganggaran',
            'Pengadministrasi Perencanaan dan Program',
            'Pengelola Keuangan',
            'Verifikatur',
            'Analis Laporan Keuangan',
            'Bendahara',
            'Pengadministrasi Keuangan',
            'Pengelola Gaji',
            'Pengadministrasi Umum',
            'Pengelola Barang Milik Negara',
            'Pengelola Kepegawaian',
            'Analis Sumber Daya Manusia Aparatur',
            'Pengelola Barang Milik Negara (Penyimpan Barang)'
        ];

        $jabatan_ketua = [
            'Kepala Sub Bagian Perencanaan dan Pelaporan',
            'Kepala Sub Bagian Keuangan dan Aset',
            'Kepala Sub Bagian Kepegawaian dan Umum'
        ];

        $anggota = Pegawai::whereIn('jabatan', $jabatan_anggota)->get();
        $ketua = Pegawai::whereIn('jabatan', $jabatan_ketua)->get();

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasbopsupervisi'] = $dinasbopsupervisi;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'edit';
        $data['dinasbop'] = $request['dinasbop'];
        $data['dinasbop_data'] = $dinasbop_data;
        $data['anggota'] = $anggota;
        $data['ketua'] = $ketua;
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        return View::make('dinasbop.form_supervisi', $data);
    }

    public function create_pengumpuldata(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Pengumpul Data';

        $dinasbop = DinasBop::find($request['dinasbop']);
        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '/pengumpuldata?nip='.$this->_nip.'&dinasbop=' . $request['dinasbop']);
        $data['act'] = 'create';
        $data['dinasbop'] = $dinasbop;
        $data['route'] = url($this->route  .'/detail?id='. $request['dinasbop']);
        return View::make('dinasbop.form_pengumpuldata', $data);
    }

    public function edit_pengumpuldata(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Pengumpul Data';

        $dinasboppengumpuldata = DinasBopPengumpuldata::find($request['id']);
        $dinasbop = DinasBop::find($request['dinasbop']);

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasboppengumpuldata'] = $dinasboppengumpuldata;
        $data['dinasbop'] = $request['dinasbop'];
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '/pengumpuldata?nip='.$this->_nip.'&dinasbop='.$request['dinasbop'].'&id=' . $dinasboppengumpuldata->id);
        $data['act'] = 'edit';
        $data['dinasbop'] = $dinasbop;
        $data['route'] = url($this->route  .'/detail?id='. $request['dinasbop']);
        return View::make('dinasbop.form_pengumpuldata', $data);
    }

    public function create_pengumpuldata_tim(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Tim Pengumpul Data';

        $auditan = [];
        $kabkota = IrbanKabkota::with('kabkota')->get();
        $skpd = IrbanSkpd::with('skpd')->get();

        foreach ($kabkota as $v) {
            $auditan['Kabupaten / Kota'][$v->kabkota->nama_kabkota] = $v->kabkota->nama_kabkota;
        }

        foreach ($skpd as $v) {
            $auditan['Perangkat Daerah'][$v->skpd->nama_skpd] = $v->skpd->nama_skpd;
        }

        $jabatan_anggota = [
            'Analis Perencanaan, Evaluasi dan Pelaporan',
            'Pengelola Evaluasi Tindak Lanjut Laporan Hasil Pemeriksaan',
            'Analis Laporan Hasil Pengawasan',
            'Perencana Pertama',
            'Pengolah Data Perencanaan dan Penganggaran',
            'Pengadministrasi Perencanaan dan Program',
            'Pengelola Keuangan',
            'Verifikatur',
            'Analis Laporan Keuangan',
            'Bendahara',
            'Pengadministrasi Keuangan',
            'Pengelola Gaji',
            'Pengadministrasi Umum',
            'Pengelola Barang Milik Negara',
            'Pengelola Kepegawaian',
            'Analis Sumber Daya Manusia Aparatur',
            'Pengelola Barang Milik Negara (Penyimpan Barang)'
        ];

        $jabatan_ketua = [
            'Kepala Sub Bagian Perencanaan dan Pelaporan',
            'Kepala Sub Bagian Keuangan dan Aset',
            'Kepala Sub Bagian Kepegawaian dan Umum',
            'Sekretaris'
        ];

        $anggota = Pegawai::whereIn('jabatan', $jabatan_anggota)->get();
        $ketua = Pegawai::whereIn('jabatan', $jabatan_ketua)->get();

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '/timpengumpuldata?nip='.$this->_nip.'&dinasbop='.$request['dinasbop'].'&pengumpuldata=' . $request['pengumpuldata']);
        $data['act'] = 'create';
        $data['auditan'] = $auditan;
        $data['anggota'] = $anggota;
        $data['ketua'] = $ketua;
        $data['route'] = url($this->route.'/detail?id='. $request['dinasbop']);
        $data['dinasbop'] = $request['dinasbop'];
        $data['dinasboppengumpuldata'] = DinasBopPengumpulData::find($request['pengumpuldata']);
        return View::make('dinasbop.form_timpengumpuldata', $data);
    }

    public function edit_pengumpuldata_tim(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Pengumpul Data';

        $dinasboptimpengumpuldata = DinasBopPengumpulDataTim::find($request['id']);

        $jabatan_anggota = [
            'Analis Perencanaan, Evaluasi dan Pelaporan',
            'Pengelola Evaluasi Tindak Lanjut Laporan Hasil Pemeriksaan',
            'Analis Laporan Hasil Pengawasan',
            'Perencana Pertama',
            'Pengolah Data Perencanaan dan Penganggaran',
            'Pengadministrasi Perencanaan dan Program',
            'Pengelola Keuangan',
            'Verifikatur',
            'Analis Laporan Keuangan',
            'Bendahara',
            'Pengadministrasi Keuangan',
            'Pengelola Gaji',
            'Pengadministrasi Umum',
            'Pengelola Barang Milik Negara',
            'Pengelola Kepegawaian',
            'Analis Sumber Daya Manusia Aparatur',
            'Pengelola Barang Milik Negara (Penyimpan Barang)'
        ];

        $jabatan_ketua = [
            'Kepala Sub Bagian Perencanaan dan Pelaporan',
            'Kepala Sub Bagian Keuangan dan Aset',
            'Kepala Sub Bagian Kepegawaian dan Umum',
            'Sekretaris'
        ];

        $anggota = Pegawai::whereIn('jabatan', $jabatan_anggota)->get();
        $ketua = Pegawai::whereIn('jabatan', $jabatan_ketua)->get();

        $auditan = [];
        $kabkota = IrbanKabkota::with('kabkota')->get();
        $skpd = IrbanSkpd::with('skpd')->get();

        foreach ($kabkota as $v) {
            $auditan['Kabupaten / Kota'][$v->kabkota->nama_kabkota] = $v->kabkota->nama_kabkota;
        }

        foreach ($skpd as $v) {
            $auditan['Perangkat Daerah'][$v->skpd->nama_skpd] = $v->skpd->nama_skpd;
        }

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasboptimpengumpuldata'] = $dinasboptimpengumpuldata;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '/timpengumpuldata?nip='.$this->_nip.'&id='.$request['id'].'&pengumpuldata=' . $request['pengumpuldata']);
        $data['act'] = 'edit';
        $data['auditan'] = $auditan;
        $data['anggota'] = $anggota;
        $data['ketua'] = $ketua;
        $data['dinasbop'] = $request['dinasbop'];
        $data['pengumpuldata'] = DinasBopPengumpulData::find($request['pengumpuldata']);
        $data['route'] = url($this->route.'/detail?id='.$dinasboptimpengumpuldata->dinasbop_id);
        return View::make('dinasbop.form_timpengumpuldata', $data);
    }

    public function create_administrasi(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data Pengadministrasi';

        $dinasbop = DinasBop::find($request['dinasbop']);

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '/administrasi?nip='.$this->_nip.'&dinasbop=' . $request['dinasbop']);
        $data['act'] = 'create';
        $data['dinasbop'] = $dinasbop;
        $data['route'] = url($this->route  .'/detail?id='. $request['dinasbop']);
        return View::make('dinasbop.form_administrasi', $data);
    }

    public function edit_administrasi(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="' . url('dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data Pengadministrasi';

        $dinasbopadministrasi = DinasBopAdministrasi::find($request['id']);
        $dinasbop = DinasBop::find($request['dinasbop']);

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasbopadministrasi'] = $dinasbopadministrasi;
        $data['dinasbop'] = $request['dinasbop'];
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '/administrasi?nip='.$this->_nip.'&dinasbop='.$request['dinasbop'].'&id=' . $dinasbopadministrasi->id);
        $data['act'] = 'edit';
        $data['dinasbop'] = $dinasbop;
        $data['route'] = url($this->route  .'/detail?id='. $request['dinasbop']);
        return View::make('dinasbop.form_administrasi', $data);
    }

    public function create_administrasi_tim(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Tim Pengadministrasi';

        $auditan = [];
        $kabkota = IrbanKabkota::with('kabkota')->get();
        $skpd = IrbanSkpd::with('skpd')->get();

        foreach ($kabkota as $v) {
            $auditan['Kabupaten / Kota'][$v->kabkota->nama_kabkota] = $v->kabkota->nama_kabkota;
        }

        foreach ($skpd as $v) {
            $auditan['Perangkat Daerah'][$v->skpd->nama_skpd] = $v->skpd->nama_skpd;
        }

        $jabatan_anggota = [
            'Analis Perencanaan, Evaluasi dan Pelaporan',
            'Pengelola Evaluasi Tindak Lanjut Laporan Hasil Pemeriksaan',
            'Analis Laporan Hasil Pengawasan',
            'Perencana Pertama',
            'Pengolah Data Perencanaan dan Penganggaran',
            'Pengadministrasi Perencanaan dan Program',
            'Pengelola Keuangan',
            'Verifikatur',
            'Analis Laporan Keuangan',
            'Bendahara',
            'Pengadministrasi Keuangan',
            'Pengelola Gaji',
            'Pengadministrasi Umum',
            'Pengelola Barang Milik Negara',
            'Pengelola Kepegawaian',
            'Analis Sumber Daya Manusia Aparatur',
            'Pengelola Barang Milik Negara (Penyimpan Barang)'
        ];

        $jabatan_ketua = [
            'Kepala Sub Bagian Perencanaan dan Pelaporan',
            'Kepala Sub Bagian Keuangan dan Aset',
            'Kepala Sub Bagian Kepegawaian dan Umum',
            'Sekretaris'
        ];

        $anggota = Pegawai::whereIn('jabatan', $jabatan_anggota)->get();
        $ketua = Pegawai::whereIn('jabatan', $jabatan_ketua)->get();

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '/timadministrasi?nip='.$this->_nip.'&dinasbop='.$request['dinasbop'].'&administrasi=' . $request['administrasi']);
        $data['act'] = 'create';
        $data['auditan'] = $auditan;
        $data['anggota'] = $anggota;
        $data['ketua'] = $ketua;
        $data['route'] = url($this->route.'/detail?id='. $request['dinasbop']);
        $data['dinasbop'] = $request['dinasbop'];
        $data['administrasi'] = DinasBopAdministrasi::find($request['administrasi']);
        return View::make('dinasbop.form_timadministrasi', $data);
    }

    public function edit_administrasi_tim(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Pengadministrasi';

        $dinasboptimadministrasi = DinasBopAdministrasiTim::find($request['id']);

        $jabatan_anggota = [
            'Analis Perencanaan, Evaluasi dan Pelaporan',
            'Pengelola Evaluasi Tindak Lanjut Laporan Hasil Pemeriksaan',
            'Analis Laporan Hasil Pengawasan',
            'Perencana Pertama',
            'Pengolah Data Perencanaan dan Penganggaran',
            'Pengadministrasi Perencanaan dan Program',
            'Pengelola Keuangan',
            'Verifikatur',
            'Analis Laporan Keuangan',
            'Bendahara',
            'Pengadministrasi Keuangan',
            'Pengelola Gaji',
            'Pengadministrasi Umum',
            'Pengelola Barang Milik Negara',
            'Pengelola Kepegawaian',
            'Analis Sumber Daya Manusia Aparatur',
            'Pengelola Barang Milik Negara (Penyimpan Barang)'
        ];

        $jabatan_ketua = [
            'Kepala Sub Bagian Perencanaan dan Pelaporan',
            'Kepala Sub Bagian Keuangan dan Aset',
            'Kepala Sub Bagian Kepegawaian dan Umum',
            'Sekretaris'
        ];

        $anggota = Pegawai::whereIn('jabatan', $jabatan_anggota)->get();
        $ketua = Pegawai::whereIn('jabatan', $jabatan_ketua)->get();

        $auditan = [];
        $kabkota = IrbanKabkota::with('kabkota')->get();
        $skpd = IrbanSkpd::with('skpd')->get();

        foreach ($kabkota as $v) {
            $auditan['Kabupaten / Kota'][$v->kabkota->nama_kabkota] = $v->kabkota->nama_kabkota;
        }

        foreach ($skpd as $v) {
            $auditan['Perangkat Daerah'][$v->skpd->nama_skpd] = $v->skpd->nama_skpd;
        }

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasboptimadministrasi'] = $dinasboptimadministrasi;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '/timadministrasi?nip='.$this->_nip.'&id='.$request['id'].'&administrasi=' . $request['administrasi']);
        $data['act'] = 'edit';
        $data['auditan'] = $auditan;
        $data['anggota'] = $anggota;
        $data['ketua'] = $ketua;
        $data['dinasbop'] = $request['dinasbop'];
        $data['administrasi'] = DinasBopAdministrasi::find($request['administrasi']);
        $data['route'] = url($this->route.'/detail?id='.$dinasboptimadministrasi->dinasbop_id);
        return View::make('dinasbop.form_timadministrasi', $data);
    }

    public function create_custom_tim(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-plus"></i> Tambah Data Tim';

        $dinasboptim = DinasBopCustomTim::where('dinasbop_id', $request['dinasbop'])->get();
        $auditan = [];

        if (count($dinasboptim) > 0) {
            $tujuan = [];

            foreach ($dinasboptim as $v) {
                array_push($tujuan, $v->auditan);
            }

            $kabkota = IrbanKabkota::with(['kabkota' => function ($query) use ($tujuan) {
                $query->whereNotIn('kabkota.nama_kabkota', $tujuan);
            }])->get();

            $skpd = IrbanSkpd::with(['skpd' => function ($query) use ($tujuan) {
                $query->whereNotIn('nama_skpd', $tujuan);
            }])->get();

            foreach ($kabkota as $v) {
                if ($v->kabkota != null) {
                    $auditan['Kabupaten / Kota'][$v->kabkota->nama_kabkota] = $v->kabkota->nama_kabkota;
                }
            }

            foreach ($skpd as $v) {
                if ($v->skpd != null) {
                    $auditan['Perangkat Daerah'][$v->skpd->nama_skpd] = $v->skpd->nama_skpd;
                }
            }
        } else {
            $kabkota = IrbanKabkota::with('kabkota')->get();
            $skpd = IrbanSkpd::with('skpd')->get();

            foreach ($kabkota as $v) {
                $auditan['Kabupaten / Kota'][$v->kabkota->nama_kabkota] = $v->kabkota->nama_kabkota;
            }

            foreach ($skpd as $v) {
                $auditan['Perangkat Daerah'][$v->skpd->nama_skpd] = $v->skpd->nama_skpd;
            }
        }

        $dinasbop_data = DinasBop::find($request['dinasbop']);
        $pegawai = Pegawai::where('jabatan', '!=', 'Sekretaris Daerah')->get();

        $jabatan_pj = ['Inspektur'];

        $jabatan_wp = [
            'Inspektur Pembantu Bidang Pemerintahan dan Kesejahteraan Masyarakat',
            'Inspektur Pembantu Bidang Administrasi',
            'Inspektur Pembantu Bidang Khusus',
            'Inspektur Pembantu Bidang Perekonomian dan Pembangunan',
            'Sekretaris'
        ];

        $jabatan_dalnis = [
            'Kepala Sub Bagian Kepegawaian dan Umum',
            'Kepala Sub Bagian Keuangan dan Aset',
            'Kepala Sub Bagian Perencanaan dan Pelaporan',
            'Auditor Madya',
            'Pengawas Pemerintahan Madya',
        ];

        $jabatan_ketua = [
            'Kepala Sub Bagian Kepegawaian dan Umum',
            'Kepala Sub Bagian Keuangan dan Aset',
            'Kepala Sub Bagian Perencanaan dan Pelaporan',
            'Auditor Madya',
            'Auditor Muda',
            'Pengawas Pemerintahan Madya',
            'Pengawas Pemerintahan Muda'
        ];

        $personil = [
            'penanggungjawab'=>[],
            'wakilpenanggungjawab'=>[],
            'pengendaliteknis'=>[],
            'ketuatim'=>[],
            'anggota'=>[]
        ];

        foreach ($pegawai as $v) {
            if (in_array($v->jabatan, $jabatan_pj)) {
                array_push($personil['penanggungjawab'], $v);
            }

            if (in_array($v->jabatan, $jabatan_wp)) {
                array_push($personil['wakilpenanggungjawab'], $v);
            }

            if (in_array($v->jabatan, $jabatan_dalnis)) {
                array_push($personil['pengendaliteknis'], $v);
            }

            if (in_array($v->jabatan, $jabatan_ketua)) {
                array_push($personil['ketuatim'], $v);
            }

            if ((!in_array($v->jabatan, $jabatan_wp)) && (!in_array($v->jabatan, $jabatan_pj))) {
                array_push($personil['anggota'], $v);
            }
        }

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'create';
        $data['auditan'] = $auditan;
        $data['personil'] = $personil;
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        $data['dinasbop'] = $request['dinasbop'];
        $data['dinasbop_data'] = $dinasbop_data;
        return View::make('dinasbop.form_custom', $data);
    }

    public function edit_custom_tim(Request $request)
    {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="'.url('dashboard').'"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<a href="'.url($this->route).'/detail?id='.$request['dinasbop'].'"><i class="fa fa-database"></i> '.$this->title.'</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data Tim';

        $dinasbopcustom = DinasBopCustomTim::find($request['id']);

        $kabkota = IrbanKabkota::with('kabkota')->get();
        $skpd = IrbanSkpd::with('skpd')->get();
        $auditan = [];

        foreach ($kabkota as $v) {
            $auditan['Kabupaten / Kota'][$v->kabkota->nama_kabkota] = $v->kabkota->nama_kabkota;
        }

        foreach ($skpd as $v) {
            $auditan['Perangkat Daerah'][$v->skpd->nama_skpd] = $v->skpd->nama_skpd;
        }

        $dinasbop_data = DinasBop::find($request['dinasbop']);
        $pegawai = Pegawai::where('jabatan', '!=', 'Sekretaris Daerah')->get();

        $jabatan_pj = ['Inspektur'];

        $jabatan_wp = [
            'Inspektur Pembantu Bidang Pemerintahan dan Kesejahteraan Masyarakat',
            'Inspektur Pembantu Bidang Administrasi',
            'Inspektur Pembantu Bidang Khusus',
            'Inspektur Pembantu Bidang Perekonomian dan Pembangunan',
            'Sekretaris'
        ];

        $jabatan_dalnis = [
            'Kepala Sub Bagian Kepegawaian dan Umum',
            'Kepala Sub Bagian Keuangan dan Aset',
            'Kepala Sub Bagian Perencanaan dan Pelaporan',
            'Auditor Madya',
            'Pengawas Pemerintahan Madya',
        ];

        $jabatan_ketua = [
            'Kepala Sub Bagian Kepegawaian dan Umum',
            'Kepala Sub Bagian Keuangan dan Aset',
            'Kepala Sub Bagian Perencanaan dan Pelaporan',
            'Auditor Madya',
            'Auditor Muda',
            'Pengawas Pemerintahan Madya',
            'Pengawas Pemerintahan Muda'
        ];

        $personil = [
            'penanggungjawab'=>[],
            'wakilpenanggungjawab'=>[],
            'pengendaliteknis'=>[],
            'ketuatim'=>[],
            'anggota'=>[]
        ];

        foreach ($pegawai as $v) {
            if (in_array($v->jabatan, $jabatan_pj)) {
                array_push($personil['penanggungjawab'], $v);
            }

            if (in_array($v->jabatan, $jabatan_wp)) {
                array_push($personil['wakilpenanggungjawab'], $v);
            }

            if (in_array($v->jabatan, $jabatan_dalnis)) {
                array_push($personil['pengendaliteknis'], $v);
            }

            if (in_array($v->jabatan, $jabatan_ketua)) {
                array_push($personil['ketuatim'], $v);
            }

            if ((!in_array($v->jabatan, $jabatan_wp)) && (!in_array($v->jabatan, $jabatan_pj))) {
                array_push($personil['anggota'], $v);
            }
        }

        $data = [];
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['dinasbopcustom'] = $dinasbopcustom;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api);
        $data['act'] = 'edit';
        $data['auditan'] = $auditan;
        $data['personil'] = $personil;
        $data['dinasbop'] = $request['dinasbop'];
        $data['dinasbop_data'] = $dinasbop_data;
        $data['route'] = url($this->route.'/detail?id='.$request['dinasbop']);
        return View::make('dinasbop.form_custom', $data);
    }
}

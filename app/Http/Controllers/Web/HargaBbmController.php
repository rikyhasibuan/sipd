<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\HargaBbm;
use App\Libraries\Access;
use Closure;

class HargaBbmController extends Controller
{
    protected $title = 'Harga BBM';
    protected $link  = 'hargabbm';
    protected $api   = 'api/hargabbm';
    protected $route = 'hargabbm';
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
        $breadcrumb[1] = '<a href="' . url($this->route) . '"><i class="fa fa-balance-scale"></i> ' . $this->title . '</a>';
        $breadcrumb[2] = '<i class="fa fa-wrench"></i> Ubah Data';

        $hargabbm = HargaBbm::find(1);

        $data = array();
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['hargabbm'] = $hargabbm;
        $data['breadcrumb'] = $breadcrumb;
        $data['api'] = url($this->api . '?nip='.$this->_nip.'&id=1');
        $data['act'] = 'edit';
        $data['route'] = url($this->route);
        return View::make('hargabbm.form', $data);
    }
}

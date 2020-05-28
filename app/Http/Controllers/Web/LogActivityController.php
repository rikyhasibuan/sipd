<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Libraries\Access;
use Closure;

class LogActivityController extends Controller
{
    protected $title = 'Log Aktifitas';
    protected $link  = 'logaktifitas';
    protected $api   = 'api/logaktifitas';
    protected $route = 'logaktifitas';
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

  public function index() {
    $breadcrumb = array();
    $breadcrumb[0] = '<a href="' . url('admin/dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
    $breadcrumb[1] = '<i class="fa fa-file-text"></i> ' . $this->title;

    $data = array();
    $data['breadcrumb'] = $breadcrumb;
    $data['title']  = $this->title;
    $data['link'] = $this->link;
    $data['api'] = url($this->api);
    $data['route'] = url($this->route);
    $data['access'] = $this->access;
    return View::make('log', $data);
  }
}

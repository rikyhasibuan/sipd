<?php

namespace App\Http\Controllers\Web;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\User;

/**
 * @author rikyhsb
 *
 */
class ProfileController extends Controller
{
    public $title = 'Ubah Password';
    public $link = 'profile';
    protected $api = 'api/profile';

    public function __construct()
    {
        $this->middleware(
            function ($request, Closure $next) {
                if (Cookie::get('login') == true) {
                    return $next($request);
                } else {
                    return redirect('admin');
                }
            }
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request) {
        $breadcrumb = [];
        $breadcrumb[0] = '<a href="' . url('admin/dashboard') . '"><i class="fa fa-dashboard"></i> Dashboard</a>';
        $breadcrumb[1] = '<i class="fa fa-user"></i> '. $this->title;

        $user  = User::find(Cookie::get('id'));

        $data = [];
        $data['breadcrumb'] = $breadcrumb;
        $data['title']  = $this->title;
        $data['link'] = $this->link;
        $data['api'] = url($this->api.'?id='.$user->id);
        $data['user'] = $user;
        return View::make('profile', $data);
    }
}

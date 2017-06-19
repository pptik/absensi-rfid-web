<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class CInformasi extends Controller
{
    public function index(){
        if (session()->has('ID')) {
            return view('authenticated.dashboardadmin');
        }else{
            return view('index');
        }
    }
    public function ruang(){
        if (session()->has('ID')) {
            return view('authenticated.ruang');
        }else{
            return view('index');
        }
    }
}

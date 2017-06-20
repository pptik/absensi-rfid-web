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
    public function scanner(){
        if (session()->has('ID')) {
            return view('authenticated.scanner');
        }else{
            return view('index');
        }
    } 
    public function jadwal(){
        if (session()->has('ID')) {
            return view('authenticated.jadwal');
        }else{
            return view('index');
        }
    }
}

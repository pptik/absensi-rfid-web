<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use phpDocumentor\Reflection\Types\String_;
use Session;
use Redirect;
use Hash;
use App\MInstansi;
class CJadwal extends Controller{




    public function tambah(Request $request)
    {
        $start = new \MongoDB\BSON\UTCDateTime(strtotime($request['starttime'])*1000);
        $end = new \MongoDB\BSON\UTCDateTime(strtotime($request['endtime'])*1000);
        $dataarray[]=[
            'Instansi_id'=>$request['selectInstansi'],
            'Nama_mata_pelajaran'=>$request['namaMatpel'],
            'Kode_ruangan'=>$request['selectRuangan'],
            'Start'=>$start,
            'End'=>$end
        ];
        $document=DB::table('jadwal')->insert($dataarray);
        return  Session::flash('message', 'Berhasil Menambah jadwal');
    }
}
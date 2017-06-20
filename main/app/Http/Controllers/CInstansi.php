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
class CInstansi extends Controller{


    public function getalllist(){
        $documents = DB::collection('instansi')->get();
        $dataset=array();
        foreach ($documents as $value){
            $data['nama']=$value['Nama'];
            $data['ruang']=$value['Ruang'];
            $data['id']=(string)$value['_id'];
            array_push($dataset, $data);
        }
        return  $dataset;
    }
    public function tambah(Request $request)
    {

        $documents = DB::collection('instansi')
            -> where('Nama',$request['nama'])
            ->get();
        if ($documents){
            Session::flash('message', 'Nama Instansi Sudah Terdaftar');
            return Redirect::to('/');
        }else{
            $dataarray[]=[
                'Nama'=>$request['nama'],
                'Ruang'=>[[

                ],
                ],
            ];
            DB::table('instansi')->insert($dataarray);
            return Redirect::to('/');
        }
    }

}
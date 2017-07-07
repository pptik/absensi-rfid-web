<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use phpDocumentor\Reflection\Types\String_;
use SebastianBergmann\Environment\Console;
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
            $data['idinstansi']=(string)$value['_id'];
            array_push($dataset, $data);
        }
        return  $dataset;
    }
    public function tambah(Request $request)
    {
        $nama=trim($request['nama']);
        $documents = DB::collection('instansi')
            -> where('Nama','like',$nama)
            ->get();
        if ($documents){
            Session::flash('message', 'Nama Instansi Sudah Terdaftar');
            return Redirect::to('/');
        }else{
            $dataarray[]=[
                'Nama'=>$nama,
                'Ruang'=>[[

                ],
                ],
            ];
            DB::table('instansi')->insert($dataarray);
            return Redirect::to('/');
        }
    }
    public function delete(Request $request){
        $instansiID=$request['instansiID'];
        $documents = DB::collection('instansi')
            -> where('_id','=',$instansiID)
            ->delete();
        if ($documents){
            Session::flash('message', 'Instansi Berhasil Dihapus');
            return Redirect::to('/');
        }else{
            Session::flash('message', 'Instansi Gagal Dihapus');
            return Redirect::to('/');
        }
    }

}
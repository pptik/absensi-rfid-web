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
class CScanner extends Controller{


    public function getlistbyinstansi(Request $request){
        $documents=DB::table('instansi')->where('Nama',$request['namaInstansi'])->get();
        $dataset=array();
        foreach ($documents as $value){
            $data['nama']=$value['Nama'];
            $data['ruang']=$value['Ruang'];
            $data['id']=$value['_id'];
            array_push($dataset, $data);
        }
        return  $dataset;
    }
    public function getlistkelasscanner(){
        $documents=DB::table('instansi')->get();
        $dataset=array();
        foreach ($documents as $value){
            $data['nama']=$value['Nama'];
            $data['ruang']=$value['Ruang'];
            $data['id']=$value['_id'];
            foreach ($value['Ruang'] as $value2){
                $documents2=DB::table('maclist')->where('koderuangan',$value2['Kode_ruangan'])->get();
                if($documents2){
                    foreach ($documents2 as $value3){
                        $data['mac']=$value3['mac'];
                    }
                }else{
                    $data['mac']='';
                }
            }
            array_push($dataset, $data);
        }
        return  $dataset;
    }

    public function tambah(Request $request)
    {

        DB::table('maclist')->where('mac',$request['selectMac'])->update([
            'kelasassigned'=>true,
            'koderuangan'=>$request['selectKelas']
        ]);
        return Redirect::to('/scanner');
    }

    public function generateRandomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
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
use Log;
class CRuang extends Controller{


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
    public function tambah(Request $request)
    {
        $checkKode=true;
        while ($checkKode){
            $kodekelasrandom=$this->generateRandomString();
            $searcharray[]=[
                'Ruang'=>[
                    'Kode_ruangan'=>$kodekelasrandom
                ],
            ];
            $document=DB::table('instansi')->where($searcharray)->get();
            if(!$document){
                $checkKode=false;
            }
        }

            $dataarray[]=[
                'Nama'=>$request['nama'],
                'Kode_ruangan'=>$kodekelasrandom
            ];
            DB::table('instansi')->where('Nama',$request['selectInstansi'])->push('Ruang',$dataarray);
            return Redirect::to('/ruang');
    }
    public function delete(Request $request)
    {
        $dataarray[]=[
            'Nama'=>$request['nama'],
            'Kode_ruangan'=>$request['koderuangan']
        ];
        $document=DB::table('instansi')->where('Nama','like',$request['namainstansi'])->pull('Ruang',$dataarray);
        return $document;
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
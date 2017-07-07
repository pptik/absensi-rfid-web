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
            $maclist=array();
            $data['nama']=$value['Nama'];
            $data['ruang']=$value['Ruang'];
            $data['id']=(string)$value['_id'];
            foreach ($value['Ruang'] as $value2){
                $documents2=DB::table('maclist')->where('koderuangan',$value2['Kode_ruangan'])->get();
                if($documents2){
                    foreach ($documents2 as $value3){
                        $value3['idmaclist']=(string)$value3['_id'];
                        $value3['Nama_ruangan']=$value2['Nama'];
                        $value3['Kode_ruangan']=$value2['Kode_ruangan'];
                        unset($value3['koderuangan']);
                        unset($data['ruang']);
                        unset($value3['_id']);
                        array_push($maclist,$value3);
                    }
                }else{
                    $value3['mac']=null;
                    $value3['kelasassigned']=false;
                    $value3['Kode_ruangan']=null;
                    $value3['idmaclist']=null;
                    $value3['Nama_ruangan']=$value2['Nama'];
                    $value3['Kode_ruangan']=$value2['Kode_ruangan'];
                    unset($data['koderuangan']);
                    unset($data['ruang']);
                    array_push($maclist,$value3);
                }
            }
            $data['ruanganlist']=$maclist;
            array_push($dataset, $data);
        }
        return  $dataset;
    }

    public function tambah(Request $request)
    {

        $document= DB::table('maclist')->where('mac',$request['selectMac'])->update([
            'kelasassigned'=>true,
            'koderuangan'=>$request['selectKelas']
        ]);
        if ($document){
            //$document=DB::table('instansi')->
        }
        return Redirect::to('/scanner');
    }
    public function removeScanner(Request $request)
    {
        $document= DB::table('maclist')->where('mac',$request['macID'])->update([
            'kelasassigned'=>false,
            'koderuangan'=>""
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
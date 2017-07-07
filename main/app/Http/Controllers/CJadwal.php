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
        $checkKode=true;
        while ($checkKode){
            $kodekelasrandom="MK-".$this->generateRandomString();
            $document=DB::table('jadwal')->where('Kode_jadwal','like',$kodekelasrandom)->get();
            if(!$document){
                $checkKode=false;
            }
        }
        $start = new \MongoDB\BSON\UTCDateTime(strtotime($request['starttime'])*1000);
        $end = new \MongoDB\BSON\UTCDateTime(strtotime($request['endtime'])*1000);
        $dataarray[]=[
            'Instansi_id'=>$request['selectInstansi'],
            'Nama_mata_pelajaran'=>$request['namaMatpel'],
            'Kode_jadwal'=>$kodekelasrandom,
            'Kode_ruangan'=>$request['selectRuangan'],
            'Start'=>$start,
            'End'=>$end
        ];
        $document=DB::table('jadwal')->insert($dataarray);
        return  Session::flash('message', 'Berhasil Menambah jadwal');
    }
    public function deletejadwal(Request $request)
    {

        $document=DB::table('jadwal')
            ->where("_id","=",$request['jadwalid'])
            ->delete();
        if($document){
            $sessionflash=Session::flash('message', 'Berhasil Menghapus jadwal');
        }else{
            $sessionflash=Session::flash('message', 'Gagal Menghapus jadwal');
        }
        return  $sessionflash;
    }
    public function getlistjadwal(){
        $documents=DB::table('jadwal')
            ->join('instansi','jadwal.Instansi_id','=','instansi._id')
            ->get();
        $dataset=array();
        if(!$documents){
            $documents=array();
        }else{
            foreach ($documents as $d){
                $data['id']=(string)$d['_id'];
                $data['nama']=(string)$d['Nama_mata_pelajaran'];
                $data['koderuangan']=(string)$d['Kode_ruangan'];
                $data['idinstansi']=(string)$d['Instansi_id'];
                $data['namainstansi']=$this->getnamainstansi($data['idinstansi']);
                foreach ($d['Start'] as $dates){
                    $data['startdate']=date("D, d-m-Y", $dates/1000);
                    $data['starttime']=date("H:i:s", $dates/1000);
                }
                foreach ($d['End'] as $dates){
                    $data['enddate']=date("D, d-m-Y", $dates/1000);
                    $data['endtime']=date("H:i:s", $dates/1000);
                }

                array_push($dataset, $data);
            }
        }
        return $dataset;
    }
    public function getnamainstansi($instansiid){
        $documents=DB::table('instansi')
            ->where("_id","=",$instansiid)
            ->select("Nama")
            ->first();
        return $documents["Nama"];
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
    public function test(){
        $documents=DB::table('instansi')
            ->where("_id","=","595b5b5b3a88753038a2d256")
            ->select("Nama")
            ->first();
        return $documents["Nama"];
    }
}
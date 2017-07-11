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

    public function getlistabsenbyjadwal(Request $request)
    {
        $jadwal=DB::table('jadwal')
            ->where("Kode_jadwal","like",$request['Kode_jadwal'])
            ->first();
        $maclist=DB::table('maclist')
            ->where("koderuangan",'like',$jadwal['Kode_ruangan'])
            ->get();
        $jadwal['id']=(string)$jadwal['_id'];
        unset($jadwal['_id']);
        $arrMacList=array();
        foreach ($maclist as $m){
           $listabsen= DB::collection($m["mac"])
                ->whereBetween('date', array($jadwal["Start"], $jadwal["End"]))
                ->get();
            $listabsensis=array();
            foreach ($listabsen as $value){
                $listabsensi['rf_id']=$value['rf_id'];
                foreach ($value['date'] as $dates){
                    $listabsensi['date']=date("D, d-m-Y", $dates/1000);
                    $listabsensi['time']=date("H:i:s", $dates/1000);
                }
                array_push($listabsensis, $listabsensi);
            }
            $m['List_absen']=$this->unique_multidim_array($listabsensis,'rf_id');
            array_push($arrMacList,$m);
        }

        $jadwal['maclist']=$arrMacList;
        return $jadwal;
    }
    public function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                array_push($temp_array, $val);
            }
            $i++;
        }
        return $temp_array;
    }
    public function getdetailjadwalbykode(Request $r){
        $jadwal=DB::table('jadwal')
            ->where("Kode_jadwal","like",$r['Kode_jadwal'])
            ->first();
        $maclist=DB::table('maclist')
            ->where("koderuangan",'like',$jadwal['Kode_ruangan'])
            ->get();

        $jadwal['id']=(string)$jadwal['_id'];
        $jadwal['Nama_kelas']=$this->getnamakelas($jadwal['Kode_ruangan']);
        $jadwal['Nama_instansi']=$this->getnamainstansi($jadwal['Instansi_id']);
        unset($jadwal['_id']);
        foreach ($jadwal['Start'] as $dates){
            $jadwal['startdate']=date("D, d-m-Y", $dates/1000);
            $jadwal['starttime']=date("H:i:s", $dates/1000);
        }
        foreach ($jadwal['End'] as $dates){
            $jadwal['enddate']=date("D, d-m-Y", $dates/1000);
            $jadwal['endtime']=date("H:i:s", $dates/1000);
        }
        $arrMacList=array();
        foreach ($maclist as $m){
            $listabsen= DB::collection($m["mac"])
                ->whereBetween('date', array($jadwal["Start"], $jadwal["End"]))
                ->get();
            $listabsensis=array();
            foreach ($listabsen as $value){
                $listabsensi['rf_id']=$value['rf_id'];
                foreach ($value['date'] as $dates){
                    $listabsensi['date']=date("D, d-m-Y", $dates/1000);
                    $listabsensi['time']=date("H:i:s", $dates/1000);
                }
                array_push($listabsensis, $listabsensi);
            }
            $m['List_absen']=$this->unique_multidim_array($listabsensis,'rf_id');
            unset($m['_id']);
            array_push($arrMacList,$m);
        }
        unset($jadwal['Start']);
        unset($jadwal['End']);
        $jadwal['maclist']=$arrMacList;
        return $jadwal;
    }
    public function getlistjadwalbykodejadwal(Request $r){
        $jadwal=DB::table('jadwal')
            ->where("Kode_jadwal","like",$r['kodeJadwal'].'%')
            ->select('Kode_ruangan','Kode_jadwal','Start','End')
            ->get();
        $arrResult=array();
        foreach ($jadwal as $j){
            $totalAbsen=0;
            $maclist=DB::table('maclist')
                ->where("koderuangan",'like',$j['Kode_ruangan'])
                ->get();
            $listabsensis=array();
            foreach ($maclist as $m){
                $listabsen= DB::collection($m["mac"])
                    ->whereBetween('date', array($j["Start"], $j["End"]))
                    ->get();

                foreach ($listabsen as $value){
                    $listabsensi['rf_id']=$value['rf_id'];
                    array_push($listabsensis, $listabsensi);
                }
            }
            unset($j['Start']);
            unset($j['End']);
            unset($j['_id']);
            $j["totalabsen"]=count($this->unique_multidim_array($listabsensis,'rf_id'));
            array_push($arrResult,$j);
        }

        return $arrResult;
    }

    public function getnamainstansi($instansiid){
        $documents=DB::table('instansi')
            ->where("_id","=",$instansiid)
            ->select("Nama")
            ->first();
        return $documents["Nama"];
    }
    public function getnamakelas($kodekelas){
        $documents=DB::table('instansi')
            ->where("Ruang.Kode_ruangan","=",$kodekelas)
            ->first();
        $namakelas="";
        foreach ($documents['Ruang'] as $d) {
            if ($d["Kode_ruangan"]==$kodekelas)$namakelas=$d['Nama'];
        };
        return $namakelas;
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
    public function test(Request $r){
        $jadwal=DB::table('jadwal')
            ->where("Kode_jadwal","like",'%'.$r['kodeJadwal'].'%')
            ->get();
        return $jadwal;
    }
}
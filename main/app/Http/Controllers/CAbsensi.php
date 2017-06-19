<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Carbon\Carbon ;
use MongoDate;
use DateTime;
class CAbsensi extends Controller
{
    public function getlistmac()
    {
        $documents = DB::collection('maclist')->get();
        $macs=array();
        foreach ($documents as $value){
           $mac['mac']=$value['mac'];
           array_push($macs, $mac);
        }
        return  $macs;
    }
    public function getlistmacbystatus(Request $request)
    {
        $documents = DB::collection('maclist')->where('kelasassigned',$request['status'] === 'true'? true: false)->get();
        $macs=array();
        foreach ($documents as $value){
           $mac['mac']=$value['mac'];
           array_push($macs, $mac);
        }
        return  $macs;
    }
	 public function get_raw()
    {
		
		
        $documents = DB::collection('2c:6z:00:77:71:96:31')
            ->get();
        $listabsensis=array();
       
        var_dump($documents);
    }
    public function get_allabsensi()
    {
		
        $documents = DB::collection('a0:20:a6:00:e9:be')
            ->get();
        $listabsensis=array();
        foreach ($documents as $key => $value){

            $listabsensi['mac']=$value['mac'];
            $listabsensi['rf_id']=$value['rf_id'];
            foreach ($value['date'] as $dates){
                $listabsensi['date']=date("D, d-m-Y", $dates/1000);
                $listabsensi['time']=date("H:i:s", $dates/1000);
            }
            array_push($listabsensis, $listabsensi);
        }

        return  $this->unique_multidim_array($listabsensis,'rf_id');

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

    public function listabsen(Request $request)
    {
        $deviceid=$request['deviceid'];
        $start = new \MongoDB\BSON\UTCDateTime(strtotime($request['starttime'])*1000);
        $end = new \MongoDB\BSON\UTCDateTime(strtotime($request['endtime'])*1000);
        $documents = DB::collection($deviceid)
            -> whereBetween('date', array($start, $end))
            ->get();
        $listabsensis=array();
        foreach ($documents as $value){
           $listabsensi['mac']=$value['mac'];
            $listabsensi['rf_id']=$value['rf_id'];
            foreach ($value['date'] as $dates){
                $listabsensi['date']=date("D, d-m-Y", $dates/1000);
                $listabsensi['time']=date("H:i:s", $dates/1000);
            }
            array_push($listabsensis, $listabsensi);
        }
        return  $this->unique_multidim_array($listabsensis,'rf_id');
    }
    
    public function getalllistabsenbymac(Request $request)
    {
        $deviceid=$request['deviceid'];
        $documents = DB::collection($deviceid)
            ->orderBy('date', 'desc')
            ->get();
        $listabsensis=array();
        foreach ($documents as  $key=>$value){
            $listabsensi['mac']=$value['mac'];
            $listabsensi['rf_id']=$value['rf_id'];
            foreach ($value['date'] as $dates){
                $listabsensi['date']=date("D, d-m-Y", $dates/1000);
                $listabsensi['time']=date("H:i:s", $dates/1000);
            }
            array_push($listabsensis, $listabsensi);
        }
        return  $listabsensis;
    }
}

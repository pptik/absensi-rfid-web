<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Carbon\Carbon ;
use MongoDate;
use DateTime;
class CMap extends Controller
{
    public function getCCTV()
    {
        $documents = DB::collection('tb_cctv')->get();
        $cctvs      = array();
        foreach ($documents as $value){
            $cctv['ID']         =$value['ID'];
            $cctv['Name']       =$value['Name'] ;
            if($value['CityID'] ==2){

                $cctv['Video']      = "http://167.205.7.226:32658/getvideo.php?imageid=".$value['ItemID'];
                $cctv['Screenshot'] = "http://167.205.7.226:32658/getimage.php?imageid=".$value['ItemID'];

            }else{
                $cctv['Video']      = "http://bsts-svc.lskk.ee.itb.ac.id/247/content/getcontent.php?type=video&vid=".$value['ItemID'];
                $cctv['Screenshot'] = "http://bsts-svc.lskk.ee.itb.ac.id/247/content/getcontent.php?type=image&vid=".$value['ItemID'];

            }
            $cctv['Latitude']   =$value['Latitude'];
            $cctv['Longitude']  =$value['Longitude'];

            $city = DB::collection('tb_city')->select('Name', 'ProvinceID')->where('ID', $value['CityID'])->first();
            $cctv['City']       = $city["Name"];

            $province = DB::collection('tb_province')->select('Name', 'CountryID')->where('ID', $city['ProvinceID'])->first();
            $cctv['Province']   = $province['Name'];

            $country = DB::collection('tb_country')->select('Name')->where('ID',$province["CountryID"])->first();
            $cctv['Country']    = $country['Name'];
            
            $cctv['isexist']=$value['Status'];

            array_push($cctvs, $cctv);
        }
        return  json_encode($cctvs);
    }

    public function getgpstracer()
    {
        $documents = DB::collection('tb_tracker')->get();
        $tracers=array();
        foreach ($documents as $value){
            $tracer['Mac']=$value['Mac'];
            $tracer['Speed']=$value['Speed'];
            $tracer['Date']=$value['Date'];
            $tracer['Time']=$value['Time'];
            $tracer['Lokasi']=$value['Lokasi'];
            $tracer['Keterangan']=$value['Keterangan'];
            $dataarray=array($value['Data']);
            foreach($dataarray as $data) {
                $tracer['Latitude']=$data[0];
                $tracer['Longitude']=$data[1];
            }
            array_push($tracers, $tracer);
        }
        return  json_encode($tracers);
    }
    public function search()
    {
        $data = json_decode('[
            {"loc":[41.575330,13.102411], "title":"aquamarine"},
            {"loc":[41.575730,13.002411], "title":"black"},
            {"loc":[41.807149,13.162994], "title":"blue"},
            {"loc":[41.507149,13.172994], "title":"chocolate"},
            {"loc":[41.847149,14.132994], "title":"coral"},
            {"loc":[41.219190,13.062145], "title":"cyan"},
            {"loc":[41.344190,13.242145], "title":"darkblue"},	
            {"loc":[41.679190,13.122145], "title":"darkred"},
            {"loc":[41.329190,13.192145], "title":"darkgray"},
            {"loc":[41.379290,13.122545], "title":"dodgerblue"},
            {"loc":[41.409190,13.362145], "title":"gray"},
            {"loc":[41.794008,12.583884], "title":"green"},	
            {"loc":[41.805008,12.982884], "title":"greenyellow"},
            {"loc":[41.536175,13.273590], "title":"red"},
            {"loc":[41.516175,13.373590], "title":"rosybrown"},
            {"loc":[41.506175,13.173590], "title":"royalblue"},
            {"loc":[41.836175,13.673590], "title":"salmon"},
            {"loc":[41.796175,13.570590], "title":"seagreen"},
            {"loc":[41.436175,13.573590], "title":"seashell"},
            {"loc":[41.336175,13.973590], "title":"silver"},
            {"loc":[41.236175,13.273590], "title":"skyblue"},
            {"loc":[41.546175,13.473590], "title":"yellow"},
            {"loc":[41.239190,13.032145], "title":"white"}
        ]',true);

        if(isset($_GET['cities']))
            $data = json_decode( file_get_contents("http://localhost/main/resources/assets/leafletsearch/examples/data/cities15000.json"), true);

        function searchInit($text)
        {
            $reg = "/^".$_GET['q']."/i";
            return (bool)@preg_match($reg, $text['title']);
        }
        $fdata = array_filter($data, 'searchInit');
        $fdata = array_values($fdata);
        $JSON = json_encode($fdata,true);
        @header("Content-type: application/json; charset=utf-8");
        if(isset($_GET['callback']) and !empty($_GET['callback']))
            echo $_GET['callback']."($JSON)";
        else
            echo $JSON;
    }

    public function getsocialreport()
    {
        $dt = Carbon::now()->subDay();
        $documents = DB::collection('tb_post')->where("Exp",">",$dt)->get();
        $datas=array();
        foreach ($documents as $value){
           //$mongodate=new MongoDate($value['Times']['$date']['$numberLong']);

            $recordId = (string) $value["Times"];
            $mongodate=new MongoDate($recordId);
            $data['lat']=$value['Latitude'];
            $data['lon']=$value['Longitude'];
            $data['type']=$value['SubType'];
            $data['parenttype']=$value['IDsub'];
            $data['description']=$value['Description'];
            $data['reporter']=$value['PostedBy']["Name"];
            $data['time']=$value['Times'];
            $data['timex']=$recordId;
            array_push($datas, $data);
        }

        return  json_encode($datas);
    }

}

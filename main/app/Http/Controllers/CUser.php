<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use phpDocumentor\Reflection\Types\String_;
use Session;
use Redirect;
use App\MUser;
use Hash;
class CUser extends Controller{

    public function signin_action(Request $request){
        $this->validate($request,[
            'Password' => 'required'
        ]);
        $documents=DB::collection('users')
            -> where('Username',$request['Username'])
            ->get();
        if ($documents){

            foreach ($documents as $value){
              $password=$value['Password'];
              $ID=$value['_id'];
              $Username=$value['Username'];
              $Role=$value['Role'];
            }
            if ($request['Password']== $password)
            {
                if($Role!=0){
                    Session::flash('message', 'Anda Bukan Admin');
                    return Redirect::to('/login');
                }else{
                    session(['Username' => $Username,
                        'ID'=> $ID]);
                    return Redirect::to('/');
                }

            }else{
                Session::flash('message', 'Password Salah');
                return Redirect::to('/login');
            }



        }else{
            Session::flash('message', 'Email Belum Terdaftar');
            return Redirect::to('/login');
        }
    }
    public function signup_action(Request $request)
    {

        $this->validate($request,[
            'Email' => 'required|email|unique:users',
            'Password' => 'required|min:6|confirmed',
            'Password_confirmation' => 'required|min:6'
        ]);
        $documents = DB::collection('user')
            -> where('Email',$request['Email'])
            ->get();
        if ($documents){
            Session::flash('message', 'Email Sudah Digunakan');
            return Redirect::to('/');
        }else{
            $UserID=$this->getAutoIncrementId();
            $user = new MUser();
            $user->ID = $UserID;
            $user->Email = $request['Email'];
            $user->Password= bcrypt($request['Password']);
            $user->Peran= 3;
            $user->save();

            session(['Email' => $request['Email'],
                    'ID'=> $UserID]);

            return Redirect::to('/');
        }
    }
    function getAutoIncrementId(){
        $document=DB::collection('counters')
            -> where('field','ID')
            -> get();
        foreach ($document as $value){
            $ID=$value['seq'];
        }
        $tempid=$ID+1;
        DB::collection('counters')
            -> where('field','ID')
            ->update(['seq' => $tempid]);

        return $ID;
    }
    public function signup(Request $request)
    {
        return view('daftar');
    }
    public function logout()
    {
        session()->flush();
        return Redirect::to('/');
    }

}
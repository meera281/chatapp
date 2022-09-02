<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userdetail;
use App\Models\Resetpassword;
use App\Models\Chatdetail;
use Illuminate\Support\Facades\Hash;
// use Integer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\sendemail;
use App\Mail\resetpasswordemail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

use Validator;

class userController extends Controller
{

    function getData(Request $req)
    {
        $req->validate([
            // 'email'=>['required', 'unique:userdetails'],
            'email'=>['required'],
            'password'=>['required']
        ]);
        
        // return Userdetail::all();
        $userdetail = Userdetail::where('email',$req->email)->get()->first();
        if($userdetail)
        {
            $checkpassword = Hash::check($req->password, $userdetail->password);
            if($checkpassword)
            {
                // dd($userdetail);
                $role = $userdetail->role;
                if ($role == "Admin")
                {
                    // $req->session()->put("role","Admin");
                    session(["role" => "Admin"]);
                    session(['name' => $userdetail->name ]);
                    session(["id"=>$userdetail->id]);
                    return redirect ("/admin");
                } 
                elseif ($role == "Agent")
                {
                    session(["role"=>"Agent"]);     
                    session(['name' => $userdetail->name]);
                    session(["id"=>$userdetail->id]);
                    session(["name"=>$userdetail->name]);
                    // session(["created_at"=>$userdetail->created_at]);

                    if($userdetail->firstlogin == 0)
                    {
                        return view ("/resetpassword");
                    }

                    return redirect ("/agent");
                }
            }
            else
            {
                // return view("/login", ["error"=>"Invalid password"]);
                return view("/login", ["error"=> __('loginControllerAlert.passwordError') ]);
            }
        }
        else
        {
            // return view('/login', ["error"=>"Invalid email"]);
            return view('/login', ["error"=> __('loginControllerAlert.emailError') ]);
        }
    }

    function selectLanguage(Request $req)
    {
        $language = $req->lang;
        session(['language'=> $language]);
        return redirect('/login');
    }

    function updateData(Request $req)
    {
        $data = Userdetail::where('email',$req->email)->get()->first();
        if($data)
        {
            $info = Resetpassword::where('email',$req->email)->get()->first(); 
            if($info)
            {
                $otp = random_int(100000, 999999);
                $info->otp = $otp;
                $info->save();
            }
            else
            {
                $resetpassword = new ResetPassword;
                $resetpassword->email = $req->email;
                $otp = random_int(100000, 999999);
                $resetpassword->otp = $otp;
                $resetpassword->save();
            }
                $info = [ 'otp' => $otp ];
                Mail::to($req->email)->send(new resetpasswordemail($info));
                return view("checkotp");
        }
        return view("/forgetpassword",["error"=>"Invalid Email"]);
    }

    function checkOtp(Request $req)
    {
        // $data = Resetpassword::find('email')->where('otp',$req->otp)->get(); 
        $data = Resetpassword::where('email',$req->email)->get();
        if(!empty($data->toArray()))
        {
            $otp = Resetpassword::where('email',$req->email)->where('otp' ,$req->otp)->get();
            if(!empty($otp->toArray()))
            {
                return view("/setpassword");   // Here we use view instead of redirect because  route of view page is not given
            }
            return view("/checkotp",["error"=>"Invalid OTP"]);
        }
        return view("/checkotp",["error"=>"Invalid Email"]);
    }

    function setPassword(Request $req)
    {
        $userdetail = Userdetail::where('email',$req->email)->get()->first();
        if($userdetail)
        {
            if ($req->password == $req->confirmpassword)
            {
                // $data = Userdetail::find($req->id);
                $id = $userdetail->id;
                $data = Userdetail::find($id); // to find row
                $data->password = Hash::make($req->password);
                $data->save();
                return view('/login',["success"=>"Your password has  been changed"]);  // redirect
            }
            else 
            {
                return view("setpassword", ["error"=>"Password and confirm password are not same"]);
            }
        }
        else
        {
            return view("setpassword", ["error"=>"Invalid email"]);
        }
    }

    function addAgent(Request $req)       
    {
        $req->validate([
            'email'=>['required', 'unique:userdetails'],
            'name'=>['required']
        ]);

        $userdetail = new Userdetail;  // here we define new instance of table. this is done when we have to add a new row of data
        $userdetail->name = $req->name;
        $userdetail->role = "Agent";
        $userdetail->email = $req->email;
        // $userdetail->password = Hash::make( Str::random(6) );
        $password =  Str::random(6);
        $userdetail->password = Hash::make( $password );
        $userdetail->save();
        $info = [
            'email' => $req->email ,
            "password" => $password
            ];
         Mail::to($req->email)->send(new sendemail($info));
        return view("/addagents", ["success"=>"Agent added successfully"]);
    }

    function resetPassword(Request $req)
    {        
        $userdetail = Userdetail::where('email',$req->email)->get()->first();
        if(!$userdetail)
        {
            return view("/resetpassword", ["error"=>"Invalid email"]);
        }
        else
        {
            $checkpassword=Hash::check($req->password, $userdetail->password);
            if(!$checkpassword)
            {
                return view("/resetpassword", ["error"=>"The password you've entered is not correct"]);
            }
            else
            {
                if ($req->newpassword == $req->confirmpassword)
                {
                    // $id = $userdetail->id;
                    // $data = Userdetail::find($id); // to find row
                    $userdetail->password = Hash::make($req->newpassword);
                    $userdetail->firstlogin = 1;
                    $userdetail->save();
                    session()->pull('role');
                    return view("/resetpassword", ["success"=>"Your password has changed successfully"]);
                }
                else 
                {
                    return view("/resetpassword", ["error"=>"New Password and confirm password are not same"]);
                }
            }
        } 
    }

    public function showList(Request $req)
    {
        // $data = Userdetail::all();

        if($req->search)
        {
            $data = Userdetail::where('role','Agent')->Where('name','LIKE',"%$req->search%")->where('email','LIKE',"%$req->search%")->get();
            return view("admin", ["userdetails"=>$data]); 
        }
        $data = Userdetail::where('role','Agent')->get()->toArray();
        return view("admin", ["userdetails"=>$data]);
        // Here the key userdetails is going to use in admin.blade file as a key of foreach in the table// 
    }

    function editAgent(Request $req)
    {
        $userdetail = Userdetail::find($req->id);
        $userdetail->name = $req->name;
        $userdetail->save();
        return redirect('/admin')->with('success','Agent Updated Successfully');  
        // We use redirect here instead of view because the view page donot exist for agent list
    }

    function deleteAgent($id)
    {
        $userdetail = Userdetail::find($id);
        $userdetail->delete();
        return redirect('/admin')->with('success','Agent deleted Successfully');  
    }

    function showAgents()
    {
        // if($req->search)
        // {
        //     $data = Userdetail::where('role','Agent')->Where('name','LIKE',"%$req->search%")->where('email','LIKE',"%$req->search%")->get();
        //     return ['status'=>true, 'userdetails'=>$data]; 
        // }
        // $data = Userdetail::where('role','Agent')->get();
        $data = Userdetail::all();
        // return view("agent", ["userdetails"=>$data]);
        return ['status'=>true, 'userdetails'=>$data]; 
    }
    
    function getagentfromadmin()
    {
        session(["role"=>"Agent"]); 
        return redirect("/agent"); 
    }

    function deleteChat(Request $req)
    {
        // return 'hello';
        
        $loginUser = session('id');
        $receiverUser = $req->receiverid;

        $userdetail = Chatdetail::where('senderid',$loginUser)->Where('receiverid',$receiverUser);
        $userdetail->delete();
        $userdetail = Chatdetail::where('senderid',$receiverUser)->Where('receiverid',$loginUser);
        $userdetail->delete();
        // return redirect('/agent')->with('success','Chat deleted Successfully');
        return redirect('/agent');
    }

    public function backupChat(Request $req)
    {
        $loginUser = session('id');
        $receiverUser = $req->backupid;
        Storage::disk('local')->put("$loginUser-$receiverUser.csv", 'Backup');

        $chatMessage = Chatdetail::orderBy('created_at')->get();
        $msg = [];
        foreach($chatMessage as $message)
        {
            if( ($message['senderid'] == $loginUser) && ($message['receiverid'] == $receiverUser) )
            {
                $message['type']='outgoing';
                $message['message'] = Crypt::encryptString($message['message']);

                Storage::append("$loginUser-$receiverUser.csv",$message);

            }
            else if( ($message['senderid'] == $receiverUser) && ($message['receiverid'] == $loginUser) )
            {
                $message['type']='incoming';
                $message['message'] = Crypt::encryptString($message['message']);

                Storage::append("$loginUser-$receiverUser.csv", $message);
            }
        }

        return redirect('agent');
    }

    public function restoreChat(Request $req)
    {
        $loginUser = session('id');
        $receiverUser = $req->restoreid;
        $contents = Storage::get("$loginUser-$receiverUser.csv");
       
            $location = "app";
            $filename = "$loginUser-$receiverUser.csv";
            $filepath = storage_path($location."/".$filename);
            $file = fopen($filepath,"r");
            $importData_arr = array();
            $i = 0;
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata );
                
                // Skip first row (Remove below comment if you want to skip the first row)
                if($i == 0){
                   $i++;
                   continue; 
                }       
                for ($c=0; $c < $num; $c++) {
                   $importData_arr[$i][] = $filedata [$c];
                }
                $i++;
            }
            fclose($file);
            foreach($importData_arr as $importData){
                $chatdetail = new Chatdetail();

                $import = explode(":",$importData[1]);
                $chatdetail->senderid = $import[1];
                
                $import = explode(":",$importData[2]);
                $chatdetail->receiverid = $import[1];
                
                $import = explode(":",$importData[3]);
                $r = substr($import[1], 1, -1);
                $chatdetail->message = Crypt::decryptString($r);

                $c = substr($importData[4], 11, -1);
                $e = str_replace("T", " ", $c);
                $e = substr($e, 0, strpos($e, "."));
                $e = substr($e,1,-1);
                $chatdetail->created_at = $e;
                
                $d = substr($importData[5], 11, -1);            
                $f = str_replace("T", " ", $d);
                $f = substr($f, 0, strpos($f, "."));
                $f = substr($f,1,);
                $chatdetail->updated_at = $f;

                $chatdetail->save();
            }
            
        return redirect('agent');
    }


    function getChatdata($id)
    {
        $loginUser = session('id');
        $receiverUser = $id;        //

        $data = Chatdetail::orderBy('created_at')->get()->toArray();

        $message = [];
        
        foreach($data as $row)
        {
            if( ($row['senderid']==$loginUser) && ($row['receiverid']==$receiverUser) )
            {
                $row['type'] = 'outgoing';
                $row['creator'] = Userdetail::find($loginUser)->name;

                $time = $row['created_at'];
                $chattime = date("h:i:A",strtotime($time));
                $row['time'] = $chattime;
            }
            else if( ($row['senderid']==$receiverUser) && ($row['receiverid']==$loginUser) )
            {
                $row['type'] = 'incoming';
                $row['creator'] = Userdetail::find($receiverUser)->name;

                $time = $row['created_at'];
                $chattime = date("h:i:A",strtotime($time));
                $row['time'] = $chattime;
            }
            else
            {
                unset($row);  // Hide this from array 
            }
            if(isset($row))
            {
                unset( $row['receiverid'],$row['senderid'], $row['id'], $row['updated_at'] );
                // $row['created_at'] = $this->formatTime($row['created_at']);        //

                $message[] = $row;
            }    
        }   
        return response()-> json([
            'status' =>'200',
            'chatmessage'=> $message,
            'name' => Userdetail::find($receiverUser)->name
        ]);
        // return ['status' =>'200', 'chatmessage'=> $message];
    }

    function submitChatdata(Request $req)
    {
        if(!$req->receiverid)
        {
            return response()-> json([
                'status' =>'500',
                'message'=>'Internal Server Error'
            ]);
        }
        else
        {
            $data = new Chatdetail;
            $data->senderid = $req->senderid;
            $data->receiverid = $req->receiverid;
            $data->message = $req->message;
            $data->created_at = Carbon::now()->addminutes('330');
            $data->save();
            return response()-> json([
                'status' =>'200',
                'message'=>'Message sent successfully'
            ]);
        }
            // return redirect('showchatdata');
            // return redirect('getchatdata');
    }

    // public function formatTime($baseTime)
    // {
    //     $time =explode('-', $baseTime );
    //     $time = $time[2];
    //     $time = explode(':', $time);

    //     $h = $time[0];
    //     $m = $time[1];
    //     $s = $time[2];
    //      $h = explode('T', $h);
    //      $h = $h[1];
    //      $s = explode('.', $s);
    //      $s = $s[0];
    //      $time = [$h, $m, $s];
    //     return implode(':',$time);
    // }

}

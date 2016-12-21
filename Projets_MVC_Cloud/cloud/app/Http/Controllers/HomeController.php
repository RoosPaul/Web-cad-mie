<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use Session;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function contact() {
        $admin = [];
        $data = DB::table('users')
        ->select('email')
        ->where('admin', 2)
        ->get();
        foreach ($data as $val) {
            array_push($admin, $val->email);
        }
        if (isset($_POST['_token'])) {
            foreach ($admin as $v) {
                Mail::send( 'email.contact', array('content' => $_POST['objet'], 'title' => $_POST['titre']), function( $message ) use ($v)
                {
                    $message->to($v)
                    ->subject('Contact site Cloud Wac');
                });
            }
        }
        return view('contact');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::guest() != true) {
            $session = $request->session()->all();
            $session = Auth::User()->id;
            // dd(Auth::User()->id);
            // $session = 1;
            $tmp = scandir(getcwd() . "/images/$session");
            $current_dir = getcwd() . "/images/$session";
            $data = [];
            foreach ($tmp as $value) {
                if (is_dir(getcwd() . "/images/$session/$value") && $value != "." && $value != "..") {
                    array_push($data, $value);
                }
            }

            if(!empty($_FILES)){
               foreach ($_FILES["files"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $taille_max    = 10485760;
                    $taille_fichier = filesize($_FILES['files']['tmp_name'][$key]);
                    if ($taille_fichier < $taille_max){
                        $tmp = DB::table('users')
                        ->where('id', $session)
                        ->select('taille')
                        ->get();
                        foreach ($tmp as $key => $value) {
                            $taille = $value->taille;
                        }
                        if (intval($taille) + intval(filesize($_FILES['files']['tmp_name'][$key])) < 52428800) {
                            DB::table('users')
                            ->where('id', $session)
                            ->update(['taille' => intval($taille) + intval(filesize($_FILES['files']['tmp_name'][$key]))]);

                            $name = $_FILES["files"]["name"][$key];
                            $file_extention = strrchr($name,".");
                            $tmp_name = $_FILES["files"]["tmp_name"][$key];
                            move_uploaded_file($tmp_name, "$current_dir/".$_POST['folder']."/$name");
                            DB::table('files')->insert([
                                ['user_id' => $session, 'folder' => $_POST['folder'], 'file' => $name, 'type' => $_FILES["files"]["type"][$key], 'taille' => filesize($_FILES['files']['tmp_name'][$key])],
                                ]);
                        }
                        else {
                            echo "Vous ne pouvez pas upload d'autres fichiers il n'y a plus de place sur votre compte !";
                        }
                    }
                }
            }
        }
        return view('welcome', ['data' => $data]);
    }
}
}
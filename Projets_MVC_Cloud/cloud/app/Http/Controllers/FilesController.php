<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

use App\Http\Requests;

class FilesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::User() == NULL)
            return redirect('/login');
        if (Auth::User()->admin != 2 && Auth::User()->admin != 1)
            return redirect('/');
        $session = $request->session()->all();
        $session = $session['user']->id;
        $tmp = scandir(getcwd() . "/images/$session");
        $current_dir = getcwd() . "/images/$session";
        $user_folders = [];
        foreach ($tmp as $value) {
            if (is_dir(getcwd() . "/images/$session/$value") && $value != "." && $value != "..") {
                array_push($user_folders, $value);
            }
        }
        $data = DB::table('files')
        ->where('user_id', $session)
        ->paginate(1);
        return view('files.index', ['data' => $data, 'folders' => $user_folders]);
    }

    public function share(Request $request) {
        if (Auth::User() == NULL)
            return redirect('/login');
        if (Auth::User()->admin != 2 && Auth::User()->admin != 1)
            return redirect('/');
        $session = $request->session()->all();
        $session = $session['user']->id;
        if (isset($_POST['private']) && isset($_POST['folders'])) {
            foreach ($_POST['folders'] as $val) {
                DB::table('share')
                ->where('user_share', $session)
                ->where('folder', $val)
                ->delete();
            }
        }
        else if (isset($_POST['users']) && isset($_POST['folders'])) {
            foreach ($_POST['users'] as $value) {
                foreach ($_POST['folders'] as $val) {
                    DB::table('share')
                    ->insert(['user_id' => $value, 'user_share' => $session, 'folder' => $val]);
                }
            }
        }
        
        $data = DB::table('users')
        ->get();
        $tmp = scandir(getcwd() . "/images/$session");
        $current_dir = getcwd() . "/images/$session";
        $user_folders = [];
        foreach ($tmp as $value) {
            if (is_dir(getcwd() . "/images/$session/$value") && $value != "." && $value != "..") {
                array_push($user_folders, $value);
            }
        }
        return view('files.share', ['data' => $data, 'folders' => $user_folders]);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::User() == NULL)
            return redirect('/login');
        if (Auth::User()->admin != 2 && Auth::User()->admin != 1)
            return redirect('/');
        $file = DB::table('users')
        ->join('files', 'users.id', '=', 'files.user_id')
        ->where('files.id', $id)
        ->get();
        foreach ($file as $value) {
            $type = $value->type;
        }
        $image = ['gif', 'jpeg', 'png', 'bmp', 'jpg'];
        $video = ['webm', 'mp4', 'ogv'];
        $audio = ['mp3', 'wav'];
        if (in_array($type, $image)) {
            return view('show.image', ['data' => $file]);
        }
        else if (in_array($type, $video)) {
            return view('show.video', ['data' => $file]);
        }
        else if (in_array($type, $audio)) {
            return view('show.audio', ['data' => $file]);
        }
        else {
            return view('show.unknow', ['data' => $file]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if (Auth::User() == NULL)
            return redirect('/login');
        if (Auth::User()->admin != 2 && Auth::User()->admin != 1)
            return redirect('/');
        $session = $request->session()->all();
        $session = $session['user']->id;
        $folder = getcwd() . "/images/$session";
        if (isset($_POST['name'])) {
            if ($_POST['name'] != "") {
                rename("$folder/" . $_POST['folder'] ."/".$_POST['old_name'], 
                    "$folder/" . $_POST['folder'] ."/".$_POST['name']);
                DB::table('files')
                ->where('id', $id)
                ->update(['file' => $_POST['name']]);
                $data = DB::table('files')
                ->where('id', $id)
                ->get();
                return redirect('/files')
                ->with('status', 'Votre fichier a bien été renommer !');
            }
        }
        $data = DB::table('files')
        ->where('id', $id)
        ->get();
        return view('files.edit', ["data" => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add_dir(Request $request)
    {
        if (Auth::User() == NULL)
            return redirect('/login');
        if (Auth::User()->admin != 2 && Auth::User()->admin != 1)
            return redirect('/');
        $session = $request->session()->all();
        $session = $session['user']->id;
        $folder = getcwd() . "/images/$session";

        if (!is_dir($folder . "/".$_GET['folder'])) {
            mkdir($folder . "/".$_GET['folder']);
            return redirect('/files')
            ->with('status', 'Votre dossier a bien été créer !');
        }
        else {
            return redirect('/files');
        }
    }

    public function delete_dir(Request $request) {
        if (Auth::User() == NULL)
            return redirect('/login');
        if (Auth::User()->admin != 2 && Auth::User()->admin != 1)
            return redirect('/');
        $session = $request->session()->all();
        $session = $session['user']->id;
        if ($_POST['folder'] != "default") {
            $folder = getcwd() . "/images/$session";
            $data = scandir($folder . "/" . $_POST['folder']);
            foreach ($data as $value) {
                if ($value != "." && $value != "..") {
                    unlink($folder . "/" . $_POST['folder'] . "/" . $value);
                }
            }
            rmdir($folder . "/" . $_POST['folder']);
            DB::table('files')
            ->where('user_id', $session)
            ->where('folder', $_POST['folder'])
            ->delete();
            return redirect('/files')
            ->with('status', 'Votre dossier a bien été supprimer !');
        }   
        return redirect('/files');
    }

    public function move_dir(Request $request) {
        if (Auth::User() == NULL)
            return redirect('/login');
        if (Auth::User()->admin != 2 && Auth::User()->admin != 1)
            return redirect('/');
        $session = $request->session()->all();
        $session = $session['user']->id;
        $user_folder = getcwd() . "/images/$session";
        $data = DB::table('files')
        ->where('id', $_POST['file'])
        ->where('user_id', $session)
        ->get();

        foreach ($data as $value) {
            $folder = $value->folder;
            $file = $value->file;
        }
        if (is_dir($user_folder . "/" . $_POST['folder'])) {
            rename($user_folder . "/" . $folder . "/" . $file, $user_folder . "/" . $_POST['folder'] . "/" . $file);
        }
        $data = DB::table('files')
        ->where('id', $_POST['file'])
        ->where('user_id', $session)
        ->update(['folder' => $_POST['folder']]);
        return redirect('/files')
        ->with('status', 'Votre fichier a bien été déplacer !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (Auth::User() == NULL)
            return redirect('/login');
        if (Auth::User()->admin != 2 && Auth::User()->admin != 1)
            return redirect('/');
        $session = $request->session()->all();
        $session = $session['user']->id;

        $tmp = DB::table('files')
        ->where('id', $id)
        ->select('taille')
        ->get();

        foreach ($tmp as $value) {
            $files = $value->taille;
        }

        $tmp = DB::table('users')
        ->where('id', $session)
        ->select('taille')
        ->get();

        foreach ($tmp as $value) {
            $users = $value->taille;
        }        
        DB::table('users')
        ->where('id', $session)
        ->update(['taille' => intval($users) -
            intval($files)]);

        DB::table('files')
        ->where('id', $id)
        ->delete();
        return redirect('/files')->with('status', "Félicitation, votre fichier a bien été supprimer !");
    }
}

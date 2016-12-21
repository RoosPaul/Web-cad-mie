<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;
// use Request;
use Response;
use Illuminate\Support\Facades\Response as FacadeResponse;

class DropzoneController extends Controller {

    public function index() {
        return view('welcome');
    }

    public function uploadFiles(Request $request) {

        $input = Input::all();

        $rules = array(
            'file' => 'max:10485760',
            );

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            return FacadeResponse::make($validation->errors->first(), 400);
        }
        $session = $request->session()->all();
        $session = $session['user']->id;
        $destinationPath = 'images/' . $session . '/default/'; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting file extension
        $fileName = rand(11111, 99999) . '.' . $extension; // renameing image

        $tmp = DB::table('users')
        ->where('id', $session)
        ->select('taille')
        ->get();
        foreach ($tmp as $value) {
            $taille = $value->taille;
        }
        $imageSize = Input::file('file')->getClientSize();

        if (($taille + $imageSize) < 52428800) {
            $upload_success = Input::file('file')->move($destinationPath, $fileName);
        }
        else {
            $upload_success = false;
        }

        if ($upload_success) {
            DB::table('files')
            ->insert(
                ['user_id' => $session, 'folder' => 'default', 'file' => $fileName, 'type' => $extension, 'taille' => $imageSize]
                );

            DB :: table('users')
            ->where('id', $session)
            ->update(['taille' => $taille + $imageSize]);
            return FacadeResponse::json('success', 200);
        } else {
            return FacadeResponse::json('error', 400);
        }
    }

}
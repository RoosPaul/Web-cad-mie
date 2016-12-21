<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;

class ShareController extends Controller
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
        $data = DB::table('share')
        ->where('user_id', $session)
        ->get();
        $tmp = [];
        foreach ($data as $value) {
            $buffer = DB::table('files')
            ->where('user_id', $value->user_share)
            ->where('folder', $value->folder)
            ->get();
            array_push($tmp, $buffer);
        }
        return view('share.index', ['data' => $tmp]);
    }
}

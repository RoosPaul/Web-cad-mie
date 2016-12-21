<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

use App\Http\Requests;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::User() == NULL)
            return redirect('/login');
        if (Auth::User()->admin != 2)
            return redirect('/');
        $users = DB::table('users')
        ->orderBy('id', 'desc')
        ->limit(10)
        ->get();

        $files = DB::table('files')
        ->orderBy('id', 'desc')
        ->limit(10)
        ->get();

        return view('admin.index', ['users' => $users, 'files' => $files]);
    }

    public function files() {
        if (Auth::User() == NULL)
            return redirect('/login');
        if (Auth::User()->admin != 2)
            return redirect('/');
        $files = DB::table('files')
        ->get();
        return view('admin.files', ['files' => $files]);
    }

    public function users() {
        if (Auth::User() == NULL)
            return redirect('/login');
        if (Auth::User()->admin != 2)
            return redirect('/');
        $users = DB::table('users')
        ->get();
        return view('admin.users', ['users' => $users]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        if (Auth::User() == NULL)
            return redirect('/login');
        if (Auth::User()->admin != 2)
            return redirect('/');
        $tmp = DB::table('users')
        ->select('id')
        ->where('username', $user)
        ->get();

        foreach ($tmp as $value) {
            $id = $value->id;
        }

        $files = DB::table('files')
        ->where('user_id', $id)
        ->orderBy('id', 'desc')
        ->get();
        return view('admin.user', ['files' => $files, 'user' => $user]);
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
        if (Auth::User()->admin != 2)
            return redirect('/');
        $admin = DB::table('users')
        ->select('admin')
        ->where('id', $id)
        ->get();

        foreach ($admin as $value) {
            if ($value->admin == 2) {
                $new_val = 1;
            }
            else if ($value->admin == 1) {
                $new_val = 2;
            }
        }
        DB::table('users')
        ->where('id', $id)
        ->update(['admin' => intval($new_val)]);
        return redirect('/admin/users')
        ->with('status', 'Le changement de status du compte a été appliquer !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::User() == NULL)
            return redirect('/login');
        if (Auth::User()->admin != 2)
            return redirect('/');
        $admin = DB::table('users')
        ->select('admin')
        ->where('id', $id)
        ->get();

        foreach ($admin as $value) {
            if ($value->admin == 0) {
                $new_val = '1';
            }
            else if ($value->admin == 1) {
                $new_val = 0;
            }
        }
        DB::table('users')
        ->where('id', $id)
        ->update(['admin' => intval($new_val)]);
        return redirect('/admin/users')
        ->with('status', 'Le changement de status du compte a été appliquer !');
    }
}

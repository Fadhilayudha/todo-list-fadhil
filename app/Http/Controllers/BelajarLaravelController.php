<?php

namespace App\Http\Controllers;

use App\Models\BelajarLaravel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class BelajarLaravelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    
    public function register()
    {
        return view("register", [
            'title' => 'register'
        ]);
    }
    
    public function index()
    {
        return view("login", [
            'title' => 'login',
        ]);
    }

    public function registerAccount(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email'=>'required|email:dns',
            'username'=>'required|min:4|max:8',
            'password'=>'required|min:4',
            'name'=>'required|min:3',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
        ]);

        //redirect kemana setelah berhasil tambah data + dikirim pemberitahuan
        return redirect('/')->with('success','Berhasil menambahkan akun! Silahkan login');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required',
        ],[
            'username.exists' => 'username ini belum tersedia',
            'username.required' => 'username harus diisi',
            'password.required' => 'password harus diisi',
        ]);

        $user = $request->only('username','password');
        if(Auth::attempt($user)){
            return redirect()->route('BelajarLaravel.index');
        }else{
            return redirect()->back()->with('error','Gagal login, silahkan cek dan coba lagi!');
        }
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // public function create()
    // {
    //     //
    // }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BelajarLaravel  $belajarLaravel
     * @return \Illuminate\Http\Response
     */
    public function show(BelajarLaravel $belajarLaravel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BelajarLaravel  $belajarLaravel
     * @return \Illuminate\Http\Response
     */
    public function edit(BelajarLaravel $belajarLaravel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BelajarLaravel  $belajarLaravel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BelajarLaravel $belajarLaravel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BelajarLaravel  $belajarLaravel
     * @return \Illuminate\Http\Response
     */
    public function destroy(BelajarLaravel $belajarLaravel)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\BelajarLaravel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        //menghapus history login
        Auth::logout();
        //mengarahkan ke halaman login lagi
        return redirect('/');
    }


    public function dashboard()
    {
        return view("dashboard", [
            'title' => 'dashboard'
        ]);
    }
    
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
        //array ke-2 untuk cuntom message
        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required',
        ],[
            'username.exists' => 'username belom ada woi',
            'username.required' => 'usernamenya isi cuy',
            'password.required' => 'minimal isi password lah',
        ]);

        $user = $request->only('username','password');
        if(Auth::attempt($user)){
            return redirect()->route('dashboard.index');
        }else{
            return redirect()->back()->with('error','Gagal login, silahkan cek dan coba lagi!');
        }
    }
}

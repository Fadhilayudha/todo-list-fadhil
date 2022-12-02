<?php

namespace App\Http\Controllers;

use App\Models\BelajarLaravel;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        return view("todo", [
            'title' => 'todo'
        ]);
    }

    public function create()
    {
        return view("create", [
            'title' => 'create'
        ]);
    }


    public function edit($id)
    {
        $todo = BelajarLaravel::where('id', $id)->first();
        $title = 'Edit Todo';
        return view('edit', compact('todo', 'title'));
    }

    
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|min:3',
            'date' => 'required',
            'description' => 'required|min:5',
        ]);

        //mengirim data ke database belajar_laravel dengan model BelajarLaravel 
        //$request-> = value attribute name pada input
        //kenapa dikirimnya 5 data? karena pada tabel db belajar_laravel membutuhkan 6 column input
        //salah satunya colum 'done_time' yang tipenya nullable,karena nullable jadi ga perlu dikirim nilai 
        $BelajarLaravel=BelajarLaravel::create([
            'title' => $request->title,
            'date'=> $request->date,
            'description'=> $request->description,
            'user_id'=> auth()->user()->id,
            'status'=>0
        ]);

        return redirect()->route('dashboard.index')->with('successAdd', 'Berhasil menambahkan data Todo!');


        if($BelajarLaravel){
            return redirect()->route('dashboard.index');
        }else{
            return redirect()->back()->with('error','Gagal login, silahkan cek dan coba lagi!');
        }
    }


    public function destroy($id)
    {
        $todo = BelajarLaravel::where('id', $id)->first();
        $todo->delete();
        return redirect()->route('dashboard.index')->with('successAdd', 'Berhasil menghapus  Todo!');
    }

    public function updateComplated($id)
    {
        BelajarLaravel::where('id', '=', $id)->update([
            'status' => 1,
            'date_time' => \Carbon\Carbon::now(),
        ]);
        return redirect()->back()->with('done', 'Berhasil mengubah status!');
    }


    
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|min:3',
            'date' => 'required',
            'description' => 'required|min:5',
        ]);

        //mengirim data ke database belajar_laravel dengan model BelajarLaravel 
        //$request-> = value attribute name pada input
        //kenapa dikirimnya 5 data? karena pada tabel db belajar_laravel membutuhkan 6 column input
        //salah satunya colum 'done_time' yang tipenya nullable,karena nullable jadi ga perlu dikirim nilai 
        $todo = BelajarLaravel::where('id', $id)->first();

        $BelajarLaravel = $todo->update([
            'title' => $request->title,
            'date'=> $request->date,
            'description'=> $request->description,
            'user_id'=> auth()->user()->id,
            'status'=>0
        ]);

        return redirect()->route('dashboard.index')->with('successAdd', 'Berhasil mengubah data Todo!');

        if($BelajarLaravel){
            return redirect()->route('dashboard.index');
        }else{
            return redirect()->back()->with('error','Gagal login, silahkan cek dan coba lagi!');
        }
    }

}

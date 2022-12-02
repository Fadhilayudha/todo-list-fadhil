<?php

namespace App\Http\Controllers;

use App\Models\BelajarLaravel;
use Illuminate\support\Facades\Auth;
use App\Models\User;    
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $todos = BelajarLaravel::where('user_id', Auth::user()->id)->get();
        return view("dashboard", compact('todos'), [
            'title' => 'dashboard'
        ]); 
    }
}

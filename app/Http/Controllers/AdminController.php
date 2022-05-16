<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
   public function index(): \Inertia\Response
   {
       return Inertia::render('Admin/Index');
   }

   public function users(): \Inertia\Response
   {
       $users = User::latest()->with('role')->get();
       return Inertia::render('Admin/Users/Index', [
           'users' => $users
       ]);
   }

   public function create(): \Inertia\Response
   {
       return Inertia::render('Admin/Users/Create');
   }
}

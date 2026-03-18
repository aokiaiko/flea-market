<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
 public function index()
 {
    return view('items/index');
 }


    public function showLogin()
 {
    return view('auth/login');
 }

  public function login(LoginRequest $request)
  {
     
    if (!Auth::attempt($request->only('email','password'))) {
        return back()->withErrors([
           'login' => 'ログイン情報が登録されていません'
        ]);
    }
    

    return redirect('/?tab=mylist');
  }



  public function showRegister()
  {
    return view('auth/register');
  }

  public function store(RegisterRequest $request)
  {
    $user=$request->only(['name','email','password']);
    $user['password'] = Hash::make($user['password']);
    $user=User::create($user);
    Auth::login($user); 

    event(new Registered($user));

    return redirect('/mypage/edit');
   
  }
}

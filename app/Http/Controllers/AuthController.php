<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ShortURL;
use Hash, Session, Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            return redirect('dashboard');
        }
        
        return view('auth.login');
    }  
      
    public function Login(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = User::where('email', $request->login)
            ->orWhere('username', $request->login)
            ->first();
        
        if ($user) {
            if ($request->login === $user->email) {
                if (Auth::attempt(['email' => $request->login,
                'password' => $request->password])) {
                    return redirect()->intended('dashboard')
                                ->withSuccess('signed in');
                }
            } else if ($request->login === $user->username) {
                if (Auth::attempt(['username' => $request->login,
                'password' => $request->password])) {
                    return redirect()->intended('dashboard')
                                ->withSuccess('signed in');
                }
            } 
        }      
  
        return redirect("login")->with('error', 'Login details are not valid');
    }

    public function register()
    {
        if(Auth::check()){
            return redirect('dashboard');
        }

        return view('auth.register');
    }
      
    public function Registration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'username' => $data['username'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }    
    
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard', ['users' => Auth::user(), 'shortUrls' => new ShortURL]);
        }
  
        return redirect("login")->with('error', 'Pleae login with your credentials!');
    }
    
    public function logOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}

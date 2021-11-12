<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // dd($request->get('email'));
        // dd($request->email);
        $this->validate($request,[
            'nome' => 'required|max:255|min:2',
            'username' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed',
        ],
        [
            'nome.required' => 'Campo obrigatório.',
            'nome.min' => ':attribute precisa conter ao menos :min caracteres.'
        ]
        );
        // dd('store');
        User::create([
            'name' => $request->nome,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        auth()->attempt($request->only('email','password'));
        return redirect()->route('dashboard');
    }
}

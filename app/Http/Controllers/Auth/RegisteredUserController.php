<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
public function store(Request $request): Response
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $nameParts = explode(' ', $request->name, 2);
    $imie = $nameParts[0];
    $nazwisko = $nameParts[1] ?? ''; 

    $user = User::create([
        'nazwa_uzytkownika' => $request->email, 
        'imie' => $imie,
        'nazwisko' => $nazwisko,
        'email' => $request->email,
        'haslo' => $request->password, 
    ]);


    event(new Registered($user));

  
    return response()->noContent();
}
}

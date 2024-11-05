<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Core\Controller;
use App\Http\Requests\Admin\Auth\AuthLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{

    public function login(AuthLoginRequest $request): RedirectResponse|View
    {
        if ($request->isMethod('get')) {
            return view('admin.auth.login');
        }

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials))
            return redirect()->route('admin.section.view', 'home');

        return back()->with('error', 'Не верные данные.')->withInput($request->all());
    }

    public function logout(): RedirectResponse
    {
        auth()->logout();

        return redirect()->route('admin.auth.login');
    }
}

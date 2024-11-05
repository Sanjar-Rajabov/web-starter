<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Requests\Admin\Auth\ProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController
{
    public function index(ProfileRequest $req)
    {
        if ($req->isMethod('get'))
            return view('admin.auth.profile');

        $user = User::query()->find(auth()->id());

        $new_password = $req->input('new_password');
        $password = $req->input('password');
        $name = $req->input('name');

        if ($new_password !== null and strlen($new_password) < 5)
            return back()->with('error', 'Новый пароль должен быть не меньше 5 букв.');

        if (Hash::check($password, $user->password)) {
            if ($new_password !== null)
                $user->update([
                    'name' => $name,
                    'password' => Hash::make($new_password)
                ]);
            else
                $user->update([
                    'name' => $name,
                ]);
            return back()->with('success', 'Данные были сохранены!');
        }

        return back()->with('error', 'Не верный пароль');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\UserRoleEnum;
use App\Http\Requests\Auth\RegisteringRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        $roles = UserRoleEnum::getRolesForRegister();

        return view('auth.register', [
            'roles' => $roles,
        ]);
    }

    public function callback($provider): RedirectResponse
    {
        $data = Socialite::driver($provider)->user();
        $user       = User::query()
            ->where('email', $data->getEmail())
            ->first();
        $checkExist = true;
        if (is_null($user)) {
            $user        = new User();
            $user->email = $data->getEmail();
            $checkExist  = false;
        }
        $user->name   = $data->getName();
        $user->avatar = $data->getAvatar();
        $user->role   = UserRoleEnum::ADMIN;
        $user->save();
        $role = getRoleByKey($user->role);
        Auth::login($user, true);

        if ($checkExist) {
            return redirect()->route("welcome");
        }
        return redirect()->route('register');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect()->route('login');
    }
}

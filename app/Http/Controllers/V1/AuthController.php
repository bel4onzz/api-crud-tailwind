<?php

namespace App\Http\Controllers\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $login_user_data = $this->handle_register_login($user);

            return [
                'status' => 'success',
                'message' => 'User Created!',
                'data' => $user,
                'auth' => $login_user_data
            ];
        } catch (\Throwable $th) {
            return ['LOG' => $th, 'status' => 'be error', 'message' => 'Failed!'];
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $request->authenticate();
        if (Auth::attempt($request->only('email', 'password'))) {
            $token = '';
            $user = Auth::user();
            if ($user instanceof \App\Models\User) {
                DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();
                // Hinting here for $user will be specific to the User object
                $token = $user->createToken("TOKENNAME")->plainTextToken;
            }

            return [
                'data' => UserResource::make($user),
                'token' => $token
            ];
        }
        return ['status' => 'be error', 'message' => 'Failed!'];
    }

    public function handle_register_login(User $user)
    {

            $token = '';
            if ($user instanceof \App\Models\User) {
                // Hinting here for $user will be specific to the User object
                $token = $user->createToken("TOKENNAME")->plainTextToken;
            }

            return [
                'data' => UserResource::make($user),
                'token' => $token
            ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
        Auth::guard('web')->logout();
        return ['status' => 'success', 'message' => 'Failed!'];
    }
}

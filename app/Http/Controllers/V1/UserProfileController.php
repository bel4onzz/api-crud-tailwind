<?php

namespace App\Http\Controllers\V1;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserPutRequest;

class UserProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();

        return [
            'data' => UserResource::make($user),
            'token' => DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->latest()->first()
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserPutRequest $request, User $user)
    {
        unset($request['id']);
        $user->update($request->all());
        DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();
        return [
            'data' => UserResource::make($user),
            'token' => $user->createToken("TOKENNAME")->plainTextToken
        ];
    }
}

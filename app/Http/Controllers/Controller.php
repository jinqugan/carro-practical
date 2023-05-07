<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function createToken(): array
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $createToken = $user->createToken('Carro-Practical');
        $createToken->accessToken->expires_at = Carbon::now()->addDays(30);
        $createToken->accessToken->save();

        return [
            'token' => [
                'id' => $createToken->accessToken->id,
                'type' => 'Bearer',
                'token' => $createToken->plainTextToken,
                'expires_at' => $createToken->accessToken->expires_at,
            ],
        ];
    }
}

<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Register\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Services\Users\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ExceptionResource;
use App\Traits\ResponseTrait;

class RegisterController extends Controller
{
    use ResponseTrait;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->userService->createUser($request->toArray());
            Auth::login($user);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
        }

        return (new UserResource($user))->additional([
            'meta' => $this->createToken(),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Resources\User\UserResource;

class AuthController extends Controller
{
    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * AuthController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Register a new user
     */
    public function register(Request $request): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'name' => 'required', 'string', 'max:255',
            'email' => 'required|email|unique:' . User::class . ',email',
            'password' => 'required|min:3|confirmed',
        ]);
        if ($data->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $data->errors()
            ], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $token = $user->createToken('MyApp')->accessToken;
        $response = ['user'=>$user, 'accessToken'=>$token];
        return response()->json([$response, "message" => __('messages.success_register')], 201);
    }

    /**
     * Login user and return a token
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response
            (
                ['error_message' => 'Incorrect Details. Please try again!']
            );
        }
        Auth::user()->OauthAccessToken()->delete();

        $token = auth()->user()->createToken('API Token')->accessToken;
        $userService = $this->userService->findOrFailById(auth()->user()->id);
        $user=UserResource::make($userService);
        return response([
              'user' => $user,
              'accessToken' => $token]);
    }

    /**
     * Logout User
     */
    public function logout(Request $request): int
    {
        if (Auth::check()) {
            Auth::user()->OauthAccessToken()->delete();
        }

        return Response::HTTP_OK;
    }

}

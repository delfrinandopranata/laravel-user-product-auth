<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\AuthRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    use ResponseTrait;

    public $authRepository;

    public function __construct(AuthRepository $ar)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->authRepository = $ar;
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Authentication"},
     *     summary="Login",
     *     description="Log in using email and password to get an access token.",
     *     operationId="loginUser",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="email", type="string", example="delfrinando@gmail.com"),
     *              @OA\Property(property="password", type="string", example="123456")
     *          ),
     *      ),
     *      @OA\Response(response=200, description="Successful login with token"),
     *      @OA\Response(response=401, description="Invalid Email and Password"),
     *      @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->only('email', 'password');

            if ($token = $this->guard()->attempt($credentials)) {
                $data = $this->respondWithToken($token);
            } else {
                return $this->responseError(null, 'Invalid Email and Password!', Response::HTTP_UNAUTHORIZED);
            }

            return $this->responseSuccess($data, 'Logged In Successfully!');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     tags={"Authentication"},
     *     summary="Register",
     *     description="Register a new user with required fields like first name, last name, email, password, and more.",
     *     operationId="registerUser",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="first_name", type="string", example="John"),
     *              @OA\Property(property="last_name", type="string", example="Doe"),
     *              @OA\Property(property="email", type="string", example="jhondoe@example.com"),
     *              @OA\Property(property="password", type="string", example="123456"),
     *              @OA\Property(property="password_confirmation", type="string", example="123456"),
     *              @OA\Property(property="date_of_birth", type="string", format="date", example="1990-01-01"),
     *              @OA\Property(property="gender", type="string", enum={"male", "female", "other"}, example="male")
     *          ),
     *      ),
     *      @OA\Response(response=200, description="User registered successfully with token"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $requestData = $request->only('first_name', 'last_name', 'email', 'password', 'password_confirmation', 'date_of_birth', 'gender');
            
            $user = $this->authRepository->register($requestData);
            if ($user) {
                if ($token = $this->guard()->attempt(['email' => $requestData['email'], 'password' => $requestData['password']])) {
                    $data =  $this->respondWithToken($token);
                    return $this->responseSuccess($data, 'User Registered and Logged in Successfully', Response::HTTP_OK);
                }
            }
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/auth/me",
     *     tags={"Authentication"},
     *     summary="Get Authenticated User Profile",
     *     description="Retrieve the profile information of the authenticated user.",
     *     operationId="getAuthenticatedUser",
     *     @OA\Response(response=200, description="User profile fetched successfully"),
     *     @OA\Response(response=500, description="Internal server error"),
     *     security={{"bearer":{}}}
     * )
     */
    public function me(): JsonResponse
    {
        try {
            $data = $this->guard()->user();
            return $this->responseSuccess($data, 'Profile Fetched Successfully!');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     tags={"Authentication"},
     *     summary="Logout",
     *     description="Log out the authenticated user and invalidate the token.",
     *     operationId="logoutUser",
     *     @OA\Response(response=200, description="Successfully logged out"),
     *     @OA\Response(response=500, description="Internal server error"),
     *     security={{"bearer":{}}}
     * )
     */
    public function logout(): JsonResponse
    {
        try {
            $this->guard()->logout();
            return $this->responseSuccess(null, 'Logged out successfully!');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/refresh",
     *     tags={"Authentication"},
     *     summary="Refresh Token",
     *     description="Refresh the authentication token for the user.",
     *     operationId="refreshToken",
     *     @OA\Response(response=200, description="Token refreshed successfully"),
     *     @OA\Response(response=500, description="Internal server error"),
     *     security={{"bearer":{}}}
     * )
     */
    public function refresh(): JsonResponse
    {
        try {
            $data = $this->respondWithToken($this->guard()->refresh());
            return $this->responseSuccess($data, 'Token Refreshed Successfully!');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Generates JWT token response.
     *
     * @param  string  $token
     * @return array
     */
    protected function respondWithToken($token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60 * 24 * 30, // 43200 Minutes = 30 Days
            'user' => $this->guard()->user()
        ];
    }

    /**
     * Get the guard for authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    public function guard(): \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
    {
        return Auth::guard();
    }
}

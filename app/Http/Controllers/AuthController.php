<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function loggedIn(): bool
    {
        if (auth()->user())
        return True;
        else return false;
    }

    public function authRole()
    {
        $log = AuthController::loggedIn();
        if ($log)
        {
            return auth()->user()->role;
        }
        else return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized',
        ], 401);
    }

    public function payloadEncoding($token)
    {
        //token encoding
        try {
            $jwtParts = explode('.', $token);
            if (empty($header = $jwtParts[0]) || empty($payload = $jwtParts[1]) || empty($jwtParts[2])) {
                throw new JwtServiceException('Missing JWT part(s).');
            }
        } catch (Throwable $e) {
            throw new JwtServiceException('Provided JWT is invalid.', $e);
        }

        if (
            !($header = base64_decode($header))
            || !($payload = base64_decode($payload))
        ) {
            throw new JwtServiceException('Provided JWT can not be decoded from base64.');
        }

        if (
            empty(($header = json_decode($header, true)))
            || empty(($payload = json_decode($payload, true)))
        ) {
            throw new JwtServiceException('Provided JWT can not be decoded from JSON.');
        }

        return $payload;

    }

  public function login(Request $request): JsonResponse
  {
    //validating credentials
    $request->validate([
      'email' => 'required|string|email',
      'password' => 'required|string',
    ]);
    $credentials = $request->only('email', 'password');
    //getting user token
    $token = Auth::attempt($credentials);
    if (!$token) {
      return response()->json([
        'status' => 'error',
        'message' => 'Unauthorized',
      ], 401);
    }

    //getting user
    $user = User::where('email','=',$request->email)->first();
    if(!$user) {
      return response()->json(['error' => 'User not found'], 404);
    }

    $iat = $user->iat;

    $payload = AuthController::payloadEncoding($token);

    //Token refresh
    if($payload == NULL || !$iat)
    {
      Auth::attempt();
      $token = Auth::attempt($credentials);
      $payload = AuthController::payloadEncoding($token);
      $user = User::where('email','=',$request->email)->update([
        'iat' => $payload['iat']
      ]);
    }

    if($payload['iat']!= $iat)
    {
      Auth::attempt();
      $user = User::where('email','=',$request->email)->update([
        'iat' => $payload['iat']
      ]);
    }

    $user = auth()->user()->load('role');
    $expiresIn = auth()->factory()->getTTL() * 60;

    return response()->json([
      'access_token' => $token,
      'token_type' => 'bearer',
      'expires_in' => $expiresIn,
      'user' => $user,
    ]);
  }


  public function register(Request $request): JsonResponse
    {
        $validator = Validator::make(request(['name', 'email', 'password']), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        if ($request->cv) {
          User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'personalCode' => $request->personalCode,
            'email' => $request->email,
            'cv' => $request->cv,
            'password' => Hash::make($request->password),
            'fk_Schoolid_School' => $request->fk_Schoolid_School,
          ]);
        } else {
          User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'personalCode' => $request->personalCode,
            'email' => $request->email,
            'cv' => null,
            'password' => Hash::make($request->password),
            'fk_Schoolid_School' => $request->fk_Schoolid_School,
          ]);
        }

        return response()->json(['success' => 'User created successfully'], 200);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->update([
            'iat' => NULL
        ]);
        auth()->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
      return response()->json(auth()->user()->load(['role', 'confirmation', 'school', 'class1']));
    }
}

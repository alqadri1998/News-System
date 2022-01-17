<?php

namespace App\Http\Controllers\API;

use App\Helpers\Messages;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserApiAuthController extends AuthBaseController
{
    //
    //php artisan passport:client --personal
    public function login(Request $request)
    {
        $roles = [
            'email' => 'required|string|email|exists:users',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $user = User::where("email", $request->get('email'))->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $this->revokePreviousTokens($user->id);
                    return $this->generateToken($user, 'LOGGED_IN_SUCCESSFULLY');
                } else {
                    return ControllersService::generateProcessResponse(false, 'ERROR_CREDENTIALS');
                }
            } else {
                return ControllersService::generateProcessResponse(false, 'ERROR_CREDENTIALS');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }

    public function register(Request $request)
    {
        $roles = [
            'name' => 'required|string|min:3|max:10',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|numeric|unique:users|digits:9',
            'password' => 'required|min:3',
            'age' => 'required|integer|min:10',
            'gender' => 'required|in:Male,Female',
        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $user = new User();
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->mobile = $request->get('mobile');
            $user->password = Hash::make($request->get('password'));
            $user->age = $request->get('age');
            $user->gender = $request->get('gender');
            $isSaved = $user->save();
            if ($isSaved) {
                return $this->generateToken($user, 'REGISTERED_SUCCESSFULLY');
            } else {
                return ControllersService::generateProcessResponse(false, 'LOGIN_IN_FAILED');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }

    public function update(Request $request)
    {
        $userId = $request->user('user_api')->id;
        $roles = [
            'name' => 'required|string|min:3|max:10',
            'email' => 'required|string|email|unique:users,email,' . $userId,
            'mobile' => 'required|numeric|digits:9|unique:users,mobile,' . $userId,
            'age' => 'required|integer|min:10',
            'gender' => 'required|in:Male,Female',
        ];
        $validator = Validator::make($request->all(), $roles);

        if (!$validator->fails()) {
            $user = User::find($request->user('user_api')->id);
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->mobile = $request->get('mobile');
            $user->age = $request->get('age');
            $user->gender = $request->get('gender');
            $isUpdated = $user->save();
            if ($isUpdated) {
                return ControllersService::generateObjectSuccessResponse($user, Messages::getMessage('USER_UPDATED_SUCCESS'));
            } else {
                return ControllersService::generateObjectSuccessResponse($user, Messages::getMessage('USER_UPDATED_FAILED'));
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }

    public function requestPasswordReset(Request $request)
    {
        $roles = [
            'mobile' => 'required|numeric|digits:9|exists:users,mobile',
        ];
        $validator = Validator::make($request->all(), $roles);

        if (!$validator->fails()) {
            $user = User::where("mobile", $request->get('mobile'))->first();
            if (!$user->password_reset_code) {
                $user->password_reset_code = Hash::make(1234);
                $isSaved = $user->save();
                return ControllersService::generateProcessResponse(true, $isSaved ? 'FORGET_PASSWORD_SUCCESS' : 'FORGET_PASSWORD_FAILED');
            } else {
                return ControllersService::generateProcessResponse(false, 'PASS_RESET_CODE_SENT_BEFORE');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }

    public function resetPassword(Request $request)
    {
        $roles = [
            'mobile' => 'required|numeric|digits:9|exists:users,mobile',
            'code' => 'required|numeric|digits:4',
            'new_password' => 'required|min:3',
        ];
        $validator = Validator::make($request->all(), $roles);

        if (!$validator->fails()) {
            $user = User::where("mobile", $request->get('mobile'))->first();
            if (!is_null($user->password_reset_code)) {
                if (Hash::check($request->get('code'), $user->password_reset_code)) {
                    $user->password = Hash::make($request->get('new_password'));
                    $user->password_reset_code = null;
                    $isSaved = $user->save();

                    $this->revokePreviousTokens($user->id);

                    return ControllersService::generateProcessResponse(true, $isSaved ? 'RESET_PASSWORD_SUCCESS' : 'RESET_PASSWORD_FAILED');
                } else {
                    return ControllersService::generateProcessResponse(false, 'PASSWORD_RESET_CODE_ERROR');
                }
            } else {
                return ControllersService::generateProcessResponse(false, 'NO_PASSWORD_RESET_CODE');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }

    private function generateToken($user, $message)
    {
        $tokenResult = $user->createToken('News-User');
        $token = $tokenResult->accessToken;
        $user->setAttribute('token', $token);
        return response()->json([
            'status' => true,
            'message' => Messages::getMessage($message),
            'object' => $user,
        ]);
    }
}

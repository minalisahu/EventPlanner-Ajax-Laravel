<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class RegisterController extends BaseController
{
 /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone'=>'required|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        $input = $request->all();
        $input['access']= 2;
        $input['password']=Hash::make($input['password']);
        // $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $user->address()->create(['status' => 1]);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required',
            'remember_me' => 'boolean'

        ]);
        if ($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
      
       
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('MyApp')->accessToken;
                $response = ['token' => $token ,'name'=>$user->name];
            return $this->sendResponse($response, 'User login successfully.');
            } else {
                $response = ["message" => "Password mismatch"];
                return $this->sendError($response);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return $this->sendError($response);
        }
    }
  


    public function logout()
    { 
        if (Auth::check()) {
           Auth::user()->AauthAcessToken()->delete();
        }
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
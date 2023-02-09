<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tinkeshwar\Imager\Facades\Imager;
use App\Http\Resources\Profile as ProfileResource;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Events\PasswordChanged;

class ProfileController extends BaseController
{

    function __construct()
    {
        $this->middleware('auth:api');
    }

    //update profile

    public function update_profile(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
            'phone' => 'nullable|unique:users,phone,' . auth()->user()->id,
            'gender'=>'nullable',
            'image' => 'image|nullable',
            'address1'=>'nullable',
            'address2'=>'nullable',
            'state'=>'nullable',
            'country'=>'nullable',
            'city'=>'nullable',
            'zipcode'=>'nullable',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }           
        $user = User::find(auth()->user()->id);

        if ($user) {
            $user->firstname = $input['firstname'];
            $user->lastname = $input['lastname'];
            $user->email = $input['email'];
            $user->phone = $input['phone'];
            $user->gender = $input['gender'];
            $user->address()->update([
                'address1' =>$input['address1'],
                'address2' =>$input['address2'],
                'state' =>$input['state'],
                'country' =>$input['country'],
                'city' =>$input['city'],
                'zipcode' =>$input['zipcode'],
            ]); 
            $user->update();  
            if($request->hasFile('image')){
                $user->image()->create([
                    'name'=>Imager::moveFile($request->file('image'),'public'), //second parameter is optional, `public` is default
                    'path'=>'public/', //sample path used in above function
                    'driver' => config('image.image_storage')
                ]);
            }
            return $this->sendResponse($user, 'Profile Updated successfully.');
        }  
    }
    
    public function profileDetails(Request $request)
    {
        try
        {
            $user = User::with('address','image')->find(auth()->user()->id);
            return $this->sendResponse($user, 'Profile Details.');
    
        }catch(\Exception $e){
            return $this->apiSomethingWentWorng('Unexpected error occurred while trying to process your request.');
        }   
     
    }

    public function update_password(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'current_password' => 'required|password',
            'new_password' => 'required|string|min:6|same:confirm_password',
            'confirm_password' => 'required|string|min:6',
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }     
        if (auth()->user()->fill(['password' => Hash::make($data['new_password'])])->save()) {
            event(new PasswordChanged(auth()->user()));
            return $this->sendResponse($data, 'Password Updated successfully.');
        }
        return $this->apiSomethingWentWorng('Unexpected error occurred while trying to process your request.');
    }

}
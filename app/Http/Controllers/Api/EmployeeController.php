<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Validator;
use App\Models\Employee;
use App\Http\Resources\Employee as EmployeResource;

class EmployeeController extends BaseController
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return $this->sendResponse(EmployeResource::collection($employees), 'Employees retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required'

        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $product = Employee::create($input);
   
        return $this->sendResponse(new EmployeResource($product), 'Employe created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
  
        if (is_null($employee)) {
            return $this->sendError('Employee not found.');
        }
   
        return $this->sendResponse(new EmployeResource($employee), 'Employee retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (is_null($employee)) {
            return $this->sendError('Employee not found.');
        }
   
        $input = $request->all();

        $validator = Validator::make($input, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        if ($employee) {
            $employee->firstname = $input['firstname'];
            $employee->lastname = $input['lastname'];
            $employee->email = $input['email'];
            $employee->phone = $input['phone'];
            $employee->save();  
            return $this->sendResponse(new EmployeResource($employee), 'Employee updated successfully.');
        }
   
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return $this->sendResponse([], 'Employee deleted successfully.');
    }

}

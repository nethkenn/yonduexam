<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all the users
        return response(["users" => User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
        $this->checkIfUnique($request,0);
        // save the data to the database
        User::Create($this->finalizeRequest($request));
        // return message
        return response(["message" => "Successfully Added!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.


    * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // check if email and username is unique
        $this->checkIfUnique($request, $user->id);
        // update the data
        User::where('id',$user->id)->update($this->finalizeRequest($request, $user));
        // return message
        return response(["message" => "Successfully Updated!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // delete data
        $user->delete();
        // return message
        return response(["message" => "Successfully Deleted!"]);
    }

    public function multipleDelete(Request $request)
    {
        // delete all
        User::whereIn('id',$request->ids)->delete();
        //return message with count
        $message = count($request->ids). " ".(count($request->ids) == 1 ? "User" : "Users")." has been deleted";
        return response(["message" => $message]);
    }

    public static function checkIfUnique($request, $userId)
    {
        request()->validate([
            'email'    => ['required','email',Rule::unique('users')->ignore($userId)],
            'username' => ['required',Rule::unique('users')->ignore($userId)],
            'password' => 'required',
            'firstName'=> 'required',
            'lastName' => 'required',
        ]);
    }

    public static function finalizeRequest($request, $user = [])
    {
        //collect all the inputs except token and password then merge and convert it to array.
        return collect($request->all())
                ->except(['password','created_at','updated_at'])
                ->merge([
                    "email_verified_at" => now(),
                    "remember_token"    => Str::random(10),  //check if password changed, if changed hash it
                    "password"          => !empty($user) && $user->password == $request->password ? $user->password : bcrypt($request->password)])
                ->toArray();
    }
}




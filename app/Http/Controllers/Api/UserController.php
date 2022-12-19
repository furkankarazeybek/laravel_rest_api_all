<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offset = $request->has('offset') ? $request->query('offset'):0;
        $limit = $request->has('limit') ? $request->query('limit') : 10;

        $queryBuilder = User::query();

        //filteleme
        if ($request->has('q')) {
            $queryBuilder->where('name', 'like', '%' . $request->query('q') . '%');
        }

        //sıralama
        if ($request->has('q')) {
            $queryBuilder->orderBy($request->query('sortBy'), $request->query('sort', 'DESC')); //defaul sort DESC olarak belirlendi
        }

        $data = $queryBuilder->offset($offset)->limit($limit)->get();

        $data->each->setAppends(['full_name']);
        
        return response($data,200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {

        //request dosyasız bunlar ekli olmalı
       /*  $validator = Validator::make($request->all(), [
        'email' => 'required|email|unique:users',
        'name' => 'required|string|max:50',
        'password' => 'required'
        ]); 

        if($validator->fails()) {
            return $this->apiResponse(ResultType::Error, $validator->errors(), 'Validation error', 422);

        } */

        //request dosyası ile

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
   

        $user->save();

        return response([
            'data' => $user,
            'message' => 'user created.'

        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)  //user model
    {
        //belirtilen id ye göre veriyi get etme 
        
        
        $user = User::find($id);
        
        if($user)
        return response($user,200);
        else return response(['message'=> "User not found"],404);

        
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {

        $user = User::find($id);
        //kontrolsüz update
        /*
     
        $update_input = $request->all();
        $product->update($update_input);  
         */


        //kontrollü update
       
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        

        return response([
            'data' => $user,
            'message' => 'User updated.'

        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        return response([
            'message' => 'User deleted' 
        ],200);
    }

    public function custom1() {
        /*
        $user2 = User::find(2);
        UserResource::withoutWrapping();  //data anahtarını kaldırır
        return new UserResource($user2);   //bir kayıt dönerse new var
        */


        
        /* $users = User::all();
        return UserResource::collection($users); //toplu kayıt new yok */
        

     
        //EK KOLONLARI OLANLAR, withoutwrapping ile DATA ANAHTARI KALKMAZ İSTİSNA 
        
       $users = User::all();
        return UserResource::collection($users)->additional([
            'meta' => [
                'total_users' => $users->count(),
                'custom' => 'value'
            ]

        ]);
        


        
         //USERCOLLECTION DOSYASI KULLANILARAK
         /*
        $users = User::all();
        return new UserCollection($users); 
         */  

    }


 }

<?php

namespace App\Http\Controllers;

use App\Models\addpepole;
use Illuminate\Http\Request;

class AddpepoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return addpepole::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' =>  'email:rfc,dns'
        ]);

         addpepole::create($request->all());

        return response('',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\addpepole  $addpepole
     * @return \Illuminate\Http\Response
     */
    public function show(addpepole $addpepole)
    {
        return $addpepole;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\addpepole  $addpepole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, addpepole $addpepole)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

      $data =  addpepole::find($request->id);
      $data->name =$request->name;
      $data->email =$request->email;
      $data->save();
        return response('',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\addpepole  $addpepole
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = addpepole::find($id);
        $data->delete();

         return response('',204);

    }
    public function searchquery($name){
          return  addpepole::query()->where('name', 'LIKE', "%$name%")->latest()->paginate(10);

    }

}

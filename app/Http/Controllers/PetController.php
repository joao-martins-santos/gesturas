<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetRequest;
use App\Pet;


class PetController extends Controller
{
	public function index(){
        $pets = Pet::orderBy('created_at', 'desc')->paginate(10);
        return view('pets.index',['pets' => $pets]);
    }

    public function create(){
    	return view('pets.create');
    }
  
    public function store(PetRequest $request){
        $pet = new Pet;
        $pet->name        = $request->name;
        $pet->description = $request->description;
        $pet->quantity    = $request->quantity;
        $pet->price       = $request->price;
        $pet->save();
        return redirect()->route('pets.index')->with('message', 'Pet cadastrado com sucesso!');
    }
  
    public function show($id){
        
    }

	public function edit($id){
        $pet = Pet::findOrFail($id);
        return view('pets.edit',compact('pet'));
    }

	public function update(PetRequest $request, $id){
        $pet = Pet::findOrFail($id);
        $pet->name        = $request->name;
        $pet->description = $request->description;
        $pet->quantity    = $request->quantity;
        $pet->price       = $request->price;
        $pet->save();
        return redirect()->route('pets.index')->with('message', 'Pet alterado com sucesso!');
    }
  
    public function destroy($id)
    {
        $pet = Product::findOrFail($id);
        $pet->delete();
        return redirect()->route('pets.index')->with('alert-success','Pet removido!');
    }


}

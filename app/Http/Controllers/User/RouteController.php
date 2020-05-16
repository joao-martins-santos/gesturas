<?php

namespace App\Http\Controllers\Vet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\PetConsult;
use App\PetVetPrescription;
use App\PetVetPrescriptionDrugs;

class RouterController extends Controller
{
    
    public function index(){
        //$pets_assistance = PetVetAssistance::where('vet_id', 1)->first();
        //$pets = $pets_assistance->petsassistance;
        //dd($pets_assistance->petsassistance);
        //var_dump($pets_assistance->pet_id);

        $pets_consult      = PetConsult::with('pet')->where('vet_id', auth()->user()->id)->get();
        $pets_consult_json = array();
        foreach($pets_consult as $pet) {
            $pets_consult_json[] = array($pet->created_at->format('d/m/Y H:i:s'), $pet->pet->name, $pet->pet->breed->name, $pet->pet->user->name, "<a href='/vet/service/consult/print/$pet->id' target='_blank' class='btn btn-default'>Visualizar</a>" );
        }

        $pets_consult_json = json_encode($pets_consult_json);
        return view('vet.consult.index', compact('pets_consult_json'));
    }

    public function new(){
        //$pets_assistance = PetVetAssistance::where('vet_id', 1)->first();
        //$pets = $pets_assistance->petsassistance;
        //dd($pets_assistance->petsassistance);
        //var_dump($pets_assistance->pet_id);
        return view('vet.consult.new');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request){
        dd($request,$request->etdIdPet,'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required'
        ]);

        $userId = $request->user_id;
        $user   =   User::updateOrCreate(['id' => $userId],
                    ['name' => $request->name, 'email' => $request->email]);
    
        return Response::json($user);

        /// 
       $contact = new Contact([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'job_title' => $request->get('job_title'),
            'city' => $request->get('city'),
            'country' => $request->get('country')
        ]);
        $contact->save();
        return redirect('/contacts')->with('success', 'Contact saved!');
    }


    public function print($id){
        $pet_consult       = PetConsult::where('vet_id', auth()->user()->id)->where('id', $id)->first();
        $prescriptionDrugs = PetVetPrescriptionDrugs::where('pet_consults_id', $pet_consult->id)->get();

        return view('vet.consult.print', compact('prescriptionDrugs','pet_consult'));
    }

}

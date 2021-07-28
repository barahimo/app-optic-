<?php

namespace App\Http\Controllers;

use App\Client;
use App\Commande;
use App\Reglement;
use Illuminate\Http\Request;

class ReglementController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
   
       }
    public function index()
    {

        $reglements = Reglement::orderBy('id','desc')->paginate(3);
        
        // $clients = Commande::where('id', '=', $reglements->$commande_id);
        
        // dd($clients);     
        return view('managements.réglements.index', compact('reglements','nom_client'));
    }

    public function search(Request $request){
        $q = $request->input('q');

     $reglements =  Reglement::where('nom_client', 'like', "%$q%")
         ->orWhere('commande_id', 'like', "%$q%")
         ->paginate(5);

         return view('managements.réglements.search')->with('reglements');  
      
      }

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
        //
    }

   
    public function show(Reglement $reglement)
    {
        
        
        // $commande= Commande::with('client')->where('id',$reglement->commande_id )->first();
        $commande= Commande::with('client')->find($reglement->commande_id);

        // dd($commande->client);
        return view('managements.réglements.show', [
        
            'commande' => $commande,
            'reglement' => $reglement

        ]);
    
    }

    
    public function edit(Reglement $reglement)
    {
        return view('managements.réglements.edit')->with([
           "reglement" => $reglement,
           'clients' => Client::all()
        ]);
    }

    
    public function update(Request $request, Reglement $reglement)
    {
    
        $reglement->nom_client= $request->input('nom_client');
        $reglement->mode_reglement = $request->input('mode_reglement');
        $reglement->avance = $request->input('avance');
        $reglement->reste = $request->input('reste');
        $reglement->date = $request->input('date');
        $reglement->reglement = $request->input('reglement');
        $reglement->commande_id = $request->input('commande_id');
        

        $reglement->save();
        $request->session()->flash('status','le règlement a été bien modifié !');


        return redirect()->route('reglement.index');

    }

   
    public function destroy(Reglement $reglement)
    {
        
        $reglement->delete();

        // Post::destroy($id); supression directement

        return redirect()->route('reglement.index')->with([
            "success" => "le réglement a été supprimer avec succès!"
        ]); 
    }
}

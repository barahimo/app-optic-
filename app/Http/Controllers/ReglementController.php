<?php

namespace App\Http\Controllers;

use App\Client;
use App\Commande;
use App\Reglement;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        // return view('managements.réglements.index', compact('reglements','nom_client'));
        return view('managements.réglements.index', compact('reglements'));
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

    // *****************************************************
    public function index22(){
        $commandes = Commande::with('reglements')->get();
        $clients = Client::get();
        
        return view('managements.réglements.index22', [
            'commandes' => $commandes,
            'clients'=>$clients
        ]);
    }

    public function index2(){
        $reglements = Reglement::get();
        $clients = Client::get();
        
        return view('managements.réglements.index2', [
            'reglements' => $reglements,
            'clients'=>$clients
        ]);
    }

    public function getReglements(Request $request){
        $client = $request->client;
        $status = $request->status;
        if($client){
            $nom_client = Client::find($client)->nom_client;
            if($status){
                if($status == 'nr'){
                    $reglements = Reglement::with('commande')
                        ->whereHas('commande' , function($query){$query->where('reste', '>', 0);})
                        ->where('nom_client',$nom_client)->get();
                }
                else if($status == 'r'){
                    $reglements = Reglement::with('commande')
                        ->whereHas('commande' , function($query){$query->where('reste', '<=', 0);})
                        ->where('nom_client',$nom_client)->get();
                }
                else if($status == 'all'){
                    $reglements = Reglement::with('commande')->where('nom_client',$nom_client)->get();
                }
            }
            else 
                $reglements = [];
        }
        else{
            if($status){
                if($status == 'nr'){
                    $reglements = Reglement::with('commande')
                            ->whereHas('commande' , function($query){$query->where('reste', '>', 0);})
                        ->get();
                }
                else if($status == 'r'){
                    $reglements = Reglement::with('commande')
                        ->whereHas('commande' , function($query){$query->where('reste', '<=', 0);})
                        ->get();
                }
                else if($status == 'all'){
                    $reglements = Reglement::with('commande')->get();
                }
            }
            else 
                $reglements = [];
        }        
        return response()->json($reglements);
    }

    public function getReglements2(Request $request){
        $client = $request->client;
        $status = $request->status;
        if($client){
            $nom_client = Client::find($client)->nom_client;
            if($status){
                if($status == 'nr'){
                    $commandes = Commande::with('reglements')
                        ->where('reste', '>', 0)
                        ->where('nom_client',$nom_client)
                        ->get();
                }
                else if($status == 'r'){
                    $commandes = Commande::with('reglements')
                        ->where('reste', '<=', 0)
                        ->where('nom_client',$nom_client)
                        ->get();
                }
                else if($status == 'all'){
                    $commandes = Commande::with('reglements')
                    ->where('nom_client',$nom_client)
                    ->get();
                }
            }
            else 
                $commandes = [];
        }
        else{
            if($status){
                if($status == 'nr'){
                    $commandes = Commande::with('reglements')
                        ->where('reste', '>', 0)
                        ->get();
                }
                else if($status == 'r'){
                    $commandes = Commande::with('reglements')
                        ->where('reste', '<=', 0)
                        ->get();
                }
                else if($status == 'all'){
                    $commandes = Commande::with('reglements')->get();
                }
            }
            else 
                $commandes = [];
        }        
        return response()->json($commandes);
    }

    public function getReglements3(Request $request){
        $client = $request->client;
        if($client){
            $nom_client = Client::find($client)->nom_client;
            $commandes = Commande::with('reglements')
                        ->where('reste', '>', 0)
                        ->where('nom_client',$nom_client)
                        ->get();
        }
        else{
            $commandes = Commande::with('reglements')
                        ->where('reste', '>', 0)
                        ->get();
        }
        return response()->json($commandes);
    }
    //regler plusieurs commandes 
    public function create2(Request $request){
        $clients = Client::get();
        $client = $request->client;
        $date = Carbon::now();
        if($client){
            $nom_client = Client::find($client)->nom_client;
            $commandes = Commande::where('reste', '>', 0)->where('nom_client',$nom_client)->get();
        }
        else{
            $commandes = Commande::where('reste', '>', 0)->get();
        }
        return view('managements.réglements.create2',compact('clients','client','commandes','date'));
    }

    //Regler une seule commande
    public function create3(Request $request){
        $commande_id = $request->commande;
        $date = Carbon::now();
        $commande = Commande::find($commande_id);
        return view('managements.réglements.create3',compact('commande','date'));
    }

    public function store2(Request $request){ 
        $lignes = $request->input('lignes');
        if(!empty($lignes)){
            $date = $request->input('date');
            $client = $request->input('client');
            $mode = $request->input('mode');

            if(!empty($date) && !empty($client)){
                // ------------ Begin reglement -------- //
                foreach ($lignes as $ligne) {
                    $reglement = new Reglement();
                    $reglement->date = $date;
                    $reglement->nom_client = Client::find($client)->nom_client;
                    $reglement->mode_reglement = $mode;
                    $reglement->avance = $ligne['avance'];
                    $reglement->reste = $ligne['reste'];
                    $reglement->reglement = $ligne['status'];
                    $reglement->commande_id = $ligne['cmd_id'];
                    $reglement->save();
                    
                    $commande = Commande::find($ligne['cmd_id']);
                    $commande->avance = $commande->avance+$ligne['avance'];
                    $commande->reste = $ligne['reste'];
                    $commande->save();
                }
                // ------------ End Reglement -------- //
            } 
            else{
                return ['status'=>"error",'message'=>"Veuillez remplir les champs vides !"];
            }
        }
        else {
            return ['status'=>"error",'message'=>"Veuillez d'ajouter des reglements"];
        }
    
        return ['status'=>"success",'message'=>"Le reglement a été bien enregistrée !!"];
    }

    public function store3(Request $request){ 
        $lignes = $request->input('lignes');
        if(!empty($lignes)){
            $date = $request->input('date');
            $mode = $request->input('mode');
            if(!empty($date)){
                // ------------ Begin reglement -------- //
                foreach ($lignes as $ligne) {
                    $reglement = new Reglement();
                    $reglement->date = $date;
                    $reglement->mode_reglement = $mode;
                    $reglement->nom_client = $ligne['client'];
                    $reglement->avance = $ligne['avance'];
                    $reglement->reste = $ligne['reste'];
                    $reglement->reglement = $ligne['status'];
                    $reglement->commande_id = $ligne['cmd_id'];
                    $reglement->save();
                    
                    $commande = Commande::find($ligne['cmd_id']);
                    $commande->avance = $commande->avance+$ligne['avance'];
                    $commande->reste = $ligne['reste'];
                    $commande->save();
                }
                // ------------ End Reglement -------- //
            } 
            else{
                return ['status'=>"error",'message'=>"Veuillez remplir les champs vides !"];
            }
        }
        else {
            return ['status'=>"error",'message'=>"Veuillez d'effectuer le règlement"];
        }
    
        return ['status'=>"success",'message'=>"Le règlement a été bien enregistrée !!"];
    }

    public function avoir(Request $request){ 
        $data = $request->input('obj');

        $reg_id = $data['reg_id']; 
        $reg_avance = $data['reg_avance'];
        $reg_reste = $data['reg_reste'];
        $cmd_id = $data['cmd_id'];
        $cmd_avance = $data['cmd_avance'];
        $cmd_reste = $data['cmd_reste'];

        $reglement = Reglement::find($reg_id);
        $reglement->avance = $reg_avance + $reg_reste;
        $reglement->reste = $reg_reste - $reg_reste;
        $reglement->reglement = 'R';
        $reglement->save();
        $commande = Commande::find($cmd_id);
        $commande->avance = $cmd_avance + $reg_reste;
        $commande->reste = $cmd_reste - $reg_reste;;
        $commande->save();

        return ['status'=>"success",'message'=>"Opération effectuée avec succés !!!"];
    }

}

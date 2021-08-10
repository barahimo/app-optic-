<?php

namespace App\Http\Controllers;

use App\Facture;
use App\Commande;
use App\Lignecommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FactureController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
   
       }
    public function index()
    {
        // $factures = Facture::orderBy('id','desc')->paginate(3);
        $factures = Facture::with(['commande' => function ($query) {
            $query->with('client')->get();
        }])->paginate(3);

        // foreach ($factures as $facture) {
        //     dump($facture->commande->client->nom_client);
        // }
        return view('managements.factures.index', compact('factures'));
     }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
  public function edit(Facture $facture)
  
    {
        $commande = Commande::with('client')->where('id', "=", $facture->commande_id)->first();
        $lignecommandes =  Lignecommande::with('produit')->where('commande_id', '=', $commande->id)->get();

       
        
        $prix_HT = 0;
        foreach($lignecommandes as $q){
        //    dd($q);
           $prix_HT = $prix_HT +  ($q->produit->prix_produit_HT * $q->Qantite);
        }

    
         $TVA = 0;
        foreach($lignecommandes as $q){
           
           $TVA = $TVA +  ($q->produit->prix_produit_HT * $q->Qantite * $q->produit->TVA) ;
        }

       
        $priceTotal = 0;
        foreach($lignecommandes as $p){
            $priceTotal = floatval($priceTotal  + $p->totale_produit) ;
            $p->nom_produit = $p->produit->nom_produit;
        }

        return view('managements.factures.edit')->with([
           "facture" => $facture,
           'lignecommandes' =>  $lignecommandes,
             'priceTotal'  => $priceTotal,
             'prix_HT' => $prix_HT,
             'TVA' => $TVA,
             'commande' => $commande
          
        ]);
    }
    

   
    public function update(Request $request, Facture $facture)
    {
        $facture->totale_HT = $request->input('totale_HT');
        $facture->totale_TVA = $request->input('totale_TVA');
        $facture->totale_TTC = $request->input('totale_TTC');
        $facture->commande_id = $request->input('commande_id');
        // $facture->clients_id = $request->input('client_id');
        $facture->reglement = $request->input('reglement');
        
        // dd($facture);
        $facture->save();


        return redirect()->route('reglement.index')->with([
            "status" => "la facture a été bien modifier !! veuillez modifier le reglement de la commande N°" .$facture->commande_id
        ]); 
    }

    
    public function destroy(Facture $facture)
    {
            $facture->delete();
    
            return redirect()->route('facture.index'); 
        
    }

    public function search(Request $request){
        $q = $request->input('q');

     $factures =  Facture::where('clients_id', '=', $q)
         ->orWhere('commande_id', '=', $q)
         ->paginate(5);

         return view('managements.factures.search')->with('factures', $factures);  
      
      }

      public function show(Request $request, Facture $facture){

        $facture = $facture;
        // $lastOne = DB::table('commandes')->latest('id')->first();
        $commande = Commande::with('client')->where('id', "=", $facture->commande_id)->first();
    //    dd($commande);
        // $lignecommandes = lignecommande::orderBy('id');
        $lignecommandes =  Lignecommande::with('produit')->where('commande_id', '=', $commande->id)->get();
         
        //  dd($lignecommandes);

        
       


        $prix_HT = 0;
        foreach($lignecommandes as $q){
           
           $prix_HT = $prix_HT +  ($q->produit->prix_produit_HT * $q->Qantite);
        }

    
         $TVA = 0;
        foreach($lignecommandes as $q){
           
           $TVA = $TVA +  ($q->produit->prix_produit_HT * $q->Qantite * $q->produit->TVA) ;
        }

       
        $priceTotal = 0;
        foreach($lignecommandes as $p){
            $priceTotal = floatval($priceTotal  + $p->totale_produit) ;
           
        }



        return view('managements.factures.show', [

           
            'lignecommandes' =>  $lignecommandes,
             'priceTotal'  => $priceTotal,
             'prix_HT' => $prix_HT,
             'TVA' => $TVA,
             'commande' => $commande,
             'facture' => $facture
        ]);
    }

    public function show2(Request $request, Facture $facture){
        $facture = $facture;
        $commande = Commande::with('client')->where('id', "=", $facture->commande_id)->first();
        $lignecommandes =  Lignecommande::with('produit')->where('commande_id', '=', $commande->id)->get();
        $prix_HT = 0;
        foreach($lignecommandes as $q){
           $prix_HT = $prix_HT +  ($q->produit->prix_produit_HT * $q->Qantite);
        }
         $TVA = 0;
        foreach($lignecommandes as $q){
           $TVA = $TVA +  ($q->produit->prix_produit_HT * $q->Qantite * $q->produit->TVA) ;
        }
        $priceTotal = 0;
        foreach($lignecommandes as $p){
            $priceTotal = floatval($priceTotal  + $p->totale_produit) ;
        }
        return view('managements.factures.show2', [
            'lignecommandes' =>  $lignecommandes,
             'priceTotal'  => $priceTotal,
             'prix_HT' => $prix_HT,
             'TVA' => $TVA,
             'commande' => $commande,
             'facture' => $facture
        ]);
    }

}

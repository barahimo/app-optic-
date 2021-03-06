<?php

namespace App\Http\Controllers;

use App\Facture;
use App\Commande;
use App\Company;
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
            "status" => "la facture a ??t?? bien modifier !! veuillez modifier le reglement de la commande N??" .$facture->commande_id
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
        $companies = Company::get();
        $count = count($companies);
        ($count>0)  ? $company = Company::first(): $company = null;
        $adresse = $this->getAdresse($company);
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
        // return view('managements.factures.show2', [
        return view('managements.factures.view1', [
            'lignecommandes' =>  $lignecommandes,
             'priceTotal'  => $priceTotal,
             'prix_HT' => $prix_HT,
             'TVA' => $TVA,
             'commande' => $commande,
             'facture' => $facture,
             'company' => $company,
             'count' => $count,
             'adresse' => $adresse
        ]);
    }

    public function getAdresse($company){
        // ############################################################### //
        // Si??ge social : ITIC SOLUTION - 3 ,immeuble Karoum, Av Alkhansaa, Cit?? Azmani , 83350 , OULED TEIMA , MAROC<br>
        $adresse1 = '';
        // ############################################################### //
        ($company && ($company->nom || $company->nom != null)) ? $adresse1 .= 'Si??ge social : '.$company->nom.' - ' : $adresse1 .= 'Si??ge social : nom_societ??';
        // -------------------------------------//
        ($company && ($company->adresse || $company->adresse != null)) ? $adresse1 .= $company->adresse.' , ' : $adresse1 .= '';
        // -------------------------------------//
        ($company && ($company->code_postal || $company->code_postal != null)) ? $adresse1 .= $company->code_postal.' , ' : $adresse1 .= '';
        // -------------------------------------//
        ($company && ($company->ville || $company->ville != null)) ?  $adresse1 .= $company->ville.' , ' : $adresse1 .= '';
        // -------------------------------------//
        ($company && ($company->pays || $company->pays != null)) ? $adresse1 .= $company->pays : $adresse1 .= '';
        // ############################################################### //
        // Capital : 100000 - ICE : 123456789012345  - I.F. : 12345678 - <br>
        $adresse2 = '';
        // ############################################################### //
        ($company && ($company->capital || $company->capital != null)) ? $adresse2 .= 'Capital : '.$company->capital.' - ' : $adresse2 .= '';
        // -------------------------------------//
        ($company && ($company->ice || $company->ice != null)) ? $adresse2 .= 'ICE : '.$company->ice.' - ' : $adresse2 .= '';
        // -------------------------------------//
        ($company && ($company->iff || $company->iff != null)) ? $adresse2 .= 'I.F. : '.$company->iff.' - ' : $adresse2 .= '';
        // ############################################################### //
        // R.C. : 1234 -Patente : 12345678 - CNSS : 87654321 <br>
        $adresse3 = '';
        // ############################################################### //
        ($company && ($company->rc || $company->rc != null)) ? $adresse3 .= 'R.C. : '.$company->rc.' - ' : $adresse3 .= '';
        // -------------------------------------//
        ($company && ($company->patente || $company->patente != null)) ? $adresse3 .= 'Patente : '.$company->patente.' - ' : $adresse3 .= '';
        // -------------------------------------//
        ($company && ($company->cnss || $company->cnss != null)) ? $adresse3 .= 'CNSS : '.$company->cnss.' - ' : $adresse3 .= '';
        // ############################################################### //
        // T??l : 0857854354 - site : https://itic-solution.com/ - email : Contact@itic-solution.com<br>
        $adresse4 = '';
        // ############################################################### //
        ($company && ($company->tel || $company->tel != null)) ? $adresse4 .= 'T??l : '.$company->tel.' - ' : $adresse4 .= '';
        // -------------------------------------//
        ($company && ($company->site || $company->site != null)) ? $adresse4 .= 'Site : '.$company->site.' - ' : $adresse4 .= '';
        // -------------------------------------//
        ($company && ($company->email || $company->email != null)) ? $adresse4 .= 'Email : '.$company->email.' - ' : $adresse4 .= '';
        // ############################################################### //
        // BANQUE : BMCE - RIB : 12345678912345<br>
        $adresse5 = '';
        // ############################################################### //
        ($company && ($company->banque || $company->banque != null)) ? $adresse5 .= 'BANQUE : '.$company->banque.' - ' : $adresse5 .= '';
        // -------------------------------------//
        ($company && ($company->rib || $company->rib != null)) ? $adresse5 .= 'RIB : '.$company->rib.' - ' : $adresse5 .= '';
        // ############################################################### //
        $adresse = '';
        if($adresse1 != '')
            $adresse .= $adresse1.'<br>';
        if($adresse2 != '')
            $adresse .= $adresse2.'<br>';
        if($adresse3 != '')
            $adresse .= $adresse3.'<br>';
        if($adresse4 != '')
            $adresse .= $adresse4.'<br>';
        if($adresse5 != '')
            $adresse .= $adresse5.'<br>';
        return $adresse;
    }

// ----------------------------------------------
}

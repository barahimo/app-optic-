<?php

namespace App\Http\Controllers;

use App\Client;
use App\Facture;
use App\Produit;
use App\Commande;
use App\Categorie;
use App\Reglement;
use App\Lignecommande;
use Faker\Core\Number;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommandeController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
   
       }
    var $commande;
  

	public function findProductName(Request $request){

	
        $data=Produit::select('nom_produit','id')->where('categorie_id',$request->id)->take(100)->get();
        return response()->json($data);//then sent this data to ajax success
	}


	// public function findPrice(Request $request){
	
	// 	//it will get price if its id match with product id
	// 	$p=Produit::select('prix_produit_HT')->where('id',$request->id)->first();
		
    // 	return response()->json($p);
	// }

    public function findPrice(Request $request){

        $produit=Produit::where('id',$request->id)->first();

        return response()->json($produit);
    }
   
   
    public function index(Request $request)
    {
        $lastOne = DB::table('commandes')->latest('id')->first();
        
        $date = Carbon::now();
        // dd($date);
      
        $prod=Categorie::all();//get data from table
		
        $p = $request->input('categorie_id');
        
        
        
        
        $lignecommandes =  Lignecommande::with('produit')->where('commande_id', '=', $lastOne->id)->paginate(100);
        

        $priceTotal = 0;
        foreach($lignecommandes as $p){
              
            $p->nom_produit = $p->produit->nom_produit;
            $priceTotal = $priceTotal + $p->totale_produit ;
            }
        //    dd($priceTotal);
    
        
        return view('managements.commandes.index', [

            'prod' => $prod,
            'clients' =>client::all(),
            'produits' => Produit::all(),
            'commandes' => Commande::all(),
            'categories' => Categorie::all(),
            'lastOne' =>  $lastOne, 
            'lignecommandes' =>  $lignecommandes,
             'priceTotal'  => $priceTotal,
             'date' => $date,
            //  'reglement' => $reglement 
        ]);
    
    }
    public function affiche(){  //index commande

        $commandes = Commande::orderBy('id', 'desc')->paginate(3);
         return view('managements.commandes.affiche', compact('commandes'));
    }
    
   
    // public function create()
    // {
    //     return view('managements.commandes.create',[
    //         'clients' => Client::all()
    //     ]);
    // }

    
    public function store(Request $request)

      {  

        $commande = new Commande();
        $commande->cadre = $request->input('cadre');
        $commande->date = $request->input('date');
        $commande->oeil_gauche = $request->input('oeil_gauche');
        $commande->oeil_droite = $request->input('oeil_droite');
        $commande->mesure_vue = $request->input('mesure_vue');
        $commande->mesure_visage = $request->input('mesure_visage');
        $commande->nom_client = $request->input('nom_client');

        $commande->client_id = $request->input('nom_client');

       
        $commande->totale = Str::slug($commande->mesure_visage, '-');

        
    
        $clientligne = Client::where('id','=', $commande->client_id)->get();
        foreach($clientligne as $var)
        {   
   
            $name = $var->nom_client;
        } 
   
        $commande->nom_client = $name;
      
        

       $commande->save();

       $lastOne = DB::table('commandes')->latest('id')->first();
       
        $request->session()->flash('status','la commande a été bien enregistré !');
         return redirect()->route('commande.index');

        }
        
      

         public function storeL(Request $request)
    {
        //     $commande =Commande::where('id','=', $request->input('commande_id'))->first();
            
        //     $lignecommandes = Lignecommande::where('commande_id', '=', $commande->id)->get();
        //      dd($lignecommandes->count());
        
        $lignecommande = new Lignecommande();
        $lignecommande->commande_id = $request->input('commande_id');
        $lignecommande->produit_id = $request->input('prod_id');
        $lignecommande->Qantite = $request->input('quantite');
        
        $lignecommande->nom_produit = $request->input('nom_produit');
        $lignecommande->totale_produit = $request->input('amount');
        
        
        $lignecommande->save();
        
        $commande =Commande::where('id','=', $request->input('commande_id'))->first();
        $lignecommandes = Lignecommande::where('commande_id', '=', $commande->id)->get();
        // dd($lignecommandes->count());

            if($lignecommandes->count() == 1){
                
            $request->session()->flash('status','la ligne de commande a été bien enregistré ! veuillez valider  la facture de la commande N°' .$lignecommande->commande_id) ;
              return redirect()->route('commande.index');
            }
            
            else{
                
                $request->session()->flash('status','la ligne de commande a été bien enregistré ! veuillez modifier  la facture de la commande N°' .$lignecommande->commande_id) ;
                return redirect()->route('facture.index');
   
        }
       
         }

        //  public function storeLP(Request $request)

        //  {  
   
        //     $lignecommande = new Lignecommande();
        //     $lignecommande->commande_id = $request->input('commande_id');
        //     $lignecommande->produit_id = $request->input('produit_id');
        //     $lignecommande->nom_produit = $request->input('nom_produit');
        //     $lignecommande->Qantite = $request->input('qt');
        //     $lignecommande->totale_produit = $request->input('ttc');
        
    
          
           
        
        //     $lignecommande->save();

            
   
          
        //  }
         public function storeLR(Request $request)

         { $reglement= new Reglement();
            // $reglement->commande_id = $request->commande_id;
            $reglement->commande_id = $request->input('commande_id');
            $reglement->nom_client = $request->input('nom_client');
            $reglement->mode_reglement = $request->input('mode_reglement');
            $reglement->avance = $request->input('avc');
            $reglement->reste = $request->input('rst');
            $reglement->date = $request->input('date');
            $reglement->reglement = $request->input('reglement');
    // dd($reglement->commande_id);
            $reglement->save();
            $request->session()->flash('status','le réglement a été bien enregistré !');
            return redirect()->route('reglement.index');
   
          
         }




    
    public function show(Commande $commande)
    {
        

        $clients =  Client::where('nom_client', 'like', $commande->nom_client)
        ->paginate(5);
        $lignecommandes =  Lignecommande::with('produit')->where('commande_id', '=', $commande->id)
         ->paginate(100);
         foreach ($lignecommandes as $p) {
            $p->nom_produit = $p->produit->nom_produit;
         }

         return view('managements.commandes.detaille')->with([
             'lignecommandes' => $lignecommandes,
             'clients' => $clients,
             'commande' => $commande,

             ]) ;
        }

    
    public function edit(Commande $commande)
    {
        return view('managements.commandes.edit')->with([
           "commande" => $commande,
           'clients' => Client::all()
        ]);
    }

    
    public function update(Request $request, Commande $commande)
    {
    
        $commande->cadre = $request->input('cadre');
        $commande->date = $request->input('date');
        $commande->oeil_gauche = $request->input('oeil_gauche');
        $commande->oeil_droite = $request->input('oeil_droite');
        $commande->avance = $request->input('mesure_vue');
        $commande->reste = $request->input('mesure_visage');
        $commande->nom_client = $request->input('nom_client');
        // $commande->client_id = $request->input('n');

       
        $commande->totale = Str::slug($commande->avance, '-');

        
    
        $clientligne = Client::where('nom_client','=', $commande->nom_client)->get();
        foreach($clientligne as $var)
        {   
   
            $id = $var->id;
        } 
   
        $commande->nom_client = $id;
      
        

        $commande->save();
        $request->session()->flash('status','le commande a été bien modifié !');


        return redirect()->route('commande.affiche');

    }

    public function editL(Lignecommande $lignecommande)
    {
        $Produitligne = Produit::where('id','=', $lignecommande->produit_id)->get();
        foreach($Produitligne as $var)
        {   
   
            $name = $var->nom_produit;
            $tva =  $var->TVA;
            $pu = $var->prix_produit_HT;
        } 
    
        return view('managements.commandes.editL', [

            "lignecommande" => $lignecommande,
            "tva" => $tva,
            "pu" => $pu,
            "nom" => $name
        ]);
    }



    public function updateL(Request $request, Lignecommande $lignecommande)
    {
        $lignecommande->commande_id = $request->input('commande_id');
        $lignecommande->produit_id = $request->input('produit_id');
        $lignecommande->Qantite = $request->input('quantite');
    
       $lignecommande->nom_produit = $request->input('nom_produit');
       $lignecommande->totale_produit = $request->input('amount');
 
    
        $lignecommande->save();

        // $facture =Facture::where('commande_id', '=', $lignecommande->commande_id)->get();

    //    dd($facture);
     
    $request->session()->flash('status','la ligne de commande a été bien modifié ! veuillez modifier la facture de la commande N°'.$lignecommande->commande_id);
        return redirect()->route('facture.index');
       

    }
    // {-------START---------}
    public function savecmd(){
        $this->commande->save();

        $lastOne = DB::table('commandes')->latest('id')->first();
    }
    // {---------END-------}

    public function search(Request $request){
        $q = $request->input('q');

     $commandes =  Commande::where('nom_client', 'like', "%$q%")
         ->orWhere('id', 'like', "%$q%")
         ->paginate(5);

         return view('managements.commandes.search')->with('commandes', $commandes);  
      
      }

    
    public function destroy(Commande $commande)
    {
        $facture = Facture::where('commande_id','=',$commande->id)->first();
        $reglement = Reglement::where('commande_id','=',$commande->id)->first();
        $lignecommandes = LigneCommande::where('commande_id','=',$commande->id)->get();
        if($lignecommandes->count() != 0){
            foreach ($lignecommandes as $lignecommande) {
                $lignecommande->delete();
            }
        }
        if($facture)
            $facture->delete();
        if($reglement)
            $reglement->delete();
        $commande->delete();
        return redirect()->route('commande.affiche')->with([
            "status" => "la commande, facture et règlement ont été supprimer avec succès!"
        ]); 
    }


    public function reglement()
    {
        return view('managements.commandes.reglement');
    }

    public function facture(){

        $lastOne = DB::table('commandes')->latest('id')->first();
        $commande = Commande::with('client')->find($lastOne->id);
    //    dd($commande->id);
        // $lignecommandes = lignecommande::orderBy('id');
        $lignecommandes =  Lignecommande::with('produit')->where('commande_id', '=', $lastOne->id)
         ->paginate(100);

        // foreach($lignecommandes as $ligne){
        // //   $produit = Produit::where('id', '=' , $ligne->produit_id)->first();
        //     dump($ligne->produit->prix_produit_HT);
        // }
       


        $prix_HT = 0;
        foreach($lignecommandes as $q){
           
           $prix_HT = $prix_HT +  ($q->produit->prix_produit_HT * $q->Qantite);
           $q->nom_produit = $q->produit->nom_produit;  
        }

    
         $TVA = 0;
        foreach($lignecommandes as $q){
           
           $TVA = $TVA +  ($q->produit->prix_produit_HT * $q->Qantite * $q->produit->TVA) ;
        }

       
        $priceTotal = 0;
        foreach($lignecommandes as $p){
            $priceTotal =  floatval($priceTotal  + $p->totale_produit) ;
           
        }



        return view('managements.commandes.facture', [

            'lastOne' =>  $lastOne, 
            'lignecommandes' =>  $lignecommandes,
             'priceTotal'  => $priceTotal,
             'prix_HT' => $prix_HT,
             'TVA' => $TVA,
             'commande' => $commande
        ]);
    }

    public function storefacture( Request $request)
    {

        // $validateData = $request->validate([
     
        //     'totale_HT' => 'required',
        //     'totale_TVA ' => 'required',
        //     'totale_TTC' => 'required' ,
        //     'commande_id ' => 'required|unique:factures,commande_id',
        //     'clients_id' => 'required|min:4|max:100' 
                   
        // ]);


        $facture = new Facture();
            $factures = Facture::where('commande_id','=',$request->input('commande_id'))->get();
            if($factures->count()>0)
                $msg= "La commande é été déja facturée! ";
            else{
                // dd('ok');
                $facture->totale_HT = $request->input('totale_HT');
                $facture->totale_TVA = $request->input('totale_TVA');
                $facture->totale_TTC = $request->input('totale_TTC');
                $facture->commande_id = $request->input('commande_id');
                // $facture->clients_id = $request->input('client_id');
                $facture->reglement = $request->input('reglement');
                
                $facture->save();
                $msg= "la facture a été bien enregistré vous devez ajouter le règlement de la commande N° .$facture->command_id ";
            }
            
            return redirect()->route('commande.index')->with([
                "status" => $msg
            ]); 

            
    }
    
    public function updateF(Request $request, Facture $facture)
    {
        $facture->totale_HT = $request->input('totale_HT');
        $facture->totale_TVA = $request->input('totale_TVA');
        $facture->totale_TTC = $request->input('totale_TTC');
        $facture->commande_id = $request->input('commande_id');
        $facture->clients_id = $request->input('client_id');
        $facture->reglement = $request->input('reglement');
        
        dd($facture);
        $facture->save();

        return redirect()->route('facture.index')->with([
            "status" => "la facture a été bien enregistré !!"
        ]); 
    }
    
}

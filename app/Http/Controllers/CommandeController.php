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

    // ########################################################################
    public function edit2($id){
        $commande = Commande::with('reglements')->find($id);
        // return $commande;
        $date = Carbon::now();
        $clients = Client::get();
        $categories=Categorie::all();
        return view('managements.commandes.edit2', [
            'commande' =>$commande,
            'clients' =>$clients,
            'date' =>$date,
            'categories' =>$categories,
        ]);
    }

    public function editCommande(Request $request){
        $lignecommandes = Lignecommande::where('commande_id',$request->id)->get();
        $reglement = reglement::where('commande_id',$request->id)->first();

        return [
            'lignecommandes'=>$lignecommandes,
            'reglement'=>$reglement,
        ];
    }

    public function index22(Request $request){
        $commandes = Commande::get();
        $lignecommandes = Lignecommande::get();
        $reglements = reglement::get();
        $clients = Client::get();
        return view('managements.commandes.index22', [
            'commandes'=>$commandes,
            'lignecommandes'=>$lignecommandes,
            'reglements'=>$reglements,
            'clients' =>$clients,
        ]);
    }

    public function index222(Request $request){
        $commandes = Commande::get();
        $lignecommandes = Lignecommande::get();
        $reglements = reglement::get();
        $clients = Client::get();
        return view('managements.commandes.index222', [
            'commandes'=>$commandes,
            'lignecommandes'=>$lignecommandes,
            'reglements'=>$reglements,
            'clients' =>$clients,
        ]);
    }

    public function index5(Request $request){
        // $commandes = Commande::with('reglements')->where('facture','nf')->where('reste','>',0)->where('client_id',3)->get();
        // return $commandes;
        $commandes = Commande::with('reglements')->get();
        $lignecommandes = Lignecommande::get();
        $reglements = reglement::get();
        $clients = Client::get();
        return view('managements.commandes.index5', [
            'commandes'=>$commandes,
            'lignecommandes'=>$lignecommandes,
            'reglements'=>$reglements,
            'clients' =>$clients,
        ]);
    }

    //get commandes pour la page commande
    public function getCommandes(Request $request){
        $search = $request->search;
        $client = $request->client;
        if($search){
            if($search == "f" || $search == "nf")
                $commandes = Commande::where('facture',$request->search)->get();
            else if($search == "r")
                $commandes = Commande::where('reste','<=',0)->get();
            else if($search == "nr")
                $commandes = Commande::where('reste','>',0)->get();
        }
        else if($client)
            $commandes = Commande::where('client_id',$request->client)->get();
        else
            $commandes = Commande::get();
        $lignecommandes = Lignecommande::get();
        $reglements = reglement::get();
        $clients = Client::get();
        return response()->json([
            'commandes'=>$commandes,
            'lignecommandes'=>$lignecommandes,
            'reglements'=>$reglements,
            'clients' =>$clients,
        ]);
    }

    //get commandes v2 pour la page commande
    public function getCommandes2(Request $request){
        // ------------------------------------
        $facture = $request->facture;//f - nf - all - null
        $status = $request->status;//r - nr - all - null
        $client = $request->client;
        // ------------------------------------
        $r = Commande::where('reste','<=',0);
        $nr = Commande::where('reste','>',0);
        $f = Commande::where('facture','f');
        $nf = Commande::where('facture','nf');
        $fr = Commande::where('facture','f')->where('reste','<=',0);
        $fnr = Commande::where('facture','f')->where('reste','>',0);
        $nfr = Commande::where('facture','nf')->where('reste','<=',0);
        $nfnr = Commande::where('facture','nf')->where('reste','>',0);
        if($client){
            if(!$facture && !$status)  //echo '[]';
                $commandes = [];
            else if((!$facture && $status=='r') || ($facture=='all' && $status=='r'))  //echo 'r';
                $commandes = $r->where('client_id',$client)->get();
            else if((!$facture && $status=='nr') || ($facture=='all' && $status=='nr'))  //echo 'nr';
                $commandes = $nr->where('client_id',$client)->get();
            else if((!$facture && $status=='all') || ($facture=='all' && !$status) || ($facture=='all' && $status=='all')) //echo 'all';
                $commandes = Commande::where('client_id',$client)->get();
            else if(($facture=='f' && !$status) || ($facture=='f' && $status=='all')) //echo 'f';
                $commandes = $f->where('client_id',$client)->get();
            else if($facture=='f' && $status=='r') //echo 'fr';
                $commandes = $fr->where('client_id',$client)->get();
            else if($facture=='f' && $status=='nr') //echo 'fnr';
                $commandes = $fnr->where('client_id',$client)->get();
            else if(($facture=='nf' && !$status) || ($facture=='nf' && $status=='all')) //echo 'nf';
                $commandes = $nf->where('client_id',$client)->get();
            else if($facture==' nf' && $status=='r') //echo 'nfr';
                $commandes = $nfr->where('client_id',$client)->get();
            else if($facture=='nf' && $status=='nr') //echo 'nfnr';
                $commandes = $nfnr->where('client_id',$client)->get();
            else //echo '[]';
                $commandes = [];
        }
        else{
            if(!$facture && !$status)  //echo '[]';
                $commandes = [];
            else if((!$facture && $status=='r') || ($facture=='all' && $status=='r'))  //echo 'r';
                $commandes = $r->get();
            else if((!$facture && $status=='nr') || ($facture=='all' && $status=='nr'))  //echo 'nr';
                $commandes = $nr->get();
            else if((!$facture && $status=='all') || ($facture=='all' && !$status) || ($facture=='all' && $status=='all')) //echo 'all';
                $commandes = Commande::get();
            else if(($facture=='f' && !$status) || ($facture=='f' && $status=='all')) //echo 'f';
                $commandes = $f->get();
            else if($facture=='f' && $status=='r') //echo 'fr';
                $commandes = $fr->get();
            else if($facture=='f' && $status=='nr') //echo 'fnr';
                $commandes = $fnr->get();
            else if(($facture=='nf' && !$status) || ($facture=='nf' && $status=='all')) //echo 'nf';
                $commandes = $nf->get();
            else if($facture==' nf' && $status=='r') //echo 'nfr';
                $commandes = $nfr->get();
            else if($facture=='nf' && $status=='nr') //echo 'nfnr';
                $commandes = $nfnr->get();
            else //echo '[]';
                $commandes = [];
        }
        // ------------------------------------
        return response()->json($commandes);
    }

    //get commandes v2 pour la page commande
    public function getCommandes5(Request $request){
        // ------------------------------------
        $facture = $request->facture;//f - nf - all - null
        $status = $request->status;//r - nr - all - null
        $client = $request->client;
        // ------------------------------------
        // ------------------------------------
        $r = Commande::with('reglements')->where('reste','<=',0);
        $nr = Commande::with('reglements')->where('reste','>',0);
        $f = Commande::with('reglements')->where('facture','f');
        $nf = Commande::with('reglements')->where('facture','nf');
        $fr = Commande::with('reglements')->where('facture','f')->where('reste','<=',0);
        $fnr = Commande::with('reglements')->where('facture','f')->where('reste','>',0);
        $nfr = Commande::with('reglements')->where('facture','nf')->where('reste','<=',0);
        $nfnr = Commande::with('reglements')->where('facture','nf')->where('reste','>',0);
        if($client){
            if(!$facture && !$status)  //echo '[]';
                $commandes = [];
            else if((!$facture && $status=='r') || ($facture=='all' && $status=='r'))  //echo 'r';
                $commandes = $r->where('client_id',$client)->get();
            else if((!$facture && $status=='nr') || ($facture=='all' && $status=='nr'))  //echo 'nr';
                $commandes = $nr->where('client_id',$client)->get();
            else if((!$facture && $status=='all') || ($facture=='all' && !$status) || ($facture=='all' && $status=='all')) //echo 'all';
                $commandes = Commande::with('reglements')->where('client_id',$client)->get();
            else if(($facture=='f' && !$status) || ($facture=='f' && $status=='all')) //echo 'f';
                $commandes = $f->where('client_id',$client)->get();
            else if($facture=='f' && $status=='r') //echo 'fr';
                $commandes = $fr->where('client_id',$client)->get();
            else if($facture=='f' && $status=='nr') //echo 'fnr';
                $commandes = $fnr->where('client_id',$client)->get();
            else if(($facture=='nf' && !$status) || ($facture=='nf' && $status=='all')) //echo 'nf';
                $commandes = $nf->where('client_id',$client)->get();
            else if($facture==' nf' && $status=='r') //echo 'nfr';
                $commandes = $nfr->where('client_id',$client)->get();
            else if($facture=='nf' && $status=='nr') //echo 'nfnr';
                $commandes = $nfnr->where('client_id',$client)->get();
            else //echo '[]';
                $commandes = [];
        }
        else{
            if(!$facture && !$status)  //echo '[]';
                $commandes = [];
            else if((!$facture && $status=='r') || ($facture=='all' && $status=='r'))  //echo 'r';
                $commandes = $r->get();
            else if((!$facture && $status=='nr') || ($facture=='all' && $status=='nr'))  //echo 'nr';
                $commandes = $nr->get();
            else if((!$facture && $status=='all') || ($facture=='all' && !$status) || ($facture=='all' && $status=='all')) //echo 'all';
                $commandes = Commande::with('reglements')->get();
            else if(($facture=='f' && !$status) || ($facture=='f' && $status=='all')) //echo 'f';
                $commandes = $f->get();
            else if($facture=='f' && $status=='r') //echo 'fr';
                $commandes = $fr->get();
            else if($facture=='f' && $status=='nr') //echo 'fnr';
                $commandes = $fnr->get();
            else if(($facture=='nf' && !$status) || ($facture=='nf' && $status=='all')) //echo 'nf';
                $commandes = $nf->get();
            else if($facture==' nf' && $status=='r') //echo 'nfr';
                $commandes = $nfr->get();
            else if($facture=='nf' && $status=='nr') //echo 'nfnr';
                $commandes = $nfnr->get();
            else //echo '[]';
                $commandes = [];
        }
        // ------------------------------------
        return response()->json($commandes);
    }

    public function index2(Request $request){
        $date = Carbon::now();
        $categories=Categorie::all();//get data from table
        $clients = Client::all();
        return view('managements.commandes.index2', [
            'clients' =>$clients,
            'categories' => $categories,
            'date' => $date,
        ]);
    }

    public function productsCategory(Request $request){
        $data=Produit::select('id','nom_produit','prix_produit_TTC')->where('categorie_id',$request->id)->get();
        return response()->json($data);
	}

    public function infosProducts(Request $request){
        $data=Produit::find($request->id);
        return response()->json($data);
	}

    public function store2(Request $request){ 
        $lignes = $request->input('lignes');
        if(!empty($lignes)){
            $date = $request->input('date');
            $client = $request->input('client');
            $gauche = $request->input('gauche');
            $droite = $request->input('droite');
            $total = $request->input('total');
            $avance = $request->input('avance');
            $reste = $request->input('reste');
            $status = $request->input('status');
            // -----------------------------------------------------
            $time = strtotime($date);
            $year = date('y',$time);
            $month = date('m',$time);
            // -----------------------------------------------------
            $commandes = Commande::get();
            (count($commandes)>0) ? $lastcode = $commandes->last()->code : $lastcode = null;
            $str = 1;
            if(isset($lastcode)){
                // ----- 2108-0001 ----- //
                $list = explode("-",$lastcode);
                $y = substr($list[0],0,2);
                $n = $list[1];
                ($y == $year) ? $str = $n+1 : $str = 1;
            } 
            $pad = str_pad($str,4,"0",STR_PAD_LEFT);
            $code = $year.''.$month.'-'.$pad;
            // -----------------------------------------------------
            if(!empty($date) && !empty($client) && !empty($gauche) && !empty($droite)){
                // ------------ Begin Commande -------- //
                $commande = new Commande();
                $commande->date = $date;
                $commande->client_id = $client;
                $commande->nom_client = Client::find($client)->nom_client;
                $commande->oeil_gauche = $gauche;
                $commande->oeil_droite = $droite;
                $commande->facture = "nf"; 
                $commande->avance = $avance;
                $commande->reste = $reste;
                $commande->totale = $total;
                $commande->code = $code;
                $commande->save();
                // ------------ End Commande -------- //
                if($commande->id){
                    // ------------ Begin LigneCommande -------- //
                    foreach ($lignes as $ligne) {
                        $lignecommande = new Lignecommande();
                        $lignecommande->commande_id = $commande->id;
                        $lignecommande->produit_id = $ligne['prod_id'];
                        $lignecommande->nom_produit = $ligne['libelle'];
                        $lignecommande->Qantite = $ligne['qte'];
                        $lignecommande->totale_produit = $ligne['total'];
                        $lignecommande->save();
                    }
                    // ------------ End LigneCommande -------- //
                    // ------------ Begin Reglement -------- //
                    if($request->input('avance')>0){
                        $reglement= new Reglement();
                        $reglement->commande_id = $commande->id;
                        $reglement->date = $date;
                        $reglement->nom_client = Client::find($client)->nom_client ;
                        $reglement->mode_reglement = $request->input('mode');
                        $reglement->avance = $request->input('avance');
                        $reglement->reste = $request->input('reste');
                        $reglement->reglement = $request->input('status');
                        $reglement->save();
                    }
                    // ------------ End Reglement -------- //
                }
                else{
                    return ['status'=>"error",'message'=>"Problème d'enregistrement de la commande !"];
                }
            } 
            else{
                return ['status'=>"error",'message'=>"Veuillez remplir les champs vides !"];
            }
        }
        else {
            return ['status'=>"error",'message'=>"Veuillez d'ajouter des lignes des commandes"];
        }
    
        return ['status'=>"success",'message'=>"La commande a été bien enregistrée !!"];
    }

    public function update2(Request $request){ 
        $lignes = $request->input('lignes');
        if(!empty($lignes)){
            $id = $request->input('id');
            $date = $request->input('date');
            $client = $request->input('client');
            $gauche = $request->input('gauche');
            $droite = $request->input('droite');

            // $total = $request->input('total');
            // $avance = $request->input('avance');
            // $reste = $request->input('reste');
            // $status = $request->input('status');

            $reglements = $request->input('reglements');
            $cmd_avance = $request->input('cmd_avance');
            $cmd_total = $request->input('cmd_total');
            $cmd_reste = $request->input('cmd_reste');

            // return ['status'=>"error",'message'=>$reglements[0]['reg_id']];

            if(!empty($date) && !empty($client) && !empty($gauche) && !empty($droite)){
                // ------------ Begin Commande -------- //
                $commande = Commande::find($id);
                $commande->date = $date;
                $commande->client_id = $client;
                $commande->nom_client = Client::find($client)->nom_client;
                $commande->oeil_gauche = $gauche;
                $commande->oeil_droite = $droite;
                $commande->facture = "nf"; 
                // $commande->avance = $avance;
                // $commande->reste = $reste;
                // $commande->totale = $total;
                $commande->avance = $cmd_avance;
                $commande->reste = $cmd_reste;
                $commande->totale = $cmd_total;
                $commande->save();
                // ------------ End Commande -------- //
                if($commande->id){
                    // ------------ Begin LigneCommande -------- //
                    $lignecommandes = Lignecommande::where('commande_id',$id)->get();
                    foreach ($lignecommandes as $ligne) {
                        $ligne->delete();
                    }
                    foreach ($lignes as $ligne) {
                        $lignecommande = new Lignecommande();
                        $lignecommande->commande_id = $id;
                        $lignecommande->produit_id = $ligne['prod_id'];
                        $lignecommande->nom_produit = $ligne['libelle'];
                        $lignecommande->Qantite = $ligne['qte'];
                        $lignecommande->totale_produit = $ligne['total'];
                        $lignecommande->save();
                    }
                    // ------------ End LigneCommande -------- //
                    // ------------ Begin Reglement -------- //
                    // $reglement = reglement::where('commande_id',$id)->first();
                    // $reglement->commande_id = $id;
                    // $reglement->date = $date;
                    // $reglement->nom_client = Client::find($client)->nom_client ;
                    // $reglement->mode_reglement = $request->input('mode');
                    // $reglement->avance = $request->input('avance');
                    // $reglement->reste = $request->input('reste');
                    // $reglement->reglement = $request->input('status');
                    // $reglement->save();
                    foreach ($reglements as $reg) {
                        $reglement = reglement::find($reg['reg_id']);
                        $reglement->reste = $reg['reste'];
                        $reglement->reglement = $reg['status'];;
                        $reglement->save();
                    }
                    // ------------ End Reglement -------- //
                }
                else{
                    return ['status'=>"error",'message'=>"Problème d'enregistrement de la commande !"];
                }
            } 
            else{
                return ['status'=>"error",'message'=>"Veuillez remplir les champs vides !"];
            }
        }
        else {
            return ['status'=>"error",'message'=>"Veuillez d'ajouter des lignes des commandes"];
        }
        return ['status'=>"success",'message'=>"La commande a été bien enregistrée !!"];
    }

    public function facture2(Request $request){
        $datetime = Carbon::now();
        $date = $datetime->isoFormat('YYYY-MM-DD');
        $year = $datetime->isoFormat('YY');
        $month = $datetime->isoFormat('MM');
        // -------- test la date -------- //
        // $time = strtotime('02/16/2023');
        // $date = date('Y-m-d',$time);
        // $year = date('y',$time);
        // $month = date('m',$time);
        // ---------------------        
        $count = Facture::get();
        (count($count)>0) ? $lastcode = Facture::get()->last()->code : $lastcode = null;
        $str = 1;
        if(isset($lastcode)){
            $list = explode("-",$lastcode);
            // $f = $list[0];
            $y = substr($list[1],0,2);
            // $m = substr($list[1],2,2);
            $n = $list[2];
            ($y == $year) ? $str = $n+1 : $str = 1;
        } 
        $pad = str_pad($str,4,"0",STR_PAD_LEFT);
        $code = 'FA-'.$year.''.$month.'-'.$pad;
        // ---------------------        

        $cmd_id = $request->commande;
        $commande = Commande::with('client')->find($cmd_id);
        $lignecommandes = Lignecommande::with('produit')->where('commande_id', '=', $cmd_id)->get();
        $prix_HT = 0;
        foreach($lignecommandes as $ligne){
            $prix_HT = $prix_HT +  ($ligne->produit->prix_produit_HT * $ligne->Qantite);
            $ligne->nom_produit = $ligne->produit->nom_produit;  
        }
        $TVA = 0;
        foreach($lignecommandes as $ligne){
            $TVA = $TVA +  ($ligne->produit->prix_produit_HT * $ligne->Qantite * $ligne->produit->TVA) ;
        }
        $priceTotal = 0;
        foreach($lignecommandes as $ligne){
            $priceTotal =  floatval($priceTotal  + $ligne->totale_produit) ;
        }
        return view('managements.commandes.facture2', [
            'cmd_id' =>  $cmd_id, 
            'date' =>  $date, 
            'year' =>  $year, 
            'month' =>  $month, 
            'code' =>  $code, 
            'lignecommandes' =>  $lignecommandes,
            'priceTotal'  => $priceTotal,
            'prix_HT' => $prix_HT,
            'TVA' => $TVA,
            'commande' => $commande
        ]);
    }

    public function storefacture2( Request $request){
        $cmd_id = $request->input('commande_id');
        $factures = Facture::where('commande_id','=',$cmd_id)->get();
        if($factures->count()>0)
            $msg= "La commande a été déja facturée! ";
        else{
            $facture = new Facture();
            $facture->totale_HT = $request->input('totale_HT');
            $facture->totale_TVA = $request->input('totale_TVA');
            $facture->totale_TTC = $request->input('totale_TTC');
            $facture->commande_id = $request->input('commande_id');
            $facture->reglement = $request->input('reglement');
            $facture->date = $request->input('date');
            $facture->code = $request->input('code');
            $facture->save();
            $msg= "la facture a été bien enregistré vous devez ajouter le règlement de la commande N° .$facture->command_id ";
            if($facture->id){
                $commande = Commande::find($facture->commande_id);
                $commande->facture = "f";
                $commande->save();
            }

        }
        return redirect()->route('commande.index22')->with([
            "status" => $msg
        ]); 
    }

    public function show2($cmd_id){
        $commande = Commande::with('client')->find($cmd_id);
        $lignecommandes = Lignecommande::with('produit')->where('commande_id', '=', $cmd_id)->get();
        // return $lignecommandes;
        $prix_HT = 0;
        foreach($lignecommandes as $ligne){
            $prix_HT = $prix_HT +  ($ligne->produit->prix_produit_HT * $ligne->Qantite);
            $ligne->nom_produit = $ligne->produit->nom_produit;  
        }
        $TVA = 0;
        foreach($lignecommandes as $ligne){
            $TVA = $TVA +  ($ligne->produit->prix_produit_HT * $ligne->Qantite * $ligne->produit->TVA) ;
        }
        $priceTotal = 0;
        foreach($lignecommandes as $ligne){
            $priceTotal =  floatval($priceTotal  + $ligne->totale_produit) ;
        }
        // return view('managements.commandes.show2', [
        return view('managements.commandes.view1', [
            'cmd_id' =>  $cmd_id, 
            'commande' =>  $commande, 
            'lignecommandes' =>  $lignecommandes,
            'priceTotal'  => $priceTotal,
            'prix_HT' => $prix_HT,
            'TVA' => $TVA,
        ]);
    }
//-------------------
}

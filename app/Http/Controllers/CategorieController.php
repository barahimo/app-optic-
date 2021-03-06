<?php

namespace App\Http\Controllers;

use App\Produit;
use App\Categorie;
use App\Lignecommande;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
   
       }
    public function index()
    {
       $categories = Categorie::orderBy('id', 'desc')->paginate(3);
       return view('managements.categories.index', compact('categories'));
    }

   
    public function create()
    {
        return view('managements.categories.create');
    }

    
    public function store(Request $request)

      {  
            // $validateData = $request->validate([
     
            //     'nom_client' => 'required',
            //     'telephone' => 'required',
            //     'adresse' => 'required' ,
            //     'solde' => 'required',
            //     'code_client' => 'required|min:4|max:100' 
                        
            // ]);

        $categorie = new Categorie();
        $categorie ->nom_categorie = $request->input('nom_categorie');
        $categorie ->descreption = $request->input('descreption');
        

        $categorie->save();

        $request->session()->flash('status','Categorie a été bien enregistré !');
         return redirect()->route('categorie.index');


      }


    
    public function show(Categorie $categorie)
    {
        $produits =  Produit::where('categorie_id', '=', $categorie->id)
        ->paginate(100);
        return view('managements.categories.show', [
            "categorie" => $categorie,
            "produits" => $produits 

        ]);
    }

    
    public function edit(Categorie $categorie)
    {
        return view('managements.categories.edit')->with([
           "categorie" => $categorie
        ]);
    }

    
    public function update(Request $request, Categorie $categorie)
    {
        // $this->validate($request, [

        //     'code_client' => 'required|min:4|max:100',     
        //     'nom_client' => 'required',
        //     'telephone' => 'required',
        //     'adresse' => 'required',
        //     'solde' => 'required',

        // ]);

        $categorie ->nom_categorie = $request->input('nom_categorie');
        $categorie ->descreption = $request->input('descreption');
        

        $categorie->save();


        $request->session()->flash('status','Categorie a été bien modifié !');


        return redirect()->route('categorie.index');

    }

    
    public function destroy(Categorie $categorie)
    {
        
        $produits = Produit::where('categorie_id','=',$categorie->id)->get();
        if($produits->count()){
            $existe = false;
            foreach ($produits as $produit) {
                $lgcommande = Lignecommande::where('produit_id', '=', $produit->id )->first();
                if($lgcommande){
                    $existe = true;
                    break;
                }
            }
            if($existe){
                $msg = "La catégorie ne peut pas être supprimée car ses produits sont déja appartient à une commande";
            }
            else{
                $msg = "la catègorie et ses produits tous sont supprimées avec succès !";
                foreach ($produits as $produit) {
                    $produit->delete();
                }
                $categorie->delete();
            }
        }
        else{
            $categorie->delete();
            $msg = "categorie a été supprimer avec succès !";
        }

        // Post::destroy($id); supression directement

        return redirect()->route('categorie.index')->with([
            "status" => $msg
        ]); 
    }

        public function search(Request $request){
            $q = $request->input('q');

            $categories =  Categorie::where('nom_categorie', 'like', "%$q%")
            ->paginate(5);

            return view('managements.categories.search')->with('categories', $categories);  
        
        }

        public function ajouteProduit(Request $request,$id){
            $categorie=Categorie::find($id);
            return view('managements.categories.createProduit', [

                 'categorie' => $categorie
            ]);

        }

    public function storeP(Request $request )
    {
        $produit = new Produit();
        $produit->nom_produit = $request->input('nom_produit');
        $produit->code_produit = $request->input('code_produit');
        $produit->TVA = $request->input('TVA');
        $produit->prix_produit_HT = $request->input('prix_produit_HT');
        $produit->descreption = $request->input('descreption');
        $produit->nom_categorie =  $request->input('nom_categorie');

        // dd($produit);

        $categorieligne = Categorie::where('nom_categorie','like', $produit->nom_categorie)->first();
        $produit->categorie_id = $categorieligne->id;
        

        $produit->save();

        $request->session()->flash('status','le produit a été ajouter à cette catégorie !');
         return redirect()->route('categorie.index');

   }
}

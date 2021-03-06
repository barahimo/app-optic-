<?php

namespace App\Http\Controllers;

use Throwable;
use App\Client;
use App\Commande;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function __construct(){
     $this->middleware('auth');

    }
  
    public function index( Request $request)
    {
        // $clients = Client::withTrashed()->get();
        // $clients = Client::onlyTrashed()->get();
        // return $clients;

        try{ 
            $clients = Client::orderBy('id','desc')->paginate(3);
            return view('managements.clients.index', compact('clients'));
        }
        catch(Throwable $e)
        {
            $request->session()->flash('status', $e->getMessage());
            return view('error');
        }
    }

    
   
    public function create()
    {
        return view('managements.clients.create');
    }

    
    public function store(Request $request)

      {  
            // $validateData = $request->validate([
     
            //     'nom_client' => 'required',
            //     'telephone' => 'required',
            //     'adresse' => 'required' ,
            //     'solde' => 'required',
            //     'code' => 'required|min:4|max:100' 
                        
            // ]);

        // --------------------------------------------------
        $clients = Client::withTrashed()->get();
        (count($clients)>0) ? $lastcode = $clients->last()->code : $lastcode = null;
        $str = 1;
        if(isset($lastcode))
            $str = $lastcode+1 ;
        $code = str_pad($str,4,"0",STR_PAD_LEFT);
        // --------------------------------------------------
        $client = new Client();
        $client->nom_client = $request->input('name');
        $client->adresse = $request->input('adresse');
        $client->telephone = $request->input('telephone');
        $client->solde = $request->input('solde');
        $client->code = $code;
       
        $client->ICE = Str::slug($client->nom_client, '-');
        

        $client->save();

        $request->session()->flash('status','le client a ??t?? bien enregistr?? !');
         return redirect()->route('client.index');


      }

      public function search(Request $request){
          $q = $request->input('q');

       $clients =  Client::where('nom_client', 'like', "%$q%")
           ->orWhere('code', 'like', "%$q%")
           ->paginate(5);

           return view('managements.clients.search')->with('clients', $clients);  
        
        }

    
    public function show(Client $client)
    {
        $commandes = Commande::where('client_id', '=', $client->id)
         ->paginate(2);
         
         return view('managements.clients.show')->with([
             'commandes' => $commandes,
             'client' => $client
         ]);
        
         
    }

    
    public function edit(Client $client)
    {
        return view('managements.clients.edit')->with([
           "client" => $client
        ]);
    }

    
    public function update(Request $request, Client $client)
    {
        // $this->validate($request, [

        //     'code' => 'required|min:4|max:100',     
        //     'nom_client' => 'required',
        //     'telephone' => 'required',
        //     'adresse' => 'required',
        //     'solde' => 'required',

        // ]);

        $client->nom_client = $request->input('name');
        $client->adresse = $request->input('adresse');
        $client->telephone = $request->input('telephone');
        $client->solde = $request->input('solde');
        $client->code = $request->input('code');
       
        $client->ICE = Str::slug($client->code, '-');
    
        $client->save();

        $request->session()->flash('status','le client a ??t?? bien modifi?? !');
        return redirect()->route('client.index');

        // return redirect()->route('client.index')->with('status','le client a ??t?? bien modifi?? !');

    }

    
    public function destroy(Client $client)
    {

        $commandes = Commande::where('client_id','=',$client->id)->get();
        if($commandes->count() != 0){
            foreach ($commandes as $commande) {
                $commande->delete();
            }
        }
        $client->delete();

        // Post::destroy($id); supression directement

        return redirect()->route('client.index')->with([
            "status" => "le client, ses commandes et reglements  ont ??t?? supprimer avec succ??s!"
        ]); 
    }
}

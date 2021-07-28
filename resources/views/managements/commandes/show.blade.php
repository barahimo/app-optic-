
   @extends('layout.dashboard')

@section('contenu')


<center>
  <table style=" width: 900px; margin-top:30px; background-color:rgba(241, 241, 241, 0.842);" class="table table-hover ">
    



      <form  method="POST" action="{{route('commande.storeLP')}}">
        @csrf 
        
      

      <thead>
        
        <tr  >
          <th style=" padding-left:350px; font-size:25px; background-color:white; " colspan="2" scope="col">reglement lignecommande</th>
      
        </tr>
      </thead>

      <tbody>
           <tr>
              <th scope="col">nom Produit :</th>
              <td>{{$nom}}</td>
            </tr>
            <tr>
              <th scope="col"> prix unitaire :</th>
              <td><input id="pu"  name="pu" type="text" value="{{$pu}}" readonly></td>
            </tr>
            <tr>
              <th scope="col">TVA:</th>
              <td><input id="tva" name="tva" type="text" value="{{$tva}}" readonly></td>
            </tr>
            
             {{-- <tr>
              <th scope="col">ligncommandeid :</th> 
              <td><input id="lignecommande_id" name="lignecommande_id" type="text" value="{{ $lignecommande->id }}"  ></td>
              
            </tr>  --}}



            <tr>
              <th scope="col">commandeid :</th> 
              <td><input id="commande_id" name="commande_id" type="text" value="{{ old('commande_id', $lignecommande->commande_id ?? null) }}"  ></td>
            </tr>

            <tr>
              <th scope="col">produitid :</th> 
              <td><input id="produit_id" name="produit_id" type="text" value="{{ old('produit_id', $lignecommande->produit_id ?? null) }}"  ></td>
            </tr>
           
            <tr>
              <th scope="col">nom produit:</th>
              <td><input id="nom_produit" name="nom_produit" type="text" value="{{ old('nom_produit', $lignecommande->nom_produit ?? null) }}" ></td>
            </tr> 

           
            <tr>
              <th scope="col">Quantité :</th>
              <td><input id="qt" name="qt" type="text" value="{{$lignecommande->Qantite}}" onchange="calculTotal() "></td>
            </tr>
            <tr>
              <th scope="col">prix :</th>
              <td><input id="ttc" name="ttc" type="text" value="{{$lignecommande->totale_produit}}" readonly ></td>
            </tr>
            <tr>
              <th scope="col">Prix Total Produit TTC :</th>
              <td> <input  type="text" id="amount" name="amount" readonly> </td>
             
            </tr>

            <tr>
              
              {{-- <td > <input  type="button" value="calculer" > </td> --}}
              <td > <input  type="submit" value="enregistrer" > </td>
             
            </tr>


          
          
      </tbody>
    </form>
    </table>

    
</center>

@endsection
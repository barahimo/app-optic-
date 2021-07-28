@extends('layout.dashboard')

@section('contenu')
<center>
  <table style=" width: 700px; margin-top:20px;background-color:rgba(241, 241, 241, 0.842);" class="table table-hover ">
    <thead>
      <tr  >
        <th style=" font-size:25px; text-align:center; background-color:white;" colspan="2" scope="col">Fiche Produit</th>
    
      </tr>
    </thead>
    <tbody>
          <tr>
            <th scope="col">id-produit :</th>
            <td>{{$produit->id}}</td>
          </tr>
          <tr>
            <th scope="col">nom_produit :</th>
            <td>{{$produit->nom_produit}}</td>
          </tr>
          <tr>
            <th scope="col">code_produit :</th>
            <td>{{$produit->code_produit}}</td>
          </tr>
          <tr>
            <th scope="col">TVA :</th>
            <td>{{$produit->TVA}}</td>
          </tr>
          <tr>
            <th scope="col">Prix_Produit_HT :</th>
            <td>{{$produit->prix_produit_HT}}</td>
          </tr>
          <tr>
            <th scope="col">descreption :</th>
            <td>{{$produit->descreption}}</td>
          </tr>
          <tr>
            <th scope="col">nom categorie:</th>
            <td>{{$produit->nom_categorie}}</td>
          </tr>
          <tr>
            <th scope="col">Id categorie :</th>
            <td>{{$produit->categorie_id}}</td>
          </tr>
          <tr>
            <th scope="col">créé le :</th>
            <td>{{$produit->created_at}}</td>
          </tr>
          <tr>
            <th scope="col">modifié le :</th>
            <td>{{$produit->updated_at}}</td>
          </tr>
          <tr>
            <td colspan="2">
              <a href="{{action('ProduitController@index')}}" class="btn btn-primary" style="margin-left: 100px ; margin-top: 20px ;">retour</a>
            </td>
          </tr>
        
    </tbody>
  </table>
</center>







@endsection


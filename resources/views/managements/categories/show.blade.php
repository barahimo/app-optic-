@extends('layout.dashboard')

@section('contenu')

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-3">
                <h2 style="  font-size: font-size: 25px; color:black; text-align:center " class="" >Fiche Categorie :  </h2>

            </div>
           
            
        </div>
        <div class="card"  style=" background-color:rgba(241, 241, 241, 0.842)">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="name"> <strong><strong>identidiant:</strong> </strong></label>
                        <pre>{{$categorie->id}}</pre>
                    </div>
                    <div class="col-md-3">
                        <label for="nom_categorie"> <strong><strong> Nom Categorie:</strong></strong></label>
                        <pre>{{$categorie->nom_categorie}}</pre>
                    </div>
                    <div class="col-md-3">
                        <label for="name"><strong><strong> Descreption :</strong></strong></label>
                        <pre>{{$categorie->descreption}}</pre>
                    </div>
                
                   
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="name"><strong><strong>crée le :</strong></strong></label>
                        <pre>{{$categorie->created_at}}</pre>
                    </div>
                    <div class="col-md-3">
                        <label for="name"><strong> <strong> modifié le :</strong></strong></label>
                        <pre>{{$categorie->updated_at}}</pre>
                    </div>
                   
                </div>
                
            </div>

        </div>
        
    </div>
</div>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<div class="row justify-content-center">
    <div class="col-md-10">
    <a href="{{route('categorie.produit',['id'=> $categorie->id])}}" class="btn btn-info btn-lg m-b-10 " style="margin-left: 930px; " > <i class="fa fa-plus">Produit</i></a>
       
            <div class="card" style="background-color: rgba(241, 241, 241, 0.842)">
                <div class="card-body">
                    
                    <table class="table">
                        <thead>
                            <tr  >
                                <th style=" font-size:25px; text-align:center; background-color:white;" colspan="8" scope="col">Produits de la Categorie</th>
                            
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>nom produit</th>
                                <th> code produit</th>
                                <th> TVA</th>
                                <th> prix_produit_HT</th>
                                <th>descreption</th>
                                <th>nom categorie</th>                            
                               
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produits as $produit)
                              <tr>
                                  <td>{{$produit->id }}</td>
                                  <td>{{$produit->nom_produit}}</td>
                                  <td>{{$produit->code_produit}}</td>
                                  <td>{{$produit->TVA}}</td>
                                  <td>{{$produit->prix_produit_HT}}</td>
                                  <td>{{$produit->descreption}}</td>
                                  <td>{{$produit->nom_categorie}}</td>
    
                                  <td>
                             
    
                                      <form style="display: inline" method="POST" action="{{route('produit.destroy',['produit'=> $produit])}}">
                                        @csrf {{-- génère un toke pur protéger le formulaie--}}
                                       @method('DELETE')
                                       <a href="{{ action('ProduitController@show',['produit'=> $produit])}}" class="btn btn-secondary btn-md"><i class="fas fa-info"></i></a>
                                       <a href="{{route('produit.edit',['produit'=> $produit])}}"class="btn btn-success btn-md"><i class="fas fa-edit"></i></a>
                                       <button class="btn btn-danger btn-md" type="submit"><i class="fas fa-trash"></i></button>
                                       
                                    </form>  
    
                                  </td>
                              </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
    
            </div>
       
    </div>

</div>

<div  class="col-md-3" style="height: 70px" >
    
    <a href="{{action('CategorieController@index')}}" class="btn btn-info btn-lg" style=" width:110px; margin-left: 100px ; margin-top: 20px ; margin-left:1030px;">retour</a>
</div>


@endsection


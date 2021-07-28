@extends('layout.dashboard')

@section('contenu')

{{-- <script>
    Swal.fire(
        'The Internet?',
        'That thing is still around?',
        'question'
        );
        
        </script> --}}
<div >
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-3">
                <h2 style="  font-size: font-size: 25px; color:black; margin-top:10px; "  >Fiche Client :  </h2>

            </div>
           
            
        </div>
        <div class="card" style="background-color:rgba(241, 241, 241, 0.842)">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="name"> <strong> <strong>identidiant:</strong></strong></label>
                        {{$client->id}}
                    </div>
                    <div class="col-md-4">
                        <label for="name"> <strong> <strong>Nom Complet :</strong></strong></label>
                        {{$client->nom_client}}
                    </div>
                    <div class="col-md-4">
                        <label for="name"><strong><strong> Adresse :</strong></strong></label>
                         
                        {{$client->adresse}}
                    </div>
                   
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="name"><strong> <strong>Télephone :</strong></strong></label>
                        {{$client->telephone}}
                    </div>
                    <div class="col-md-4">
                        <label for="name"><strong><strong> ICE:</strong></strong></label>
                       {{$client->ICE}}
                    </div>
                    <div class="col-md-4">
                        <label for="name"><strong> <strong>Solde:</strong></strong></label>
                        {{$client->solde}}
                    </div>
                   
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="name"><strong><strong>Code client:</strong></strong></label>
                        {{$client->code_client}}
                    </div>

                    <div class="col-md-4">
                        <label for="name"><strong><strong>crée le :</strong></strong></label>
                        {{$client->created_at}}
                    </div>
                    <div class="col-md-4">
                        <label for="name"><strong> <strong> modifié le :</strong></strong></label>
                        {{$client->updated_at}}
                    </div>
                   
                </div>
                
            </div>

        </div>
        
    </div>
</div>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card" style="background-color: rgba(241, 241, 241, 0.842)">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr  >
                            <th style=" font-size:25px; text-align:center; background-color:white;" colspan="7" scope="col">les Commandes d'un client</th>
                        
                        </tr>
                        <tr>
                            <th>#id</th>
                            <th>Cadre</th>
                            <th> Date</th>
                            <th> oeil_gauche</th>
                            <th> oeil_droit</th>
                            {{-- <th>avance</th>
                            <th>reste</th> --}}
                            <th>Nom client</th>
                            {{-- <th>id_client</th>
                            <th>totale</th> --}}
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commandes as $commande)
                          <tr>
                              <td>{{$commande->id }}</td>
                              <td>{{$commande->cadre}}</td>
                              <td>{{$commande->date}}</td>
                              <td>{{$commande->oeil_gauche}}</td>
                              <td>{{$commande->oeil_droite}}</td>
                              {{-- <td>{{$commande->avance}}</td>
                              <td>{{$commande->reste}}</td> --}}
                              <td>{{$commande->nom_client}}</td>

                              <td>
                                  
                                  <form style="display: inline" method="POST" action="{{route('commande.destroy',['commande'=> $commande])}}">
                                    @csrf 
                                   @method('DELETE')
                                   <a href="{{ action('CommandeController@show',['commande'=> $commande])}}" class="btn btn-secondary btn-md">detailler</i></a>
                                   <a href="{{route('commande.edit',['commande'=> $commande])}}"class="btn btn-success btn-md">editer</i></a>
                                   <button class="btn btn-danger btn-md" type="submit">archiver</button>
                                 </form>  

                              </td>
                          </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        {{ $commandes->links()}}
    </div>
</div>
<div  class="col-md-3" style="height: 70px" >
    {{-- <button type="button" class="btn btn-dark">Dark</button> --}}
    <a href="{{action('ClientController@index')}}" class="btn btn-primary" style="margin-left: 100px ; margin-top: 20px ;">retour</a>
</div>


@endsection


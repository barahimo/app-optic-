@extends('layout.dashboard')
@section('contenu')
<!-- ##################################################################### -->
<div class="container">
  <div class="row">
    <div class="col-6">
      <select class="form-control" name="client" id="client">
        @foreach($clients as $client)
        <option value="{{$client->id }}">{{ $client->nom_client}}</option>
        @endforeach
      </select>
    </div>
    <div class="col-6">
      <select class="form-control" name="search" id="search">
        <option value="">Global</option>
        <option value="reglée">Réglée</option>
        <option value="non reglée">Non réglée</option>
        <option value="facturée">Facturée</option>
        <option value="non facturée">Non facturée</option>
      </select>
    </div>
  </div>
  <br>
  <div>
    <a href="{{route('commande.index2')}}" class="btn btn-primary m-b-10 ">
      <i class="fa fa-plus">&nbsp;Commande</i>
    </a>
  </div>
  <br>
  <div class="card" style="background-color: rgba(241, 241, 241, 0.842)">
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Client</th>
            <th>Montant total</th>
            <th>Reste à payer</th>
            <th>Status</th>
            <th>Facture</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
          @foreach($commandes as $commande)
            @php
              $somme = 0;
              $avance = 0;
              $reste = 0;
              $status = "non reglée";
              foreach($lignecommandes as $lignecommande){
                if($lignecommande->commande_id == $commande->id)
                    $somme += $lignecommande->totale_produit;
              }
              foreach($reglements as $reglement){
                if($reglement->commande_id == $commande->id)
                    $avance += $reglement->avance;
              }
              $reste = $somme - $avance;
              if($reste == 0) 
                $status = "reglée";
            @endphp
          <tr>
            <td>{{$commande->id}}</td>
            <td>{{$commande->date}}</td>
            <td>{{$commande->nom_client}}</td>
            <td>{{number_format($somme, 2, '.', '')}}</td>
            <td>{{number_format($reste, 2, '.', '')}}</td>
            <td>{{$status}}</td>
            <td>{{$commande->cadre}}</td>
            <td>
              <button class="btn btn-link" id="facture" <?php if($commande->cadre == "facturée") echo "disabled";?>><i class="fa fa-plus">&nbsp;Facture</i></button>
              &nbsp;&nbsp;
              <button class="btn btn-link" id="reglement" <?php if($status == "reglée") echo "disabled";?>><i class="fa fa-plus">&nbsp;Règlement</i></button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- ---------  BEGIN SCRIPT --------- -->
<script type="text/javascript">
  $(document).ready(function(){
    // -----------Change Category--------------//
    $(document).on('change','#search',function(){
      var search=$(this).val();
      var table=$('.table');
      $.ajax({
        type:'get',
        url:'{!!URL::to('productsCategory')!!}',
        data:{'search':search},
        success:function(data){
          var body = '<option value="0" disabled="true" selected="true">-Product-</option>';
          for(var i=0;i<data.length;i++){
            options+=`<option value="${data[i].id}">${data[i].nom_produit} | ${data[i].prix_produit_HT}</option>`;
          }  
          product.html("");        
          product.append(options);        
        },
        error:function(){
        }
      });
    });
    // -----------End Change Category--------------//
  });
  // -----------My function--------------//
  function eventButtons(id){
    var facture = $("#facture");
    var reglement = $("#reglement");
  }
</script>
<!-- ##################################################################### -->
@endsection


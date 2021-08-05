@extends('layout.dashboard')
@section('contenu')
<!-- ##################################################################### -->
<div class="container">
<div>
    <a href="{{route('commande.index2')}}" class="btn btn-primary m-b-10 ">
      <i class="fa fa-plus">&nbsp;Commande</i>
    </a>
  </div>
  <br>
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
        <option value="r">Réglée</option>
        <option value="nr">Non réglée</option>
        <option value="f">Facturée</option>
        <option value="nf">Non facturée</option>
      </select>
    </div>
  </div>
  <br>
  <div class="card" style="background-color: rgba(241, 241, 241, 0.842)">
    <div class="card-body">
      <table class="table" id="table">
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
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- ---------  BEGIN SCRIPT --------- -->
<script type="text/javascript">
  $(document).ready(function(){
    searchSelect(null,null);
    // -----------Change Select_Search--------------//
    $(document).on('change','#search',function(){
      var search=$(this).val();
      searchSelect(null,search);
    });
    // -----------End Select_Search--------------//
    // -----------Change Select_Client--------------//
    $(document).on('change','#client',function(){
      var client=$(this).val();
      searchSelect(client,null);
    });
    // -----------End Select_Client--------------//
  });
  // -----------My function--------------//
  function searchSelect(param1,param2){
    var table=$('#table');
    $.ajax({
      type:'get',
      url:'{!!URL::to('getCommandes')!!}',
      data:{'client':param1,'search':param2},
      success:function(data){
        var ligne = '';
        var commandes = data.commandes;
        var lignecommandes = data.lignecommandes;
        var reglements = data.reglements;
        var clients = data.clients;
        commandes.forEach(commande => {
          // ************************ //
          var somme = 0;
          var avance = 0;
          var reste = 0;
          lignecommandes.forEach(lignecommande => {
              if(lignecommande.commande_id == commande.id)
                  somme += parseFloat(lignecommande.totale_produit);
          })
          reglements.forEach(reglement => {
              if(reglement.commande_id == commande.id)
                  avance += parseFloat(reglement.avance);
          })
          // ************************ //
          var url = "{{route('commande.edit2',['id'=>":id"])}}".replace(':id', commande.id);
          var facture = "non facturée";
          if(commande.facture == "f")
            facture = "facturée";
          var status = "réglée";
          if(commande.reste > 0)
            status = "non réglée";
          ligne += `<tr>
              <td>${commande.id}</td>
              <td>${commande.date}</td>
              <td>${commande.nom_client}</td>
              <td>${commande.totale}</td>
              <td>${commande.reste}</td>
              <td>${status}</td>
              <td>${facture}</td>
              <td>
                <button class="btn btn-link" onclick="actionButton()"><i class="fa fa-plus">&nbsp;Facture</i></button>
                &nbsp;&nbsp;
                <button class="btn btn-link"><i class="fa fa-plus">&nbsp;Règlement</i></button>
                &nbsp;&nbsp;
                <a class="btn btn-danger" href=${url}>Edit</a>
              </td>
            </tr>`;

        });
        table.find('tbody').html("");
        table.find('tbody').append(ligne);
        actionButton();    
      },
      error:function(){
        console.log([]);    
      }
    });
  }
  function actionButton(){
    table = $('#table');
    list = table.find('tbody').find('tr');
    for (let index = 0; index < list.length; index++) {
      var item = list.eq(index).find('td');
      var status = item.eq(5);
      var facture = item.eq(6);
      var action = item.eq(7).find('button');
      var btnFacture = action.eq(0);
      var btnStatus = action.eq(1);
      (facture.html() == 'facturée') ?btnFacture.attr('disabled',true) : btnFacture.attr('disabled',false);
      (status.html() == 'réglée') ? btnStatus.attr('disabled',true): btnStatus.attr('disabled',false);
    }
  }
</script>
<!-- ##################################################################### -->
@endsection


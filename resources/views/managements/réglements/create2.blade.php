@extends('layout.dashboard')
@section('contenu')
<!-- ##################################################################### -->
<div class="container">
  <p>Client : {{$client}}</p>
  <div class="row">
    <div class="col-6">
      <select class="form-control" name="client" id="client">
        <option value="">--La liste des clients--</option>
        @foreach($clients as $item)
        <option value="{{$item->id }}" @if ($item->id == old('client_id',$client)) selected="selected" @endif>{{ $item->nom_client}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <br>
  <br>
  <div class="card" style="background-color: rgba(241, 241, 241, 0.842)">
    <div class="card-body">
      <table class="table" id="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Commande</th>
            <th>Client</th>
            <th>Montant total</th>
            <th>Montant payer</th>
            <th>Reste à payer</th>
            <th>Avance</th>
            <th>Reste</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
          @foreach($commandes as $commande)
          <tr>
              <td>{{$commande->id}}</td>
              <td>{{$commande->date}}</td>
              <td>Cmd_{{$commande->id}}</td>
              <td>{{$commande->nom_client}}</td>
              <td>{{$commande->totale}}</td>
              <td>{{$commande->avance}}</td>
              <td>{{$commande->reste}}</td>
              <td>0.00</td>
              <td>{{$commande->reste}}</td>
              <td>NR</td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          @php
            $totale = 0;
            $avance = 0;
            $reste = 0;
            foreach($commandes as $commande){
              $totale += $commande->totale;
              $avance += $commande->avance;
              $reste += $commande->reste;
            }
          @endphp
          <tr>
            <th colspan="4"></th>
            <th>{{number_format($totale, 2, '.', '')}}</th>
            <th>{{number_format($avance, 2, '.', '')}}</th>
            <th>{{number_format($reste, 2, '.', '')}}</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
   <!-- Begin Reglement  -->
   <div class="card text-left">
    <img class="card-img-top" src="holder.js/100px180/" alt="">
    <div class="card-body">
      <h4 class="card-title">Reglement :</h4>
      <div class="card-text">
        <div class="form-row">
          <div class="col-3">
            <label for="mode">mode reglement :</label>
            <select class="form-control" id="mode" name='mode' placeholder="mode reglement"> 
              <option value="chèque">chèque</option>
              <option value="carte banquaire">carte banquaire</option>
            </select>
          </div>
          <div class="col-3">
            <label for="nom">Avance :</label>
            <input type="number" id="avance" name="avance" min="0" class="form-control" placeholder="0.00" value="0.00">
          </div>
          <div class="col-3">
            <label for="reste">Reste :</label>
            <input type="number" id="reste" name="reste" class="form-control" placeholder="reste" min="0" value="0.00" disabled>

          </div>
          <div class="col-3">
            <label for="status">Status :</label>
            <input type="text" name="status" id="status"  class="form-control" placeholder="status" disabled>
          </div>
        </div>
      </div>
    </div>
  </div>  
  <!-- End Reglement  -->
</div>
<!-- ---------  BEGIN SCRIPT --------- -->
<script type="text/javascript">
  // -----------Begin Déclaration des variables--------------//
    var avance = $('#avance');
    var reste = $('#reste');
    var stat = $('#status');
    var table = $('#table');
    var tbody = table.find('tbody');
    var tfoot = table.find('tfoot');
  // -----------End Déclaration des variables--------------//
  $(document).ready(function(){
    // -----------Change Select_Client--------------//
    $(document).on('change','#client',function(){
      $client = $(this).val();
      if($client == "")
        getReglements();
      else
        getReglements($client);
    });
    // -----------End Select_Client--------------//
    // -----------keyup Avance--------------//
    $(document).on('keyup','#avance',function(){
      var navance = parseFloat(avance.val());
      if(navance > sommeReste())
        avance.val(sommeReste());
      if(avance.val()=="")
        avance.val('0');
      calculs();
      calculsLignes();
    });
    // -----------End keyup Avance--------------//
  });
  // -----------My function--------------//
  test();
  calculs();
  function test(){
  }
  function search(){ }
  function sommeTotal(){
    var list = tbody.find('tr');
    var ntotal = 0;
    for (let index = 0; index < list.length; index++) {
      var ligne = list.eq(index).find('td');
      var total = parseFloat(ligne.eq(4).html());
      ntotal += total;
    }
    return ntotal;
  }
  function sommeAvance(){
    var list = tbody.find('tr');
    var navance = 0;
    for (let index = 0; index < list.length; index++) {
      var ligne = list.eq(index).find('td');
      var avance = parseFloat(ligne.eq(5).html());
      navance += avance;
    }
    return navance;
  }
  function sommeReste(){
    var list = tbody.find('tr');
    var nreste = 0;
    for (let index = 0; index < list.length; index++) {
      var ligne = list.eq(index).find('td');
      var reste = parseFloat(ligne.eq(6).html());
      nreste += reste;
    }
    return nreste;
  }
  function calculs(){
    var sreste = sommeReste();
    var res = sreste-parseFloat(avance.val());
    reste.val(res.toFixed(2));
    if(res>0)
      stat.val('NR');
    else
      stat.val('R');
  }
  function calculsLignes(){
    var navance = parseFloat(avance.val());
    var reg = navance;
    var list = tbody.find('tr');
    for (let index = 0; index < list.length; index++) {
      var ligne = list.eq(index).find('td');
      // --------------
      var reste_cmd = ligne.eq(6);
      var nreste_cmd = parseFloat(reste_cmd.html());
      var av = ligne.eq(7);
      var res = ligne.eq(8);
      var stat = ligne.eq(9);
      var nres = 0;
      var pay = 0;
      // --------------
      if(reg>=nreste_cmd)
        pay = nreste_cmd;
      else 
        pay = reg;
      av.html(pay);
      nres = nreste_cmd - pay;
      res.html(nres);
      reg -= parseFloat(av.html());
      (nres>0)?stat.html('NR'):stat.html('R');
    }
    return ntotal;
  }
  function getReglements(param){
    $.ajax({
      type:'get',
      url:'{!!URL::to('getReglements')!!}',
      data:{'client':param,'status':'nr'},
      success:function(data){
        var table = $('#table');
          table.find('tbody').html("");
          var lignes = '';
          data.forEach(ligne => {
            lignes+=`<tr>
                    <td>${ligne.id}</td>
                    <td>${ligne.date}</td>
                    <td>Cmd ${ligne.commande_id}</td>
                    <td>${ligne.nom_client}</td>
                    <td>${ligne.commande.totale}</td>
                    <td>${ligne.avance}</td>
                    <td>${ligne.reste}</td>
                    <td>
                        
                    </td>
                    </tr>`;
          });
          table.find('tbody').append(lignes);
      },
      error:function(){
        console.log([]);    
      }
    });
  }
  // var list = tfoot.find('tr');
    // var nreste = parseFloat(list.find('th').eq(3).html());
    // reste.val(nreste.toFixed(2));
</script>
<!-- ##################################################################### -->
@endsection


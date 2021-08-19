@extends('layout.dashboard')
@section('contenu')
<!-- ##################################################################### -->
<div class="container">
  <div class="row">
    <div class="col-6">
      <select class="form-control" name="client" id="client">
        <option value="">--La liste des clients--</option>
        @foreach($clients as $item)
        <option value="{{$item->id }}" @if ($item->id == old('client_id',$client)) selected="selected" @endif>{{ $item->nom_client}}</option>
        @endforeach
      </select>
    </div>
    <div class="col-6">
      <input type="date" 
      class="form-control" 
      name="date" 
      id="date" 
      value={{$date}}
      placeholder="date">
    </div>
  </div>
  <br>
  <br>
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
  <!-- Begin TABLE -->
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
              <td>
                <!-- 0.00 -->
                <input type="number" min="0" style="width: 50%" value="0.00" onclick="setAvances({{$commande->id}})" onkeyup="setAvances({{$commande->id}})">
              </td>
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
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>{{number_format($totale, 2, '.', '')}}</th>
            <th>{{number_format($avance, 2, '.', '')}}</th>
            <th>{{number_format($reste, 2, '.', '')}}</th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  <!-- End TABLE -->
  <button class="btn btn-secondary" id="valider">Effectuer le reglement</button>
</div>
<!-- ---------  BEGIN SCRIPT --------- -->
<script type="text/javascript">
  // -----------Begin Déclaration des variables--------------//
    var avance = $('#avance');
    var reste = $('#reste');
    var stat = $('#status');
    var mode=$('#mode');
    var date=$('#date');
    var client=$('#client');
    var table = $('#table');
    var tbody = table.find('tbody');
    var tfoot = table.find('tfoot');
  // -----------End Déclaration des variables--------------//
  $(document).ready(function(){
    // -----------Change Select_Client--------------//
    $(document).on('change','#client',function(){
      $client = $(this).val();
      if($client == "")
        // getReglements();
        getReglements3();
      else
        // getReglements($client);
        getReglements3($client);
      // --------------
    });
    // -----------End Select_Client--------------//
    // -----------keyup Avance--------------//
    $(document).on('keyup','#avance',function(){
      var navance = parseFloat(avance.val());
      if(navance > sommeReste())
        avance.val(sommeReste());
      if(avance.val()=="")
        avance.val(0);
      // --------------
      calculs();
      calculsLignes();
      // --------------
      getTfoot();
    });
    // -----------End keyup Avance--------------//
    // -----------Begin valider--------------//
    $(document).on('click','#valider',function(e){
      if(client.val() == "") 
        Swal.fire("Veuillez choisir un client");
      var client_id = parseInt(client.val());
      var _token=$('input[name=_token]'); //Envoi des information via method POST
      // ***** BEGIN variables lignes ******** //
      var list = tbody.find('tr');
      var array = [];
      for (let i = 0; i < list.length; i++) {
        var cmd_id = list.eq(i).find('td').eq(0).html();
        var avance = list.eq(i).find('td').eq(7).find('input').val();
        var navance = parseFloat(avance);
        var reste = list.eq(i).find('td').eq(8).html();
        var status = list.eq(i).find('td').eq(9).html();
        if(navance > 0){
          var obj = {
                "cmd_id":parseInt(cmd_id),
                "avance":navance,
                "reste":parseFloat(reste),
                "status":status,
              };
          array = [...array,obj];
        }
      }
      // ***** END variables lignes ******** //
      $.ajax({
        type:'post',
        url:'{!!URL::to('storeReglements')!!}',
        data:{
          _token : _token.val(),
          date : date.val(),
          mode:mode.val(),
          client : client_id,
          lignes : array,
        },
        success: function(data){
          Swal.fire(data.message);
          if(data.status == "success"){
            setTimeout(() => {
              // window.location.assign("/reglements2")
              window.location.assign("/index5")
            }, 2000);
          }
        } ,
        error:function(err){
          if(err.status === 500){
            Swal.fire(err.statusText);
          }
          else{
            Swal.fire("Erreur d'enregistrement de reglement !");
          }
        },
      });
    });
    // -----------End valider--------------//
  });
  // -----------My function--------------//
  calculs();
  // --------------
  getTfoot();
  // --------------
  // test();
  function test(){}
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
  function sommeAvance2(){
    var list = tbody.find('tr');
    var navance = 0;
    for (let index = 0; index < list.length; index++) {
      var ligne = list.eq(index).find('td');
      var avance = parseFloat(ligne.eq(7).find('input').val());
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
  function sommeReste2(){
    var list = tbody.find('tr');
    var nreste = 0;
    for (let index = 0; index < list.length; index++) {
      var ligne = list.eq(index).find('td');
      var reste = parseFloat(ligne.eq(8).html());
      nreste += reste;
    }
    return nreste;
  }
  // Permet de calculer Le total des restes
  function calculs(){
    var sreste = sommeReste();
    var res = sreste-parseFloat(avance.val());
    reste.val(res.toFixed(2));
    (res>0) ? stat.val('NR'): stat.val('R');
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
      // av.html(pay);
      av.find('input').val(pay.toFixed(2));
      nres = nreste_cmd - pay;
      res.html(nres);
      // reg -= parseFloat(av.html());
      reg -= parseFloat(av.find('input').val());
      (nres>0)?stat.html('NR'):stat.html('R');
    }
    // --------------
    getTfoot();
  }
  function checkIndex(id){
    var index = -1;
    var list = tbody.find('tr'); 
    for (let i = 0; i < list.length; i++) {
      var cmd_id = list.eq(i).find('td').eq(0).html();
      if(cmd_id == id){
        index = i;
        break;
      }
    }
    return index;
  }
  function setAvances(cmd_id){
    var index = checkIndex(cmd_id);
    var list = tbody.find('tr');
    var ligne = list.eq(index).find('td');
    // --------------
    var reste_cmd = ligne.eq(6);
    var nreste_cmd = parseFloat(reste_cmd.html());
    // --------------
    var av = ligne.eq(7);
    var res = ligne.eq(8);
    var stat = ligne.eq(9);
    // --------------
    var input = av.find('input');
    var pay = parseFloat(input.val());
    if(pay > nreste_cmd)
        input.val(nreste_cmd.toFixed(2));
    if(input.val()=="")
      input.val(0);
    // --------------
    var nres = nreste_cmd - pay;
    res.html(nres.toFixed(2));
    (nres>0)?stat.html('NR'):stat.html('R');
    // --------------
    avance.val(sommeAvance2().toFixed(2));
    reste.val(sommeReste2().toFixed(2));
    (parseFloat(reste.val())>0)?$('#status').val('NR'):$('#status').val('R');
    // --------------
    getTfoot();
  }
  function getTfoot(){
    var list = tfoot.find('tr');
    var total = list.find('th').eq(4);
    var avance1 = list.find('th').eq(5);
    var reste1 = list.find('th').eq(6);
    var avance2 = list.find('th').eq(7);
    var reste2 = list.find('th').eq(8);
    total.html(sommeTotal().toFixed(2));
    avance1.html(sommeAvance().toFixed(2));
    reste1.html(sommeReste().toFixed(2));
    avance2.html(sommeAvance2().toFixed(2));
    reste2.html(sommeReste2().toFixed(2));
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
  function getReglements3(param){
    $.ajax({
      type:'get',
      url:'{!!URL::to('getReglements3')!!}',
      data:{'client':param},
      success:function(data){
          var table = $('#table');
          table.find('tbody').html("");
          var lignes = '';
          data.forEach(ligne => {
            lignes+=`<tr>
                      <td>${ligne.id}</td>
                      <td>${ligne.date}</td>
                      <td>Cmd_${ligne.id}</td>
                      <td>${ligne.nom_client}</td>
                      <td>${ligne.totale}</td>
                      <td>${ligne.avance}</td>
                      <td>${ligne.reste}</td>
                      <td>
                        <input type="number" min="0" style="width: 50%" value="0.00" onclick="setAvances(${ligne.id})" onkeyup="setAvances(${ligne.id})">
                      </td>
                      <td>${ligne.reste}</td>
                      <td>NR</td>
                    </tr>`;
          });
          table.find('tbody').append(lignes);
          // ------------------------------------------------
          // table.find('tfoot').html("");
          // totale = 0;
          // avance = 0;
          // reste = 0;
          // data.forEach(ligne => {
          //   totale += parseFloat(ligne.totale);
          //   avance += parseFloat(ligne.avance);
          //   reste += parseFloat(ligne.reste);
          // });
          // var ligne = '';
          // ligne+=`<tr>
          //           <th></th>
          //           <th></th>
          //           <th></th>
          //           <th></th>
          //           <th>${totale.toFixed(2)}</th>
          //           <th>${avance.toFixed(2)}</th>
          //           <th>${reste.toFixed(2)}</th>
          //           <th></th>
          //           <th></th>
          //           <th></th>
          //         </tr>`;
          // table.find('tfoot').append(ligne);
          // ------------------------------------------------
          calculs();
          getTfoot();
      },
      error:function(){
        console.log([]);    
      }
    });
  }
</script>
<!-- ##################################################################### -->
@endsection


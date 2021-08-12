@extends('layout.dashboard')
@section('contenu')
<!-- ##################################################################### -->
<div class="container">
  <p id="ptest">vide</p>
  <button id="btest">test</button>
  <!-- Begin Commande_Client  -->
  <div class="card text-left">
    <img class="card-img-top" src="holder.js/100px180/" alt="">
    <div class="card-body">
      <h4 class="card-title">Ajout d'un nouveau commande :</h4>
      <div class="card-text">
        <!-- <form id="commandeForm"> -->
            <!-- @csrf -->
            <div class="form-row">
              <div class="col-3">
                <input type="date" 
                class="form-control" 
                name="date" 
                id="date" 
                value="{{old('date',$commande->date)}}"
                placeholder="date">
              </div>
              <div class="col-3">     
                <select class="form-control" name="client" id="client">
                @foreach($clients as $client)
                <option value="{{$client->id}}" @if ($client->id == old('client_id',$commande->client_id)) selected="selected" @endif>{{ $client->nom_client}}</option>
                @endforeach
                </select>
              </div>
              <div class="col-3">
                <input type="text" class="form-control" name="oeil_gauche" id="gauche" placeholder="oeil_gauche" value="{{old('oeil_gauche',$commande->oeil_gauche ?? null)}}">
              </div>
              <div class="col-3">
                <input type="text" class="form-control" name="oeil_droite" id="droite" placeholder="oeil_droite" value="{{old('oeil_droite',$commande->oeil_droite ?? null)}}">
              </div>
            </div>
            <!-- <button type="submit" class="btn btn-success">Submit</button> -->
        <!-- </form> -->
      </div>
    </div>
  </div>
  <!-- End Commande_Client  -->
  <!-- Begin Category_Product  -->
  <div class="card text-left">
    <img class="card-img-top" src="holder.js/100px180/" alt="">
    <div class="card-body">
      <h4 class="card-title">Choisir un produit :</h4>
      <div class="card-text">
        <div class="form-row">
          <div class="col-6">
            <select class="form-control" id="category">
              <option value="0" disabled="true" selected="true">-Select-</option>
              @foreach($categories as $cat)
                <option value="{{$cat->id}}">{{$cat->nom_categorie}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-6">
            <select class="form-control" id="product">
              <option value="0" disabled="true" selected="true">-Product-</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Category_Product  -->
  <!-- Begin Infos_product  -->
  <div class="card text-left">
    <img class="card-img-top" src="holder.js/100px180/" alt="">
    <div class="card-body">
      <h4 class="card-title">Les informations de produit :</h4>
      <input type="hidden" name="prod_id" id="prod_id">
      <div class="card-text">
        <div class="form-row">
          <div class="col-3">
            <label for="nom">Nom :</label>
            <input type="text" class="form-control" name="libelle" id="libelle" placeholder="nom de produit" disabled>
          </div>
          <div class="col-3">
            <label for="prix">prix :</label>
            <input type="number" class="form-control" name="prix" id="prix" value="0.00" min="0">
          </div>
          <div class="col-3">
            <label for="qte">Qté :</label>
            <input type="number" class="form-control" name="qte" id="qte" value="1" min="1">
          </div>
          <div class="col-3">
            <label for="total">Total :</label>
            <input type="text" class="form-control" name="total" id="total" value="0.00" disabled>
          </div>
        </div>
        <br>
        <button class='btn btn-success' id="addLigne">Add Ligne</button>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <button class='btn btn-warning' id="updateLigne">Update</button>
      </div>
    </div>
  </div>
  <!-- End Infos_product  -->
  <!-- Begin LigneCommande  -->
  <div class="card text-left">
    <img class="card-img-top" src="holder.js/100px180/" alt="">
    <div class="card-body">
      <h4 class="card-title">Les Ligne des commandes :</h4>
      <div class="card-text">
        <table class="table" id="lignes">
          <thead>
            <tr>
              <th>#</th>
              <th>Libelle</th>
              <th>Prix</th>
              <th>Qté</th>
              <th>Total</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
            <tr>
              <th></th>
              <th></th>
              <th></th>
              <th>Total a payer</th>
              <th id="somme">0.00</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
  <!-- End LigneCommande  -->
  <!-- Begin Reglement  -->
  <!-- <div class="card text-left">
    <img class="card-img-top" src="holder.js/100px180/" alt="">
    <div class="card-body">
      <h4 class="card-title">Reglement :</h4>
      <input type="hidden" name="prod_id" id="prod_id">
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
            <input type="number" id="avance" name="avance" min="0" class="form-control" placeholder="0.00">
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
  </div>   -->
    <div class="card text-left">
    <img class="card-img-top" src="holder.js/100px180/" alt="">
    <div class="card-body">
      <h4 class="card-title">Les règlements :</h4>
      <div class="card-text">
        <div class="form-row">
          <div class="col-3">
              <label for="mode">Date de règlement :</label>
          </div>
          <div class="col-3">
            <label for="mode">Mode de règlement :</label>
          </div>
          <div class="col-2">
            <label for="nom">Montant payer :</label>
          </div>
          <div class="col-2">
            <label for="reste">Reste à payer :</label>
          </div>
          <div class="col-2">
            <label for="status">Status :</label>
          </div>
        </div>
        <div id="reglements">
        @foreach($commande->reglements as $reglement)
        <div class="form-row">
          <input type="hidden" value="{{$reglement->id}}">
          <input type="hidden" value="{{$reglement->reste}}">
          <div class="col-3">
            <input type="text" class="form-control" name="reg_date" placeholder="reg_date" value="{{$reglement->date}}" disabled>
          </div>
          <div class="col-3">
            <input type="text" class="form-control" name="mode" placeholder="mode" value="{{$reglement->mode_reglement}}" disabled>
          </div>
          <div class="col-2">
            <input type="text" class="form-control" name="avance" placeholder="avance" value="{{$reglement->avance}}" disabled>
          </div>
          <div class="col-2">
            <input type="text" class="form-control" name="reste"  placeholder="reste" value="{{$reglement->reste}}" disabled>
          </div>
          <div class="col-2">
            <input type="text" class="form-control" name="status"  placeholder="status" value="{{$reglement->reglement}}" disabled>
          </div>
        </div>
        <br>
        @endforeach
        </div>
      </div>
    </div>
  </div>  
  <!-- End Reglement  -->
  <button class="btn btn-secondary" id="valider">Valider Les modifications</button>
  &nbsp;&nbsp;&nbsp;&nbsp;
  <!-- <button class="btn btn-secondary" id="test">test</button> -->
</div>

<!-- ---------  BEGIN SCRIPT --------- -->
<script type="text/javascript">
  $(document).ready(function(){
    getLignes();
    // -----------Change Category--------------//
    $(document).on('change','#category',function(){
      var cat_id=$(this).val();
      var product=$('#product');
      $.ajax({
        type:'get',
        url:'{!!URL::to('productsCategory')!!}',
        data:{'id':cat_id},
        success:function(data){
          var options = '<option value="0" disabled="true" selected="true">-Product-</option>';
          for(var i=0;i<data.length;i++){
            options+=`<option value="${data[i].id}">${data[i].nom_produit} | ${data[i].prix_produit_TTC}</option>`;
          }  
          product.html("");        
          product.append(options);        
        },
        error:function(){
        }
      });
    });
    // -----------End Change Category--------------//
    // -----------Change Product--------------//
    $(document).on('change','#product',function(){
      var id=$(this).val();
      var prod_id=$('#prod_id');
      var libelle=$('#libelle');
      var qte=$('#qte');
      var prix=$('#prix');
      var total=$('#total');
      $.ajax({
        type:'get',
        url:'{!!URL::to('infosProducts')!!}',
        data:{'id':id},
        success:function(data){
          prod_id.val(data.id) ;        
          libelle.val(data.nom_produit) ;        
          prix.val(data.prix_produit_TTC);                
          total.val(data.prix_produit_TTC);   
          qte.val("1");
        },
        error:function(){
        }
      });
    });
    // -----------End Change Product--------------//
    // -----------Change Qte--------------//
    $(document).on('change','#qte',function(){
      var qte=$(this).val();
      var prix=$('#prix').val();
      var total=$('#total');
      var NQte = parseInt(qte);
      var NPrix = parseFloat(prix);
      var NTotal = NQte * NPrix;
      total.val(NTotal.toFixed(2)) ;
    });
    // -----------End Change Qte--------------//
    // -----------Begin AddLigne--------------//
    $(document).on('click','#addLigne',function(){
      var prod_id=$('#prod_id');
      var libelle=$('#libelle');
      var prix=$('#prix');
      var qte=$('#qte');
      var table=$('#lignes');
      var total=$('#total');
      var somme=$('#somme');
      if(libelle.val() == "" || prix.val() == "")
        return;
      if(check(prod_id.val())){
        changeQte(qte.val(),prod_id.val());
      }
      else{
        var ligne=`<tr>
                    <td>${prod_id.val()}</td>
                    <td>${libelle.val()}</td>
                    <td>${prix.val()}</td>
                    <td>${qte.val()}</td>
                    <td>${total.val()}</td>
                    <td>
                      <button class="btn btn-success" onclick="edit(${prod_id.val()})"><i class="fas fa-edit"></i></button>
                      &nbsp;&nbsp;&nbsp;
                      <button class="btn btn-danger" onclick="remove(${prod_id.val()})"><i class="fas fa-trash"></i></button>
                    </td>
                  </tr>`;
        table.find('tbody').append(ligne);
      }
        qte.val("1");
        total.val(prix.val());
        somme.html(calculSomme());
        // calculReste();
        calculReglement();
    });
    // -----------End AddLigne--------------//
    // -----------Begin UpdateLigne--------------//
    $(document).on('click','#updateLigne',function(){
      var prod_id=$('#prod_id');
      var libelle=$('#libelle');
      var prix=$('#prix');
      var qte=$('#qte');
      var total=$('#total');
      var table=$('#lignes');
      var somme=$('#somme');
      if(check(prod_id.val())){
        var index = checkIndex(prod_id.val());
        if(index != -1){
          var list = table.find('tbody').find('tr'); 
          list.eq(index).find('td').eq(0).html(prod_id.val());
          list.eq(index).find('td').eq(1).html(libelle.val());
          list.eq(index).find('td').eq(2).html(prix.val());
          list.eq(index).find('td').eq(3).html(qte.val());
          list.eq(index).find('td').eq(4).html(total.val());
        }
      }
      else{
        
      }
        qte.val("1");
        total.val(prix.val());
        somme.html(calculSomme());
        // calculReste();
        calculReglement();
    });
    // -----------End UpdateLigne--------------//
    // -----------keyup Prix--------------//
    $(document).on('keyup','#prix',function(){
      var prix=$(this);
      var qte=$('#qte');
      var total=$('#total');
      NTotal = parseFloat(prix.val())*parseInt(qte.val());
      total.val(NTotal.toFixed(2));
    });
    // -----------End keyup Prix--------------//
    // -----------keyup Avance--------------//
    $(document).on('keyup','#avance',function(){
      var avance=$(this);
      var NAvance = parseFloat(avance.val());
      if(NAvance > calculSomme())
        avance.val(calculSomme());
      // calculReste();
    });
    // -----------End keyup Avance--------------//
    // -----------Begin valider--------------//
    $(document).on('click','#valider',function(e){
      // var cmd_total = calculSomme();
      // var cmd_avance = calculAvances();
      // var cmd_reste = calculSomme()-calculAvances();

      // console.log(cmd_total);
      // console.log(cmd_avance);
      // console.log(cmd_reste);

      // return ;
      // e.preventDefault(); //Pour ne peut refresh la page en cas de bouton submit 
      var cmd_id = <?php echo $commande->id;?>;
      var _token=$('input[name=_token]'); //Envoi des information via method POST
      // ***** BEGIN variables commande ******** //
      var date=$('#date');
      var client=$('#client');
      var gauche=$('#gauche');
      var droite=$('#droite');
      // ***** END variables commande ******** //

      // ***** BEGIN variables lignes ******** //
      var table=$('#lignes');
      var list = table.find('tbody').find('tr');
      var array1 = [];
      for (let i = 0; i < list.length; i++) {
        var prod_id = list.eq(i).find('td').eq(0).html();
        var libelle = list.eq(i).find('td').eq(1).html();
        var prix = list.eq(i).find('td').eq(2).html();
        var qte = list.eq(i).find('td').eq(3).html();
        var total = list.eq(i).find('td').eq(4).html();
        var obj = {
              "prod_id":parseInt(prod_id),
              "libelle":libelle,
              "prix":prix,
              "qte":qte,
              "total":parseFloat(total)
            };

        array1 = [...array1,obj];
      }
      // ***** END variables lignes ******** //
      // ***** BEGIN variables reglements ******** //
      // var mode =$('#mode');
      // var avance= $('#avance');
      // var reste =$('#reste');
      // var status =$('#status');
      // ***** BEGIN variables lignes ******** //
      var reglements=$('#reglements');
      var list = reglements.find('.form-row');
      var array2 = [];
      for (let i = 0; i < list.length; i++) {
        var hidden = list.eq(i).find('input:hidden');
        var n_reg_id_hidden = parseFloat(hidden.eq(0).val());
        var row = list.eq(i).find('div');
        var reste = row.eq(3).find('input');
        nreste = parseFloat(reste.val());
        var status = row.eq(4).find('input'); 
        (nreste>0) ? txt = 'NR' : (nreste==0) ? txt = 'R' : txt = 'AV';
        var obj = {
              "reg_id":parseInt(n_reg_id_hidden),
              "reste":nreste,
              "status":txt,
            };

        array2 = [...array2,obj];
      }
      // ***** END variables reglements ******** //

      $.ajax({
        type:'post',
        url:'{!!URL::to('update2')!!}',
        data:{
          id : cmd_id,
          date : date.val(),
          client : parseInt(client.val()),
          gauche : parseFloat(gauche.val()),
          droite : parseFloat(droite.val()),
          _token : _token.val(),
          lignes : array1,
          // mode:mode.val(),
          // avance:parseFloat(avance.val()),
          // reste:parseFloat(reste.val()),
          // status:status.val(),
          reglements : array2,
          cmd_avance : calculAvances(),
          cmd_total : calculSomme(),
          cmd_reste : calculSomme()-calculAvances(),
        },
        success: function(data){
          Swal.fire(data.message);
          if(data.status == "success"){
            setTimeout(() => {
              window.location.assign("/gestioncommande")
            }, 2000);
          }
        } ,
        error:function(err){
          if(err.status === 500){
            Swal.fire(err.statusText);
          }
          else{
            Swal.fire("Erreur d'enregistrement de la commande !");
          }
        },
      });
    });
    // -----------End valider--------------//
    // -----------Click TEST--------------//
    $(document).on('click','#test',function(){
        var mode = $("#mode");
        var avance = $("#avance");
        var table=$('#lignes');
        var list = table.find('tbody').find('tr'); 
        if(list.length>0){
          avance.attr("disabled", true);
          mode.attr("disabled", true);
        }
        else{
          avance.attr("disabled", false);
          mode.attr("disabled", false);
        }
    });
    // -----------END TEST--------------//
    $(document).on('click','#btest',function(){
      n = -100;
      b = 100;
      if(-n == b)
        console.log("ok");
      else 
        console.log("ko");

      console.log(n);
    });
  });
  // -----------My function--------------//
  function remove(id){
    var i = checkIndex(id);
    var table=$('#lignes');
    var list = table.find('tbody').find('tr'); 
    list.eq(i).remove();
    var somme=$('#somme');
    somme.html(calculSomme());
    // calculReste();
    calculReglement();
  }
  function edit(id){
    var i = checkIndex(id);
    var table=$('#lignes');
    var list = table.find('tbody').find('tr'); 
    var td = list.eq(i).find('td');

    var prod_id = $('#prod_id');
    var libelle = $('#libelle');
    var prix = $('#prix');
    var qte = $('#qte');
    var total = $('#total');

    var vProd_id = td.eq(0).html();
    var vLibelle = td.eq(1).html();
    var vPrix = td.eq(2).html();
    var vQte = td.eq(3).html();
    var vTotal = td.eq(4).html();

    prod_id.val(vProd_id);
    libelle.val(vLibelle);
    prix.val(vPrix);
    qte.val(vQte);
    total.val(vTotal);
  }
  function check(id){
    var existe = false;
    var table=$('#lignes');
    var list = table.find('tbody').find('tr'); 
    for (let i = 0; i < list.length; i++) {
      var prod_id = list.eq(i).find('td').eq(0).html();
      if(prod_id == id){
        existe = true;
        break;
      }
    }
    return existe;
  }
  function checkIndex(id){
    var index = -1;
    var table=$('#lignes');
    var list = table.find('tbody').find('tr'); 
    for (let i = 0; i < list.length; i++) {
      var prod_id = list.eq(i).find('td').eq(0).html();
      if(prod_id == id){
        index = i;
        break;
      }
    }
    return index;
  }
  function changeQte(qteNew,id){
    var table=$('#lignes');
    var list = table.find('tbody').find('tr'); 
    var i = checkIndex(id);
    var prod_id = list.eq(i).find('td').eq(0).html();
    var libelle = list.eq(i).find('td').eq(1).html();
    var prix = list.eq(i).find('td').eq(2).html();
    var qte = list.eq(i).find('td').eq(3).html();
    var total = list.eq(i).find('td').eq(4).html();
    var NPrix = parseFloat(prix);
    var NQte = parseInt(qte) + parseInt(qteNew);
    var NTotal = NQte * NPrix;
    list.eq(i).find('td').eq(3).html(NQte);
    list.eq(i).find('td').eq(4).html(NTotal);
  }
  function calculSomme(){
    var table=$('#lignes');
    var list = table.find('tbody').find('tr'); 
    var somme = 0.0;
    for (let i = 0; i < list.length; i++) {
      var total = list.eq(i).find('td').eq(4).html();
      var NTotal = parseFloat(total);
      somme+=NTotal;
    }
    return somme.toFixed(2);
  }
  function calculAvances(){
    var comp = 0;
    var reglements=$('#reglements');
    var list = reglements.find('.form-row');
    for (let i = 0; i < list.length; i++) {
      var row = list.eq(i).find('div');
      var avance = row.eq(2).find('input');
      var navance = parseFloat(avance.val());
      comp += navance;
    }
    return comp.toFixed(2);
  }
  // function calculReste(){
  //   var avance=$("#avance");
  //   var reste=$('#reste');
  //   var status=$("#status");
  //   var NReste = 0;
  //   if(avance.val()){
  //     NReste = calculSomme()-parseFloat(avance.val());
  //     (NReste > 0) ? status.val("non réglée"): status.val("réglée");    
  //   }
  //   else{
  //     status.val("");
  //   }
  //   reste.val(NReste.toFixed(2));
  // }
  function getLignes(){
    var cmd_id = <?php echo $commande->id;?>;
    $.ajax({
        type:'get',
        url:'{!!URL::to('editCommande')!!}',
        data:{'id' : cmd_id},
        success: function(data){
          var lignecommandes = data.lignecommandes
          var reglement = data.reglement
          // -----------BEGIN lignes--------------//
          var table = $('#lignes');
          table.find('tbody').html("");
          var lignes = '';
          lignecommandes.forEach(ligne => {
            var prix = ligne.totale_produit/parseInt(ligne.Qantite);
            lignes+=`<tr>
                    <td>${ligne.produit_id}</td>
                    <td>${ligne.nom_produit}</td>
                    <td>${prix.toFixed(2)}</td>
                    <td>${ligne.Qantite}</td>
                    <td>${ligne.totale_produit}</td>
                    <td>
                      <button class="btn btn-success" onclick="edit(${ligne.produit_id})"><i class="fas fa-edit"></i></button>
                      &nbsp;&nbsp;&nbsp;
                      <button class="btn btn-danger" onclick="remove(${ligne.produit_id})"><i class="fas fa-trash"></i></button>
                    </td>
                  </tr>`;
          });
          table.find('tbody').append(lignes);
          var somme=$('#somme');
          somme.html(calculSomme());
          // -----------END lignes--------------//
          // -----------BEGIN Reglement--------------//
          // console.log(reglement);
          var mode=$("#mode");
          var avance=$("#avance");
          var reste=$('#reste');
          var status=$("#status");
          mode.val(reglement.mode_reglement);
          avance.val(parseFloat(reglement.avance).toFixed(2));
          reste.val(parseFloat(reglement.reste).toFixed(2));
          status.val(reglement.reglement);
          // -----------END Reglement--------------//
          calculReglement();
        } ,
        error:function(err){
            Swal.fire(err);
        },
      });
  }
  
  function calculReglement(){
    var cmd_total = <?php echo $commande->totale; ?>;
    var diff = calculSomme() - cmd_total;
    // var diff = 100;
    // $('#ptest').html(diff);
    var reglements=$('#reglements');
    var list = reglements.find('.form-row');
    for (let i = 0; i < list.length; i++) {
      var hidden = list.eq(i).find('input:hidden');
      var n_reg_id_hidden = parseFloat(hidden.eq(0).val());
      var n_reste_hidden = parseFloat(hidden.eq(1).val());
      var row = list.eq(i).find('div');
      var reste = row.eq(3).find('input');
      // -----------------------------------
      var avance = row.eq(2).find('input');
      var navance = parseFloat(avance.val());
      var n = n_reste_hidden+diff;
      (-n <= navance) ? reste.val(n): reste.val(-navance);
      // -----------------------------------
      // reste.val(n_reste_hidden+diff);
      var nreste = parseFloat(reste.val());
      var status = row.eq(4).find('input');
      (nreste>0) ? status.val('Non reglée'): (nreste==0) ? status.val('Reglée'): status.val('AVOIR');
    }
    
  }
  function ftest(){
    var p = $('#ptest');
    p.html('ok');
  }
</script>
<!-- ##################################################################### -->
@endsection


@extends('layout.dashboard')

@section('contenu')

<div class="row justify-content-center">
    <div class="col-md-10">
       
            
            
            <table class="table">
              <tr>
                <td colspan="2">
                   
                  @if(session()->has('status'))
                  <script>
                    Swal.fire('{{ session('status')}}')
                  </script>

                @endif
                </td>
                <td align="right" colspan="2">
                  <a href="{{route('commande.affiche')}}" class="btn btn-primary  ">Toutes les ventes</a>
                </td>
              </tr>
              
           </table>

            

        
        <table class="table">
          <tr>
              <th colspan="4" style="background-color:rgb(186, 206, 224); color:black; text-align:center ; font-size:21px;">ajouter commande</th>
           </tr>
       </table>
        <form  method="POST" action="{{route('commande.store')}}">
            @csrf 
            <div class="form-row">
              <div class="col">
                <input type="text" class="form-control" name="cadre" placeholder="cadre"  >
              </div>
              <div class="col">
                <input type="date" class="form-control" name="date" value={{$date}} placeholder="date"  >
              </div>
              <div class="col">
                <input type="tele" class="form-control" name="oeil_gauche" placeholder="oeil_gauche"   >
              </div>
              <div class="col">
                <input type="text" class="form-control" name="oeil_droite" placeholder="oeil_droite"   >
              </div>
              
            </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" name="mesure_vue" placeholder="mesure_vue"  >
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="mesure_visage" placeholder="mesure_visage" >
                </div>
               
                <div class="col">       
                                
                                 @include('select')
                                
                        
                </div>
                <div class="col">
                    <button class="btn btn-primary" type="submit" style="width:100px"> ajouter</button>
                   {{-- <a href="{{action('CommandeController@index')}}" class="btn btn-info"  >retour</a> --}}
                </div>
                
              </div>
          </form>&nbsp;&nbsp;&nbsp;
         
             <table class="table">
                <tr>
                    <th style="background-color:rgb(186, 206, 224); color:black; text-align:center ; font-size:21px;">ajouter lignecommande</th>
                 </tr>
             </table>
        
             <form  method="POST" action="{{route('commande.storeL')}}">
              @csrf 
          
  
                
                  <input type="text" class="form-control" name="commande_id" value="{{$lastOne->id}}"   >
            
                  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                
                {{-- ---------------- BEGIN --------------------- --}}
            
        
                <select class="productcategory form-control" id="prod_cat_id">
                
                <option value="0" disabled="true" selected="true">-Select-</option>
                @foreach($prod as $cat)
                <option value="{{$cat->id}}">{{$cat->nom_categorie}}</option>
                @endforeach
                
                </select>
           
                &nbsp;&nbsp;
          
           
                  <select  class="productname form-control" name="nom_produit">
                  
                  <option value="0" disabled="true" selected="true">Product Name</option>
                  </select>
           
          
               &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
          
             <input type="text" class="prod_price form-control" id="prod_price" name="prod_price" placeholder="prix_unutaire">
         
  
             &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
        
          
          <input type="text" class="prod_id form-control" id="prod_id" name="prod_id" placeholder="produit_id">
  
          &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
          
          <input type="text" class="prod_TVA form-control" id="prod_TVA" name="prod_TVA" placeholder="TVA">
          
          {{-- </div> --}}
          <script type="text/javascript">
            $(document).ready(function(){
          
              $(document).on('change','.productcategory',function(){
                // console.log("hmm its change");
          
                var cat_id=$(this).val();
                // console.log(cat_id);
                var div=$(this).parent();
          
                var op=" ";
          
                $.ajax({
                  type:'get',
                  url:'{!!URL::to('findProductName')!!}',
                  data:{'id':cat_id},
                  success:function(data){
                    // console.log('success');
          
                    // console.log(data);
          
                    // console.log(data.length);
                    op+='<option value="0" selected disabled>chose product</option>';
                    for(var i=0;i<data.length;i++){
                    op+='<option value="'+data[i].id+'">'+data[i].nom_produit+'</option>';
                     }
          
                     div.find('.productname').html(" ");
                     div.find('.productname').append(op);
                  },
                  error:function(){
          
                  }
                });
              });
          
              $(document).on('change','.productname',function () {
                var prod_id=$(this).val();
          
                var a=$(this).parent();
                // console.log(prod_id);
                var op="";
                $.ajax({
                  type:'get',
                  url:'{!!URL::to('findPrice')!!}',
                  data:{'id':prod_id},
                  dataType:'json',//return data will be json
                  success:function(data){
                    // console.log("price");
                    console.log(data);
                    // console.log(data.prix_produit_HT);
          
                    // here price is coloumn name in products table data.coln name
          
                    a.find('.prod_price').val(data.prix_produit_HT);
                    a.find('.prod_TVA').val(data.TVA);
                    a.find('.prod_id').val(data.id);
  
          
                  },
                  error:function(){
          
                  }
                });
          
          
              });
          
            });
          </script>
  
                {{-- -----------------END -------------------- --}}
  
                &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                <div class="form-row">  
                  <div class="col">
                    <input type="text" class="form-control" id="quantite" name="quantite" placeholder="quantite" onchange="calculTotal() "   >
                  </div>
    
                  <div class="col">
                  <input  type="text" class="form-control" id="amount" name="amount" readonly  placeholder="Prix_TTC"> 
                  </div>
    
                  <div class="col">
                    <button class="btn btn-primary" type="submit" style="width: 100px">Ajouter</button>
                   </div>
              </div>    
                &nbsp;&nbsp;
                
              </form>
    </div>
</div>


<div class="row justify-content-center">
  <div class="col-md-10">
      <div class="row">
         


      </div>
      <div class="card" style="background-color: rgba(226, 224, 224, 0.842);">
          <div class="card-body">
              <table class="table table-hover" id="tabledit">
                  <thead>
                      <tr>
                          <th scope="col">#id</th>
                          
                          <th scope="col"> idcommande</th>
                          <th scope="col"> Nom produit</th>
                          <th scope="col"> quantite </th>

                          <th scope="col">Prix_TTC</th>
                          <th scope="col">Action</th>
                          
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($lignecommandes as $lignecommande)
                        <tr>
                            <th scope="row" >{{$lignecommande->id }}</th>
                            
                            <td>{{$lignecommande->commande_id}}</td>
                            <td>{{$lignecommande->nom_produit}}</td>
                            <td>{{$lignecommande->Qantite}}</td>
                            <td>{{$lignecommande->totale_produit}}</td>
                            <td>
                                 <a href="{{ action('LignecommandeController@show',['lignecommande'=> $lignecommande])}}" class="btn btn-secondary btn-md"><i class="fas fa-info"></i></a>
                                 @if( Auth::user()->is_admin )
                                 <a href="{{route('lgcommande.editL',['lignecommande'=> $lignecommande])}}"class="btn btn-success btn-md"><i class="fas fa-edit"></i></a>
                              <button class="btn btn-danger btn-flat btn-md remove-lignecommande" 
                              data-id="{{ $lignecommande->id }}" 
                              data-action="{{ route('lignecommande.destroy',$lignecommande->id) }}"> 
                              <i class="fas fa-trash"></i>
                             </button>
                             @endif

                           </td>
                       </tr>
                     @endforeach
                 </tbody>
             </table>
         </div>
<script type="text/javascript">
 
 
 $("body").on("click",".remove-lignecommande",function(){
     var current_object = $(this);
     
     Swal.fire({
         title: 'Un lignecommande est sur le point de être DÉTRUITE ',
         text: "vous voulez vraiment la supprimer !",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'oui, je suis sur!'
         }).then((result) => {
         if (result.isConfirmed) {
             // begin destroy
                 var action = current_object.attr('data-action');
                 var token = jQuery('meta[name="csrf-token"]').attr('content');
                 var id = current_object.attr('data-id');
                 $('body').html("<form class='form-inline remove-form' method='post' action='"+action+"'></form>");
                 $('body').find('.remove-form').append('<input name="_method" type="hidden" value="delete">');
                 $('body').find('.remove-form').append('<input name="_token" type="hidden" value="'+token+'">');
                 $('body').find('.remove-form').append('<input name="id" type="hidden" value="'+id+'">');
                 $('body').find('.remove-form').submit();
             //end destroy
            //  Swal.fire(
            //  'Deleted!',
            //  'Your file has been deleted.',
            //  'success'
            //  )
         }
         })
     // end swal2
     });
         </script>
     </div>
     {{ $lignecommandes->links()}}
 
      &nbsp;&nbsp;&nbsp;&nbsp;
{{--      
     <span><strong>Prix_totale</strong></span>
      <input type="text" class="form-control" name="prix-totale" id="prix-totale" readonly placeholder="prix_Totale" value="{{ $priceTotal}}">   --}}

     <table class="table">
      
       <tr>
         <td>
          <input type="text" style="width: 500px" id="prix-totale" class="form-control" name="prix-totale" placeholder="prix-totale" value="{{ $priceTotal}}">
         </td>
         <td  >
          
          
          <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus">réglement du client</i></button>
         </td>  
         <td >
          {{-- <button type="button" class="btn btn-info btn-lg"><i class="fa fa-plus">génerer Facture</i></button> --}}
          <a href="{{route('commande.facture')}}" class="btn btn-info btn-lg  "  ><i class="fa fa-plus">Voir Facture</i></a>
         </td>       
      </tr>
     </table>

     
     <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <form method="POST" action="{{route('commande.storeLR')}}">
            @csrf 

          <div class="modal-header" style="background_color:rgb(150, 243, 228);">
            
            <h4 class="modal-title" >Réglement client</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="card-body">
              <input type="text" name='commande_id' class="form-control" placeholder="Id commande" value="{{$lastOne->id}}">&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="text" name='nom_client' class="form-control" placeholder="Nom Client" value="{{$lastOne->nom_client}}">&nbsp;&nbsp;&nbsp;&nbsp;
              <select class="form-control" name='mode_reglement' placeholder="mode reglement"> 

                  <option value="chèque">chèque</option>
                  <option value="carte banquaire">carte banquaire</option>
                  
                  
              </select>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <input type="text" id="avc" name="avc" class="form-control" placeholder="avance" onchange="calculTotal() ">&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="text" id="rst" name="rst" class="form-control" placeholder="reste" onclick="calculTotal() " >&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="date" name="date"  class="form-control" value={{$date}} placeholder="date">&nbsp;&nbsp;&nbsp;&nbsp;

              <!-- <select class="form-control" name="reglement" placeholder="reglement"> 

                <option value="client réglé">client réglé</option>
                <option value="non réglé">non réglé</option>
                
                
            </select> -->
            
            <input type="text" name="reglement" id="reglement"  class="form-control"  placeholder="reglement">&nbsp;&nbsp;&nbsp;&nbsp;
          </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-info" type="submit">Ajouter</button>
          </div>
          </form>
        </div>
        
      </div>
    </div>

    {{-- <div class="modal fade" id="my" role="dialog">
      <div class="modal-dialog">
      
        
        <div class="modal-content">
          <form method="POST" action="#">
            @csrf 

          <div class="modal-header" style="background_color:rgb(150, 243, 228);">
            
            <h4 class="modal-title" >Modifier LignCommande</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="card-body">
              <input type="text" name='commande_id' class="form-control" placeholder="Id commande" value="{{ old('commande_id ', $lignecommande->commande_id ?? null) }}"  >&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="text" name='produit_id' class="form-control" placeholder="Id produit" value="{{ old('produit_id', $lignecommande->produit_id ?? null) }}" >&nbsp;&nbsp;&nbsp;&nbsp;
              
              <input type="quantite" name="quantite"  class="form-control" placeholder="quantite" value="{{ old('quantite ', $lignecommande->Qantite ?? null) }}">&nbsp;&nbsp;&nbsp;&nbsp;
              
          </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-info" type="submit">modifier</button>
          </div>
          </form>
        </div>
        
      </div>
    </div> --}}
    
    
  </div>



  </div>

</div>

<script>
  function dataview(){
    $.ajax({

      url:'process.php?p=view',
      method: 'GET'
    }).done(function(data){
      $('tbody').html(data)
      DataTable()
    })
  }
  function DataTable(){
    $('#tabledit').Tabledit({
    url: 'process.php',
    eventType: 'dblclick',
    editButton: false,
    columns: {
        identifier: [0, 'id'],
        editable: [[1, 'car'], [2, 'color', '{"1": "Red", "2": "Green", "3": "Blue"}']]
    }
  });
  }
</script>

@endsection


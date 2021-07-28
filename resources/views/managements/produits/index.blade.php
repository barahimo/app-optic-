@extends('layout.dashboard')

@section('contenu')

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-3">
                <h4>Managements Produits</h4>

            </div>
           

            <div class="col-md-9 text-right">
                <a href="{{route('produit.create')}}" class="btn btn-primary m-b-10 "><i class="fa fa-plus">Nouveau Produit</i></a>
                <a href="{{route('categorie.index')}}" class="btn btn-primary m-b-10  "><i class="far fa-eye">voir tous les catégories</i></a>  
               </div>
            
                    @if(session()->has('status'))
                    <script>
                        Swal.fire('{{ session('status')}}')
                      </script>
  
                    @endif
                  
            <table class="table">
                    
                <tr>
                  <td scope="col">


                      @include('partials.searchproduit')

                  </td>
                  
                </tr>
              
            </table>

        </div>
        <div class="card" style="background-color: rgba(241, 241, 241, 0.842)">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>nom produit</th>
                            <th> code produit</th>
                            {{-- <th> TVA</th>
                            <th> prix_produit_HT</th>
                            <th>descreption</th> --}}
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
                              {{-- <td>{{$produit->TVA}}</td>
                              <td>{{$produit->prix_produit_HT}}</td>
                              <td>{{$produit->descreption}}</td> --}}
                              <td>{{$produit->nom_categorie}}</td>

                              <td>
                                 

                                 
                                  <a href="{{ action('ProduitController@show',['produit'=> $produit])}}" class="btn btn-secondary btn-md"><i class="fas fa-info"></i></a>
                                  @if( Auth::user()->is_admin )
                                  <a href="{{route('produit.edit',['produit'=> $produit])}}"class="btn btn-success btn-md"><i class="fas fa-edit"></i></a>
                                  <button class="btn btn-danger btn-flat btn-md remove-produit" 
                                  data-id="{{ $produit->id }}" 
                                  data-action="{{ route('produit.destroy',$produit->id) }}"> 
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
   
   
   $("body").on("click",".remove-produit",function(){
       var current_object = $(this);
       
       Swal.fire({
           title: 'Un produit est sur le point de être DÉTRUITE ',
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
            //    Swal.fire(
            //    'Deleted!',
            //    'Your file has been deleted.',
            //    'success'
            //    )
           }
           })
       // end swal2
       });
           </script>
       </div>
       {{ $produits->links()}}
       </div>
      
      
     
</div>

@endsection




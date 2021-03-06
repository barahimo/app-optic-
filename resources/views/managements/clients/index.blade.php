

 @extends('layout.dashboard')

@section('contenu')

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-3">
                <h4>Managements Clients</h4>

            </div>
           
          



            <div class="col-md-9 text-right">
                <a href="{{route('client.create')}}" class="btn btn-primary m-b-10 "><i class="fa fa-user-plus"> Nouveau Client</i></a>
            </div> 

                    @if(session('status'))
                   
                    {{-- <div class="alert  alert-success "> 
                        {{ session()->get('status')}}
                    </div> --}}
                    <script>
                        Swal.fire('{{ session('status')}}')
                      </script>
                    @endif
               
            
    
                

                  <table class="table">
                    
                      <tr>
                        <td scope="col">


                            @include('partials.search')

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
                            <th>Code Client</th>
                                <th>nom Client</th>
                            <th> Adresse</th>
                            <th> Telephone</th>
                           
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                        $i = 0 ;
                        @endphp
                        @foreach($clients as $client)
                          <tr>
                            <td>{{++$i}}</td>
                            <td>{{$client->code}}</td>
                              <td>{{$client->nom_client}}</td>
                              <td>{{$client->adresse}}</td>
                              <td>{{$client->telephone}}</td>
                             

                              <td>
                                 

                                 
                                  <a href="{{ action('ClientController@show',['client'=> $client])}}" class="btn btn-secondary btn-md"><i class="fas fa-info"></i></a>
                                @if( Auth::user()->is_admin )
                                  <a href="{{route('client.edit',['client'=> $client])}}"class="btn btn-success btn-md"><i class="fas fa-edit"></i></a>
                                  <button class="btn btn-danger btn-flat btn-md remove-client" 
                                  data-id="{{ $client->id }}" 
                                  data-action="{{ route('client.destroy',$client->id) }}"> 
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
    
    
    $("body").on("click",".remove-client",function(){
        var current_object = $(this);
        // begin swal1
        // swal({
        //     title: "Are you sure?",
        //     text: "Once deleted, you will not be able to recover this imaginary file!",
        //     icon: "warning",
        //     buttons: true,
        //     dangerMode: true,
        //     })
        //     .then((willDelete) => {
        //     if (willDelete) {
        //         //begin destroy
        //             var action = current_object.attr('data-action');
        //             var token = jQuery('meta[name="csrf-token"]').attr('content');
        //             var id = current_object.attr('data-id');
        //             $('body').html("<form class='form-inline remove-form' method='post' action='"+action+"'></form>");
        //             $('body').find('.remove-form').append('<input name="_method" type="hidden" value="delete">');
        //             $('body').find('.remove-form').append('<input name="_token" type="hidden" value="'+token+'">');
        //             $('body').find('.remove-form').append('<input name="id" type="hidden" value="'+id+'">');
        //             $('body').find('.remove-form').submit();
        //         //end destroy
        //         swal("Poof! Your imaginary file has been deleted!", {
        //         icon: "success",
        //         });
        //     } 
        // });
        // end swal1
        // begin swal2
        Swal.fire({
            title: 'Un client est sur le point de ??tre D??TRUITE ',
            text: "est ce que vous etes sur !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
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
                // Swal.fire(
                // 'Deleted!',
                // 'Your file has been deleted.',
                // 'success'
                // )
            }
            })
        // end swal2
        });
            </script>
        </div>
        {{ $clients->links()}}
        </div>
       
       
      
</div>

@endsection



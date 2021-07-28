<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    {{-- monstyle --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <title>Document</title>
    <style>
    :root{
        --main-color: #027581;
        --color-dark:  #1D2231;
        --text-grey: #8390A2;
    }

    * {
         font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
         margin: 0;
         padding: 0;
         text-decoration: none;
         list-style-type : none;
         box-sizing : border-box;
     }
     

     #sidebar-toggle {
            display: none;
        }

     .sidebar {

         height: 100%;
         width: 240px;
         position: fixed;
         left: 0;
         top:0;
         z-index: 100;
         background: var(--main-color);
         color:#fff;
         overflow-y: auto;
  }
      .sidebar-header {
          display: flex ;
          justify-content:space-between;
          align-items: center;
          height: 60px;
          padding: auto;
          margin: auto;
      }

      /* .brand{
          padding: auto;
          margin: auto;
      } */

      .sidebar-menu{
          padding: 1rem;
      }
      .sidebar li {
          margin-bottom: 2rem;
      }
      .sidebar a {
          color: #fff;
          font-size: 1.2rem; 
      }
      .sidebar  a span:last-child {

        padding-left: .5rem;

        }
        #sidebar-toggle:checked ~ .sidebar{
            width:5%;
        }

        #sidebar-toggle:checked ~ .sidebar .sidebar-header h3 span:last-child,
        #sidebar-toggle:checked ~ .sidebar li span:last-child
        {
            display: none;
        }

        

       
        /* style formulaire */


    </style>


</head>
<body>


    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar">
        <div class="sidebar-header">
         <h3 class="brand">
            <span class="ti-unlink"></span>
            <span>Gestion-Optic </span>
         </h3>
         <label for="sidebar-toggle" class="ti-menu-alt"></label>
           
        </div>

        <div class="sidebar-menu">
            <ul>
                <li>   
                    <a href="{{ route('app.home')}}">
                        <span class="ti-home"></span>
                        <span>Home</span>
                     </a>
                </li>
                <li>   
                    <a href="{{ route('client.index')}}">
                        <span ><i class="fas fa-users"></i></span>
                        <span>Clients</span>
                     </a>
                </li>
                @if( Auth::user()->is_admin )
                <li>   
                    <a href="{{ route('commande.index')}}">
                        <span ><i class="fab fa-shopify"></i></span>
                        <span>Commandes</span>
                     </a>
                </li>
                <li>   
                    <a href="{{ route('produit.index')}}">
                        <span ><i class="fab fa-product-hunt"></i></span>
                        <span>Produits</span>
                       
                     </a>
                </li>
                <li>   
                    <a href="{{ route('categorie.index')}}">
                        <span class="ti-folder"></span>
                        <span>Catégories</span>
                     </a>
                </li>
               
                <li>   
                    <a href="{{ route('facture.index')}}"">
                        <span ><i class="fas fa-money-check-alt"></i></span>
                        <span>Factures</span>
                        
                     </a>
                </li>
                <li>   
                    <a href="{{ route('reglement.index')}}">
                        <span ><i class="fab fa-cc-amazon-pay"></i></span>
                        <span> Règlement</span>
                     </a>
                </li>
               @endif

            </ul>
        </div>
    </div>




    <div class="main-content">
        
        <main id="hadi"  class="py-4">
            {{-- <div class="dash-image">
            <img class="image" src="https://krys-krys-storage.omn.proximis.com/Imagestorage/images/2560/1600/602a299825ad8_Header_G_n_rique_Optique_v2.jpg" >
            </div> --}}
            <div  class="container">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6 transparence">
                        <h1 class="text-center">Modifier Commande</h1>

                        <form  method="POST" action="{{route('commande.update',['commande'=> $commande])}}">
                            @csrf 
                            
                            @method('PUT')
                            

                        <label class="label col-md-9 control-label">Cadre :</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="cadre" placeholder="cadre" value="{{ old('cadre', $commande->cadre?? null) }}"  >
                        </div>

                        <label class="label col-md-9 control-label">Date :</label>
                        <div class="col-md-12">
                            <input type="hidden" class="form-control" name="date" placeholder="date" value="{{ old('date', $commande->date ?? null) }}"  >
                        </div>
                       
                        <label class="label col-md-9 control-label">Oeil_gauche :</label>
                        <div class="col-md-12">
                            <input type="tele" class="form-control" name="oeil_gauche" placeholder="oeil_gauche"  value="{{ old('oeil_gauche', $commande->oeil_gauche ?? null) }}"  >
                        </div>
                        
                        <label class="label col-md-9 control-label">Oeil_droite :</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="oeil_droite" placeholder="oeil_droite"  value="{{ old('oeil_droite', $commande->oeil_droite ?? null) }}"  >
                        </div>
                        <label class="label col-md-9 control-label">mesure de vue  :</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="mesure_vue" placeholder="mesure_vue"  value="{{ old('mesure_vue', $commande->avance ?? null) }}"  >
                       
                        </div>
                        <label class="label col-md-9 control-label">mesure visage :</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="mesure_visage" placeholder="mesure_visage "  value="{{ old('mesure_visage ', $commande->reste ?? null) }}"  >
                        </div>

                        <label class="label col-md-9 control-label">nom_client :</label>
                        <div class="col-md-12">
                            
                            
                            <input type="text" class="form-control" name="nom_client" placeholder="nom_client " readonly value="{{ old('nom_client ', $commande->nom_client ?? null) }}"  >
                        </div>
                        
                    

                        
                        <div class="col-md-12">
                        <button class="btn btn-info" type="submit">modifier</button>  
                        <a href="{{action('CommandeController@index')}}" class="btn btn-info"  >retour</a>
                        </div>
                    </form>

                    </div>
                    {{-- <div class="col-md-3"></div> --}}
                </div>
             </div>
            
        </main>
    </div>
</body>
</html>


   
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
                        <span>Cat??gories</span>
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
                        <span> R??glement</span>
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
                        <h1 class="text-center">Formulaire Categorie</h1>

                        <form  method="POST" action="{{route('categorie.update',['categorie'=> $categorie])}}">
                            @csrf 
                            @method('PUT')

                            <label class="label col-md-9 control-label">Nom Categorie :</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="nom_categorie" placeholder="nom categorie"  value="{{ old('nom_categorie', $categorie->nom_categorie ?? null) }}">
                            </div>
    
                            <label class="label col-md-9 control-label">Descreption :</label>
                            <div class="col-md-12">
                                <textarea class="form-control" name="descreption" placeholder="descreption"  value="{{ old('descreption', $categorie->descreption ?? null) }}"></textarea>
                            </div>

                        {{-- <label class="label col-md-9 control-label">Code client:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="solde" placeholder="codes">
                        </div> --}}
                        
                        <div class="col-md-12">
                        <button class="btn btn-info" type="submit">modifier</button>  
                        <a href="{{action('CategorieController@index')}}" class="btn btn-info"  >retour</a>
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


   
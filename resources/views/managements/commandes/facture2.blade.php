<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->  
    {{-- <script src="{{ asset('js/sweetalert2.min.js') }}" defer></script> --}}
    <script src="{{asset('js/sweetalert2.min.js')}}"></script> 
    <link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/dash.js') }}" defer></script>
    <script src="{{ asset('js/test.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/style.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/searchstyle.css') }}" rel="stylesheet">
    {{-- monstyle --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <title>Document</title>
    <!-- My Styles -->
    <style>
        .table th, .table td { 
            border-top: none ;
            border-bottom: none ;
        }
    </style>
</head>
<body>
    <div class="align-center" style="display: flex;align-items: center;justify-content: center;">
        <div style="width : 90%;">
            <div class="card" style="background-color: rgba(255, 249, 249, 0.842); width:100%; margin-top:20px">
                <div class="card-body">
                    <table class="table table-hover" border="0" style="border: 0px solid red">
                        <thead>
                            <tr>
                                <td colspan="5" class="text-left">
                                    <img src="{{asset('images/logo.jpg')}}" alt="" style="width:120px">
                                </td>
                                <td colspan="2" class="text-left">
                                    Code client: {{$commande->client->code}} <br>  
                                    Nom Client : {{$commande->client->nom_client}} <br>
                                    T??l??phone : {{$commande->client->telephone}} <br>  
                                    Adresse : {{$commande->client->adresse}} <br>  
                                    Date facture : {{$date}} <br>   
                                </td>
                            </tr>
                            <tr >
                                <th colspan="7" style="text-align:center; background-color:rgb(235, 233, 233); font-size:20px">
                                    Facture N?? : {{$code}}
                                </th>
                            </tr>
                            <tr>
                                <th style="width:10%" class="text-center border">R??f.</th>
                                <th style="width:45%" class="text-center border">D??signation</th>
                                <th style="width:5%" class="text-center border">Qt??</th>
                                <th style="width:10%" class="text-center border">PU. HT</th>
                                <th style="width:5%" class="text-center border">TVA</th>
                                <th style="width:14%" class="text-center border">MT. HT</th>
                                <th style="width:15%" class="text-center border">MT. TTC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $TTC = 0;
                                $HT = 0;
                            @endphp
                            @foreach($lignecommandes as $lignecommande)
                            @php 
                                $montant_HT = $lignecommande->totale_produit / (1 + $lignecommande->produit->TVA/100);
                                $prix_unit_HT = $montant_HT / $lignecommande->Qantite;
                                $HT += $montant_HT;
                                $TTC += $lignecommande->totale_produit;
                            @endphp
                            <tr>
                                <td style="width:10%" class="text-left border">{{$lignecommande->produit->code_produit}}</td>
                                <td style="width:45%" class="text-left border">{{$lignecommande->nom_produit}}</td>
                                <td style="width:5%" class="text-center border">{{$lignecommande->Qantite}}</td>
                                <td style="width:10%" class="text-right border">{{number_format($prix_unit_HT,2)}}</td>
                                <td style="width:5%" class="text-center border">{{$lignecommande->produit->TVA}}</td>
                                <td style="width:10%" class="text-right border">{{number_format($montant_HT,2)}}</td>
                                <td style="width:15%" class="text-right border">{{$lignecommande->totale_produit}}</td>
                            </tr>
                            @endforeach
                            @php 
                            $TVA = $TTC - $HT;
                            @endphp
                            <tr>
                                <td colspan="4" style="border-bottom: none !important"></td>
                                <th colspan="2" class="text-right border">Totale HT :</th>
                                <td colspan="1" class="text-right border">{{number_format($HT,2)}} DH</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="border-bottom: 0px solid red"></td>
                                <th colspan="2" class="text-right border">TVA :</th>
                                <td colspan="1" class="text-right border">{{number_format($TVA,2)}} DH</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="border-bottom: none !important"></td>
                                <th colspan="2" class="text-right border">Totale TTC :</th>
                                <td colspan="1" class="text-right border">{{number_format($TTC,2)}} DH</td>
                            </tr>
                            <tr style="height: 10px">
                                <td colspan="7" class="text-center" style="text-align:center; background-color:rgb(235, 233, 233)">
                                    <address>
                                        Si??ge social : ITIC SOLUTION -3 ,immeuble Karoum, Av Alkhansaa, Cit?? Azmani-83350 OULED TEIMA, Maroc<br>
                                        T??l??phone : 085785435457890 -https://itic-solution.com/ -Contact@itic-solution.com <br>
                                        I.F. :4737443330 - ICE: 002656767875765788978
                                    </address>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <form  method="POST" action="{{route('facture.store2')}}">
                            @csrf 
                            <input type="hidden" name="commande_id" value="{{$commande->id}}">
                            <input type="hidden" name="date" value="{{$date}}">
                            <input type="hidden" name="code" value="{{$code}}">
                            <input type="hidden" name="totale_HT" value="{{$prix_HT}}">
                            <input type="hidden"  name="totale_TVA" value="{{$TVA}}">
                            <input type="hidden" name="totale_TTC"  value="{{$priceTotal}}" >
                            <input type="hidden" name="reglement" value="?? raception">
                            <input type="submit" class="btn btn-info bnt-lg" value="Valider">
                        </form>
                    </div>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    <hr>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
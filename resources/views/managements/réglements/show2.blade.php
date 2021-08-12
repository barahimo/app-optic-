<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>REG n° : {{$reglement->code}}</title>
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
                            <tr >
                                <th colspan="4" style="text-align:center; background-color:rgb(235, 233, 233); font-size:20px">
                                    RECEPISSE DE REGLEMENT
                                </th>
                            </tr>
                            <tr>
                                <th style="width:25%"></th>
                                <th style="width:50%" class="text-center" colspan="2">
                                    Reçu n° : REG-{{$reglement->code}}
                                </th>
                                <th class="text-right" style="width:25%">
                                    @php
                                    $time = strtotime($reglement->date);
                                    $date = date('d/m/Y',$time);
                                    @endphp
                                    Le, {{$date}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width:25%" class="text-right border">Code client:</td>
                                <td style="width:25%" class="text-left border">{{$reglement->commande->client->code}}</td>
                                <td style="width:25%" class="text-right border">Commande :</td>
                                <td style="width:25%" class="text-left border">BON-{{$reglement->commande->code}}</td>
                            </tr>
                            <tr>
                                <td style="width:25%" class="text-right border">Nom client :</td>
                                <td style="width:25%" class="text-left border">{{$reglement->commande->client->nom_client}}</td>
                                <td style="width:25%" class="text-right border">Montant total en dh : </td>
                                <td style="width:25%" class="text-left border">{{$reglement->commande->totale}} </td>
                            </tr>
                            <tr>
                                <td style="width:25%" class="text-right border">Adresse : </td>
                                <td style="width:25%" class="text-left border">{{$reglement->commande->client->adresse}}</td>
                                <td style="width:25%" class="text-right border">Montant payer en dh : </td>
                                <td style="width:25%" class="text-left border">{{$reglement->avance}}</td>
                            </tr>
                            <tr>
                                <td style="width:25%"></td>
                                <td style="width:25%"></td>
                                <td style="width:25%" class="text-right border">Reste à payer en dh : </td>
                                <td style="width:25%" class="text-left border">{{$reglement->reste}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr style="height: 10px">
                                <td colspan="4" class="text-center" style="text-align:center; background-color:rgb(235, 233, 233)">
                                    <address>
                                        Siège social : ITIC SOLUTION -3 ,immeuble Karoum, Av Alkhansaa, Cité Azmani-83350 OULED TEIMA, Maroc<br>
                                        Téléphone : 085785435457890 -https://itic-solution.com/ -Contact@itic-solution.com <br>
                                        I.F. :4737443330 - ICE: 002656767875765788978
                                    </address>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="text-center">
                        <button class="btn btn-info bnt-lg"  onclick="window.print()">Imprimer</button>
                    </div>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <script type="application/javascript">
      test();
      function test(){
        // console.log('test : '+$('input').eq(1).val());
        // console.log('test : '+$('input').eq(2).val());
      }
    </script>
</body>
</html>
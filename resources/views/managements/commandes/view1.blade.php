<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BON n° : {{$commande->code}}</title>
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
            padding-top: 4px; 
            padding-bottom: 4px;
        }
        #content{
            width: 550px;
            height: 800px;
            margin-left: auto;
            margin-right: auto;
            font-size:12px;
            /* border : 1px solid black;  */
            /* background-color : yellow; */
        }
    </style>
</head>
<body>
<br>
    <!-- #########################################################" -->
    <div class="container">
        <div class="row">
            <div class="col-10">
                <div id="content">
                    <div class="align-center" style="display: flex;align-items: center;justify-content: center;">
                        <div class="card" style="background-color: rgba(255, 249, 249, 0.842); width:100%; margin-top:20px;border : 0px solid black">
                            <div class="card-body">
                                <table class="table table-hover" border="0" style="border: 0px solid red">
                                    <thead>
                                        <tr>
                                            <td colspan="2" class="text-left">
                                                <!-- <img src="{{asset('images/logo.jpg')}}" alt="Logo" style="width:80px" class="border rounded-circle"> -->
                                                @if($company && ($company->logo || $company->logo != null))
                                                    <img src="{{Storage::url($company->logo ?? null)}}"  alt="logo" style="width:80px;height:80px" class="img-fluid">
                                                @else
                                                    <img src="{{asset('images/image.png')}}" alt="Logo" style="width:120px">
                                                @endif
                                            </td>
                                            <td colspan="3" class="text-left">
                                                Code client: {{$commande->client->code}} <br>  
                                                Nom client : {{$commande->client->nom_client}} <br>
                                                Télèphone : {{$commande->client->telephone}} <br>  
                                                Adresse : {{$commande->client->adresse}} <br>  
                                                @php
                                                    $time = strtotime($commande->date);
                                                    $date = date('d/m/Y',$time);
                                                @endphp
                                                Date commande : {{$date}}<br>   
                                            </td>
                                        </tr>
                                        <tr >
                                            <th colspan="5" style="text-align:center; background-color:rgb(235, 233, 233);">
                                                BON n° : {{$commande->code}}
                                            </th>
                                        </tr>
                                        <tr style="height:10px"></tr>
                                        <tr style="font-size:8px ;padding : 0">
                                            <th style="width:10%" class="text-center border">Réf.</th>
                                            <th style="width:50%" class="text-center border">Désignation</th>
                                            <th style="width:10%" class="text-center border">Qté</th>
                                            <th style="width:15%" class="text-center border">PU</th>
                                            <th style="width:15%" class="text-center border">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size : 8px">
                                        @php 
                                            $TTC = 0;
                                        @endphp
                                        @foreach($lignecommandes as $lignecommande)
                                        @php 
                                            $prix_unit = $lignecommande->totale_produit / $lignecommande->Qantite;
                                            $TTC += $lignecommande->totale_produit;
                                        @endphp
                                        <tr>
                                            <td style="width:10%" class="text-left border-right border-left">{{$lignecommande->produit->code_produit}}</td>
                                            <td style="width:50%" class="text-left border-right border-left">{{$lignecommande->nom_produit}}</td>
                                            <td style="width:10%" class="text-center border-right border-left">{{$lignecommande->Qantite}}</td>
                                            <td style="width:15%" class="text-right border-right border-left">{{number_format($prix_unit,2)}}</td>
                                            <td style="width:15%" class="text-right border-right border-left">{{$lignecommande->totale_produit}}</td>
                                        </tr>
                                        @endforeach
                                        <tr id="tbody_ligne">
                                            <td class="text-left border-right border-left border-bottom"></td>
                                            <td class="text-left border-right border-left border-bottom"></td>
                                            <td class="text-left border-right border-left border-bottom"></td>
                                            <td class="text-left border-right border-left border-bottom"></td>
                                            <td class="text-left border-right border-left border-bottom"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="border-bottom: none !important"></td>
                                            <th colspan="2" class="text-right border">MONTANT A PAYER :</th>
                                            <td colspan="1" class="text-right border">{{number_format($TTC,2)}} DH</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr style="height:30px"></tr>
                                        <tr style="height: 10px">
                                            <td colspan="5" class="text-center" style="text-align:center; background-color:rgb(235, 233, 233)">
                                                <!-- Siège social : ITIC SOLUTION -3 ,immeuble Karoum, Av Alkhansaa, Cité Azmani-83350 OULED TEIMA, Maroc<br>
                                                Téléphone : 085785435457890 -https://itic-solution.com/ -Contact@itic-solution.com <br>
                                                I.F. :4737443330 - ICE: 002656767875765788978 -->
                                                {!!$adresse!!}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2" style="text-align : right">
                <div class="text-center">
                    <i class="fas fa-arrow-circle-left fa-3x" onclick="window.location.assign('/index5')"></i>
                </div>
                <br>
                <div class="text-center">
                    <button onclick="onprint()" class="btn btn-primary">Créer PDF</button>
                </div>
            </div>
        </div>
    </div>
    <!-- #########################################################" -->
    <div id="display" style="display : none">
        <div id="pdf"></div>
    </div>
    <!-- #########################################################" -->
    <!-- <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.1/html2canvas.min.js" integrity="sha512-Ki6BxhTDkeY2+bERO2RGKOGh6zvje2DxN3zPsNg4XhJGhkXiVXxIi1rkHUeZgZrf+5voBQJErceuCHtCCMuqTw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="{{ asset('js/jspdf.umd.min.js') }}"></script>
    <script src="{{ asset('js/html2canvas.min.js') }}"></script>
    <script type="application/javascript">
      function dimensionTBODY(){
            // var tbody = $('#display').find('#pdf').find('table').find('tbody');
            // var height_tbody = tbody.outerHeight();
            // var lignes = tbody.find('tr');
            // tbody_ligne = lignes.eq(lignes.length - 2);
            // tbody_ligne.height(350-height_tbody);
            var height_tbody = $('#pdf').find('table').find('tbody').outerHeight();
            $('#pdf').find('#tbody_ligne').height(350-height_tbody);
            // var height_tbody = $('table').find('tbody').outerHeight();
            // $('#tbody_ligne').height(500-height_tbody);
            // console.log(document.getElementById('tr1').offsetHeight);
            // console.log(document.getElementById('tr2').offsetHeight);
        }
        function onprint(){
            // -------- declarartion des jsPDF and html2canvas ------------//
            window.html2canvas = html2canvas;
            window.jsPDF = window.jspdf.jsPDF;
            // -------- Change Style ------------//
            $('#pdf').html($('#content').html());
            dimensionTBODY();
            // $('#pdf').prop('style','height: 700px;width: 500px;margin-left: auto;margin-right: auto;');
            var style = `
                height: 800px;
                width: 550px;
                margin-left: auto;
                margin-right: auto;
                font-size:10px;
            `;
            $('#pdf').prop('style',style);
            // -------- Initialization de doc ------------//
            var doc = new jsPDF("p", "pt", "a4",true);
            // -------- html to pdf ------------//
            // -------- Footer ------------//
            var foot1 = `Siège social : ITIC SOLUTION -3 ,immeuble Karoum, Av Alkhansaa, Cité Azmani-83350 OULED TEIMA, Maroc`;
            var foot2 = `Téléphone : 085785435457890 -https://itic-solution.com/ -Contact@itic-solution.com`;
            var foot3 = `I.F. :4737443330 - ICE: 002656767875765788978`;
            doc.setFontSize(10);//optional
            var pageHeight = doc.internal.pageSize.height || doc.internal.pageSize.getHeight();
            var pageWidth = doc.internal.pageSize.width || doc.internal.pageSize.getWidth();
            // doc.text(foot1, pageWidth / 2, pageHeight  - 50, {align: 'center'});
            // doc.text(foot2, pageWidth / 2, pageHeight  - 35, {align: 'center'});
            // doc.text(foot3, pageWidth / 2, pageHeight  - 20, {align: 'center'});
            // -------- Footer ------------//
            doc.html(document.querySelector("#pdf"), {
                callback: function (doc) {
                    var code = "<?php echo $commande->code;?>";
                    doc.save("BON"+code+".pdf");
                },
                x: 20,
                y: 10,
            });
        }
    </script>
</body>
</html>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- <meta charset="utf-8"> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>REG n° : {{$reglement->code}}</title>
    <!-- Scripts -->  
    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <!-- My Styles -->
    <style>
        /* .text-left {
        text-align: left !important;
        }

        .text-right {
        text-align: right !important;
        }

        .text-center {
        text-align: center !important;
        }
        .table {
        border-collapse: collapse !important;
        }

        .table td,
        .table th {
        background-color: #fff !important;
        }

        .table-bordered th,
        .table-bordered td {
        border: 1px solid #dee2e6 !important;
        }

        .table-dark {
        color: inherit;
        }

        .table-dark th,
        .table-dark td,
        .table-dark thead th,
        .table-dark tbody + tbody {
        border-color: #dee2e6;
        }

        .table .thead-dark th {
        color: inherit;
        border-color: #dee2e6;
        }
        .border {
        border: 1px solid #dee2e6 !important;
        }
        .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.25rem;
        } */
        .table th, .table td { 
            border-top: none ;
            border-bottom: none ;
        }
        .page-break {
            page-break-after: always;
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
                                <th colspan="6" style="text-align:center; background-color:rgb(235, 233, 233); font-size:20px">
                                    RECEPISSE DE REGLEMENT
                                </th>
                            </tr>
                            <tr>
                                <th style="width:20%"></th>
                                <th style="width:60%" class="text-center" colspan="4">
                                    <span style="background-color:yellow">
                                        Reçu n° : REG-{{$reglement->code}}
                                    </span>
                                </th>
                                <th  style="width:20%" class="text-right">
                                    @php
                                    $time = strtotime($reglement->date);
                                    $date = date('d/m/Y',$time);
                                    @endphp
                                    Le, {{$date}}
                                </th>
                            </tr>
                            <tr><td colspan="6"></td></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td rowspan="3" style="width:10%">
                                    <img src="data:image/jpeg;base64,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" alt="" style="width:120px">
                                    <!-- <img src="http://localhost:3000/images/logo.jpg" alt="" style="width:120px"> -->
                                    <!-- <img src="{{asset('images/logo.jpg')}}" alt="" style="width:120px"> -->
                                </td>
                                <td style="width:15%" class="text-right border">Client:</td>
                                <td style="width:25%" class="text-left border">{{$reglement->commande->client->code}} | {{$reglement->commande->client->nom_client}}</td>
                                <td style="width:5%"></td>
                                <td style="width:15%" class="text-right border">Commande :</td>
                                <td style="width:30%" class="text-left border">
                                        BON-{{$reglement->commande->code}} | 
                                        <span style="background-color:yellow">
                                        Total à payer : {{$reglement->commande->totale}} dh
                                        </span>
                                </td>
                            </tr>
                            <tr>
                                <!-- <td style="width:10%" class="text-right border"></td> -->
                                <td style="width:15%" class="text-right border">Adresse : </td>
                                <td style="width:25%" class="text-left border">{{$reglement->commande->client->adresse}}</td>
                                <td style="width:5%"></td>
                                <td style="width:15%" class="text-right border">Total des règlements : </td>
                                @php
                                $total_reg = $reglement->commande->totale - $reglement->reste;
                                @endphp
                                <td style="width:30%" class="text-left border">{{number_format($total_reg, 2, '.', '')}} dh</td>
                            </tr>
                            <tr>
                                <!-- <td style="width:10%" class="text-right border"></td> -->
                                <td style="width:15%" class="text-right border">Montant réglé :</td>
                                <td style="width:25%" class="text-left border">{{$reglement->avance}} dh</td>
                                <td style="width:5%"></td>
                                <td style="width:15%" class="text-right border">Reste à payer : </td>
                                <td style="width:30%" class="text-left border">{{$reglement->reste}} dh</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr><td colspan="6"></td></tr>
                            <tr style="height: 10px">
                                <td colspan="6" class="text-center" style="text-align:center; background-color:rgb(235, 233, 233)">
                                    <address>
                                        Siège social : ITIC SOLUTION -3 ,immeuble Karoum, Av Alkhansaa, Cité Azmani-83350 OULED TEIMA, Maroc<br>
                                        Téléphone : 085785435457890 -https://itic-solution.com/ -Contact@itic-solution.com <br>
                                        I.F. :4737443330 - ICE: 002656767875765788978
                                    </address>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="page-break"></div>
    <div>Page2</div>
</body>
</html>
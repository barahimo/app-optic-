@extends('layout.dashboard')
@section('contenu')
<!-- ##################################################################### -->
<!-- {!! Html::style( asset('/css/style.css')) !!} -->
<div  class="container">
    <div class="card" style="background-color : #dff3d5;border : 1px solid black;width:70%;margin-right: auto;margin-left: auto">
        <div class="card-body">
            <form  method="POST" action="{{route('company.update',['company'=>$company->id])}}">
                @csrf 
                @method('PUT')
                <!-- ########################################## -->
                <!-- BEGIN Nom/Raison && logo -->
                <div class="form-row">
                    <!-- BEGIN Nom/Raison -->
                    <div class="form-group col-md-6">
                        <label for="nom">Nom/Raison sociale : :</label>
                        <div class="input-group">
                            <input type="text" value="{{old('nom',$company->nom)}}" id="nom" name="nom" class="form-control" placeholder="Nom/Raison sociale" />
                        </div>
                    </div>
                    <!-- END Nom/Raison -->
                    <!-- BEGIN logo -->
                    <div class="form-group col-md-6">
                        <label for="logo">Logo :</label>
                        <div class="input-group">
                            <input type="text" value="{{old('logo',$company->logo)}}" id="logo" name="logo"  class="form-control" placeholder="Logo"/>
                        </div>
                    </div>
                    <!-- END logo -->
                </div>
                <!-- END Nom/Raison && logo -->
                <!-- BEGIN Adresse -->
                <div class="form-group">
                    <label for="adresse">Adresse :</label>
                    <textarea id="adresse" name="adresse" class="form-control" rows="3" cols="3">{{old('adresse',$company->adresse)}}</textarea>
                </div>
                <!-- END Adresse -->
                <!-- BEGIN code_postal &&  ville -->
                <div class="form-row">
                    <!-- BEGIN code_postal -->
                    <div class="form-group col-md-6">
                        <label for="code_postal">Code postal :</label>
                        <div class="input-group">
                            <input type="text" value="{{old('code_postal',$company->code_postal)}}"  id="code_postal" name="code_postal"  class="form-control" placeholder="Code postal"/>
                        </div>
                    </div>
                    <!-- END code_postal -->
                    <!-- BEGIN ville -->
                    <div class="form-group col-md-6">
                        <label for="ville">Ville :</label>
                        <div class="input-group">
                            <input type="text" value="{{old('ville',$company->ville)}}"  id="ville" name="ville"  class="form-control" placeholder="Ville"/>
                        </div>
                    </div>
                    <!-- END ville -->
                </div>
                <!-- END code_postal &&  ville -->
                <!-- BEGIN pays &&  tel -->
                <div class="form-row">
                    <!-- BEGIN pays -->
                    <div class="form-group col-md-6">
                        <label for="pays">Pays :</label>
                        <div class="input-group">
                            <input type="text" value="{{old('pays',$company->pays)}}"  id="pays" name="pays"  class="form-control" placeholder="Pays"/>
                        </div>
                    </div>
                    <!-- END pays -->
                    <!-- BEGIN tel -->
                    <div class="form-group col-md-6">
                        <label for="tel">T??l??phone :</label>
                        <div class="input-group">
                            <input type="text" value="{{old('tel',$company->tel)}}"  id="tel" name="tel"  class="form-control" placeholder="T??l??phone"/>
                        </div>
                    </div>
                    <!-- END tel -->
                </div>
                <!-- END pays &&  tel -->
                <!-- BEGIN site && email -->
                <div class="form-row">
                    <!-- BEGIN site -->
                    <div class="form-group col-md-6">
                        <label for="site">Site web :</label>
                        <div class="input-group">
                            <input type="text" value="{{old('site',$company->site)}}"  id="site" name="site"  class="form-control" placeholder="Site web"/>
                        </div>
                    </div>
                    <!-- END site -->
                    <!-- BEGIN email -->
                    <div class="form-group col-md-6">
                        <label for="email">Email :</label>
                        <div class="input-group">
                            <input type="text" value="{{old('email',$company->email)}}" id="email" name="email"  class="form-control" placeholder="Email"/>
                        </div>
                    </div>
                    <!-- END email -->
                </div>
                <!-- END site && email -->
                <!-- BEGIN note -->
                <div class="form-group">
                    <label for="note">Note :</label>
                    <textarea id="note" name="note" class="form-control" rows="3" cols="3" >{{old('note',$company->note)}}</textarea>
                </div>
                <!-- END note -->
                <!-- BEGIN IF &&  ice -->
                <div class="form-row">
                    <!-- BEGIN IF -->
                    <div class="form-group col-md-6">
                        <label for="iff">Identifiant fiscal :</label>
                        <div class="input-group">
                            <input type="text" value="{{old('iff',$company->iff)}}"  id="iff" name="iff"  class="form-control" placeholder="Identifiant fiscal"/>
                        </div>
                    </div>
                    <!-- END IF -->
                    <!-- BEGIN ice -->
                    <div class="form-group col-md-6">
                        <label for="ice">Identifiant Commun (ICE) :</label>
                        <div class="input-group">
                            <input type="text" value="{{old('ice',$company->ice)}}"  id="ice" name="ice"  class="form-control" placeholder="ICE"/>
                        </div>
                    </div>
                    <!-- END ice -->
                </div>
                <!-- END IF &&  ice -->
                <!-- BEGIN capital &&  rc -->
                <div class="form-row">
                    <!-- BEGIN capital -->
                    <div class="form-group col-md-6">
                        <label for="capital">Capital :</label>
                        <div class="input-group">
                            <input type="text" value="{{old('capital',$company->capital)}}"  id="capital" name="capital"  class="form-control" placeholder="Capital"/>
                        </div>
                    </div>
                    <!-- END capital -->
                    <!-- BEGIN rc -->
                    <div class="form-group col-md-6">
                        <label for="rc">Registre du commerce :</label>
                        <div class="input-group">
                            <input type="text" value="{{old('rc',$company->rc)}}"  id="rc" name="rc"  class="form-control" placeholder="Registre du commerce"/>
                        </div>
                    </div>
                    <!-- END rc -->
                </div>
                <!-- END capital &&  rc -->
                <!-- BEGIN patente &&  cnss -->
                <div class="form-row">
                    <!-- BEGIN patente -->
                    <div class="form-group col-md-6">
                        <label for="patente">Patente :</label>
                        <div class="input-group">
                            <input type="text" value="{{old('patente',$company->patente)}}"  id="patente" name="patente"  class="form-control" placeholder="Patente"/>
                        </div>
                    </div>
                    <!-- END patente -->
                    <!-- BEGIN cnss -->
                    <div class="form-group col-md-6">
                        <label for="cnss">CNSS :</label>
                        <div class="input-group">
                            <input type="text" value="{{old('cnss',$company->cnss)}}"  id="cnss" name="cnss"  class="form-control" placeholder="CNSS"/>
                        </div>
                    </div>
                    <!-- END cnss -->
                </div>
                <!-- END patente &&  cnss -->
                <!-- BEGIN banque &&  rib -->
                <div class="form-row">
                    <!-- BEGIN banque -->
                    <div class="form-group col-md-6">
                        <label for="banque">Banque :</label>
                        <div class="input-group">
                            <input type="text" value="{{old('banque',$company->banque)}}"  id="banque" name="banque"  class="form-control" placeholder="Banque"/>
                        </div>
                    </div>
                    <!-- END banque -->
                    <!-- BEGIN rib -->
                    <div class="form-group col-md-6">
                        <label for="rib">Relev?? d'Identit?? Bancaire (RIB) :</label>
                        <div class="input-group">
                            <input type="text" value="{{old('rib',$company->rib)}}"  id="rib" name="rib"  class="form-control" placeholder="RIB"/>
                        </div>
                    </div>
                    <!-- END rib -->
                </div>
                <!-- END banque &&  rib -->
                <!-- ########################################## -->
                <div class="form-group">
                    <button class="btn btn-info" type="submit">Modifier</button>
                    <a href="{{action('CompanyController@index')}}" class="btn btn-info">retour</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
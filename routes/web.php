<?php

use App\Http\Controllers\CommandeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// routes authentification user admin
Auth::routes();
Route::get('/admin/login', 'Auth\Admin\LoginController@showLoginForm');
Route::post('/admin/login', 'Auth\Admin\LoginController@login')->name('adminlogin');

Route::get('/admin/register', 'Auth\Admin\RegisterController@showRegisterForm');
Route::post('/admin/register', 'Auth\Admin\RegisterController@register')->name('adminregister');
 
// route clients

Route::resource('client', 'ClientController');
Route::resource('commande', 'CommandeController');
Route::resource('categorie', 'CategorieController');
Route::get('/createProduit/{id}', 'CategorieController@ajouteProduit')->name('categorie.produit');
Route::post('/storeP', 'CategorieController@storeP')->name('categorie.storeP');
Route::resource('produit', 'ProduitController');
Route::resource('reglement', 'ReglementController');
Route::resource('facture', 'FactureController');
// Route::post('/updateF/{facture}', 'CommandeController@updateF')->name('update.facturation');
// Route::get('/index', 'FactureController@index')->name('facture.index');
// Route::get('/create', 'FactureController@create')->name('facture.create');



Route::resource('lignecommande', 'LignecommandeController');
Route::post('/store', 'CommandeController@storeL')->name('commande.storeL');
Route::post('/storelp', 'CommandeController@storeLP')->name('commande.storeLP');
Route::get('/affiche', 'CommandeController@affiche')->name('commande.affiche');

Route::post('/reglement', 'CommandeController@storeLR')->name('commande.storeLR');
Route::get('/facturation', 'CommandeController@facture')->name('commande.facture');
Route::get('/facturation2', 'CommandeController@facture2')->name('commande.facture2');

Route::get('/prodview','CommandeController@prodfunct');
Route::get('/findProductName','CommandeController@findProductName');
Route::get('/findPrice','CommandeController@findPrice');


Route::get('/search', 'ClientController@search')->name('client.search');
Route::get('/searchc', 'CommandeController@search')->name('commande.search');
Route::get('/searchctg', 'CategorieController@search')->name('categorie.search');
Route::get('/searchpr', 'ProduitController@search')->name('produit.search');
Route::get('/searchreg', 'ReglementController@search')->name('reglement.search');
Route::get('/searchl', 'LignecommandeController@search')->name('lignecommande.search');
Route::get('/searchFacture', 'FactureController@search')->name('facture.search');


Route::get('/lignecommandeajoute/{id}', 'LignecommandeController@ajoute')->name('lignecommande.ajoute');
Route::get('/lignecommandedit/{lignecommande}', 'CommandeController@editL')->name('lgcommande.editL');
Route::put('/lignecommandeupdate/{lignecommande}', 'CommandeController@updateL')->name('lgcommande.updateL');
Route::put('/affecte', 'LignecommandeController@affecte')->name('lgcommande.affecte');
Route::post('/facture', 'CommandeController@storefacture')->name('facture.store');
Route::post('/facture2', 'CommandeController@storefacture2')->name('facture.store2');
// Route::get('/select', 'HomeController@select')->name('select');
// Route::get('/selectpr', 'HomeController@selectProduit')->name('selectproduit');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/application', 'HomeController@application')->name('app.home');
// ->middleware('Auth');




// ########################################################
//Commande
Route::get('/commandes', 'CommandeController@index2')->name('commande.index2');
Route::get('/getCommandes', 'CommandeController@getCommandes')->name('commande.getCommandes');
Route::get('/commande22', 'CommandeController@index22')->name('commande.index22');
Route::get('/gestioncommande', 'CommandeController@index22')->name('commande.index22');
// ----------------------------------------
Route::get('/gestioncommande2', 'CommandeController@index222')->name('commande.index222');
Route::get('/getCommandes2', 'CommandeController@getCommandes2')->name('commande.getCommandes2');
// ----------------------------------------
Route::get('/productsCategory','CommandeController@productsCategory');
Route::get('/infosProducts','CommandeController@infosProducts');
Route::post('/storeCommande','CommandeController@store2')->name('commande.store2');
Route::get('/edit2/{id}','CommandeController@edit2')->name('commande.edit2');
Route::get('/editCommande','CommandeController@editCommande')->name('commande.editCommande');
Route::post('/update2','CommandeController@update2')->name('commande.update2');

// REglements
Route::get('/reglements','ReglementController@index2')->name('reglement.index2');
Route::get('/reglements2','ReglementController@index22')->name('reglement.index22');
Route::get('/reglements/create2','ReglementController@create2')->name('reglement.create2');
Route::get('/reglements/create3','ReglementController@create3')->name('reglement.create3');
Route::get('/getReglements','ReglementController@getReglements')->name('reglement.getReglements');
Route::get('/getReglements2','ReglementController@getReglements2')->name('reglement.getReglements2');
Route::get('/getReglements3','ReglementController@getReglements3')->name('reglement.getReglements3');
Route::post('/storeReglements','ReglementController@store2')->name('reglement.store2');
Route::post('/storeReglements3','ReglementController@store3')->name('reglement.store3');
Route::get('/facture2/{facture}','FactureController@show2')->name('facture.show2');
Route::post('/avoir','ReglementController@avoir')->name('reglement.avoir');

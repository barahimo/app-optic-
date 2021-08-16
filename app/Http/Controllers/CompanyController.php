<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::get();
        $count = count($companies);
        $company = Company::first();
        // return $company;
        return view('parametres.index',compact('company','count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('parametres.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = new Company();
            $company->nom = $request->nom;
            $company->logo = $request->logo;
            $company->adresse = $request->adresse;
            $company->code_postal = $request->code_postal;
            $company->ville = $request->ville;
            $company->pays = $request->pays;
            $company->tel = $request->tel;
            $company->site = $request->site;
            $company->email = $request->email;
            $company->note = $request->note;
            $company->iff = $request->iff;
            $company->ice = $request->ice;
            $company->capital = $request->capital;
            $company->rc = $request->rc;
            $company->patente = $request->patente;
            $company->cnss = $request->cnss;
            $company->banque = $request->banque;
            $company->rib = $request->rib;
        $company->save();
        $request->session()->flash('status',"L'opération effectuée avec succès !");
        return redirect()->route('company.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::first();
        return view('parametres.edit',compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $company->nom = $request->input('nom');
        $company = Company::find($id);
            $company->nom = $request->nom;
            $company->logo = $request->logo;
            $company->adresse = $request->adresse;
            $company->code_postal = $request->code_postal;
            $company->ville = $request->ville;
            $company->pays = $request->pays;
            $company->tel = $request->tel;
            $company->site = $request->site;
            $company->email = $request->email;
            $company->note = $request->note;
            $company->iff = $request->iff;
            $company->ice = $request->ice;
            $company->capital = $request->capital;
            $company->rc = $request->rc;
            $company->patente = $request->patente;
            $company->cnss = $request->cnss;
            $company->banque = $request->banque;
            $company->rib = $request->rib;
        $company->save();
        $request->session()->flash('status',"L'opération effectuée avec succès !");
        return redirect()->route('company.index');
    }

    /**
     * Remove the specified resource from storage.
        *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function hello()
    {
        return ['hello'=>"hello world !!"];
    }
}

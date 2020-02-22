<?php

namespace App\Http\Controllers;

use App\Employe;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Imports\EmployeImport;
use Maatwebsite\Excel\Facades\Excel;



class EmployeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $employes = Employe::all();
         return view('employe.index')->with([
            'employes' => $employes,
        ]);
    }

    public function store(Request $request)
    {
        $employe = new Employe();

        $employe->matricule = $request->input('matricule');
        $employe->nom = $request->input('nom');
        $employe->prenom = $request->input('prenom');
        $employe->fonction = $request->input('fonction');
        $employe->unite = $request->input('unite');
        $employe->tel = $request->input('tel');
        $employe->adresse = $request->input('adresse');
        $employe->date_naissance = $request->input('date_naissance');
        $employe->date_rec = $request->input('date_rec');

        $employe->save();

        return redirect('employes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function show(Employe $id)
    {
        //
    }

    public function update(Request $request, Employe $id)
    {
       $employe = Employe::find($id);
    }
     
    public function destroy(Employe $id)
    {
        $employe = Employe::find($id);
        $employe->delete();
        return redirect('employes');
    }

    public function import(Request $request)
     {
        // if($request->hasFile('file')){
        // Excel::import(new EmployeImport, request()->file('file'),\Maatwebsite\Excel\Excel::XLSX);

        if($request->hasFile('file')){
            $path =$request->file('file')->getRealPath(); getPathName()
            
            //$request->file('file')->getRealPath();
            $data = Excel::import($path, function($reader){})->get();
            
            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) {
                    $employe = new Employe();
                    $employe->matricule = $value->matricule;
                    $employe->nom = $value->nom;
                    $employe->prenom = $value->prenom;
                    $employe->fonction = $value->fonction;
                    $employe->unite = $value->unite;
                    $employe->date_naissance = $value->date_naissance;
                    $employe->date_rec = $value->date_rec;
                    $employe->tel = $value->tel;
                    $employe->adresse = $value->adresse;
                                
                    $employe->save();
                }
            }
        }
        return back();
     }
}

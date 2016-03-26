<?php

namespace App\Http\Controllers;

use App\Patient;

use App\PatientVitals;

use Illuminate\Http\Request;

use App\Http\Requests;

class VitalsController extends Controller
{
    public function index(Patient $patient)//type-hinting therefore the variable has to be the same as the wildcard in the route
    {	
    	//return $patient_id;
    	return view('patients.vitals.form', compact('patient'));//this should 
    }

    public function store(Request $request, $patient_id)
    {
    	$this->validate($request, [
            'temp'     => 'required|Numeric',
            'weight' => 'required|Numeric',
            'height'    => 'required|Numeric',
            'bp_sys'   => 'required|Numeric',
            'bp_dias' => 'required|Numeric',
            'oxy_sat' => 'required|Numeric',
            'head_cir' => 'required|Numeric',
            'waist_cir' => 'required|Numeric',
            'bmi' => 'required|Numeric'
        ]);

        //$patient = new Patient;
        $patientVitals = new PatientVitals;

        $patientVitals->patient_id = $patient_id;
        $patientVitals->temp   = $request->input('temp');
        $patientVitals->weight = $request->input('weight');
        $patientVitals->height = $request->input('height');
        $patientVitals->bp_sys = $request->input('bp_sys');
        $patientVitals->bp_dias = $request->input('bp_dias');
        $patientVitals->head_cir = $request->input('head_cir');
        $patientVitals->waist_cir = $request->input('waist_cir');
        $patientVitals->bmi = $request->input('bmi');

        /*$patient->id = Auth::user()->id;*/
    
        $patientVitals->save();

        return redirect()->route('patients.index')->with('info','New Patient vital has been created successfully');  
        }
/*        public function edit(Patient $patient)
        {
            $patient = Patient::find($id);
            return view('patients.edit',compact('patient'));   
        }
*/    }


    
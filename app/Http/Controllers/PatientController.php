<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\User; use App\Patient;

use App\Vital; use App\Test; use App\Note;

use App\Http\Requests;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $patient = Patient::all();
        $users = User::all();
       // $users = User::orderBy('role','asc')->get();

        $forRecords = Patient::where('whomToSee', 'Records Officer')->get();
        $forNurse = Patient::where('whomToSee', 'Nurse')->get();
        $forDoctor = Vital::where('whomToSee', 'Doctor')->get();
        $forLab = Note::where('whomToSee', 'Lab Attendant')->get();
        $forPharmacy = Note::where('whomToSee', 'Pharmacist')->get();
        
        return view('patients.index', compact(['patient', 'users', 'forRecords', 'forNurse', 'forDoctor', 'forLab', 'forPharmacy']));  

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     return view('patients.new');    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|min:3',
            'dob' => 'required|date|before:today',
            'address'    => 'required|min:10',
            'status'   => 'required',
            'phone' => 'required',
            'email' => 'required|email'
        ]);

        $patient = new Patient;

        $patient->whomToSee = $request->input('whomToSee');
        $patient->name   = $request->input('name');
        $patient->marital_stat = $request->input('status');
        $patient->dob    = $request->input('dob');
        $patient->address = $request->input('address');
        $patient->email = $request->input('email');
        $patient->phone = $request->input('phone');
        $patient->whomToSee = $request->input('whomToSee');

        $patient->save();

        return redirect()->route('patients.index')->with('success','New Patient has been created successfully');   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::find($id);
        //dd($patient);
        return view('patients.show')->withPatient($patient);
    }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            $patient = Patient::find($id);
            return view('patients.edit')->withPatient($patient);   
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
            $patient = Patient::findOrFail($id);
            
            $this->validate($request, [
                'name'     => 'required|min:3',
                'dob' => 'required|date|before:today',
                'address'    => 'required|min:10',
                'status'   => 'required',
                'phone' => 'required|min:11',
                'email' => 'required|email'
            ]);

                $values = $request->all();

                $patient->fill($values)->save();

                return redirect()->route('patients.index')->with('info','Your Patient data has been updated successfully');

        }

        /*public function getVitals()
        {
            $vitals =  Vital::patient()->get();
            return $vitals;
        }*/
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->route('patients.index')->with('info', 'Patient deleted successfully');
    }
}

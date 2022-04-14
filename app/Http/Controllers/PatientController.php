<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Notifications\PatientAccountCreated;

class PatientController
{
    /**
     * @return AnonymousResourceCollection<Patient>
     */
    public function index(): AnonymousResourceCollection
    {
        return PatientResource::collection(Patient::paginate());
    }

    public function store(CreatePatientRequest $request): PatientResource
    {
        // Interaction with external api to get the medication list. The url will be given by the client
        $medicationListRequest = Http::timeout(3)->get('http://localhost:8001/api/');
        $medicationList = $request->getBody()->getContents();

        $request->request->add(['medication_list' => $medicationList]);

        $patient = Patient::create($request->validated());

        $patient->notify(new PatientAccountCreated($patient->email));

        return PatientResource::make($patient);
    }

    public function show(Patient $patient): PatientResource
    {
        return PatientResource::make($patient);
    }

    public function update(UpdatePatientRequest $request, Patient $patient): PatientResource
    {
        $patient->update($request->validated());

        return PatientResource::make($patient);
    }
}

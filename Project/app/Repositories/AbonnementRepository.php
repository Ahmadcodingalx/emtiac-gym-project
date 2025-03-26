<?php

namespace App\Repositories;

use App\Interfaces\AbonnementInterface;
use App\Models\Abonnement;
use App\Models\Client;
use App\Models\Service;
use App\Models\Type;
use Carbon\Carbon;

class AbonnementRepository implements AbonnementInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function show()
    {
        return Abonnement::with('type')->paginate(10);
    }

    public function viewAb($id)
    {
        return Abonnement::with('createdBy', 'updatedBy', 'type', 'service', 'client')->findOrFail($id);
    }

    public function addAb()
    {
        $clients = Client::all();
        $types = Type::all();
        $services = Service::all();

        $allData = [
            'clientData' => $clients,
            'typeData' => $types,
            'serviceData' => $services
        ];

        return $allData;
    }

    public function store($data)
    {
        $startDate = null;
        $letters = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3);
        $numbers = rand(100000, 999999);
        $data['transaction_id'] = 'abb_' . $letters . '-' . $numbers;

        $checkCode = Abonnement::where('transaction_id', $data['transaction_id'])->first();

        if ($checkCode) {
            while ($checkCode->transaction_id === $data['transaction_id']) {
                $letters = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3);
                $numbers = rand(100000, 999999);
                $data['transaction_id'] = 'abb_' . $letters . '-' . $numbers;
            }
        }


        try {
            $startDate = Carbon::parse($data['start_date']);

            if ($startDate->isSameDay(Carbon::now())) {
                $data['status'] = 'actif';
            }
        } catch (\Exception $e) {
            dd('Erreur de format de date : ', $e->getMessage());
        }

        $type = Type::findOrFail($data['type_id']);

        if ($type->type === 'Jour') {
            $data['end_date'] = $startDate->addDays($type->number);
        } elseif ($type->type === 'Semaine') {
            $data['end_date'] = $startDate->addWeeks($type->number);
        } elseif ($type->type === 'Mois') {
            $data['end_date'] = $startDate->addMonths($type->number);
            // $data['end_date'] = $startDate->addMonthsNoOverflow($type->number);
        } else {
            $data['end_date'] = $startDate->addYears($type->number);
        }

        $abb = Abonnement::create($data);

        return $abb;
    }

    public function destroy($id)
    {
        return Abonnement::findOrFail($id);
    }

    public function update($request, $id)
    {
        $ab = Abonnement::findOrFail($id);

        $ab->user_update_id = auth()->id();
        $ab->client_id = $request->input('client');
        $ab->type_id = $request->input('type');
        $ab->service_id = $request->input('service');
        $ab->start_date = $request->input('start_date');
        $ab->price = $request->input('price');
        $ab->remark = $request->input('remark');

        $startDate = null;

        try {
            $startDate = Carbon::parse($request->input('start_date'));

            if ($startDate->isSameDay(Carbon::now())) {
                $ab->status = 'actif';
            }
        } catch (\Exception $e) {
            dd('Erreur de format de date : ', $e->getMessage());
        }

        $type = Type::findOrFail($request->input('type'));

        if ($type->type === 'Jour') {
            $day = $type->number - 1;
            $ab->end_date = $startDate->addDays($day);
        } elseif ($type->type === 'Semaine') {
            $ab->end_date = $startDate->addWeeks($type->number);
        } elseif ($type->type === 'Mois') {
            $ab->end_date = $startDate->addMonths($type->number);
            // $ab->end_date = $startDate->addMonthsNoOverflow($type->number);
        } else {
            $ab->end_date = $startDate->addYears($type->number);
        }

        $ab->save();

        return $ab;
    }

    public function updateStatus($status, $id)
    {
        $abb = Abonnement::findOrFail($id);

        $abb->status = $status;

        $type = Type::findOrFail($abb->type_id);

        $startDate = Carbon::now();
        $abb->start_date = now();
        // dd($startDate);
        if ($type->type === 'Jour') {
            $day = $type->number - 1;
            $abb->end_date = $startDate->addDays($day);
        } elseif ($type->type === 'Semaine') {
            $abb->end_date = $startDate->addWeeks($type->number);
        } elseif ($type->type === 'Mois') {
            $abb->end_date = $startDate->addMonths($type->number);
            // $ab->end_date = $startDate->addMonthsNoOverflow($type->number);
        } else {
            $abb->end_date = $startDate->addYears($type->number);
        }

        $abb->updated_at = now();

        $abb->save();

        return $abb;
    }






    public function show_service()
    {
        return Service::all();
    }

    public function create_service($data)
    {
        return Service::create($data);
    }

    public function update_service($request, $id)
    {
        $service = Service::findOrFail($request->input('id'));

        if ($request->input('name')) {
            $service->name = $request->input('name');
            $service->description = $request->input('desc');
        }

        $service->updated_at = now();

        $service->save();

        return $service;
    }


    public function destroy_service($id)
    {
        return Service::find($id);
    }

    public function show_type()
    {
        return Type::all();
    }

    public function create_type($data)
    {
        return Type::create($data);
    }

    public function update_type($request, $id)
    {
        $type = Type::findOrFail($request->input('id'));

        if ($request->input('name')) {
            $type->name = $request->input('name');
            $type->description = $request->input('desc');
            $type->number = $request->input('number');
            $type->type = $request->input('type');
            $type->description = $request->input('amount');
        }

        $type->updated_at = now();

        $type->save();

        return $type;
    }


    public function destroy_type($id)
    {
        return Type::find($id);
    }
}

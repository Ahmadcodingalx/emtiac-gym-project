<?php

namespace App\Repositories;

use App\Interfaces\AbonnementInterface;
use App\Models\Abonnement;
use App\Models\Client;
use App\Models\Service;
use App\Models\Type;

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
        return Abonnement::paginate(10);
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
        $abb = Abonnement::create($data);

        return $abb;
    }

    public function destroy($id)
    {
        return Abonnement::findOrFail($id);
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

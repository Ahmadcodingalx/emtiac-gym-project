<?php

namespace App\Repositories;

use App\Interfaces\AbonnementInterface;
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

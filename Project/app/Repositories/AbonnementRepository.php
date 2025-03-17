<?php

namespace App\Repositories;

use App\Interfaces\AbonnementInterface;
use App\Models\Service;

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
}

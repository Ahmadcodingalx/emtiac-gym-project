<?php

namespace App\Repositories;

use App\Interfaces\CoursInterface;
use App\Models\Cours;

class CoursRepository implements CoursInterface
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
        return Cours::all();
    }

    public function create($data)
    {
        return Cours::create($data);
    }

    public function update($request, $id)
    {
        $cours = Cours::findOrFail($request->input('id'));

        if ($request->input('name')) {
            $cours->name = $request->input('name');
            $cours->description = $request->input('desc');
            $cours->coach_id = $request->coach_id === 'Selectionner un coach' ? null : $request->coach_id;
            $cours->coach_id = $request->input('coach_id');
        }

        $cours->updated_at = now();
        
        $cours->save();

        return $cours;
    }

    
    public function destroy($id)
    {
        return Cours::find($id);
    }
}

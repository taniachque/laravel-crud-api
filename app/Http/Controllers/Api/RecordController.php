<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Record::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $record = Record::create($request->all());
        return response()->json($record,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Record::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = Record::findOrFail($id);
        $record->update($request->all());
        return response()->json($record,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Record::destroy($id);
        return response()->json(null,204);
    }
}

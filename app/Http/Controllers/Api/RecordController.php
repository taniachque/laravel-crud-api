<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RecordController extends Controller
{
    public function index()
    {
        return Record::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'required|string|max:50|unique:records,code',
            'status' => 'required|in:active,inactive',
        ]);

        $record = Record::create([
            'uuid' => Str::uuid(),
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'code' => $validatedData['code'],
            'status' => $validatedData['status'],
        ]);

        return response()->json($record, 201);
    }

    public function show(Record $record)
    {
        return $record;
    }

    public function update(Request $request, Record $record)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'required|string|max:50|unique:records,code,' . $record->uuid . ',uuid',
            'status' => 'required|in:active,inactive',
        ]);

        $record->update($validatedData);

        return response()->json($record, 200);
    }

    public function destroy(Record $record)
    {
        $record->delete();

        return response()->json(null, 204);
    }
}

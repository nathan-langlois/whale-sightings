<?php

namespace App\Http\Controllers\Api;

use App\Enums\SightingTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Sighting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class SightingController extends Controller
{
    public function listAll(Request $request)
    {
        if (! $request->user()->tokenCan('get-all-sightings')) {
            return response()->json(['error' => 'Unauthenticated - token lacks ability.'], 401);
        }

        $limit = $request->limit && $request->limit <= 500 ? $request->limit : 100;
        $offset = $request->offset ? $request->offset : 0;
        $sightings = Sighting::orderBy('when', 'desc')->limit($limit)->offset($offset)->get();

        $data = [
            'message' => 'List of all sightings',
            'sightings' => $sightings,
        ];

        return response()->json($data, 200);
    }

    public function listMine(Request $request)
    {
        if (! $request->user()->tokenCan('get-my-sightings')) {
            return response()->json(['error' => 'Unauthenticated - token lacks ability.'], 401);
        }

        $limit = $request->limit && $request->limit <= 500 ? $request->limit : 100;
        $offset = $request->offset ? $request->offset : 0;
        $sightings = Sighting::where('user_id', Auth::id())->orderBy('when', 'desc')->limit($limit)->offset($offset)->get();

        $data = [
            'message' => 'List of your sightings',
            'sightings' => $sightings,
        ];

        return response()->json($data, 200);
    }

    public function create(Request $request)
    {
        if (! $request->user()->tokenCan('create-sighting')) {
            return response()->json(['error' => 'Unauthenticated - token lacks ability.'], 401);
        }

        $request->validate($this->rules());

        $params = $request->only(['type', 'when', 'latitude', 'longitude', 'notes', 'image_url']);
        $params['user_id'] = Auth::id();
        $sighting = Sighting::create($params);

        if (! $sighting->id) {
            return response()->json(['error' => 'Error creating sighting record.'], 500);
        }

        $data = [
            'message' => 'Sighting has been created',
            'sighting' => $this->mapSightingResponse($sighting),
        ];

        return response()->json($data, 201);
    }

    protected function rules()
    {
        return [
            'type' => [new Enum(SightingTypeEnum::class)],
            'when' => 'required|datetime',
            'latitude' => 'required|numeric|min:-90|max:90',
            'longitude' => 'required|numeric|min:-180|max:180',
            'notes' => 'string',
            'image_url' => 'string',
        ];
    }

    protected function mapSightingResponse($sighting)
    {
        return [
            'id' => $sighting->id,
            'type' => $sighting->type,
            'latitude' => $sighting->latitude,
            'longitude' => $sighting->longitude,
            'notes' => $sighting->notes,
            'image_url' => $sighting->image_url,
            'user_id' => $sighting->user_id,
        ];
    }
}

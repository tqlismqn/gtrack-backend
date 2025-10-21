<?php

namespace App\Http\Controllers\V1\Drivers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class DriversController extends BaseController
{
    public function createOne(Request $req) {
        return response()->json(['success' => true, 'data' => ['id' => 1], 'meta' => ['mock' => true]]);
    }

    public function readMany(Request $req) {
        return response()->json(['success' => true, 'data' => [], 'meta' => ['count' => 0, 'mock' => true]]);
    }

    public function readOne($id) {
        return response()->json(['success' => true, 'data' => ['id' => (int)$id], 'meta' => ['mock' => true]]);
    }

    public function updateOne($id, Request $req) {
        return response()->json(['success' => true, 'data' => ['id' => (int)$id], 'meta' => ['updated' => true, 'mock' => true]]);
    }

    public function deleteOne($id) {
        return response()->json(['success' => true, 'data' => ['id' => (int)$id], 'meta' => ['deleted' => true, 'mock' => true]]);
    }
}

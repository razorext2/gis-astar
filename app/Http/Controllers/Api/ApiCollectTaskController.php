<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectTaskResource;
use App\Models\CollectTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ApiCollectTaskController extends Controller
{
    public function store(Request $request)
    {
        // definisikan validator
        $validator = Validator::make($request->all(), [
            'no_sr' => 'required|min:3|max:16',
            'sr_type' => 'required|string',
            'sr_date' => 'required|date',
            'customer_name' => 'required|string|min:5',
            'customer_recipient' => 'string|max:128',
            'customer_address' => 'required|string|max:256',
            'customer_telp' => 'required|string|min:3|max:15',
            'customer_fax' => 'string|min:2|max:15',
            'shipping_address' => 'string|min:5',
            'total_bill' => 'string|min:3',
            'assign_by' => 'required|string',
            'assign_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $query = CollectTask::create($data);

        if ($request->isJson()) {
            return new CollectTaskResource(true, 'Data berhasil ditambah!', $query);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambah!',
            'data' => $query
        ]);
    }

    public function destroy(string $id)
    {
        $query = CollectTask::find($id);
        $query->delete();

        return new CollectTaskResource(true, 'Data berhasil dihapus', null);
    }
}

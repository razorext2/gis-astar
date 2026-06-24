<?php

namespace App\Http\Controllers\Api;

/** Goal: REST API Controller for DataTimbangIndodaya, Caller: API Routes, Deps: App\Models\DataTimbang\DataTimbangIndodaya */

use App\Http\Controllers\Controller;
use App\Models\DataTimbang\DataTimbangIndodaya;
use App\Http\Requests\StoreDataTimbangIndodayaRequest;
use App\Http\Requests\UpdateDataTimbangIndodayaRequest;
use Illuminate\Http\JsonResponse;

class ApiDataTimbangIndodayaController extends Controller
{
    /**
     * Helper to validate fixed token if provided in Authorization header, X-Timbang-Token, or query string.
     */
    private function checkToken(): void
    {
        $request = request();
        $token = $request->bearerToken() ?? $request->header('X-Timbang-Token') ?? $request->query('token');

        if ($token !== null && $token !== 'testing-token-indodaya-2026') {
            abort(response()->json([
                'success' => false,
                'message' => 'Unauthorized: Invalid token'
            ], 401));
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $this->checkToken();
        $data = DataTimbangIndodaya::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDataTimbangIndodayaRequest $request): JsonResponse
    {
        $this->checkToken();
        $data = DataTimbangIndodaya::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data timbang berhasil disimpan.',
            'data' => $data
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $this->checkToken();
        $data = DataTimbangIndodaya::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDataTimbangIndodayaRequest $request, string $id): JsonResponse
    {
        $this->checkToken();
        $data = DataTimbangIndodaya::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $data->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data timbang berhasil diperbarui.',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $this->checkToken();
        $data = DataTimbangIndodaya::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data timbang berhasil dihapus.'
        ]);
    }
}

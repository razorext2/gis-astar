<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Number;

class ProxyController extends Controller
{
    public function fetchIDCNon(Request $request)
    {
        $no_sr = $request->query('no_sr');

        if (!$no_sr) {
            return response()->json([
                'error' => 'No. SR is required.'
            ], 400);
        }

        $url = "https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchSR&NomorPermintaanJual=" . $no_sr;

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $result = $response->json();

                $url = "https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchSisa&NomorPermintaanJual=" . $no_sr;

                $response = Http::get($url);

                if ($response->successful()) {
                    $result['data'][0]['SisaPiutang'] = intval($response->json('data.0.SisaPiutang'));

                    return $result;
                }

                return response()->json([
                    'error' => 'Failed to fetch Sisa Piutang data from external API.',
                    'status' => $response->status(),
                    'body' => $response->body()
                ], $response->status());
            }

            return response()->json([
                'error' => 'Failed to fetch data from external API.',
                'status' => $response->status(),
                'body' => $response->body()
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while processing the request.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function fetchIDCPpn(Request $request)
    {
        $no_sr = $request->query('no_sr');

        if (!$no_sr) {
            return response()->json([
                'error' => 'No. SR is required.'
            ], 400);
        }

        $url = "https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchSR1&NomorFakturPajak=" . $no_sr;

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $result = $response->json();

                $url = "https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchSisa1&NomorFakturPajak=" . $no_sr;

                $response = Http::get($url);

                if ($response->successful()) {
                    $result['data'][0]['SisaPiutang'] = intval($response->json('data.0.SisaPiutang'));

                    return $result;
                }

                return response()->json([
                    'error' => 'Failed to fetch Sisa Piutang data from external API.',
                    'status' => $response->status(),
                    'body' => $response->body()
                ], $response->status());
            }

            return response()->json([
                'error' => 'Failed to fetch data from external API.',
                'status' => $response->status(),
                'body' => $response->body()
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while processing the request.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function fetchIDYPpn(Request $request)
    {
        $no_sr = $request->query('no_sr');

        if (!$no_sr) {
            return response()->json([
                'error' => 'No. SR is required.'
            ], 400);
        }

        $url = "https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchSR2&NomorFakturPajak=" . $no_sr;

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $result = $response->json();

                $url = "https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchSisa2&NomorFakturPajak=" . $no_sr;

                $response = Http::get($url);

                if ($response->successful()) {
                    $result['data'][0]['SisaPiutang'] = intval($response->json('data.0.SisaPiutang'));

                    return $result;
                }

                return response()->json([
                    'error' => 'Failed to fetch Sisa Piutang data from external API.',
                    'status' => $response->status(),
                    'body' => $response->body()
                ], $response->status());
            }

            return response()->json([
                'error' => 'Failed to fetch data from external API.',
                'status' => $response->status(),
                'body' => $response->body()
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while processing the request.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function getVT(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_vt' => 'required|string|min:3|max:12',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors()->first());
        }

        $no_vt = $request->query('no_vt');

        try {
            $url = 'https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchKunjungan&NomorKunjungan=' . $no_vt;

            $response = Http::get($url);

            $result = $response->json();

            if ($result['status'] == 'success') {

                $no_identitas = $result['data'][0]['NomorIdentitasTeknisi'];

                // untuk saat ini filter data pakai hasRole = admin, kdepannya harus ubah jadi permission
                if (!Auth::user()->hasRole('Admin')) {
                    if ($no_identitas != Auth::user()->kode_pegawai) {
                        return new ApiResource(false, 'Anda tidak memiliki akses untuk mengambil data ini', null);
                    }
                }

                $id = rawurlencode($result['data'][0]['IDPermintaanKunjungan']);
                $date = $result['data'][0]['TanggalKunjungan'];

                $url = 'https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchKunjunganRelasi&IDPermintaanKunjungan=' . $id . '&TanggalKunjungan=' . $date;

                $response = Http::get($url);

                $partner = $response->json();

                if ($partner['status'] == 'success') {
                    $result['data'][0]['partner'] = $partner['data'];

                    return new ApiResource(true, 'Berhasil mengambil data dari API', $result);
                }

                return new ApiResource(false, 'Terjadi kegagalan saat mengambil data', $partner['message']);
            }

            return new ApiResource(false, 'Terjadi kegagalan saat mengambil data', $result['message']);
        } catch (\Exception $e) {
            return new ApiResource(false, 'Terjadi kesalahan saat memproses data', $e->getMessage());
        }
    }
}

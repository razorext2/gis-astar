<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
}

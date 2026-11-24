<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $stats  = null;
        $recent = [];
        $error  = null;

        try {
            $api = Http::baseUrl(config('services.internal_api.base_url'))
                ->acceptJson()
                ->timeout(5);

            $stats  = $api->get('/api/stats')->throw()->json('data');
            $recent = $api->get('/api/tickets', ['per_page' => 5])->throw()->json('data');
        } catch (HttpClientException $e) {
            $error = 'Data dashboard tidak dapat dimuat. Pastikan server API (INTERNAL_API_URL) sedang berjalan.';
        }

        return view('dashboard', compact('stats', 'recent', 'error'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HealthCheckController extends Controller
{
    public function index()
    {
        $services = [
            [
                "service" => "Google",
                "url" => "https://google.com"
            ],
            [
                "service" => "Fake",
                "url" => "https://fakeurl.12345"
            ],
            [
                "service" => "Yahoo",
                "url" => "https://yahoo.com"
            ]
        ];

        $check_results = [];

        foreach ($services as $service) {
            $check_results[] = $this->check($service);
        }

        return response()->json($check_results);
    }

    private function check($service)
    {
        $response_time = null;

        try {

            $start = microtime(true);

            $response = Http::timeout(5)->get($service["url"]);

            $response_time = (microtime(true) - $start) * 1000;

            if ($response->successful()) {
                return [
                    "service" => $service["service"],
                    "status" => "up",
                    "http_status" => $response->status(),
                    "response_time" => round($response_time, 2),
                    "checked_at" => now()
                ];
            } else {
                return [
                    "service" => $service["service"],
                    "status" => "down",
                    "http_status" => $response->status(),
                    "response_time" => round($response_time, 2),
                    "checked_at" => now()
                ];
            }
        } catch (\Exception $e) {
            return [
                "service" => $service["service"],
                "status" => "down",
                "http_status" => null,
                "response_time" => $response_time,
                "error" => $e->getMessage(),
                "checked_at" => now()
            ];
        }
    }
}

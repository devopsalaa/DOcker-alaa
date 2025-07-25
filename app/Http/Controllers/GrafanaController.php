<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GrafanaController extends Controller
{
    protected $client;

   public function __construct()
{
    $this->client = new Client([
        'base_uri' => env('GRAFANA_URL', 'http://localhost:3000'),
        'headers' => [
            'Authorization' => 'Bearer ' . env('GRAFANA_API_KEY'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ]
    ]);
}

    public function getDashboard($uid)
    {
        try {
            $response = $this->client->get("/api/dashboards/uid/{$uid}");
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

   public function getContainerMetrics($containerId)
{
    try {
        $metrics = [
            'cpu' => "rate(container_cpu_usage_seconds_total{container_name=~\"$containerId.*\"}[5m])",
            'memory' => "container_memory_usage_bytes{container_name=~\"$containerId.*\"}",
            'network_in' => "rate(container_network_receive_bytes_total{container_name=~\"$containerId.*\"}[5m])",
            'network_out' => "rate(container_network_transmit_bytes_total{container_name=~\"$containerId.*\"}[5m])",
        ];
        $results = [];
        foreach ($metrics as $type => $query) {
            $response = $this->client->get("/api/datasources/proxy/" . env('PROMETHEUS_DATASOURCE_ID', 1) . "/api/v1/query", [
                'query' => ['query' => $query]
            ]);
            $results[$type] = json_decode($response->getBody(), true);
        }
        return $results;
    } catch (\Exception $e) {
        Log::error("Grafana metrics fetch failed: " . $e->getMessage());
        return ['error' => 'Unable to fetch metrics. Ensure Prometheus is configured and running.'];
    }
}
}

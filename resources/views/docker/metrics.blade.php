<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">Container Metrics ({{ $containerId }})</h2>
            </div>
            <div class="p-6">
                @if(isset($error))
                    <div class="bg-red-50 border-l-4 border-red-600 text-red-800 p-4 mb-6 rounded-lg">
                        <span>{{ $error }}</span>
                        <p class="mt-2 text-sm">Check if Grafana and Prometheus are running. Verify the API key and datasource ID in your .env file.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">CPU Usage</h3>
                            <iframe src="{{ env('GRAFANA_URL') }}/d/193/docker-monitoring?orgId=1&var-container={{ $containerId }}&panelId=1" width="100%" height="300" frameborder="0"></iframe>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Memory Usage</h3>
                            <iframe src="{{ env('GRAFANA_URL') }}/d/193/docker-monitoring?orgId=1&var-container={{ $containerId }}&panelId=2" width="100%" height="300" frameborder="0"></iframe>
                        </div>
                    </div>
                @endif
                <div class="flex justify-end">
                    <a href="{{ env('GRAFANA_URL') }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Open in Grafana
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

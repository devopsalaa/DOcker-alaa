<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">Container Details ({{ $containerId }})</h2>
            </div>
            <div class="p-6">
                @if(isset($error))
                    <div class="bg-red-50 border-l-4 border-red-600 text-red-800 p-4 mb-6 rounded-lg">
                        <span>{{ $error }}</span>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">General</h3>
                            <p><strong>Name:</strong> {{ $details['Name'] }}</p>
                            <p><strong>Image:</strong> {{ $details['Config']['Image'] }}</p>
                            <p><strong>State:</strong> {{ $details['State']['Status'] }}</p>
                            <p><strong>Created:</strong> {{ \Carbon\Carbon::parse($details['Created'])->diffForHumans() }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Network</h3>
                            <p><strong>Ports:</strong>
                                @foreach($details['NetworkSettings']['Ports'] ?? [] as $containerPort => $hostPorts)
                                    {{ $containerPort }} -> {{ $hostPorts ? $hostPorts[0]['HostPort'] : 'N/A' }}<br>
                                @endforeach
                            </p>
                            <p><strong>IP Address:</strong> {{ $details['NetworkSettings']['IPAddress'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                @endif
                <div class="flex justify-end mt-4">
                    <a href="{{ route('docker.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Back to Containers
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

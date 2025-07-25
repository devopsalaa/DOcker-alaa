<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">Container Logs ({{ $containerId }})</h2>
            </div>
            <div class="p-6">
                @if(isset($error))
                    <div class="bg-red-50 border-l-4 border-red-600 text-red-800 p-4 mb-6 rounded-lg">
                        <span>{{ $error }}</span>
                    </div>
                @else
                    <div class="bg-gray-900 text-white p-4 rounded-lg font-mono text-sm max-h-[600px] overflow-auto">
                        <pre>{{ $logs }}</pre>
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

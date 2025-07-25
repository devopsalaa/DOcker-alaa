<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-600 text-green-800 p-4 mb-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
            @endif

            @if(session('error') || isset($error))
            <div class="bg-red-50 border-l-4 border-red-600 text-red-800 p-4 mb-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('error') ?? $error ?? 'An error occurred while fetching data.' }}</span>
                </div>
            </div>
            @endif

            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Containers Running -->
                <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Running Containers</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $runningContainers }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Containers -->
                <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6 ValdationError: The provided value is not of type 'Object'2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Total Containers</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalContainers }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Images -->
                <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Total Images</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalImages }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Action -->
                <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
                            <a href="{{ route('docker.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">Manage Containers</a>
                            <br>
                            <a href="{{ route('docker.images') }}" class="text-blue-600 hover:text-blue-800 text-sm">Manage Images</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Containers -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-8">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">Recent Containers</h3>
                </div>
                <div class="p-6">
                    @if(empty($recentContainers))
                    <p class="text-gray-600">No containers found.</p>
                    @else
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-gray-700">
                            <thead>
                                <tr class="bg-gray-100 text-sm uppercase tracking-wide text-gray-600">
                                    <th class="px-6 py-3 text-left font-semibold">ID</th>
                                    <th class="px-6 py-3 text-left font-semibold">Name</th>
                                    <th class="px-6 py-3 text-left font-semibold">Image</th>
                                    <th class="px-6 py-3 text-left font-semibold">Status</th>
                                    <th class="px-6 py-3 text-left font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentContainers as $container)
                                <tr class="hover:bg-gray-50 transition-colors border-b border-gray-200">
                                    <td class="px-6 py-4 font-mono text-sm">{{ substr($container['Id'], 0, 12) }}</td>
                                    <td class="px-6 py-4">{{ ltrim($container['Names'][0], '/') }}</td>
                                    <td class="px-6 py-4">{{ $container['Image'] }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $container['State'] === 'running' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            @if($container['State'] === 'running')
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-500" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            @else
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-500" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            @endif
                                            {{ $container['State'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 flex gap-3">
                                        <a href="{{ route('docker.metrics', substr($container['Id'], 0, 12)) }}"
                                           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                            Metrics
                                        </a>
                                        @if($container['State'] === 'running')
                                        <form method="POST" action="{{ route('docker.stop', substr($container['Id'], 0, 12)) }}">
                                            @csrf
                                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path>
                                                </svg>
                                                Stop
                                            </button>
                                        </form>
                                        @else
                                        <form method="POST" action="{{ route('docker.start', substr($container['Id'], 0, 12)) }}">
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Start
                                            </button>
                                        </form>
                                        @endif
                                        <form method="POST" action="{{ route('docker.destroy', substr($container['Id'], 0, 12)) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                        <script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('form[action^="{{ route('docker.destroy', '') }}"]');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function (event) {
                const confirmed = confirm('Are you sure you want to delete this container?');
                if (!confirmed) {
                    event.preventDefault();
                }
            });
        });
    });
</script>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Recent Images -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">Recent Images</h3>
                </div>
                <div class="p-6">
                    @if(empty($recentImages))
                    <p class="text-gray-600">No images found.</p>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tags</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentImages as $image)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">
                                        {{ substr($image['Id'], 7, 12) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        @if($image['RepoTags'])
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($image['RepoTags'] as $tag)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $tag }}
                                                </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">&lt;none&gt;</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ round($image['Size'] / 1024 / 1024, 2) }} MB
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ \Carbon\Carbon::createFromTimestamp($image['Created'])->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <button class="text-blue-600 hover:text-blue-900"
                                                    onclick="document.getElementById('runImageModal').classList.remove('hidden');
                                                             document.getElementById('runImageName').value = '{{ $image['RepoTags'][0] ?? '' }}'">
                                                Run
                                            </button>
                                            <button class="text-red-600 hover:text-red-900">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Run Image Modal (Reused from images.blade.php) -->
            <div id="runImageModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-white rounded-xl w-full max-w-lg overflow-hidden shadow-xl">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-gray-800">Run Docker Container</h3>
                        <button onclick="document.getElementById('runImageModal').classList.add('hidden')"
                                class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('docker.store') }}">
                        @csrf
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                                <input type="text" id="runImageName" name="image" readonly
                                       class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Container Name</label>
                                <div class="flex">
                                    <input type="text" name="name" placeholder="my-container"
                                           class="flex-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <button type="button" onclick="generateContainerName()"
                                            class="ml-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                        Generate
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Port Mapping</label>
                                <div id="runPortsContainer">
                                    <div class="flex gap-3 mb-3 port-mapping">
                                        <div class="flex-1">
                                            <input type="number" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                                   name="ports[0][container]" placeholder="Container Port">
                                        </div>
                                        <div class="flex-1">
                                            <input type="number" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                                   name="ports[0][host]" placeholder="Host Port">
                                        </div>
                                        <div>
                                            <button type="button" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md remove-port">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" onclick="addPortMapping()"
                                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md text-sm font-medium transition-colors mt-2">
                                    Add Port
                                </button>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                            <button type="button" onclick="document.getElementById('runImageModal').classList.add('hidden')"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Run Container
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                // Generate container name
                function generateContainerName() {
                    const randomString = Math.random().toString(36).substring(2, 8);
                    const imageName = document.getElementById('runImageName').value.split(':')[0] || 'container';
                    const nameInput = document.querySelector('#runImageModal input[name="name"]');
                    nameInput.value = `${imageName}-${randomString}`;
                }

                // Add port mapping
                function addPortMapping() {
                    const container = document.getElementById('runPortsContainer');
                    const count = container.querySelectorAll('.port-mapping').length;
                    const newPort = document.createElement('div');
                    newPort.className = 'flex gap-3 mb-3 port-mapping';
                    newPort.innerHTML = `
                        <div class="flex-1">
                            <input type="number" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                   name="ports[${count}][container]" placeholder="Container Port">
                        </div>
                        <div class="flex-1">
                            <input type="number" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                   name="ports[${count}][host]" placeholder="Host Port">
                        </div>
                        <div>
                            <button type="button" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md remove-port">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    `;
                    container.appendChild(newPort);
                }

                // Remove port mapping
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-port') || e.target.closest('.remove-port')) {
                        e.target.closest('.port-mapping').remove();
                    }
                });
            </script>
        </div>
    </div>
</x-app-layout>

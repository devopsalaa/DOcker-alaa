<x-app-layout>
    <div class="container mx-auto px-4 py-8 max-w-7xl" style="max-width: 100%">
        <!-- Error Display -->
        @if(isset($error))
        <div class="bg-red-50 border-l-4 border-red-600 text-red-800 p-4 mb-6 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <div>
                    <strong class="font-semibold">Error:</strong> {{ $error }}
                    <p class="mt-1 text-sm">Make sure Docker is running and the API is accessible.</p>
                </div>
            </div>
        </div>
        @endif

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

        @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-600 text-red-800 p-4 mb-6 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <!-- Quick Start Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Quick Start</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                <!-- Nginx -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <img src="https://www.docker.com/wp-content/uploads/2022/03/vertical-logo-monochromatic.png" alt="Docker" class="h-8 mr-3">
                            <h3 class="font-semibold text-lg">Nginx</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">High performance web server and reverse proxy</p>
                        <form method="POST" action="{{ route('docker.store') }}" class="flex gap-2">
                            @csrf
                            <input type="hidden" name="image" value="nginx:latest">
                            <input type="hidden" name="name" value="nginx-{{ substr(Str::uuid(), 0, 8) }}">
                            <input type="hidden" name="ports[0][container]" value="80">
                            <input type="hidden" name="ports[0][host]" value="8080">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors flex-1">
                                Deploy
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Redis -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <img src="https://www.docker.com/wp-content/uploads/2022/03/vertical-logo-monochromatic.png" alt="Docker" class="h-8 mr-3">
                            <h3 class="font-semibold text-lg">Redis</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">In-memory data structure store, used as database</p>
                        <form method="POST" action="{{ route('docker.store') }}" class="flex gap-2">
                            @csrf
                            <input type="hidden" name="image" value="redis:latest">
                            <input type="hidden" name="name" value="redis-{{ substr(Str::uuid(), 0, 8) }}">
                            <input type="hidden" name="ports[0][container]" value="6379">
                            <input type="hidden" name="ports[0][host]" value="6379">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors flex-1">
                                Deploy
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MySQL -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <img src="https://www.docker.com/wp-content/uploads/2022/03/vertical-logo-monochromatic.png" alt="Docker" class="h-8 mr-3">
                            <h3 class="font-semibold text-lg">MySQL</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Popular open-source relational database</p>
                        <form method="POST" action="{{ route('docker.store') }}" class="flex gap-2">
                            @csrf
                            <input type="hidden" name="image" value="mysql:latest">
                            <input type="hidden" name="name" value="mysql-{{ substr(Str::uuid(), 0, 8) }}">
                            <input type="hidden" name="ports[0][container]" value="3306">
                            <input type="hidden" name="ports[0][host]" value="3306">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors flex-1">
                                Deploy
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Postgres -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <img src="https://www.docker.com/wp-content/uploads/2022/03/vertical-logo-monochromatic.png" alt="Docker" class="h-8 mr-3">
                            <h3 class="font-semibold text-lg">PostgreSQL</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Powerful open-source object-relational database</p>
                        <form method="POST" action="{{ route('docker.store') }}" class="flex gap-2">
                            @csrf
                            <input type="hidden" name="image" value="postgres:latest">
                            <input type="hidden" name="name" value="postgres-{{ substr(Str::uuid(), 0, 8) }}">
                            <input type="hidden" name="ports[0][container]" value="5432">
                            <input type="hidden" name="ports[0][host]" value="5432">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors flex-1">
                                Deploy
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Container Management Section -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h5 class="text-xl font-bold text-gray-800">Container Management</h5>
                    <p class="text-sm text-gray-600 mt-1">Manage your running Docker containers</p>
                </div>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors flex items-center" data-bs-toggle="modal" data-bs-target="#createContainerModal">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Container
                </button>

            </div>

            <div class="p-6">
                <!-- Available Images -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Available Images
                    </h3>
                    @php $images = app('App\Services\DockerService')->listImages(); @endphp
                    @if(isset($images['error']))
                        <p class="text-red-600">Error fetching images: {{ $images['error'] }}</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                            @foreach($images as $image)
                                @foreach($image['RepoTags'] ?? [] as $tag)
                                    <div class="bg-white p-3 rounded border border-gray-200 text-sm font-mono hover:bg-gray-100 transition-colors">
                                        {{ $tag }}
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Containers Table -->
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-gray-700">
                        <thead>
                            <tr class="bg-gray-100 text-sm uppercase tracking-wide text-gray-600">
                                <th class="px-6 py-3 text-left font-semibold">ID</th>
                                <th class="px-6 py-3 text-left font-semibold">Name</th>
                                <th class="px-6 py-3 text-left font-semibold">Image</th>
                                <th class="px-6 py-3 text-left font-semibold">Status</th>
                                <th class="px-6 py-3 text-left font-semibold">Health</th>
                                <th class="px-6 py-3 text-left font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($containers as $container)
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
                                <td class="px-6 py-4">
                                    @if($container['State'] === 'running' && isset($container['Health']))
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $container['Health']['Status'] === 'healthy' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $container['Health']['Status'] }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 italic">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex gap-3">
                                      <!-- Metrics Button -->
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

                                    <a href="{{ route('docker.logs', substr($container['Id'], 0, 12)) }}"
                                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20h4M12 4v16m8-8H4"></path>
                                            </svg>
                                            Logs
                                    </a>
                                    <a href="{{ route('docker.details', substr($container['Id'], 0, 12)) }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Details
                                </a>
                                <form method="POST" action="{{ route('docker.backup', substr($container['Id'], 0, 12)) }}">
                                @csrf
                                <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                    </svg>
                                    Backup
                                </button>
                            </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Container Modal -->
    <div class="modal fade" id="createContainerModal" tabindex="-1" aria-labelledby="createContainerModalLabel" aria-hidden="true">
        <div class="modal-dialog max-w-lg">
            <div class="modal-content rounded-xl">
                <div class="modal-header px-6 py-4 border-b border-gray-200">
                    <h5 class="modal-title text-xl font-bold text-gray-800" id="createContainerModalLabel">Create New Container</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('docker.store') }}">
                    @csrf
                    <div class="modal-body p-6">
                        <div class="mb-5">
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                            <select id="image" name="image" class="block w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select an image</option>
                                <option value="nginx:latest">nginx:latest</option>
                                <option value="redis:latest">redis:latest</option>
                                <option value="mysql:latest">mysql:latest</option>
                                <option value="postgres:latest">postgres:latest</option>
                                <option value="mongo:latest">mongo:latest</option>
                                <option value="node:latest">node:latest</option>
                                <option value="python:latest">python:latest</option>
                                <option value="php:latest">php:latest</option>
                                <option value="alpine:latest">alpine:latest</option>
                                <option value="ubuntu:latest">ubuntu:latest</option>
                                <option value="custom">Custom image...</option>
                            </select>
                            <input type="text" id="custom-image" name="custom-image" class="hidden mt-2 block w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter custom image name">
                        </div>
                        <div class="mb-5">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                            <div class="flex">
                                <input type="text" class="block w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="name" name="name" placeholder="my-container" required>
                                <button type="button" id="generate-name" class="ml-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                    Generate
                                </button>
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Port Mapping</label>
                            <div id="ports-container">
                                <div class="flex gap-3 mb-3 port-mapping">
                                    <div class="flex-1">
                                        <input type="number" class="block w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="ports[0][container]" placeholder="Container Port (e.g., 80)">
                                    </div>
                                    <div class="flex-1">
                                        <input type="number" class="block w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="ports[0][host]" placeholder="Host Port (e.g., 8080)">
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
                            <button type="button" id="add-port" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium mt-2 transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Port
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer px-6 py-4 bg-gray-50 flex justify-end gap-3">
                        <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2.5 rounded-md font-medium transition-colors flex items-center" data-bs-dismiss="modal">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Close
                        </button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-md font-medium transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Container
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ env('PUSHER_APP_KEY') }}',
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        forceTLS: true
    });
    Echo.channel('containers').listen('ContainerUpdated', (e) => {
        const row = document.querySelector(`tr[data-id="${e.id}"]`);
        if (row) {
            const status = row.querySelector('.status');
            status.className = `inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${e.state === 'running' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`;
            status.innerHTML = `<svg class="-ml-0.5 mr-1.5 h-2 w-2 ${e.state === 'running' ? 'text-green-500' : 'text-red-500'}" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>${e.state}`;
        }
    });
</script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image selection
            const imageSelect = document.getElementById('image');
            const customImageInput = document.getElementById('custom-image');

            imageSelect.addEventListener('change', function() {
                if (this.value === 'custom') {
                    customImageInput.classList.remove('hidden');
                    customImageInput.setAttribute('required', 'required');
                } else {
                    customImageInput.classList.add('hidden');
                    customImageInput.removeAttribute('required');
                }
            });

            // Generate random container name
            document.getElementById('generate-name').addEventListener('click', function() {
                const randomString = Math.random().toString(36).substring(2, 8);
                const nameInput = document.getElementById('name');
                const selectedImage = document.getElementById('image').value.split(':')[0] || 'container';
                nameInput.value = `${selectedImage}-${randomString}`;
            });

            // Add port mapping
            document.getElementById('add-port').addEventListener('click', function() {
                const container = document.getElementById('ports-container');
                const count = container.querySelectorAll('.port-mapping').length;
                const newPort = document.createElement('div');
                newPort.className = 'flex gap-3 mb-3 port-mapping';
                newPort.innerHTML = `
                    <div class="flex-1">
                        <input type="number" class="block w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="ports[${count}][container]" placeholder="Container Port">
                    </div>
                    <div class="flex-1">
                        <input type="number" class="block w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="ports[${count}][host]" placeholder="Host Port">
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
            });

            // Remove port mapping
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-port') || e.target.closest('.remove-port')) {
                    e.target.closest('.port-mapping').remove();
                }
            });
        });
    </script>
</x-app-layout>

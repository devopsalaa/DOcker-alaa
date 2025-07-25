<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-md shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <p class="text-red-700">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- Main Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Docker Images</h2>
                    <p class="text-sm text-gray-600 mt-1">Manage your Docker images and build new ones</p>
                </div>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg font-medium transition-colors flex items-center"
                        onclick="document.getElementById('buildImageModal').classList.remove('hidden')">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Build Image
                </button>
            </div>

            <div class="px-6 py-4">
                <!-- Search and Filter -->
                <div class="mb-4 flex justify-between items-center">
                    <div class="relative w-64">
                        <input type="text" placeholder="Search images..."
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Sort by:</span>
                        <select class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option>Newest</option>
                            <option>Oldest</option>
                            <option>Size (Large first)</option>
                            <option>Size (Small first)</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
    <form method="POST" action="{{ route('docker.pull') }}" class="flex gap-3">
        @csrf
        <input type="text" name="image" placeholder="e.g., nginx:latest" class="flex-1 border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
            Pull Image
        </button>
    </form>
</div>
                <!-- Images Table -->
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
                            @foreach($images as $image)
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
                                        <button class="text-green-600 hover:text-green-900">
                                            Pull
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

                <!-- Pagination -->
                <div class="mt-4 flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">{{ count($images) }}</span> images
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Previous
                        </button>
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Build Image Modal -->
    <div id="buildImageModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl w-full max-w-lg overflow-hidden shadow-xl">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">Build Docker Image</h3>
                <button onclick="document.getElementById('buildImageModal').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('docker.build') }}" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image Tag</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" name="tag" required placeholder="my-image:latest"
                                   class="focus:ring-blue-500 focus:border-blue-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Build Context</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="dockerfile" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload a tar archive</span>
                                        <input id="dockerfile" name="dockerfile" type="file" required accept=".tar" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">Tar archive containing your build context (including Dockerfile)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('buildImageModal').classList.add('hidden')"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Build Image
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Run Image Modal -->
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
</x-app-layout>

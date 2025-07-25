<x-app-layout>
    sty
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">Create New Container</h1>
            </div>

            <div class="p-6">
                @if(isset($error))
                <div class="bg-red-50 border-l-4 border-red-600 text-red-800 p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $error }}</span>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('docker.store') }}">
                    @csrf

                    <!-- Image Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Docker Image</label>

                        <!-- Popular Images -->
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-600 mb-2">Popular Images</p>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                @foreach($popularImages as $popularImage)
                                <button type="button" class="image-option border rounded-md p-3 text-left hover:bg-gray-100 focus:ring-2 focus:ring-blue-500" data-image="{{ $popularImage['tag'] }}">
                                    <div class="flex items-center">
                                        <img src="{{ $popularImage['logo'] }}" alt="{{ $popularImage['name'] }}" class="w-8 h-8 mr-2">
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $popularImage['name'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $popularImage['tag'] }}</p>
                                        </div>
                                    </div>
                                </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Image Selection Dropdown -->
                        <div class="flex gap-3">
                            <select id="image" name="image" class="flex-1 border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select an available image</option>
                                @forelse($imageTags as $tag)
                                    <option value="{{ $tag }}">{{ $tag }}</option>
                                @empty
                                    <option value="" disabled>No local images available</option>
                                @endforelse
                                <option value="custom">Custom image...</option>
                            </select>
                            <input type="text" id="custom-image" name="custom_image" class="hidden flex-1 border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter custom image (e.g., nginx:latest)">
                        </div>
                        @error('image')
                            <p class="mt-2 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                        @error('custom_image')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if(empty($imageTags))
                            <p class="mt-2 text-sm text-yellow-600">No local Docker images found. Pull some images first using <code>docker pull</code> or select a popular image above.</p>
                        @endif
                    </div>

                    <!-- Container Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                        <div class="flex">
                            <input type="text" class="flex-1 border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" id="name" name="name" placeholder="my-container" required>
                            <button type="button" id="generate-name" class="ml-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                                Generate
                            </button>
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Port Mapping -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Port Mapping</label>
                        <div id="ports-container">
                            <div class="flex gap-3 mb-3 port-mapping">
                                <div class="flex-1">
                                    <input type="number" class="block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" name="ports[0][container]" placeholder="Container Port (e.g., 80)">
                                </div>
                                <div class="flex-1">
                                    <input type="number" class="block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" name="ports[0][host]" placeholder="Host Port (e.g., 8080)">
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
                        <button type="button" id="add-port" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Port
                        </button>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('docker.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2.5 rounded-md font-medium">
                            Cancel
                        </a>
                        <!-- Add loading state to submit button -->
<button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-md font-medium disabled:opacity-50" id="create-btn">
    <svg class="hidden animate-spin h-5 w-5 mr-2 inline" id="spinner" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8h8a8 8 0 01-8 8 8 8 0 01-8-8z"></path>
    </svg>
    Create Container
</button>
<script>
    document.querySelector('form').addEventListener('submit', () => {
        const btn = document.getElementById('create-btn');
        btn.disabled = true;
        document.getElementById('spinner').classList.remove('hidden');
    });
</script>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image selection
            const imageSelect = document.getElementById('image');
            const customImageInput = document.getElementById('custom-image');
            const imageOptions = document.querySelectorAll('.image-option');

            // Debugging function to log issues
            function debug(message) {
                console.log(`[Image Selection Debug] ${message}`);
            }

            // Handle popular image selection
            imageOptions.forEach(option => {
                option.addEventListener('click', function() {
                    debug(`Selected popular image: ${this.dataset.image}`);
                    imageSelect.value = this.dataset.image;
                    customImageInput.classList.add('hidden');
                    customImageInput.removeAttribute('required');
                    customImageInput.value = '';
                    imageOptions.forEach(opt => opt.classList.remove('bg-blue-100', 'border-blue-500'));
                    this.classList.add('bg-blue-100', 'border-blue-500');
                    imageSelect.dispatchEvent(new Event('change'));
                });
            });

            // Handle dropdown selection
            imageSelect.addEventListener('change', function() {
                debug(`Dropdown changed to: ${this.value}`);
                imageOptions.forEach(opt => opt.classList.remove('bg-blue-100', 'border-blue-500'));

                if (this.value === 'custom') {
                    debug('Showing custom image input');
                    customImageInput.classList.remove('hidden');
                    customImageInput.setAttribute('required', 'required');
                    customImageInput.focus();
                } else {
                    debug('Hiding custom image input');
                    customImageInput.classList.add('hidden');
                    customImageInput.removeAttribute('required');
                    customImageInput.value = '';
                    const selectedOption = Array.from(imageOptions).find(opt => opt.dataset.image === this.value);
                    if (selectedOption) {
                        selectedOption.classList.add('bg-blue-100', 'border-blue-500');
                    }
                }
            });

            // Handle custom image input
            customImageInput.addEventListener('input', function() {
                if (this.value) {
                    debug(`Custom image input: ${this.value}`);
                    imageSelect.value = 'custom';
                    imageOptions.forEach(opt => opt.classList.remove('bg-blue-100', 'border-blue-500'));
                }
            });

            // Generate random container name
            document.getElementById('generate-name').addEventListener('click', function() {
                const randomString = Math.random().toString(36).substring(2, 8);
                const nameInput = document.getElementById('name');
                const selectedImage = (customImageInput.value || imageSelect.value || 'container').split(':')[0];
                nameInput.value = `${selectedImage}-${randomString}`;
                debug(`Generated container name: ${nameInput.value}`);
            });

            // Add port mapping
            document.getElementById('add-port').addEventListener('click', function() {
                const container = document.getElementById('ports-container');
                const count = container.querySelectorAll('.port-mapping').length;
                const newPort = document.createElement('div');
                newPort.className = 'flex gap-3 mb-3 port-mapping';
                newPort.innerHTML = `
                    <div class="flex-1">
                        <input type="number" class="block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" name="ports[${count}][container]" placeholder="Container Port">
                    </div>
                    <div class="flex-1">
                        <input type="number" class="block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" name="ports[${count}][host]" placeholder="Host Port">
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
                debug(`Added port mapping: ${count}`);
            });

            // Remove port mapping
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-port') || e.target.closest('.remove-port')) {
                    e.target.closest('.port-mapping').remove();
                    debug('Removed port mapping');
                }
            });
        });
    </script>
    @endsection
</x-app-layout>

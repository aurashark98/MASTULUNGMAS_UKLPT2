<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Tugas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-mtm-dark-surface overflow-hidden shadow-xl sm:rounded-3xl p-8">
                <form action="{{ route('tasks.update', $task) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <x-input-label for="category_id" :value="__('Kategori Layanan')" />
                        <select id="category_id" name="category_id" onchange="updatePrice()" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-mtm-dark text-gray-900 dark:text-gray-100 focus:border-mtm-red focus:ring-mtm-red rounded-xl shadow-sm">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $task->category_id == $category->id ? 'selected' : '' }} class="text-gray-900 dark:text-gray-100">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="title" :value="__('Judul Tugas')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full text-gray-900 dark:text-gray-100" value="{{ $task->title }}" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Deskripsi')" />
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-mtm-dark text-gray-900 dark:text-gray-100 focus:border-mtm-red focus:ring-mtm-red rounded-xl shadow-sm" required>{{ $task->description }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="distance" :value="__('Estimasi Jarak Tempuh (Km)')" />
                            <x-text-input id="distance" name="distance" type="number" step="0.1" min="0" class="mt-1 block w-full text-gray-900 dark:text-gray-100 bg-gray-150 dark:bg-white/5 font-bold cursor-not-allowed" value="{{ $task->distance }}" required readonly />
                            <x-input-error :messages="$errors->get('distance')" class="mt-2" />
                            <p class="text-[10px] text-gray-500 mt-1">Dihitung otomatis dari peta (Rp 3.000 / Km)</p>
                        </div>
                        <div>
                            <x-input-label for="duration" :value="__('Estimasi Durasi Kerja (Jam)')" />
                            <x-text-input id="duration" name="duration" type="number" min="1" class="mt-1 block w-full text-gray-900 dark:text-gray-100" value="{{ $task->duration }}" required oninput="updatePrice()" />
                            <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                            <p class="text-[10px] text-gray-500 mt-1">Biaya per Jam: Rp 10.000</p>
                        </div>
                    </div>

                    <!-- Premium Price Breakdown Box -->
                    <div class="bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-gray-800 rounded-2xl p-6 space-y-3">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400">Rincian Estimasi Harga Layanan (Kalkulator MTM)</h4>
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300">
                            <span>Tarif Dasar Kategori:</span>
                            <span id="lbl-base-price" class="font-semibold">Rp 15.000</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300">
                            <span>Biaya Jarak Tempuh:</span>
                            <span id="lbl-distance-fee" class="font-semibold">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300">
                            <span>Biaya Durasi Pengerjaan:</span>
                            <span id="lbl-duration-fee" class="font-semibold">Rp 10.000</span>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-3 flex justify-between items-center">
                            <span class="text-base font-bold text-gray-800 dark:text-gray-100">Total Biaya Tugas:</span>
                            <span id="lbl-total-price" class="text-2xl font-black text-mtm-red">Rp 25.000</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- Input Lokasi Asal -->
                        <div>
                            <x-input-label for="location" :value="__('Lokasi Asal (Penjemputan/Mulai)')" />
                            <div class="flex flex-col sm:flex-row gap-2 mt-1">
                                <div class="relative flex-1">
                                    <x-text-input id="location" name="location" type="text" class="block w-full text-gray-900 dark:text-gray-100" value="{{ $task->location }}" required />
                                </div>
                                <div class="flex gap-2 shrink-0">
                                    <button type="button" id="btn-search-origin" class="px-5 py-3 bg-gray-150 hover:bg-gray-200 dark:bg-white/5 dark:hover:bg-white/10 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-bold border border-gray-300 dark:border-gray-700 transition-all cursor-pointer">
                                        Cari Peta
                                    </button>
                                    <button type="button" id="btn-gps-origin" class="px-5 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl text-xs font-bold shadow hover:brightness-110 transition-all flex items-center gap-1.5 cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        GPS Saya
                                    </button>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <!-- Input Lokasi Tujuan -->
                        <div>
                            <x-input-label for="destination_location" :value="__('Lokasi Tujuan (Akhir)')" />
                            <div class="flex flex-col sm:flex-row gap-2 mt-1">
                                <div class="relative flex-1">
                                    <x-text-input id="destination_location" name="destination_location" type="text" class="block w-full text-gray-900 dark:text-gray-100" value="{{ $task->destination_location }}" placeholder="Ketik lokasi tujuan atau seret pin merah di peta" required />
                                </div>
                                <div class="flex gap-2 shrink-0">
                                    <button type="button" id="btn-search-destination" class="px-5 py-3 bg-gray-150 hover:bg-gray-200 dark:bg-white/5 dark:hover:bg-white/10 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-bold border border-gray-300 dark:border-gray-700 transition-all cursor-pointer">
                                        Cari Peta
                                    </button>
                                    <button type="button" id="btn-gps-destination" class="px-5 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl text-xs font-bold shadow hover:brightness-110 transition-all flex items-center gap-1.5 cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        GPS Saya
                                    </button>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('destination_location')" class="mt-2" />
                        </div>

                        <div class="relative">
                            <div id="map" class="w-full rounded-2xl border border-gray-300 dark:border-gray-700 shadow-inner z-10" style="height: 500px;"></div>
                            <div id="map-loading" class="absolute inset-0 bg-white/80 dark:bg-black/80 rounded-2xl flex items-center justify-center text-xs font-bold text-gray-500 dark:text-gray-400 z-20 hidden">
                                <span class="animate-pulse">Menghubungi layanan peta/GPS...</span>
                            </div>
                        </div>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400">Anda dapat mencari alamat secara manual atau menggunakan GPS. Seret **pin biru** untuk lokasi asal dan **pin merah** untuk lokasi tujuan untuk menghitung jarak secara otomatis.</p>
                    </div>

                    <div>
                        <x-input-label for="images" :value="__('Unggah Foto Tambahan (Opsional)')" />
                        <input type="file" id="images" name="images[]" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-mtm-red hover:file:bg-red-100" />
                        
                        @if($task->images)
                            <div class="mt-4 grid grid-cols-3 gap-4">
                                @foreach($task->images as $image)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $image) }}" class="w-full h-20 object-cover rounded-xl" alt="Task Image">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        <a href="{{ route('tasks.show', $task) }}" class="text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Batal</a>
                        <x-primary-button class="bg-gradient-to-r from-mtm-red to-mtm-red-dark hover:from-mtm-red-dark hover:to-mtm-red py-3 px-8 rounded-full">
                            {{ __('Simpan Perubahan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
window.updatePrice = function() {
    const categorySelect = document.getElementById('category_id');
    const distanceInput = document.getElementById('distance');
    const durationInput = document.getElementById('duration');
    
    if (!categorySelect || !distanceInput || !durationInput) return;
    
    const selectedOption = categorySelect.options[categorySelect.selectedIndex];
    const categoryName = selectedOption ? selectedOption.text.toLowerCase() : '';
    
    let basePrice = 15000;
    if (categoryName.includes('antre')) basePrice = 15000;
    else if (categoryName.includes('bersih') || categoryName.includes('cleaning')) basePrice = 25000;
    else if (categoryName.includes('kirim') || categoryName.includes('kurir') || categoryName.includes('delivery')) basePrice = 15000;
    else if (categoryName.includes('belanja') || categoryName.includes('shopper')) basePrice = 20000;
    
    const distance = parseFloat(distanceInput.value) || 0;
    const duration = parseInt(durationInput.value) || 1;
    
    const distanceFee = distance * 3000;
    const durationFee = duration * 10000;
    const total = basePrice + distanceFee + durationFee;
    
    document.getElementById('lbl-base-price').innerText = 'Rp ' + basePrice.toLocaleString('id-ID');
    document.getElementById('lbl-distance-fee').innerText = 'Rp ' + distanceFee.toLocaleString('id-ID');
    document.getElementById('lbl-duration-fee').innerText = 'Rp ' + durationFee.toLocaleString('id-ID');
    document.getElementById('lbl-total-price').innerText = 'Rp ' + total.toLocaleString('id-ID');
};

document.addEventListener('DOMContentLoaded', function() {
    // Default location (Jakarta)
    var defaultLat = -6.2088;
    var defaultLng = 106.8456;
    
    // Initialize Leaflet Map
    var map = L.map('map', {
        zoomControl: true,
        scrollWheelZoom: true
    }).setView([defaultLat, defaultLng], 13);
    
    // OpenStreetMap Tiles (using a sleek dark mode tile if in dark mode, or standard tile)
    var isDark = document.documentElement.classList.contains('dark');
    var tileUrl = isDark 
        ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png' 
        : 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    var attribution = isDark
        ? '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
        : '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
        
    L.tileLayer(tileUrl, {
        maxZoom: 19,
        attribution: attribution
    }).addTo(map);

    // Custom Marker Blue (Origin)
    var originIcon = L.divIcon({
        html: `<div class="relative w-8 h-8 flex items-center justify-center">
            <div class="absolute w-8 h-8 rounded-full bg-blue-500/30 animate-ping"></div>
            <div class="w-6 h-6 bg-gradient-to-tr from-blue-600 to-indigo-500 rounded-full border-2 border-white dark:border-mtm-dark shadow-lg flex items-center justify-center">
                <div class="w-2 h-2 bg-white rounded-full"></div>
            </div>
        </div>`,
        className: 'mtm-custom-marker',
        iconSize: [32, 32],
        iconAnchor: [16, 16]
    });

    // Custom Marker Red (Destination)
    var destinationIcon = L.divIcon({
        html: `<div class="relative w-8 h-8 flex items-center justify-center">
            <div class="absolute w-8 h-8 rounded-full bg-red-500/30 animate-ping"></div>
            <div class="w-6 h-6 bg-gradient-to-tr from-red-600 to-amber-500 rounded-full border-2 border-white dark:border-mtm-dark shadow-lg flex items-center justify-center">
                <div class="w-2 h-2 bg-white rounded-full"></div>
            </div>
        </div>`,
        className: 'mtm-custom-marker',
        iconSize: [32, 32],
        iconAnchor: [16, 16]
    });
    
    var markerOrigin = L.marker([defaultLat, defaultLng], {
        draggable: true,
        icon: originIcon
    }).addTo(map);

    var markerDestination = L.marker([-6.2150, 106.8500], {
        draggable: true,
        icon: destinationIcon
    }).addTo(map);

    var polyline = L.polyline([markerOrigin.getLatLng(), markerDestination.getLatLng()], {
        color: '#ef4444',
        weight: 4,
        dashArray: '6, 6'
    }).addTo(map);
    
    var mapLoading = document.getElementById('map-loading');
    
    function calculateDistance() {
        if (markerOrigin && markerDestination) {
            var originLatLng = markerOrigin.getLatLng();
            var destLatLng = markerDestination.getLatLng();
            var distanceInMeters = originLatLng.distanceTo(destLatLng);
            var distanceInKm = distanceInMeters / 1000;
            document.getElementById('distance').value = distanceInKm.toFixed(1);
            
            polyline.setLatLngs([originLatLng, destLatLng]);
            updatePrice();
        }
    }
    
    // Reverse Geocoding function
    function reverseGeocode(lat, lng, targetInputId) {
        mapLoading.classList.remove('hidden');
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=id`)
            .then(response => response.json())
            .then(data => {
                if (data && data.display_name) {
                    document.getElementById(targetInputId).value = data.display_name;
                }
                mapLoading.classList.add('hidden');
            })
            .catch(error => {
                console.error('Error reverse geocoding:', error);
                mapLoading.classList.add('hidden');
            });
    }

    // Geocoding function for Search
    function searchAddress(inputId, marker) {
        var query = document.getElementById(inputId).value;
        if (!query) return;
        
        mapLoading.classList.remove('hidden');
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1&accept-language=id`)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    var lat = parseFloat(data[0].lat);
                    var lon = parseFloat(data[0].lon);
                    var newPos = [lat, lon];
                    marker.setLatLng(newPos);
                    
                    var bounds = L.latLngBounds([markerOrigin.getLatLng(), markerDestination.getLatLng()]);
                    map.fitBounds(bounds, { padding: [50, 50] });
                    
                    document.getElementById(inputId).value = data[0].display_name;
                    calculateDistance();
                } else {
                    alert('Lokasi tidak ditemukan.');
                }
                mapLoading.classList.add('hidden');
            })
            .catch(error => {
                console.error('Error geocoding:', error);
                mapLoading.classList.add('hidden');
            });
    }
    
    // GPS Geolocation function
    function getGPSLocation(inputId, marker) {
        if (!navigator.geolocation) {
            alert('Geolocation tidak didukung oleh browser Anda.');
            return;
        }
        
        mapLoading.classList.remove('hidden');
        navigator.geolocation.getCurrentPosition(
            function(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                var newPos = [lat, lng];
                
                marker.setLatLng(newPos);
                
                var bounds = L.latLngBounds([markerOrigin.getLatLng(), markerDestination.getLatLng()]);
                map.fitBounds(bounds, { padding: [50, 50] });
                
                reverseGeocode(lat, lng, inputId);
                calculateDistance();
            },
            function(error) {
                console.error('Error getting location:', error);
                alert('Gagal mendapatkan lokasi GPS Anda.');
                mapLoading.classList.add('hidden');
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    }
    
    // Event listeners
    markerOrigin.on('dragend', function() {
        var latLng = markerOrigin.getLatLng();
        reverseGeocode(latLng.lat, latLng.lng, 'location');
        calculateDistance();
    });
    
    markerDestination.on('dragend', function() {
        var latLng = markerDestination.getLatLng();
        reverseGeocode(latLng.lat, latLng.lng, 'destination_location');
        calculateDistance();
    });
    
    document.getElementById('btn-gps-origin').addEventListener('click', function() { getGPSLocation('location', markerOrigin); });
    document.getElementById('btn-search-origin').addEventListener('click', function() { searchAddress('location', markerOrigin); });
    
    document.getElementById('btn-gps-destination').addEventListener('click', function() { getGPSLocation('destination_location', markerDestination); });
    document.getElementById('btn-search-destination').addEventListener('click', function() { searchAddress('destination_location', markerDestination); });
    
    // Prevent form submission on search map or GPS click
    ['btn-gps-origin', 'btn-search-origin', 'btn-gps-destination', 'btn-search-destination'].forEach(id => {
        document.getElementById(id).addEventListener('keydown', function(e) { if(e.key === 'Enter') e.preventDefault(); });
    });
    
    // Allow enter key to trigger map search when typing in location
    document.getElementById('location').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchAddress('location', markerOrigin);
        }
    });
    document.getElementById('destination_location').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchAddress('destination_location', markerDestination);
        }
    });

    // Check if locations have text initially and geocode them
    if (document.getElementById('location').value !== '') {
        setTimeout(function() { searchAddress('location', markerOrigin); }, 300);
    }
    if (document.getElementById('destination_location').value !== '') {
        setTimeout(function() { searchAddress('destination_location', markerDestination); }, 600);
    }

    calculateDistance();
    updatePrice();

    // Periodically invalidate map size to solve partial rendering/gray box bugs caused by parent transition animations
    var invalidateInterval = setInterval(function() {
        if (map) {
            map.invalidateSize();
        }
    }, 200);
    setTimeout(function() {
        clearInterval(invalidateInterval);
    }, 2500);
});
</script>
</x-app-layout>
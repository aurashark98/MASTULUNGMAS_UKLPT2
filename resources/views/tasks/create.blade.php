<x-app-layout>
    <!-- Dot Grid Background -->
    <div class="fixed inset-0 dot-grid opacity-[0.3] pointer-events-none z-0"></div>

    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto relative z-10 space-y-8 animate-fade-in">
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-white/5 pb-4">
            <h1 class="text-3xl font-black heading-gradient">
                {{ __('Buat Tugas Baru') }}
            </h1>
            <a href="{{ route('tasks.index') }}" class="px-4 py-2 border border-gray-200 dark:border-white/10 text-gray-550 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 text-xs font-bold rounded-full transition-all">
                Batal
            </a>
        </div>

        <div class="bg-white dark:bg-mtm-dark-surface overflow-hidden shadow-xl rounded-[2.5rem] p-8 md:p-10 border border-gray-150 dark:border-white/5">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 rounded-2xl p-4 text-sm font-bold flex items-start gap-3">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>
                        Terjadi kesalahan validasi. Mohon periksa kembali isian form Anda (kolom yang berwarna merah).
                        <ul class="mt-2 list-disc list-inside text-xs font-medium opacity-80">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="category_id" :value="__('Kategori Layanan')" />
                        <select id="category_id" name="category_id" onchange="updatePrice()" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-mtm-dark text-gray-900 dark:text-gray-100 focus:border-mtm-red focus:ring-mtm-red rounded-xl shadow-sm">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" data-slug="{{ $category->slug }}" @selected($category->id == request('category_id')) class="text-gray-900 dark:text-gray-100">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="title" :value="__('Judul Tugas')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full text-gray-900 dark:text-gray-100" placeholder="Contoh: Bantu Antre Tiket Konser" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Deskripsi')" />
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-mtm-dark text-gray-900 dark:text-gray-100 focus:border-mtm-red focus:ring-mtm-red rounded-xl shadow-sm" placeholder="Jelaskan bantuan apa yang Anda butuhkan secara detail..." required></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Jarak Tempuh (Hidden, dikalkulasi otomatis dari peta) -->
                    <input type="hidden" id="distance" name="distance" value="{{ old('distance', '0.0') }}">

                    <div>
                        <x-input-label for="duration" :value="__('Estimasi Durasi Kerja (Jam)')" />
                        <x-text-input id="duration" name="duration" type="number" min="1" class="mt-1 block w-full text-gray-900 dark:text-gray-100" value="1" required oninput="updatePrice()" />
                        <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                        <p id="hint-duration" class="text-[10px] text-gray-500 mt-1">Biaya per Jam: Rp 10.000</p>
                    </div>

                    <!-- Premium Price Breakdown Box -->
                    <div id="price-breakdown-box" class="hidden bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-gray-800 rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <x-input-label for="budget" :value="__('Harga Tawaran Anda (Rp) *')" class="text-base font-bold text-gray-800 dark:text-gray-100" />
                                <span id="lbl-surge-badge" class="hidden text-[10px] font-black px-2.5 py-1 rounded-full animate-pulse"></span>
                            </div>
                            <span class="text-xs text-gray-500">Estimasi Sistem: <strong id="lbl-total-price" class="text-mtm-red">Rp 0</strong></span>
                        </div>
                            <div class="flex items-center gap-3 mt-2">
                                <button type="button" onclick="adjustBudget(-1000)" class="w-12 h-12 flex-shrink-0 flex items-center justify-center bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-400 rounded-xl hover:bg-gray-200 dark:hover:bg-white/10 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                </button>
                                
                                <div class="relative flex-1">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold text-xl">Rp</span>
                                    <x-text-input id="budget" name="budget" type="number" step="1" class="block w-full pl-12 pr-4 py-3 text-center text-xl font-black text-mtm-red bg-white dark:bg-black/20 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-mtm-red [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" required oninput="this.dataset.userEdited = 'true'" />
                                </div>

                                <button type="button" onclick="adjustBudget(1000)" class="w-12 h-12 flex-shrink-0 flex items-center justify-center bg-mtm-red/10 text-mtm-red rounded-xl hover:bg-mtm-red/20 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </button>
                            </div>
                            <p id="hint-budget" class="text-[10px] text-gray-500 mt-1">Anda bisa menaikkan harga untuk menarik Mitra, atau menurunkan harga maksimal 20% (Minimal: Rp <span id="lbl-min-budget">0</span>).</p>
                            <x-input-error :messages="$errors->get('budget')" class="mt-2" />
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- Input Lokasi Asal -->
                        <div>
                            <x-input-label for="location" :value="__('Lokasi Asal (Penjemputan/Mulai)')" />
                            <div class="flex flex-col sm:flex-row gap-2 mt-1">
                                <div class="relative flex-1">
                                    <x-text-input id="location" name="location" type="text" class="block w-full text-gray-900 dark:text-gray-100" placeholder="Ketik lokasi asal atau seret pin biru di peta" required />
                                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
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
                                    <x-text-input id="destination_location" name="destination_location" type="text" class="block w-full text-gray-900 dark:text-gray-100" placeholder="Ketik lokasi tujuan atau seret pin merah di peta" required />
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
                        <x-input-label for="images" :value="__('Unggah Foto (Opsional)')" />
                        <input type="file" id="images" name="images[]" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-mtm-red hover:file:bg-red-100" />
                        <p class="mt-2 text-xs text-gray-500">Maksimal 3 foto, masing-masing 2MB.</p>
                    </div>

                    <div class="flex items-center justify-end pt-4">
                        <x-primary-button class="bg-gradient-to-r from-mtm-red to-mtm-red-dark hover:from-mtm-red-dark hover:to-mtm-red py-3 px-8 rounded-full">
                            {{ __('Publikasikan Tugas') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>

<script>
// === MTM Category Pricing Table ===
// Tarif per kategori: { base, perKm, perJam }
const MTM_CATEGORY_PRICING = {
    'kurir':        { base: 5000,  perKm: 3500, perJam: 5000,  icon: '🚴', label: 'Kurir' },
    'asisten':      { base: 20000, perKm: 2000, perJam: 15000, icon: '🙋', label: 'Asisten' },
    'antre':        { base: 10000, perKm: 1000, perJam: 12000, icon: '🕐', label: 'Antre' },
    'teknis':       { base: 25000, perKm: 2500, perJam: 20000, icon: '🔧', label: 'Teknis' },
    'kebersihan':   { base: 15000, perKm: 1500, perJam: 12000, icon: '🧹', label: 'Kebersihan' },
    'belanja':      { base: 10000, perKm: 2000, perJam: 8000,  icon: '🛒', label: 'Belanja' },
    'angkut-barang':{ base: 20000, perKm: 4000, perJam: 10000, icon: '📦', label: 'Angkut Barang' },
};
const MTM_DEFAULT_PRICING = { base: 15000, perKm: 3000, perJam: 10000, icon: '⚙️', label: 'Default' };

// === MTM Surge Pricing (Ala Gojek) ===
function getSurgePricing() {
    const now = new Date();
    const hour = now.getHours();
    if (hour >= 7 && hour < 9)  return { multiplier: 1.3, label: '🔴 Jam Sibuk Pagi (07–09)', badgeClass: 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400', badge: '🔴 Jam Sibuk ×1.3' };
    if (hour >= 16 && hour < 19) return { multiplier: 1.3, label: '🔴 Jam Sibuk Sore (16–19)', badgeClass: 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400', badge: '🔴 Jam Sibuk ×1.3' };
    if (hour >= 22 || hour < 5)  return { multiplier: 1.2, label: '🌙 Malam Larut (22–05)', badgeClass: 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400', badge: '🌙 Malam Larut ×1.2' };
    return { multiplier: 1.0, label: null, badgeClass: '', badge: null };
}

window.adjustBudget = function(amount) {
    const budgetInput = document.getElementById('budget');
    if (!budgetInput) return;
    
    let currentVal = parseInt(budgetInput.value) || 0;
    let minBudget = parseInt(budgetInput.min) || 0;
    
    let newVal = currentVal + amount;
    if (newVal < minBudget) {
        newVal = minBudget; // Prevent lowering below min
    }
    
    budgetInput.value = newVal;
    budgetInput.dataset.userEdited = 'true';
}

window.updatePrice = function() {
    const categorySelect = document.getElementById('category_id');
    const distanceInput = document.getElementById('distance');
    const durationInput = document.getElementById('duration');
    const breakdownBox = document.getElementById('price-breakdown-box');
    
    if (!categorySelect || !distanceInput || !durationInput) return;
    
    if (!categorySelect.value) {
        if (breakdownBox) breakdownBox.classList.add('hidden');
        return;
    }
    if (breakdownBox) breakdownBox.classList.remove('hidden');
    
    // Ambil slug dari data-slug attribute
    const selectedOption = categorySelect.options[categorySelect.selectedIndex];
    const slug = selectedOption ? (selectedOption.getAttribute('data-slug') || '') : '';
    
    // Ambil tarif kategori, fallback ke default
    const pricing = MTM_CATEGORY_PRICING[slug] || MTM_DEFAULT_PRICING;
    // Ensure positive distance and minimum 1 hour duration
    const distance = Math.max(0, parseFloat(distanceInput.value) || 0);
    
    // Surge pricing
    const surge = getSurgePricing();

    // Auto-calculate duration for 'kurir' (and 'angkut-barang')
    if (slug === 'kurir' || slug === 'angkut-barang') {
        let speed = 30; // 30 km/h normal speed
        if (surge.multiplier > 1.0) {
            speed = 15; // 15 km/h during rush hour
        }
        let estimatedHours = (distance / speed) + 0.5; // +0.5 hour for pickup/dropoff overhead
        let finalDuration = Math.ceil(estimatedHours);
        if (finalDuration < 1) finalDuration = 1;
        
        durationInput.value = finalDuration;
        durationInput.setAttribute('readonly', true);
        durationInput.classList.add('bg-gray-150', 'dark:bg-white/5', 'cursor-not-allowed');
    } else {
        durationInput.removeAttribute('readonly');
        durationInput.classList.remove('bg-gray-150', 'dark:bg-white/5', 'cursor-not-allowed');
    }

    // Force duration to be at least 1 in JS calculation
    let duration = parseInt(durationInput.value) || 1;
    if (duration < 1) {
        duration = 1;
        durationInput.value = 1;
    }
    
    const baseFee    = pricing.base;
    const distanceFee = Math.round(distance * pricing.perKm);
    const durationFee = Math.round(duration * pricing.perJam);
    const subtotal   = baseFee + distanceFee + durationFee;
    
    const surgeFee = Math.round(subtotal * (surge.multiplier - 1));
    const total = subtotal + surgeFee;
    const minBudget = Math.floor(total * 0.8);
    
    const lblTotalPrice = document.getElementById('lbl-total-price');
    const lblMinBudget  = document.getElementById('lbl-min-budget');
    if (lblTotalPrice) lblTotalPrice.innerText = 'Rp ' + total.toLocaleString('id-ID');
    if (lblMinBudget) lblMinBudget.innerText = minBudget.toLocaleString('id-ID');

    const budgetInput = document.getElementById('budget');
    if (budgetInput) {
        budgetInput.min = minBudget;
        // Auto-fill budget if not edited by user yet, or if user's budget is now below the new minimum
        if (!budgetInput.dataset.userEdited || parseInt(budgetInput.value) < minBudget) {
            budgetInput.value = total;
            // Don't set userEdited here since it's system generated
        }
    }
    
    const distHint = document.getElementById('hint-distance');
    const durHint  = document.getElementById('hint-duration');
    if (distHint) distHint.innerText = 'Dihitung otomatis dari peta (Rp ' + pricing.perKm.toLocaleString('id-ID') + ' / Km)';
    if (durHint) {
        if (slug === 'kurir' || slug === 'angkut-barang') {
            let speed = (surge.multiplier > 1.0) ? 15 : 30;
            durHint.innerText = `Otomatis berdasar jarak (${speed} km/j). Biaya per Jam: Rp ` + pricing.perJam.toLocaleString('id-ID');
        } else {
            durHint.innerText = 'Biaya per Jam: Rp ' + pricing.perJam.toLocaleString('id-ID');
        }
    }
    
    // Surge badge
    const surgeBadge = document.getElementById('lbl-surge-badge');
    if (surgeBadge) {
        if (surge.multiplier > 1.0) {
            surgeBadge.innerText = surge.badge;
            surgeBadge.className = 'text-[10px] font-black px-2.5 py-1 rounded-full animate-pulse ' + surge.badgeClass;
            surgeBadge.classList.remove('hidden');
        } else {
            surgeBadge.classList.add('hidden');
        }
    }
};

document.addEventListener('DOMContentLoaded', function() {
    // Default location (Jakarta)
    var defaultLat = -6.2088;
    var defaultLng = 106.8456;
    
    // Initialize Leaflet Map
    var map = L.map('map', {
        zoomControl: true,
        scrollWheelZoom: true,
        attributionControl: false
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
            
            // Update coordinates for origin search
            document.getElementById('latitude').value = originLatLng.lat;
            document.getElementById('longitude').value = originLatLng.lng;
            
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

    // Auto-geocode on form submit if coordinates are not yet set
    document.querySelector('form').addEventListener('submit', function(e) {
        var lat = document.getElementById('latitude').value;
        if (!lat) {
            e.preventDefault(); // Stop form submission
            var query = document.getElementById('location').value;
            if (query) {
                mapLoading.classList.remove('hidden');
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1&accept-language=id`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            document.getElementById('latitude').value = data[0].lat;
                            document.getElementById('longitude').value = data[0].lon;
                        }
                        e.target.submit();
                    })
                    .catch(error => {
                        console.error('Error auto-geocoding on submit:', error);
                        e.target.submit();
                    });
            } else {
                e.target.submit();
            }
        }
    });

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

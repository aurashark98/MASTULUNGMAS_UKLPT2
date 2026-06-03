<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Tugas Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-mtm-dark-surface overflow-hidden shadow-xl sm:rounded-3xl p-8">
                <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="category_id" :value="__('Kategori Layanan')" />
                        <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-mtm-dark focus:border-mtm-red focus:ring-mtm-red rounded-xl shadow-sm">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="title" :value="__('Judul Tugas')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" placeholder="Contoh: Bantu Antre Tiket Konser" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Deskripsi')" />
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-mtm-dark focus:border-mtm-red focus:ring-mtm-red rounded-xl shadow-sm" placeholder="Jelaskan bantuan apa yang Anda butuhkan secara detail..." required></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="budget" :value="__('Budget (Rp)')" />
                            <x-text-input id="budget" name="budget" type="number" class="mt-1 block w-full" placeholder="50000" required />
                            <x-input-error :messages="$errors->get('budget')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="location" :value="__('Lokasi')" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" placeholder="Contoh: Jakarta Selatan" required />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>
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
    </div>
</x-app-layout>

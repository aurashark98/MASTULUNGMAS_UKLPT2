<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kurir',
                'icon' => 'Package',
                'description' => 'Kirim barang atau dokumen dengan cepat dan aman.'
            ],
            [
                'name' => 'Asisten',
                'icon' => 'Users',
                'description' => 'Bantuan asisten pribadi untuk berbagai keperluan.'
            ],
            [
                'name' => 'Antre',
                'icon' => 'Clock',
                'description' => 'Jasa antre tiket, rumah sakit, atau administrasi lainnya.'
            ],
            [
                'name' => 'Teknis',
                'icon' => 'Zap',
                'description' => 'Perbaikan alat elektronik, listrik, atau teknis lainnya.'
            ],
            [
                'name' => 'Kebersihan',
                'icon' => 'Sparkles',
                'description' => 'Layanan pembersihan rumah, kantor, atau kendaraan.'
            ],
            [
                'name' => 'Belanja',
                'icon' => 'ShoppingBag',
                'description' => 'Bantuan belanja kebutuhan harian atau titip barang.'
            ],
            [
                'name' => 'Angkut Barang',
                'icon' => 'Truck',
                'description' => 'Jasa pindahan atau angkut barang besar.'
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create(array_merge($category, [
                'slug' => \Illuminate\Support\Str::slug($category['name'])
            ]));
        }
    }
}

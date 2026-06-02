<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuLog;
use App\Models\OrderItem;
use App\Models\Stall;
use App\Models\StallAccount;
use App\Models\StallLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StallMenuSeeder extends Seeder
{
    /**
     * Reset dan isi ulang data Stall & Menu dengan 5 stall resmi De'Pallet.
     */
    public function run(): void
    {
        // 1. Hapus data lama (urutan penting untuk foreign key)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        OrderItem::query()->forceDelete();
        MenuLog::query()->delete();
        Menu::withTrashed()->forceDelete();
        StallLog::query()->delete();
        StallAccount::withTrashed()->forceDelete();
        Stall::withTrashed()->forceDelete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Definisikan 5 stall beserta menu-menunya
        $stallsData = [

            // ─────────────────────────────────────────
            // 1. DPC Stall Minuman
            // ─────────────────────────────────────────
            [
                'name'       => 'DPC Stall Minuman',
                'owner_name' => 'Pak Dodi',
                'is_open'    => true,
                'account'    => ['phone_number' => '08111000001', 'password' => bcrypt('password')],
                'menus'      => [
                    [
                        'name'                 => 'Es Teh Manis Spesial',
                        'description'          => 'Teh manis segar dengan es batu pilihan, menyegarkan di hari yang panas. Favorit pelanggan kami setiap hari.',
                        'price'                => 6000,
                        'category'             => 'Minuman',
                        'is_chef_recommendation' => true,
                    ],
                    [
                        'name'                 => 'Es Jeruk Peras Segar',
                        'description'          => 'Jeruk segar diperas langsung, tanpa pengawet, kaya vitamin C, disajikan dengan es batu.',
                        'price'                => 10000,
                        'category'             => 'Minuman',
                        'is_chef_recommendation' => true,
                    ],
                    [
                        'name'                 => 'Jus Alpukat Susu',
                        'description'          => 'Jus alpukat lembut diblender dengan susu kental manis, kaya lemak sehat dan mengenyangkan.',
                        'price'                => 15000,
                        'category'             => 'Minuman',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Jus Mangga Harum Manis',
                        'description'          => 'Mangga harum manis pilihan diblender segar, manis alami tanpa tambahan gula berlebih.',
                        'price'                => 14000,
                        'category'             => 'Minuman',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Es Kopi Susu Kekinian',
                        'description'          => 'Kopi robusta lokal diseduh espresso style, dicampur susu full cream dan es batu, creamy dan bold.',
                        'price'                => 18000,
                        'category'             => 'Minuman',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Teh Tarik Spesial',
                        'description'          => 'Teh hitam pekat "ditarik" dengan susu evaporasi hingga berbusa, cita rasa otentik khas warung kopi.',
                        'price'                => 12000,
                        'category'             => 'Minuman',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Es Matcha Latte',
                        'description'          => 'Matcha premium grade Jepang dicampur susu segar, disajikan dingin. Harum, creamy, dan menyehatkan.',
                        'price'                => 22000,
                        'category'             => 'Minuman',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Soda Gembira Pelangi',
                        'description'          => 'Soda segar dicampur susu dan sirup cocopandan, ditambah potongan cincau hitam. Warna-warni dan menyegarkan.',
                        'price'                => 13000,
                        'category'             => 'Minuman',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Air Kelapa Muda Asli',
                        'description'          => 'Kelapa muda segar langsung dari buahnya, disajikan beserta daging kelapa yang lembut. Alami 100%.',
                        'price'                => 16000,
                        'category'             => 'Minuman',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Es Campur Istimewa',
                        'description'          => 'Perpaduan cincau, kolang-kaling, agar-agar, nata de coco dalam kuah santan dingin manis. Segar dan mengenyangkan.',
                        'price'                => 15000,
                        'category'             => 'Minuman',
                        'is_chef_recommendation' => false,
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // 2. Warung Jakarta
            // ─────────────────────────────────────────
            [
                'name'       => 'Warung Jakarta',
                'owner_name' => 'Bu Yanti',
                'is_open'    => true,
                'account'    => ['phone_number' => '08111000002', 'password' => bcrypt('password')],
                'menus'      => [
                    [
                        'name'                 => 'Nasi Goreng Kampung Betawi',
                        'description'          => 'Nasi goreng racikan bumbu Betawi asli, dengan kecap manis, bawang merah goreng, dan telur ceplok. Cita rasa yang khas dan autentik.',
                        'price'                => 22000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => true,
                    ],
                    [
                        'name'                 => 'Soto Betawi Santan',
                        'description'          => 'Soto khas Betawi berkuah santan gurih dengan potongan daging sapi empuk, tomat, dan perkedel. Disajikan hangat.',
                        'price'                => 28000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => true,
                    ],
                    [
                        'name'                 => 'Gado-Gado Jakarta',
                        'description'          => 'Sayuran rebus segar disiram bumbu kacang khas Jakarta yang kental dan gurih, dilengkapi kerupuk dan lontong.',
                        'price'                => 20000,
                        'category'             => 'Makanan Ringan',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Nasi Uduk Betawi Komplit',
                        'description'          => 'Nasi pulen dimasak dengan santan dan daun pandan, disajikan dengan ayam goreng, tempe orek, sambal kacang, dan emping.',
                        'price'                => 25000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Kerak Telor Betawi',
                        'description'          => 'Jajanan tradisional Betawi berbahan telur bebek, ketan putih, dan ebi, dimasak dengan bara api. Gurih dan unik.',
                        'price'                => 18000,
                        'category'             => 'Makanan Ringan',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Ketoprak Jakarta',
                        'description'          => 'Tahu goreng, bihun, ketimun, dan taoge disiram bumbu kacang manis gurih. Segar dan mengenyangkan.',
                        'price'                => 17000,
                        'category'             => 'Makanan Ringan',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Mie Goreng Jawa Spesial',
                        'description'          => 'Mie kuning kenyal digoreng dengan bumbu rempah pilihan, telur, sayuran, dan bakso. Porsi besar dan bikin kenyang.',
                        'price'                => 23000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Pecel Lele Jakarta',
                        'description'          => 'Lele goreng krispi disajikan dengan sambal terasi pedas khas Jakarta, lalapan segar, dan nasi putih pulen.',
                        'price'                => 24000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // 3. Warung Mbak Lita
            // ─────────────────────────────────────────
            [
                'name'       => 'Warung Mbak Lita',
                'owner_name' => 'Mbak Lita',
                'is_open'    => true,
                'account'    => ['phone_number' => '08111000003', 'password' => bcrypt('password')],
                'menus'      => [
                    [
                        'name'                 => 'Ayam Geprek Sambal Bawang',
                        'description'          => 'Ayam goreng tepung renyah dipukul dengan cobek, lalu disiram sambal bawang segar yang pedas menggigit. Nasi + lalapan.',
                        'price'                => 25000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => true,
                    ],
                    [
                        'name'                 => 'Nasi Pecel Mbak Lita',
                        'description'          => 'Nasi putih hangat dengan sayuran rebus pilihan — bayam, kacang panjang, taoge — disiram bumbu kacang pedas manis resep rahasia Mbak Lita.',
                        'price'                => 20000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => true,
                    ],
                    [
                        'name'                 => 'Ayam Bakar Kecap Manis',
                        'description'          => 'Ayam kampung muda dimarinasi kecap manis dan rempah, dibakar sempurna hingga harum. Disajikan dengan sambal dan lalapan.',
                        'price'                => 30000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Tempe Mendoan Goreng',
                        'description'          => 'Tempe tipis dibalut tepung berbumbu, digoreng setengah matang hingga lembut dan gurih. Cocok sebagai lauk atau camilan.',
                        'price'                => 12000,
                        'category'             => 'Makanan Ringan',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Sayur Lodeh Jawa',
                        'description'          => 'Sayuran segar — labu siam, kacang panjang, tempe, tahu — dimasak dalam kuah santan gurih bumbu lodeh khas Jawa.',
                        'price'                => 15000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Oseng Mercon Daging Sapi',
                        'description'          => 'Daging sapi cincang dimasak oseng dengan cabai rawit merah berlimpah dan rempah pilihan. Super pedas, super nikmat!',
                        'price'                => 28000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Nasi Rawon Jawa Timur',
                        'description'          => 'Kuah rawon hitam pekat berbumbu kluwek khas Jawa Timur dengan irisan daging sapi empuk dan tauge pendek. Disajikan hangat.',
                        'price'                => 27000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Sop Buntut Sapi Spesial',
                        'description'          => 'Buntut sapi dimasak perlahan hingga empuk dalam kuah bening bening rempah. Disajikan dengan nasi putih dan sambal terpisah.',
                        'price'                => 35000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // 4. Warung Putri
            // ─────────────────────────────────────────
            [
                'name'       => 'Warung Putri',
                'owner_name' => 'Bu Putri',
                'is_open'    => true,
                'account'    => ['phone_number' => '08111000004', 'password' => bcrypt('password')],
                'menus'      => [
                    [
                        'name'                 => 'Ayam Penyet Sambal Terasi',
                        'description'          => 'Ayam goreng empuk "dipenyetkan" di atas cobek batu bersama sambal terasi bakar yang harum dan pedas. Nasi + lalapan.',
                        'price'                => 26000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => true,
                    ],
                    [
                        'name'                 => 'Nasi Goreng Spesial Putri',
                        'description'          => 'Nasi goreng resep Bu Putri dengan bumbu rahasia, telur mata sapi, bakso iris, dan kerupuk udang. Lezat tiada duanya.',
                        'price'                => 23000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => true,
                    ],
                    [
                        'name'                 => 'Mie Ayam Putri Spesial',
                        'description'          => 'Mie kenyal dengan topping ayam suwir bumbu spesial, bakso, dan pangsit rebus. Kuah kaldu ayam gurih dan menghangatkan.',
                        'price'                => 20000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Soto Ayam Kampung',
                        'description'          => 'Kuah bening kunyit segar dengan ayam kampung suwir empuk, soun, telur rebus, dan perkedel kentang. Hangat dan menyehatkan.',
                        'price'                => 22000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Nasi Campur Warung Putri',
                        'description'          => 'Nasi putih pulen dengan pilihan 3 lauk: ayam, tempe, tahu, dan sayur, dilengkapi sambal dan kerupuk.',
                        'price'                => 24000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Udang Goreng Tepung Krispi',
                        'description'          => 'Udang segar dibalut tepung crispy berbumbu, digoreng hingga keemasan. Disajikan dengan saus tartar dan nasi.',
                        'price'                => 32000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Tumis Kangkung Belacan',
                        'description'          => 'Kangkung segar ditumis dengan belacan (terasi), cabai merah, dan bawang putih. Gurih, pedas, dan kaya aroma.',
                        'price'                => 15000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Ayam Kremes Renyah',
                        'description'          => 'Ayam goreng berbalut kremes kriuk renyah yang nikmat. Disajikan dengan nasi putih, sambal kecap, dan lalapan segar.',
                        'price'                => 28000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Tahu Tempe Bacem Manis',
                        'description'          => 'Tahu dan tempe dibacem dalam bumbu kecap manis dan rempah pilihan hingga meresap sempurna, lalu digoreng hingga kecoklatan.',
                        'price'                => 12000,
                        'category'             => 'Makanan Ringan',
                        'is_chef_recommendation' => false,
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // 5. Salero Rajo
            // ─────────────────────────────────────────
            [
                'name'       => 'Salero Rajo',
                'owner_name' => 'Pak Rajo',
                'is_open'    => true,
                'account'    => ['phone_number' => '08111000005', 'password' => bcrypt('password')],
                'menus'      => [
                    [
                        'name'                 => 'Rendang Daging Sapi',
                        'description'          => 'Daging sapi dimasak perlahan berjam-jam dalam kuah santan dan 40+ rempah pilihan hingga kering kemerahan. Cita rasa Minang autentik yang kaya.',
                        'price'                => 38000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => true,
                    ],
                    [
                        'name'                 => 'Nasi Padang Komplit',
                        'description'          => 'Nasi putih hangat lengkap dengan rendang, gulai ayam, dendeng balado, perkedel, sambal hijau, dan sayur daun singkong. Pesta cita rasa Minang.',
                        'price'                => 45000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => true,
                    ],
                    [
                        'name'                 => 'Ayam Pop Padang',
                        'description'          => 'Ayam kampung dimasak dalam air kelapa muda dan rempah, kemudian digoreng sebentar hingga pucat keemasan. Gurih, lembut, khas Padang.',
                        'price'                => 30000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Dendeng Balado Merah',
                        'description'          => 'Irisan daging sapi tipis kering digoreng hingga krispi, lalu ditumis balado dengan cabai merah dan tomat yang pedas merangsang selera.',
                        'price'                => 35000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Gulai Ayam Minang',
                        'description'          => 'Potongan ayam kampung dimasak dalam kuah gulai kuning santan kental berbumbu kunyit, serai, lengkuas, dan rempah Minang. Aroma harum menggiurkan.',
                        'price'                => 28000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Sambal Hijau Padang',
                        'description'          => 'Cabai hijau segar digiling kasar dengan bawang merah dan tomat hijau, ditumis sebentar. Segar, pedas, dan sangat cocok sebagai pelengkap.',
                        'price'                => 8000,
                        'category'             => 'Makanan Ringan',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Gulai Ikan Kakap',
                        'description'          => 'Ikan kakap segar dimasak dalam kuah gulai kuning santan dengan bumbu rempah Padang yang kaya. Ikan lembut, kuah gurih dan harum.',
                        'price'                => 32000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Nasi Goreng Padang Spesial',
                        'description'          => 'Nasi goreng dengan bumbu rendang dan sedikit gulai, disajikan dengan telur dadar, kerupuk merah, dan acar timun. Khas dan berbeda.',
                        'price'                => 25000,
                        'category'             => 'Makanan Berat',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Sate Padang Bumbu Kuning',
                        'description'          => 'Sate jeroan dan daging sapi disajikan dengan kuah sate Padang berwarna kuning tebal berbumbu kunyit dan cabe. Unik dan kaya rasa.',
                        'price'                => 28000,
                        'category'             => 'Makanan Ringan',
                        'is_chef_recommendation' => false,
                    ],
                    [
                        'name'                 => 'Teh Talua Minang',
                        'description'          => 'Minuman tradisional Minang — teh hitam kental dikocok dengan kuning telur ayam kampung hingga berbusa. Kaya protein dan menyegarkan.',
                        'price'                => 12000,
                        'category'             => 'Minuman',
                        'is_chef_recommendation' => false,
                    ],
                ],
            ],

        ]; // end $stallsData

        // 3. Buat stall, akun, dan menu
        foreach ($stallsData as $stallData) {
            // Buat stall
            $stall = Stall::create([
                'name'       => $stallData['name'],
                'owner_name' => $stallData['owner_name'],
                'is_open'    => $stallData['is_open'],
            ]);

            // Buat akun stall
            StallAccount::create([
                'stall_id'     => $stall->stall_id,
                'phone_number' => $stallData['account']['phone_number'],
                'password'     => $stallData['account']['password'],
            ]);

            // Buat menu-menu stall
            foreach ($stallData['menus'] as $menuData) {
                Menu::create([
                    'stall_id'               => $stall->stall_id,
                    'name'                   => $menuData['name'],
                    'description'            => $menuData['description'],
                    'price'                  => $menuData['price'],
                    'category'               => $menuData['category'],
                    'is_available'           => true,
                    'is_chef_recommendation' => $menuData['is_chef_recommendation'],
                    'image_path'             => null,
                ]);
            }
        }

        $this->command->info('✅ StallMenuSeeder selesai: 5 stall dengan ' . Menu::count() . ' menu berhasil dibuat!');
    }
}

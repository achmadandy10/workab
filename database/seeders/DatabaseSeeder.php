<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Visiting;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Generator;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nik' => '1234567890123456',
            'name' => 'Admin Workab',
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'username' => 'admin123',
            'password' => bcrypt('admin123'),
            'gender' => 'Laki-Laki',
            'role' => 'Admin',
            'photo' => 'https://ui-avatars.com/api/?name=Random&color=7F9CF5&background=EBF4FF',
            'remember_token' => Str::random(10),
        ]);

        User::factory(10)->create();

        $shop_data = array(
            0 =>
            array(
                'id' => 1,
                'toko' => 'Toko Indonesia Sehat',
                'address' => 'KAB. ACEH BARAT',
                'lat' => '4.4543',
                'long' => '96.1527',
            ),
            1 =>
            array(
                'id' => 2,
                'toko' => 'Toko Indonesia Maju',
                'address' => 'KAB. ACEH BARAT DAYA',
                'lat' => '3.7963',
                'long' => '97.0068',
            ),
            2 =>
            array(
                'id' => 3,
                'toko' => 'Toko Indonesia Mantab',
                'address' => 'KAB. ACEH BESAR',
                'lat' => '5.4529',
                'long' => '95.4778',
            ),
            3 =>
            array(
                'id' => 4,
                'toko' => 'Toko Indonesia Pargoy',
                'address' => 'KAB. ACEH JAYA',
                'lat' => '4.7874',
                'long' => '95.6458',
            ),
            4 =>
            array(
                'id' => 5,
                'toko' => 'Toko Indonesia Berkembang',
                'address' => 'KAB. ACEH SELATAN',
                'lat' => '3.3115',
                'long' => '97.3517',
            ),
            5 =>
            array(
                'id' => 6,
                'toko' => 'Toko Indonesia Bagus',
                'address' => 'KAB. ACEH SINGKIL',
                'lat' => '2.3589',
                'long' => '97.8722',
            ),
            6 =>
            array(
                'id' => 7,
                'toko' => 'Toko Indonesia Mantab',
                'address' => 'KAB. ACEH TAMIANG',
                'lat' => '4.2329',
                'long' => '98.0029',
            ),
            7 =>
            array(
                'id' => 8,
                'toko' => 'Toko Indonesia Luar Biasa',
                'address' => 'KAB. ACEH TENGAH',
                'lat' => '4.4483',
                'long' => '96.8351',
            ),
            8 =>
            array(
                'id' => 9,
                'toko' => 'Toko Indonesia Sejahtera',
                'address' => 'KAB. ACEH TENGGARA',
                'lat' => '3.3089',
                'long' => '97.6982',
            ),
            9 =>
            array(
                'id' => 10,
                'toko' => 'Toko Indonesia Juara',
                'address' => 'KAB. ACEH TIMUR',
                'lat' => '4.5224',
                'long' => '97.6114',
            ),
        );

        foreach ($shop_data as $row) {
            $uniq_code = Str::random(60);
            $generator = new Generator;
            $qrcode = $generator->size(500)->generate($uniq_code);

            Shop::create([
                'name' => $row['toko'],
                'address' => $row['address'],
                'lat' => $row['lat'],
                'long' => $row['long'],
                'barcode' => $uniq_code,
                'barcode_image' => $qrcode,
            ]);
        }

        for ($i = 2; $i <= 11; $i++) {
            Attendance::create([
                'user_id' => $i,
                'type' => 'In',
                'time' => date('H:i', strtotime('07:3' . $i)),
                'lat' => '4.522' . $i,
                'long' => '97.611' . $i,
            ]);
            Attendance::create([
                'user_id' => $i,
                'type' => 'Out',
                'time' => date('H:i', strtotime('19:3' . $i)),
                'lat' => '4.522' . $i,
                'long' => '97.611' . $i,
            ]);
        }

        for ($i = 1; $i <= 10; $i++) {
            for ($x = 1; $x <= 10; $x++) {
                Product::create([
                    'shop_id' => $i,
                    'name' => 'Barang ' . $x,
                    'stock' => '10',
                ]);
            }
        }

        for ($i = 2; $i <= 11; $i++) {
            for ($x = 1; $x <= 10; $x++) {
                Visiting::create([
                    'user_id' => $i,
                    'shop_id' => $x,
                    'lat' => '4.522' . $x,
                    'long' => '97.611' . $x,
                ]);
            }
        }
    }
}

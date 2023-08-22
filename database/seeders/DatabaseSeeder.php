<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Barang;
use App\Models\Transaksi;

use Illuminate\Database\Seeder;

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
            'name' => 'Arief Santoso',
            'username' => 'ariefsan',
            'email' => 'ariefsantoso@gmail.com',
            'password' => bcrypt('password'),
        ]);

        Barang::create([
            'kode' => 'BRG001',
            'name' => 'Sprei 150 x 200',
            'stok' => '20'
        ]);

        Barang::create([
            'kode' => 'BRG002',
            'name' => 'Mukena 150 x 200',
            'stok' => '20'
        ]);

        Transaksi::factory(10)->create();
    }
}

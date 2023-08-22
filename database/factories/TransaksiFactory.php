<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = date('dmy');
        $kode = array(
            'TRANSJ' . $date, 'TRANSB' . $date
        );
        $harga = 100000;
        $names = array(
            'B', 'J'
        );
        return [
            'kode' => $kode[mt_rand(0, count($names) - 1)],
            'jenis_transaksi' => $names[mt_rand(0, count($names) - 1)],
            'jumlah' => mt_rand(10, 20),
            'barang_id' => mt_rand(1, 2),
            'harga' => $harga + 50000, // password


        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chat_types')->insert([
        [
            'chat_type' => 'WhatsApp iOS',
            'regex'     => "^\[([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}^",
        ],
        [
            'chat_type' => 'WhatsApp Android',
            'regex'     => "^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4},^",
        ]]);
    }
}

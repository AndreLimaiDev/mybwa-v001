<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Branch;
use App\Models\Sumber;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Program;
use App\Models\Projek;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate untuk reset auto increment
        User::truncate();
        Karyawan::truncate();
        // Jabatan::truncate();
        // Branch::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Role::factory()->createMany([
            [
                'name' => 'Super Admin',
            ],
            [
                'name' => 'Branch Manager',
            ],
            [
                'name' => 'Tim Leader',
            ],
            [
                'name' => 'Fundraiser',
            ],
        ]);

        Branch::factory()->createMany([
            [
                'name' => 'Pekanbaru',
                'inisial' => 'PKU',
            ],
            [
                'name' => 'Medan',
                'inisial' => 'MDN',
            ],
            [
                'name' => 'Batam',
                'inisial' => 'BTM',
            ],
            [
                'name' => 'Lampung',
                'inisial' => 'LPG',
            ],
        ]);

        Jabatan::factory()->createMany([
            [
                'nama_jabatan' => 'Branch Manager',
            ],
            [
                'nama_jabatan' => 'Tim Leader',
            ],
            [
                'nama_jabatan' => 'Prospektor',
            ],
        ]);

        User::factory()->createMany([
            [
                'name' => 'Andre',
                'email' => 'admin@email.com',
                'role_id' => 1,
                'branch_id' => 1,
            ],
            [
                'name' => 'Yudha',
                'email' => 'yudha@gmail.com',
                'role_id' => 2,
                'branch_id' => 2,
            ],
        ]);

        Karyawan::factory()->createMany([
            [
                'user_id' => 1,
                'nama_karyawan' => 'Andre',
                'jabatan_id' => 1,
                'hp' => '08123456789',
                'is_active' => 1,
                'branch_id' => 1,
            ],
            [
                'user_id' => 2,
                'nama_karyawan' => 'Yudha',
                'jabatan_id' => 1,
                'hp' => '08123456456',
                'is_active' => 1,
                'branch_id' => 2,
            ],
        ]);

        // Create sumber
        Sumber::factory()->createMany([
            [
                'nama_sumber' => 'Presentasi Tim 1 PKU',
                'branch_id' => 1,
            ],
            [
                'nama_sumber' => 'Presentasi Tim 1 MDN',
                'branch_id' => 2,
            ],
            [
                'nama_sumber' => 'Presentasi Tim 1 BTM',
                'branch_id' => 3,
            ],
        ]);

        Program::factory()->createMany([
            ['nama_program' => "Wakaf Alqur'an dan Pembinaan"],
            ['nama_program' => "Water Action for People"],
            ['nama_program' => "Tebar Cahaya Indonesia Terang"],
            ['nama_program' => "Sedekah Kemanusiaan"],
            ['nama_program' => "Wakaf Khusus Dakwah"],
            ['nama_program' => "Indonesia Belajar"],
            ['nama_program' => "Wakaf Produktif"],
            ['nama_program' => "Zakat Peer to Peer"],
        ]);

        Projek::factory()->createMany([
            ['program_id' => 1, 'nama_projek' => "WAP Meranti", 'kode_unik' => 104, 'status' => "Full Funded"],
            ['program_id' => 1, 'nama_projek' => "WAP Road Trip Kalimantan Timur", 'kode_unik' => 154, 'status' => "Funding"],
            ['program_id' => 1, 'nama_projek' => "WAP Road Trip Kepulauan Papua", 'kode_unik' => 149, 'status' => "Funding"],
            ['program_id' => 2, 'nama_projek' => "WAFP Ponpes Raodlatul Abror NTB", 'kode_unik' => 344, 'status' => "Funding"],
            ['program_id' => 2, 'nama_projek' => "WAFP Ponpes Assalafiyatul Huda Tasikmalaya", 'kode_unik' => 343, 'status' => "Funding"],
            ['program_id' => 3, 'nama_projek' => "TCIT Pangkalan Kapas Riau", 'kode_unik' => 44, 'status' => "Full Funded"],
            ['program_id' => 6, 'nama_projek' => "IB Nabila Azmi", 'kode_unik' => 941, 'status' => "Funding"],
            ['program_id' => 5, 'nama_projek' => "WKD Motor Pelosok Garut Timur", 'kode_unik' => 535, 'status' => "Funding"],
        ]);
    }
}
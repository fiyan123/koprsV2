<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class usermanagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name'         => 'admin',
                'display_name' => 'Administrator',
                'description'  => 'Full access to the system',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'manager',
                'display_name' => 'Manager',
                'description'  => 'Manage operations and reports',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'anggota',
                'display_name' => 'Anggota',
                'description'  => 'Anggota koperasi biasa',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);

        // Create Users and Assign Roles
        $roles = DB::table('roles')->pluck('id', 'name');

        $users = [
            [
                'name'  => 'Admin User',
                'email' => 'admin@example.com',
                // 'nip'   => '1111111111',
                'role'  => 'admin',
                // 'no_ktp'  => '001',
                // 'no_hp'  => '08123456789',
            ],
            [
                'name'  => 'Manager User',
                'email' => 'manager@example.com',
                // 'nip'   => '2222222222',
                'role'  => 'manager',
                // 'no_ktp'  => '002',
                // 'no_hp'  => '081234567891',

            ],
            [
                'name'  => 'Anggota User',
                'email' => 'anggota@example.com',
                // 'nip'   => '3333333333',
                'role'  => 'anggota',
                // 'no_ktp'  => '003',
                // 'no_hp'  => '08123456787',


            ],
        ];

        foreach ($users as $user) {
            $userId = DB::table('users')->insertGetId([
                'name'              => $user['name'],
                'email'             => $user['email'],
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                // 'nip'               => $user['nip'],
                // 'alamat'            => 'Bandung',
                // 'no_ktp'               => $user['no_ktp'],
                // 'tgl_lahir'         => '2000-01-01',
                // 'no_hp'             => $user['no_hp'],
                // 'foto'              => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            DB::table('role_user')->insert([
                'role_id'   => $roles[$user['role']],
                'user_id'   => $userId,
                'user_type' => 'App\\Models\\User',
            ]);
        }
    }
}

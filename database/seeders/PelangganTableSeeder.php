<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pelanggan;
use App\Utils\FuncUUID;
use DB;

class PelangganTableSeeder extends Seeder
{
    use FuncUUID;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pelanggan = array(
                array(
                    'id' => $this->uuid_short(),
                    'nama' => 'Antonius',
                    'email' => 'antoniusardyyansah@gmail.com',
                    'alamat' => 'Brebes',
                    'jenis_kelamin' => 1,
                    'uuid' => $this->uuid(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ),
                array(
                    'id' => $this->uuid_short(),
                    'nama' => 'Deni Ambar',
                    'email' => 'deni.a@gmail.com',
                    'alamat' => 'Bantul',
                    'jenis_kelamin' => 0,
                    'uuid' => $this->uuid(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ),
        );

        $users = array(
            array(
                'id' => $this->uuid_short(),
                'name' => $pelanggan[0]['nama'],
                'email' => $pelanggan[0]['email'],
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => bcrypt('1234'),
                'role' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'uuid' => $this->uuid()
            ),
            array(
                'id' => $this->uuid_short(),
                'name' => $pelanggan[1]['nama'],
                'email' => $pelanggan[1]['email'],
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => bcrypt('1234'),
                'role' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'uuid' => $this->uuid()
            ),
            array(
                'id' => $this->uuid_short(),
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => bcrypt('admin1234'),
                'role' => '0',
                'created_at' => date('Y-m-d H:i:s'),
                'uuid' => $this->uuid()
            )
        );

        DB::beginTransaction();
        try{
            Pelanggan::insert($pelanggan);
            User::insert($users);
            DB::commit();
        }catch(Exception $e){
            dd($e->getMessage());
            DB::rollback();
        }

    }
}

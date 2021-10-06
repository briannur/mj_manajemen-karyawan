<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Office;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $i = Office::all()->count();
        $nama_kantor = ['Programmer', 'Desainer', 'HRD', 'Project Manajer'];

        //generate fake office
        foreach($nama_kantor as $name){
            DB::table('offices')->insert([
                'id' => $i,
                'office_name' => 'Kantor '. $name, //str_replace("PT","",str_replace("PD", "", str_replace("UD", "", str_replace("(Persero)", "", str_replace("Tbk", "", str_replace("Perum", "", $faker->company)))))),
                'capacity' => $faker->numberBetween(10,100),
            ]);
        }

        $j = Office::first();

        //generate admincalls
        DB::table('admincalls')->insert([
            'password' => 'admin',
            'office_name' => $j->office_name,
            'capacity' => $j->capacity,
        ]);

        //generate usercalls
        DB::table('usercalls')->insert([
            'office_name' => $j->office_name,
            'capacity' => $j->capacity,
        ]);

        $offices = App\Office::pluck('office_name')->all();
        $univPrefix = ['Universitas', 'Institut', 'Sekolah Tinggi', 'Politeknik'];
        $minim = min(Office::pluck('capacity')->all());

        //generate employee
        for($k = $minim * count($nama_kantor); $k > 0; $k--){
            DB::table('employees')->insert([
                'desk' => $faker->numberBetween(1, $minim),
                'name' => $faker->name,
                'univ' => $faker->randomElement($univPrefix)." Ke". lcfirst($faker->jobTitle). "an ". $faker->city,
                'shift' => $faker->randomElement(['07.00 - 10.00','13.00 - 17.00']),
                'office' => $faker->randomElement($offices),
                'status' => $faker->randomElement(['aktif', 'non-aktif']),
                'start' => now(),
                'end' => $faker->dateTimeBetween('+1 week', '+3 month'),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'name' => 'Amazonas',
            'code_ubg' => '01',
        ]);
        Department::create([
            'name' => 'Ancash',
            'code_ubg' => '02',
        ]);
        Department::create([
            'name' => 'Apurimac',
            'code_ubg' => '03',
        ]);
        Department::create([
            'name' => 'Arequipa',
            'code_ubg' => '04',
        ]);
        Department::create([
            'name' => 'Ayacucho',
            'code_ubg' => '05',
        ]);
        Department::create([
            'name' => 'Cajamarca',
            'code_ubg' => '06',
        ]);
        Department::create([
            'name' => 'Callao',
            'code_ubg' => '07',
        ]);
        Department::create([
            'name' => 'Cusco',
            'code_ubg' => '08',
        ]);
        Department::create([
            'name' => 'Huancavelica',
            'code_ubg' => '09',
        ]);
        Department::create([
            'name' => 'Huanuco',
            'code_ubg' => '10',
        ]);
        Department::create([
            'name' => 'Ica',
            'code_ubg' => '11',
        ]);
        Department::create([
            'name' => 'Junin',
            'code_ubg' => '12',
        ]);
        Department::create([
            'name' => 'La Libertad',
            'code_ubg' => '13',
        ]);
        Department::create([
            'name' => 'Lambayeque',
            'code_ubg' => '14',
        ]);
        Department::create([
            'name' => 'Lima',
            'code_ubg' => '15',
        ]);
        Department::create([
            'name' => 'Loreto',
            'code_ubg' => '16',
        ]);
        Department::create([
            'name' => 'Madre de Dios',
            'code_ubg' => '17',
        ]);
        Department::create([
            'name' => 'Moquegua',
            'code_ubg' => '18',
        ]);
        Department::create([
            'name' => 'Pasco',
            'code_ubg' => '19',
        ]);
        Department::create([
            'name' => 'Piura',
            'code_ubg' => '20',
        ]);
        Department::create([
            'name' => 'Puno',
            'code_ubg' => '21',
        ]);
        Department::create([
            'name' => 'San Martin',
            'code_ubg' => '22',
        ]);
        Department::create([
            'name' => 'Tacna',
            'code_ubg' => '23',
        ]);
        Department::create([
            'name' => 'Tumbes',
            'code_ubg' => '24',
        ]);
        Department::create([
            'name' => 'Ucayali',
            'code_ubg' => '25',
        ]);
    }
}

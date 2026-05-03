<?php

namespace Database\Seeders;

use App\Models\NidaTestAccount;
use Illuminate\Database\Seeder;

class NidaTestAccountsSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            // Existing accounts
            [
                'nin' => '19900101123456789012',
                'full_name' => 'Andendekisye Shekimweri',
                'date_of_birth' => '1985-05-15',
                'mother_name' => 'Maria Shekimweri',
                'birth_place' => 'Mbeya',
            ],
            [
                'nin' => '19900515234567890123',
                'full_name' => 'Mwinyi Kazimoto',
                'date_of_birth' => '1990-10-20',
                'mother_name' => 'Aisha Kazimoto',
                'birth_place' => 'Dar es Salaam',
            ],
            [
                'nin' => '19991234567890123456',
                'full_name' => 'Fatuma Said Ally',
                'date_of_birth' => '1999-03-12',
                'mother_name' => 'Zainab Ally',
                'birth_place' => 'Zanzibar',
            ],

            // Additional test accounts
            [
                'nin' => '19880321123456789123',
                'full_name' => 'John Peter Mbwambo',
                'date_of_birth' => '1988-03-21',
                'mother_name' => 'Anna Mbwambo',
                'birth_place' => 'Arusha',
            ],
            [
                'nin' => '19951210123456789456',
                'full_name' => 'Sarah Hassan Juma',
                'date_of_birth' => '1995-12-10',
                'mother_name' => 'Fatma Hassan',
                'birth_place' => 'Tanga',
            ],
            [
                'nin' => '19820115123456789789',
                'full_name' => 'Richard Samson Mtei',
                'date_of_birth' => '1982-01-15',
                'mother_name' => 'Grace Mtei',
                'birth_place' => 'Kilimanjaro',
            ],
            [
                'nin' => '20000505123456789034',
                'full_name' => 'Amina Iddi Rashid',
                'date_of_birth' => '2000-05-05',
                'mother_name' => 'Mwanaisha Rashid',
                'birth_place' => 'Morogoro',
            ],
            [
                'nin' => '19781120123456789234',
                'full_name' => 'Hamza Abdallah Kigoda',
                'date_of_birth' => '1978-11-20',
                'mother_name' => 'Zainabu Kigoda',
                'birth_place' => 'Dodoma',
            ],
            [
                'nin' => '19930718123456789567',
                'full_name' => 'Lilian Edward Mushi',
                'date_of_birth' => '1993-07-18',
                'mother_name' => 'Monica Mushi',
                'birth_place' => 'Mwanza',
            ],
            [
                'nin' => '19860930123456789890',
                'full_name' => 'Salim Omar Salim',
                'date_of_birth' => '1986-09-30',
                'mother_name' => 'Asha Omar',
                'birth_place' => 'Pwani',
            ],
            [
                'nin' => '19990125123456789101',
                'full_name' => 'Rehema Charles Mwakyembe',
                'date_of_birth' => '1999-01-25',
                'mother_name' => 'Veronica Mwakyembe',
                'birth_place' => 'Iringa',
            ],
            [
                'nin' => '19750412123456789202',
                'full_name' => 'Peter Joseph Nyagali',
                'date_of_birth' => '1975-04-12',
                'mother_name' => 'Catherine Nyagali',
                'birth_place' => 'Ruvuma',
            ],
            [
                'nin' => '19961030123456789303',
                'full_name' => 'Zaituni Juma Mwinyi',
                'date_of_birth' => '1996-10-30',
                'mother_name' => 'Mariam Mwinyi',
                'birth_place' => 'Lindi',
            ],
            [
                'nin' => '19881205123456789404',
                'full_name' => 'Emmanuel Godfrey Lyimo',
                'date_of_birth' => '1988-12-05',
                'mother_name' => 'Dorothy Lyimo',
                'birth_place' => 'Manyara',
            ],
            [
                'nin' => '19940722123456789505',
                'full_name' => 'Asha Kheri Kombo',
                'date_of_birth' => '1994-07-22',
                'mother_name' => 'Mwanaidi Kombo',
                'birth_place' => 'Dar es Salaam',
            ],
            [
                'nin' => '20010315123456789606',
                'full_name' => 'Baraka Selemani Mushi',
                'date_of_birth' => '2001-03-15',
                'mother_name' => 'Agnes Mushi',
                'birth_place' => 'Kagera',
            ],
            [
                'nin' => '19700101123456789707',
                'full_name' => 'Tatu Mohamed Kipande',
                'date_of_birth' => '1970-01-01',
                'mother_name' => 'Saada Kipande',
                'birth_place' => 'Kigoma',
            ],
            [
                'nin' => '19981109123456789808',
                'full_name' => 'Issa Ally Msafiri',
                'date_of_birth' => '1998-11-09',
                'mother_name' => 'Saumu Msafiri',
                'birth_place' => 'Shinyanga',
            ],
            [
                'nin' => '19831220123456789909',
                'full_name' => 'Neema William Mwita',
                'date_of_birth' => '1983-12-20',
                'mother_name' => 'Jane Mwita',
                'birth_place' => 'Simiyu',
            ],
        ];

        foreach ($accounts as $account) {
            NidaTestAccount::updateOrCreate(
                ['nin' => $account['nin']],
                $account
            );
        }
    }
}

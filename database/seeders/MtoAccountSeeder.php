<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MtoAccount;

class MtoAccountSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            [
                'client_id'        => 'client001',
                'identifier'       => '00000121',
                'identifier_type'  => 'BANK',
                'fsp_id'           => 'CRDB',
                'destination_fsp'  => '003',
                'full_name'        => 'Andendekisye Shekimweri',
                'account_category' => 'PERSON',
                'account_type'     => 'BANK',
                'identity_type'    => 'TIN',
                'identity_value'   => '503123579',
            ],
            [
                'client_id'        => 'client001',
                'identifier'       => '24110000296',
                'identifier_type'  => 'BANK',
                'fsp_id'           => 'NMB',
                'destination_fsp'  => '008',
                'full_name'        => 'Mwinyi Kazimoto',
                'account_category' => 'PERSON',
                'account_type'     => 'BANK',
                'identity_type'    => 'NIN',
                'identity_value'   => '19900101123456789',
            ],
            [
                'client_id'        => 'client001',
                'identifier'       => '255621804189',
                'identifier_type'  => 'MSISDN',
                'fsp_id'           => 'MPESA',
                'destination_fsp'  => '503',
                'full_name'        => 'Fatuma Said Ally',
                'account_category' => 'PERSON',
                'account_type'     => 'WALLET',
                'identity_type'    => 'NIN',
                'identity_value'   => '19850512987654321',
            ],
            [
                'client_id'        => 'client001',
                'identifier'       => '255784000111',
                'identifier_type'  => 'MSISDN',
                'fsp_id'           => 'AIRTEL',
                'destination_fsp'  => '504',
                'full_name'        => 'Juma Hassan Mbwana',
                'account_category' => 'PERSON',
                'account_type'     => 'WALLET',
                'identity_type'    => 'NIN',
                'identity_value'   => '19780301456789123',
            ],
            [
                'client_id'        => 'client001',
                'identifier'       => '01258796325',
                'identifier_type'  => 'BANK',
                'fsp_id'           => 'EXIM',
                'destination_fsp'  => '013',
                'full_name'        => 'Karibu Supplies Ltd',
                'account_category' => 'BUSINESS',
                'account_type'     => 'BANK',
                'identity_type'    => 'TIN',
                'identity_value'   => '100456789',
            ],
            [
                'client_id'        => 'client001',
                'identifier'       => '255754000222',
                'identifier_type'  => 'MSISDN',
                'fsp_id'           => 'TIGO',
                'destination_fsp'  => '501',
                'full_name'        => 'Mariam Juma Salehe',
                'account_category' => 'PERSON',
                'account_type'     => 'WALLET',
                'identity_type'    => 'NIN',
                'identity_value'   => '19920815654321987',
            ],
        ];

        foreach ($accounts as $account) {
            MtoAccount::create($account);
        }
    }
}

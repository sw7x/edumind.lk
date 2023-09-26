<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice as InvoiceModel;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {                        
            InvoiceModel::factory()->count(10)->create();        
        } catch (\Exception $e) {
            $this->command->error('Failed to seed invoices to database !');
        }
    }
}

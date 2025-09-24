<?php

namespace App\Console\Commands;

use App\Models\Equipment;
use Illuminate\Console\Command;

class CheckEquipmentStock extends Command
{
    protected $signature = 'equipment:check-stock';
    protected $description = 'Check current stock for all equipment';

    public function handle()
    {
        $equipment = Equipment::all();
        
        $this->info('Current Equipment Stock:');
        $this->table(
            ['Name', 'Stock'],
            $equipment->map(function ($item) {
                return [
                    'name' => $item->name,
                    'stock' => $item->stock
                ];
            })
        );
    }
}
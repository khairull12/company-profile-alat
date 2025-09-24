<?php

namespace App\Console\Commands;

use App\Models\Equipment;
use Illuminate\Console\Command;

class UpdateEquipmentStock extends Command
{
    protected $signature = 'equipment:update-stock {name} {stock}';
    protected $description = 'Update stock for specific equipment';

    public function handle()
    {
        $name = $this->argument('name');
        $stock = $this->argument('stock');

        $equipment = Equipment::where('name', 'like', "%{$name}%")->first();
        
        if (!$equipment) {
            $this->error("Equipment not found: {$name}");
            return 1;
        }

        $equipment->update(['stock' => $stock]);
        $this->info("Updated stock for {$equipment->name} to {$stock}");
    }
}
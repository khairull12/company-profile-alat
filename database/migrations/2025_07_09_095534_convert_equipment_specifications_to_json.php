<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Equipment;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Convert existing specifications text to JSON array
        $equipment = Equipment::all();
        
        foreach ($equipment as $item) {
            if (!empty($item->specifications) && is_string($item->specifications)) {
                $specs = [];
                $lines = explode("\n", $item->specifications);
                
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line && strpos($line, ':') !== false) {
                        $parts = explode(':', $line, 2);
                        if (count($parts) === 2) {
                            $specs[trim($parts[0])] = trim($parts[1]);
                        }
                    }
                }
                
                if (!empty($specs)) {
                    $item->specifications = $specs;
                    $item->save();
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert JSON specifications back to text
        $equipment = Equipment::all();
        
        foreach ($equipment as $item) {
            if (!empty($item->specifications) && is_array($item->specifications)) {
                $text = '';
                foreach ($item->specifications as $key => $value) {
                    $text .= $key . ': ' . $value . "\n";
                }
                
                $item->specifications = trim($text);
                $item->save();
            }
        }
    }
};

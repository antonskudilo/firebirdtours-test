<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('currency_rates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('currency_id')
                ->index()
                ->constrained('currencies')
                ->cascadeOnDelete();

            $table->decimal('latest_exchange_rate', 15, 8);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('currency_rates');
    }
};

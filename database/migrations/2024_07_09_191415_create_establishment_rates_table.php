<?php

use App\Models\Establishment;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('establishment_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Establishment::class)->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->double('rate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('establishment_rates');
    }
};

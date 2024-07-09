<?php

use App\Models\Establishment;
use App\Models\Media;
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
        Schema::create('establishment_media', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Media::class)->nullable();
            $table->foreignIdFor(Establishment::class)->nullable();
            $table->boolean('is_cover')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('establishment_media');
    }
};
<?php

use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use App\Models\Address;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('cpf_cnpj', 20)->unique();
            $table->string('phone', 20)->nullable();
            $table->enum('status', UserStatusEnum::toArrayWithString())->default(UserStatusEnum::ENABLED);
            $table->enum('type', UserTypeEnum::toArrayWithString());
            $table->foreignIdFor(Address::class)->nullable();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

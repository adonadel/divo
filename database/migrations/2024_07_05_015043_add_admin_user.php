<?php

use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@teste.com',
            'cpf_cnpj' => '123.456.789-10',
            'password' => Hash::make('Pw12345678!'),
            'type' => UserTypeEnum::ADMIN,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $model = User::whereEmail('admin@teste.com')->delete();
    }
};

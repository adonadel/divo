<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->categories() as $category) {
            Category::create($category);
        }
    }

    private function categories()
    {
        return [
            [
                'name' => 'Gastronomia',
                'description' => '',
            ],
            [
                'name' => 'Hospedagem',
                'description' => '',
            ],
            [
                'name' => 'Ponto turístico',
                'description' => '',
            ],
            [
                'name' => 'Lazer',
                'description' => '',
            ],
        ];
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->categories() as $category) {
            $model = Category::whereName($category['name'])->first();

            if ($model) {
                $model->delete();
            }
        }
    }
};

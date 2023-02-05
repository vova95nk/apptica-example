<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications_chart', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('sub_category_id');
            $table->date('stat_date');
            $table->unsignedInteger('position')->nullable();

            $table->index(['stat_date']);

            $table->unique(['category_id', 'sub_category_id', 'stat_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications_chart');
    }
};

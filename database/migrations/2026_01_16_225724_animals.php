<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::create('animals', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('species'); 
        $table->string('status');  
        $table->string('city');
        $table->text('description');
        $table->string('image')->nullable();
        $table->decimal('latitude', 10, 8)->nullable(); 
        $table->decimal('longitude', 11, 8)->nullable();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

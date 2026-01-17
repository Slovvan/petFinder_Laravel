<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adopt_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('adopt_requests', 'animal_id')) {
                $table->foreignId('animal_id')->constrained('animals')->onDelete('cascade');
            }
            if (!Schema::hasColumn('adopt_requests', 'user_id')) {
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            }
            if (!Schema::hasColumn('adopt_requests', 'message')) {
                $table->text('message');
            }
            if (!Schema::hasColumn('adopt_requests', 'read_at')) {
                $table->timestamp('read_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('adopt_requests', function (Blueprint $table) {
            if (Schema::hasColumn('adopt_requests', 'read_at')) {
                $table->dropColumn('read_at');
            }
            if (Schema::hasColumn('adopt_requests', 'message')) {
                $table->dropColumn('message');
            }
            if (Schema::hasColumn('adopt_requests', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
            if (Schema::hasColumn('adopt_requests', 'animal_id')) {
                $table->dropConstrainedForeignId('animal_id');
            }
        });
    }
};

<?php

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
        Schema::table('pegawais', function (Blueprint $table) {
            // drop old string column if exists then add proper foreign key
            if (Schema::hasColumn('pegawais', 'jabatan_id')) {
                $table->dropColumn('jabatan_id');
            }

            $table->foreignId('jabatan_id')->nullable()->constrained('jabatans')->nullOnDelete()->after('nip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            if (Schema::hasColumn('pegawais', 'jabatan_id')) {
                $table->dropForeign(['jabatan_id']);
                $table->dropColumn('jabatan_id');
            }

            $table->string('jabatan_id')->nullable()->after('nip');
        });
    }
};

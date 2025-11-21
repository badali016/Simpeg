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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 50)->unique()->comment('Nomor Induk Pegawai / Karyawan');
            $table->string('nama', 75);
            $table->string('panggilan', 15)->nullable();
            $table->string('gelas_depan', 25)->nullable();
            $table->string('gelas_belakang', 35)->nullable();
            $table->string('tempat_lahir', 35)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama', 50)->nullable();
            $table->tinyInteger('jenis_kelamin')->nullable();
            $table->tinyInteger('profesi')->nullable();


            $table->tinyInteger('smf')->nullable()->comment('Spesialis/Sub. Spesialis');
            $table->string('alamat', 150)->nullable();
            $table->char('rt', 3)->nullable();
            $table->char('rw', 3)->nullable();
            $table->char('kodepos', 5)->nullable();
            $table->char('wilayah', 10)->nullable();
            $table->timestamp('tanggal')->nullable()->useCurrent();
            $table->tinyInteger('non_pegawai')->nullable()->default(0)->comment('0=Pegawai; 1=Bukan Pegawai');
            $table->string('email', 100)->nullable()->unique();
            $table->tinyInteger('status')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};

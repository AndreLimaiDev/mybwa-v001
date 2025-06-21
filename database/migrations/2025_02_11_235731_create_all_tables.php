<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('jabatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jabatan');
            $table->timestamps();
        });

        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('inisial');
            $table->timestamps();
        });

        Schema::create('branch_user', function (Blueprint $table) {
            $table->id();
            $table->string('branch_id');
            $table->string('user_id');
            $table->timestamps();
        });

        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('nama_karyawan');
            $table->foreignId('jabatan_id')->constrained('jabatans');
            $table->string('hp');
            $table->boolean('is_active')->default(true);
            $table->foreignId('branch_id')->constrained('branches');
            $table->timestamps();
        });

        Schema::create('karyawan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawans');
            $table->foreignId('alamat');
            $table->foreignId('awal_akad');
            $table->foreignId('akhir_akad');
            $table->timestamps();
        });

        Schema::create('sumbers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sumber');
            $table->foreignId('branch_id')->constrained('branches');
            $table->timestamps();
        });

        Schema::create('wakifs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_wakif');
            $table->string('hp');
            $table->date('tgl_dapat');
            $table->string('wa_status');
            $table->foreignId('sumber_id')->constrained('sumbers');
            $table->foreignId('prospektor_id')->constrained('karyawans');
            $table->string('status_prospek');
            $table->foreignId('branch_id')->constrained('branches');
            $table->timestamps();
        });

        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wakif_id')->constrained('wakifs');
            $table->foreignId('petugas_id')->constrained('karyawans');
            $table->date('tgl_transaksi');
            $table->string('jenis_transaksi');
            $table->foreignId('branch_id')->constrained('branches');
            $table->timestamps();
        });

        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program');
            $table->timestamps();
        });

        Schema::create('projeks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs');
            $table->string('nama_projek');
            $table->string('kode_unik');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('transaksi_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksis');
            $table->foreignId('program_id')->constrained('programs');
            $table->foreignId('projek_id')->constrained('projeks');
            $table->string('revenue');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi_details');
        Schema::dropIfExists('projeks');
        Schema::dropIfExists('programs');
        Schema::dropIfExists('transaksis');
        Schema::dropIfExists('wakifs');
        Schema::dropIfExists('sumbers');
        Schema::dropIfExists('karyawans');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('branch_user');
        Schema::dropIfExists('jabatans');
    }
};

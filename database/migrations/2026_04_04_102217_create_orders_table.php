<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('nama_customer'); // guest
            $table->integer('total')->default(0);

            $table->enum('status_pembayaran', ['pending', 'lunas'])->default('pending');

            $table->timestamps();
        });
    }
};

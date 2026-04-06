<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('menus', function (Blueprint $table) {
        $table->id();
        $table->string('nama_menu');
        $table->integer('harga');

        $table->foreignId('vendor_id')->constrained()->onDelete('cascade');

        $table->timestamps();
    });
}
};

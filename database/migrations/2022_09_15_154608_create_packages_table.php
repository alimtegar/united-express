<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manifest_id')->constrained();
            $table->foreignId('invoice_id')->constrained();
            $table->integer('tracking_no')->unique();
            $table->string('recipient');
            $table->integer('quantity');
            $table->integer('weight');
            $table->integer('volume')->nullable();
            $table->enum('type', ['P', 'D'])->nullable(); // P = Parcel, D = Document
            $table->integer('cod')->nullable();
            $table->text('description')->nullable();
            $table->integer('cost');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
};

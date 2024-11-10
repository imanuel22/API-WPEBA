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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('image');
            $table->enum('status', ['upcoming', 'in_progress', 'completed'])->default('upcoming');
            $table->datetime('start_datetime'); 
            $table->unsignedInteger('duration'); //menit
            $table->string('location');
            $table->string('contact', 100); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // $table->foreignId('event_category_ids')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

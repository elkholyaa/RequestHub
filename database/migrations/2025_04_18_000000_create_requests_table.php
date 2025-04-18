<?php
/**
 * Migration: create_requests_table
 *
 * Defines the core “requests” domain entity for MVP.
 * Fields:
 *  • title, description                – basic details
 *  • type      ENUM[service,maintenance]
 *  • status    ENUM[pending,in_progress,completed]
 *  • priority  ENUM[low,medium,high]
 *  • due_date  nullable DATE
 *  • requested_by (FK users.id)        – creator
 *  • assigned_to (nullable FK users.id)– current handler
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['service', 'maintenance'])->default('service');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->date('due_date')->nullable();
            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};

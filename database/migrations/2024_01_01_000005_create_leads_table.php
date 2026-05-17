<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('name'); // lead contact name
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->enum('status', ['new', 'contacted', 'qualified', 'unqualified', 'converted', 'lost'])->default('new');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->string('source')->nullable();
            $table->decimal('estimated_value', 15, 2)->nullable();
            $table->string('currency', 3)->default('INR');
            $table->text('description')->nullable();
            $table->string('preferred_language', 5)->default('en');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('expected_close_date')->nullable();
            $table->timestamp('converted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};

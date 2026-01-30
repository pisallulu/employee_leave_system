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
    Schema::create('leave_requests', function (Blueprint $table) {
        $table->id();
        // The Link: Who is asking?
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        // The Link: What type of leave?
        $table->foreignId('leave_type_id')->constrained('leave_types')->cascadeOnDelete();
        
        // Date Logic
        $table->date('start_date');
        $table->date('end_date');
        
        // The Workflow
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->text('reason')->nullable(); // Why do they want leave?
        $table->text('rejection_reason')->nullable(); // Admin feedback
        
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};

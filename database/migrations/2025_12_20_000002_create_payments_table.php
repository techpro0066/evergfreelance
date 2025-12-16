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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('buy_course_id')->nullable()->constrained('buy_courses')->onDelete('set null');
            $table->string('payment_intent_id')->unique();
            $table->string('payment_method_id')->nullable();
            $table->string('status'); // pending, paid, failed, refunded
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('PHP');
            $table->string('payment_method_type')->nullable(); // card, gcash, grab_pay, etc.
            $table->string('order_reference')->unique();
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};


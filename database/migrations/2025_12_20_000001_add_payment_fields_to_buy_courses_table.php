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
        Schema::table('buy_courses', function (Blueprint $table) {
            $table->string('payment_intent_id')->nullable()->after('status');
            $table->string('payment_status')->default('pending')->after('payment_intent_id');
            $table->decimal('amount_paid', 10, 2)->nullable()->after('payment_status');
            $table->string('payment_method')->nullable()->after('amount_paid');
            $table->string('order_reference')->nullable()->unique()->after('payment_method');
            $table->timestamp('paid_at')->nullable()->after('order_reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buy_courses', function (Blueprint $table) {
            $table->dropColumn([
                'payment_intent_id',
                'payment_status',
                'amount_paid',
                'payment_method',
                'order_reference',
                'paid_at'
            ]);
        });
    }
};


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('acquired')->nullable(false);
            $table->float('quantity')->nullable(false);
            $table->float('avg_cost_basis')->nullable(false)->default(0);

            $table->bigInteger('fund_id');
            $table->foreign('fund_id')->references('id')->on('funds')->noActionOnUpdate()->restrictOnDelete();
            $table->bigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts')->noActionOnUpdate()->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

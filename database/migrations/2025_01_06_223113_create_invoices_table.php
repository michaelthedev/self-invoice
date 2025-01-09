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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();

            $table->foreignId('project_id')->constrained();
            $table->foreignId('client_id')->constrained();

            $table->string('reference')->nullable();

            $table->string('currency');
            $table->decimal('amount', 10)
                ->comment('Total amount of the invoice');
            $table->decimal('tax')->default(0);
            $table->decimal('discount')->default(0);

            $table->string('title')->nullable();
            $table->text('note')->nullable();

            $table->string('status');
            $table->date('due_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

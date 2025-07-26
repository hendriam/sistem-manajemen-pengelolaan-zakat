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
        Schema::create('zakat_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('muzakki_id')->constrained()->onDelete('cascade');
            $table->enum('types_of_zakat', ['fitrah', 'mal', 'profesi', 'lainnya']);
            $table->decimal('amount', 12, 2);
            $table->dateTime('zakat_transaction_date')->default(now());
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zakat_transactions');
    }
};

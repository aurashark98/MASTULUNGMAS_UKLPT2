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
        Schema::table('task_disputes', function (Blueprint $table) {
            $table->text('partner_response')->nullable()->after('evidence_path');
            $table->string('partner_evidence_path')->nullable()->after('partner_response');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_disputes', function (Blueprint $table) {
            $table->dropColumn(['partner_response', 'partner_evidence_path']);
        });
    }
};

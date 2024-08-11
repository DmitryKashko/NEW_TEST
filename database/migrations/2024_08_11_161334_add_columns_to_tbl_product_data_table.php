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
        Schema::table('tblProductData', function (Blueprint $table) {
            $table->integer("stock")->after('strProductCode');
            $table->float("cost")->after('stock');
            $table->boolean("dtmDiscontinued")->change();;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tblProductData', function (Blueprint $table) {
            $table->dropColumn('stock');
            $table->dropColumn('cost');
            $table->dateTime("dtmDiscontinued")->change();;
        });
    }
};

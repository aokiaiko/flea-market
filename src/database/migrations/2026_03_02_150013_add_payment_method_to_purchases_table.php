<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentMethodToPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('payment_method')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
         Schema::table('purchases', function (Blueprint $table) {
          if (Schema::hasColumn('purchases', 'payment_method')) {
            $table->dropColumn('payment_method');
         }
        });
    }
        
}

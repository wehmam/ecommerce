<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string("invoice_no")->unique();
            $table->string("province");
            $table->string("city");
            $table->string("district");
            $table->integer("post_code");
            $table->string("address");
            $table->decimal('total_amount', 15, 0);
            $table->enum("status_paid", ["PAID", "NOT PAID"])->default("NOT PAID");
            $table->timestamp("paid_at")->nullable();
            $table->text("dump_payment")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};

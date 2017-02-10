<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('items', function (Blueprint $table) {

        $table->increments('id');
        $table->string('name');
        $table->text('description')->nullable();
        $table->integer('amount_in');
        $table->integer('amount_out')->default(0);
        $table->integer('value_in')->nullable();
        $table->integer('value_out')->nullable();
        $table->date('expiry_date')->nullable();
        $table->integer('user_id')->index();
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
        Schema::dropIfExists('items');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderdetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orderdetails', function(Blueprint $table)
		{
			$table->integer('OrderDetailId', true);
			$table->integer('OrderId')->nullable()->index('OrderId');
			$table->integer('ProductID')->nullable()->index('ProductID');
			$table->integer('Quantity')->nullable();
			$table->decimal('Total', 10)->nullable();
			$table->decimal('TotalGST', 10)->nullable();			
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orderdetails');
	}

}

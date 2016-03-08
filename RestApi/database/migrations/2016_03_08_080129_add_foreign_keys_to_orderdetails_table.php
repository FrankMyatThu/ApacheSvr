<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOrderdetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orderdetails', function(Blueprint $table)
		{
			$table->foreign('OrderId', 'orderdetails_ibfk_1')->references('OrderId')->on('orders')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('ProductID', 'orderdetails_ibfk_2')->references('ProductID')->on('products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('orderdetails', function(Blueprint $table)
		{
			$table->dropForeign('orderdetails_ibfk_1');
			$table->dropForeign('orderdetails_ibfk_2');
		});
	}

}

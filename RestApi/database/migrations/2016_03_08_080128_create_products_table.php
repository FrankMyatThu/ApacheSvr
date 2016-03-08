<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->integer('ProductID', true);
			$table->string('ProductName', 250)->nullable();
			$table->string('Description', 250)->nullable();
			$table->string('ProductImage', 250)->nullable();
			$table->decimal('Price', 10)->nullable();
			$table->boolean('Active', 1)->nullable();			
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}

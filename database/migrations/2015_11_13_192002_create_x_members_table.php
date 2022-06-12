<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXMembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_members', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('membership_no')->unique('membership_no');
			$table->string('photo')->default('default_photo.png');
			$table->string('signature')->nullable();
			$table->string('gender')->nullable();
			$table->bigInteger('id_number')->nullable();
			$table->string('phone')->nullable();
			$table->string('email')->nullable();
			$table->text('address', 65535)->nullable();
			$table->integer('group_id')->unsigned()->nullable()->index('members_group_id_foreign');
			$table->integer('branch_id')->unsigned()->index('members_branch_id_foreign');
			$table->float('monthly_remittance_amount', 15)->nullable();
			$table->timestamps();
			$table->boolean('is_active')->nullable()->default(1);
			$table->boolean('is_css_active')->nullable()->default(0);
            $table->integer('organization_id')->nulable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('members');
	}

}

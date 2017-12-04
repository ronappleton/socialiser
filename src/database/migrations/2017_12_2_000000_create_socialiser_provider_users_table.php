<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialiserProviderUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socialiser_provider_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('provider')->length(20);
            $table->string('provider_id')->length(125);
            $table->string('name')->length(125)->nullable();
            $table->string('nickname')->length(125)->nullable();
            $table->string('email')->length(125)->nullable();
            $table->string('avatar')->length(125)->nullable();
            $table->string('token')->length(125)->nullable();
            $table->string('refresh_token')->length(125)->nullable();
            $table->timestamp('expires_in')->nullable();

            $table->unique(['provider', 'provider_id']);
            $table->unique(['provider', 'email']);

            $table->timestamps();
        });

        Schema::table('socialiser_provider_users', function (Blueprint $table) {
            $table->foreign('user_id')->references(userPrimaryKeyColumn())->on(userModelTable())->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socialiser_provider_users');
    }
}

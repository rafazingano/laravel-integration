<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntegrationsTable extends Migration
{

    public function up()
    {
        Schema::create('integration_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('view')->unique();
            $table->string('service')->nullable();
            $table->timestamps();
        });

        Schema::create('integrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('frequency_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('user_id');
            $table->string('service');
            $table->string('code', 20)->unique();
            $table->string('title');
            $table->string('key_field')->nullable();
            $table->text('options')->nullable();
            $table->string('interaction');
            $table->boolean('create')->default(1);
            $table->boolean('update')->default(1);
            $table->timestamps();

            $table->foreign('frequency_id')
                ->references('id')
                ->on('schedule_frequency_options')
                ->onDelete('cascade');

            $table->foreign('type_id')
                ->references('id')
                ->on('integration_types')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::create('integration_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('integration_id');
            $table->string('outside');
            $table->string('inside');
            $table->boolean('create')->default(1);
            $table->boolean('update')->default(1);
            $table->timestamps();

            $table->foreign('integration_id')
                ->references('id')
                ->on('integrations')
                ->onDelete('cascade');
        });

        Schema::create('integration_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('integration_id');
            $table->bigInteger('integrationdataable_id');
            $table->string('integrationdataable_type');
            $table->longText('content')->nullable();
            $table->timestamps();

            $table->foreign('integration_id')
                ->references('id')
                ->on('integrations')
                ->onDelete('cascade');
        });

        Schema::create('integration_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('integration_id');
            $table->text('content')->nullable();
            $table->timestamps();

            $table->foreign('integration_id')
                ->on('integrations')
                ->references('id')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('integration_user');
        Schema::dropIfExists('integration_data');
        Schema::dropIfExists('integration_fields');
        Schema::dropIfExists('integrations');
        Schema::dropIfExists('integration_types');
    }
}

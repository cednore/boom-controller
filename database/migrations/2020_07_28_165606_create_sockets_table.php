<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


/**
 * Migration to create sockets table.
 */
class CreateSocketsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        // Create table
        Schema::connection(config('boom.db.connection') ?: config('database.default'))->create(
            config('boom.db.tables.sockets'),
            function(Blueprint $table) {
                // Columns
                $table->string('id', 128);
                $table->string('data', 20000);
                $table->timestamps();

                // Set primary key
                $table->primary('id');

                // Set table options
                $table->engine = 'MEMORY';
                $table->charset = 'utf8';
                $table->collation = 'utf8_unicode_ci';
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::connection(config('boom.db.connection') ?: config('database.default'))
            ->dropIfExists(config('boom.db.tables.sockets'));
    }
}

<?php

use App\helpers\MigrationTables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(MigrationTables::TABLE_BOOKS, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('title');
            $table->unsignedInteger('shelf_no');
            $table->string('author_name');
            $table->unsignedBigInteger('quantity');
            $table->string('status')->default('available');// unavailable
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on(MigrationTables::TABLE_CATEGORIES);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(MigrationTables::TABLE_BOOKS);
    }
}

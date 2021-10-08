<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Post;
class AddUpdateByColumnToPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(with(new Post)->getTable(), function (Blueprint $table) {
            $table->bigInteger('updated_by_user_id')->after('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(with(new Post)->getTable(), function (Blueprint $table) {
            $table->dropColumn('updated_by_user_id');
        });
    }
}

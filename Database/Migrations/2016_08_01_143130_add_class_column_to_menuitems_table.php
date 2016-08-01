<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClassColumnToMenuitemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu__menuitems', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('class')->after('link_type')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu__menuitems', function (Blueprint $table) {
            $table->dropColumn('class');
        });
    }

}

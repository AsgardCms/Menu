<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinkTypeColymnToMenuitemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu__menuitems', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('link_type')->after('target')->default('page');
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
            $table->dropColumn('link_type');
        });
    }

}

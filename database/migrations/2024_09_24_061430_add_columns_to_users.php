<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add your columns here, e.g. $table->string('column_name');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the columns you added, e.g. $table->dropColumn('column_name');
        });
    }
}

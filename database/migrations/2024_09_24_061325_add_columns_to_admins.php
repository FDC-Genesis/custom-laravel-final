<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAdmins extends Migration
{
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            // Add your columns here, e.g. $table->string('column_name');
        });
    }

    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            // Drop the columns you added, e.g. $table->dropColumn('column_name');
        });
    }
}

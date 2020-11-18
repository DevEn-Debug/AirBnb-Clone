<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('flats', function (Blueprint $table) {
        $table->foreign('user_id', 'us_fl') -> references('id') -> on('users');
      });


      Schema::table('visits', function (Blueprint $table) {
        $table->foreign('flat_id', 'fl_vis') -> references('id') -> on('flats');
      });
      Schema::table('messages', function (Blueprint $table) {
        $table->foreign('flat_id', 'fl_mes') -> references('id') -> on('flats');
      });
      Schema::table('photos', function (Blueprint $table) {
        $table->foreign('flat_id', 'fl_ph') -> references('id') -> on('flats');
      });


      Schema::table('flat_sponsor', function (Blueprint $table) {
        $table->foreign('flat_id','sp_fl')->references('id')->on('flats');
        $table->foreign('sponsor_id','fl_sp')->references('id')->on('sponsors');
      });
      Schema::table('flat_service', function (Blueprint $table) {
        $table->foreign('flat_id','se_fl')->references('id')->on('flats');
        $table->foreign('service_id','fl_se')->references('id')->on('services');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('users', function (Blueprint $table) {
        $table->dropForeign('us_fl');
      });


      Schema::table('flats', function (Blueprint $table) {
        $table->dropForeign('fl_vis');
      });
      Schema::table('flats', function (Blueprint $table) {
        $table->dropForeign('fl_mes');
      });
      Schema::table('flats', function (Blueprint $table) {
        $table->dropForeign('fl_ph');
      });


      Schema::table('flat_sponsor', function (Blueprint $table) {
        $table->dropForeign('sp_fl');
        $table->dropForeign('fl_sp');
      });
      Schema::table('flat_service', function (Blueprint $table) {
        $table->dropForeign('se_fl');
        $table->dropForeign('fl_se');
      });

    }
}

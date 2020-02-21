<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFieldsArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->enum('type', ['text', 'photo','video','gallery','infographics'])->after('slug');
            $table->string('video')->nullable()->after('type');
            $table->integer('gallery_id')->nullable()->unsigned()->after('video');
            $table->text('extras')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            //
            $table->dropColumn('image');
        });
    }
}

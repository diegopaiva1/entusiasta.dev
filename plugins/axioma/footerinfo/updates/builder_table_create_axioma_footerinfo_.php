<?php namespace Axioma\FooterInfo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAxiomaFooterinfo extends Migration
{
    public function up()
    {
        Schema::create('axioma_footerinfo_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('about');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('axioma_footerinfo_');
    }
}

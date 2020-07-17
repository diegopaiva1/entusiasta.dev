<?php namespace Axioma\FooterInfo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAxiomaFooterinfo2 extends Migration
{
    public function up()
    {
        Schema::table('axioma_footerinfo_', function($table)
        {
            $table->string('image', 255)->change();
        });
    }
    
    public function down()
    {
        Schema::table('axioma_footerinfo_', function($table)
        {
            $table->string('image', 191)->change();
        });
    }
}

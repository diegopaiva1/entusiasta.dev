<?php namespace Axioma\FooterInfo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAxiomaFooterinfo extends Migration
{
    public function up()
    {
        Schema::table('axioma_footerinfo_', function($table)
        {
            $table->string('image');
        });
    }
    
    public function down()
    {
        Schema::table('axioma_footerinfo_', function($table)
        {
            $table->dropColumn('image');
        });
    }
}

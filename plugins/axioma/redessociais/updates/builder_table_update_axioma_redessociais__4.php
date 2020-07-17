<?php namespace Axioma\RedesSociais\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAxiomaRedessociais4 extends Migration
{
    public function up()
    {
        Schema::table('axioma_redessociais_', function($table)
        {
            $table->renameColumn('icon', 'icone');
        });
    }
    
    public function down()
    {
        Schema::table('axioma_redessociais_', function($table)
        {
            $table->renameColumn('icone', 'icon');
        });
    }
}

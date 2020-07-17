<?php namespace Axioma\RedesSociais\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAxiomaRedessociais extends Migration
{
    public function up()
    {
        Schema::table('axioma_redessociais_', function($table)
        {
            $table->string('nome', 191)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('axioma_redessociais_', function($table)
        {
            $table->string('nome', 191)->nullable(false)->change();
        });
    }
}

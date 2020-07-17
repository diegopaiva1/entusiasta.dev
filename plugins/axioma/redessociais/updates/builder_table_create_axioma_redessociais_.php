<?php namespace Axioma\RedesSociais\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAxiomaRedessociais extends Migration
{
    public function up()
    {
        Schema::create('axioma_redessociais_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('nome');
            $table->string('url');
            $table->string('icon');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('axioma_redessociais_');
    }
}

<?php namespace Axioma\FooterInfo\Models;

use Model;

/**
 * Model
 */
class FooterInfo extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'axioma_footerinfo_';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}

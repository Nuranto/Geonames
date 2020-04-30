<?php

namespace MichaelDrennen\Geonames\Models;

use Illuminate\Database\Eloquent\Model;

class Admin1Code extends Model {

    protected $table = 'geonames_admin_1_codes';

    protected $primaryKey = 'geonameid';
    
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = ['geonameid' => 'integer'];
}
<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
    use HasFactory;

    /**
     * {@inheritDoc}
     */
    protected $connection = 'mongodb';

    /**
     * {@inheritDoc}
     */
    protected $collection = 'leads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 
        'last_name',
        'email_address',
        'industry',
        'consent',
    ];

    /**
     * Set 'consent' attribute.
     *
     * @param  string  $value
     * @return void
     */
    public function setConsentAttribute($value)
    {
        $this->attributes['consent'] = (bool) $value;
    }
}

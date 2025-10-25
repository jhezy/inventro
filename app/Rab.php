<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rab extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the commodities associated with the commodity location.
     */
    public function rabs()
    {
        return $this->hasMany(Rab::class);
    }
}

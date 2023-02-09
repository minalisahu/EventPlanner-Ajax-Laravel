<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'recurrence_type',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }


    /**
     * Get created
     *
     */
    public function getCreatedAttribute()
    {
        return $this->created_at ? $this->created_at->format('jS M, Y') : '--';
    }

    /**
     * Get modified
     *
     */
    public function getModifiedAttribute()
    {
        return $this->updated_at ? $this->updated_at->format('jS M, Y') : '--';
    }

    /**
     * Get start date for edit
     *
     */
    public function getStartdateEditAttribute()
    {
        return $this->start_date ? $this->start_date->format('m/d/Y') : '--';
    }

    /**
     * Get  end date for edit
     *
     */
    public function getEnddateEditAttribute()
    {
        return $this->end_date ? $this->end_date->format('m/d/Y') : '--';
    }

    /**
     * Get start date
     *
     */
    public function getStarteventAttribute()
    {
        return $this->start_date ? $this->start_date->format('jS M, Y') : '--';
    }
    /**
     * Get  end date 
     *
     */
    public function getEndeventAttribute()
    {
        return $this->end_date ? $this->end_date->format('jS M, Y') : 'infinitely';
    }


}

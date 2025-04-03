<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products.json';

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'quantity',
        'price',
        'created_at'
    ];
/*
    protected $appends =[
        'total_value'
    ];
 */
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',            
        ];
    }

    /**
     * Get the total value
     */
    protected function getTotalValueAttribute()
    {
        return ($this->price * $this->quantity);
    }   

}

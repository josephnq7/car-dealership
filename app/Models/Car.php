<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int year
 * @property int manufacturer_id
 *
 * @property Manufacturer $manufacturer
 */
class Car extends BaseModel
{
    use HasFactory;

    protected $fillable = ['name', 'year', 'manufacturer_id'];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

}

<?php

namespace App\Models;

use App\Helpers\FileHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'logo',
        'website',
    ];

    public function setLogoAttribute($value)
    {
            $fileHelper = new FileHelper();
            $this->attributes['logo'] = $fileHelper->storeLogo($value);
    }
}

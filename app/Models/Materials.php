<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materials extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'materials';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'material_sku',
        'type',
        'name',
        'color'
    ];
}

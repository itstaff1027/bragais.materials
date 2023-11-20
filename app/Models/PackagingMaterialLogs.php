<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackagingMaterialLogs extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'packaging_materials_logs';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
}

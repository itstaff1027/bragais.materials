<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TemporaryDeliveryLogs extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'temporary_delivery_logs';
}

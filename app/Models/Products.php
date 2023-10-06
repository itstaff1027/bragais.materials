<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_sku',
        'model',
        'color',
        'size',
        'heel_height',
        'category',
        'price',
        'stocks',
        'display_stocks',
        'outlet_stocks',
        'order_from',
        'bundle',
        'Bulk',
        'BulkNo',
    ];
}

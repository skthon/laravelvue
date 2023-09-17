<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property integer id
 * @property string  subject
 * @property string  description
 * @property integer user_id
 * @property string  type
 * @property string  status
 * @property Carbon  start_date
 * @property Carbon  due_date
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'description',
        'type',
        'status',
        'start_date',
        'due_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'due_date'   => 'datetime',
    ];
}

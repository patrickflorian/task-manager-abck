<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status'
    ];

    protected $casts = [
        'due_date' => 'date',
        'status' => Status::class,
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

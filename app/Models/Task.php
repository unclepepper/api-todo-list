<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find($id)
 * @method static findOrFail(int $id)
 * @method static create(array $data)
 */
class Task extends Model
{
    use HasFactory;

    // Определяем поля, которые могут быть массово назначены
    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    // Описание значений статуса для удобства
    const array STATUSES = [
        'pending' => 'Pending',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
    ];
}

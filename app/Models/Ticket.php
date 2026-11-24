<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;
    public const PRIORITAS = ['rendah', 'sedang', 'tinggi'];
    public const STATUS = ['open', 'proses', 'selesai'];

    protected $fillable = ['category_id', 'judul', 'deskripsi', 'prioritas', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(TicketReply::class)->oldest();
    }

    public function isViewableBy(User $user): bool
    {
        return $user->isStaff() || $this->user_id === $user->id;
    }
}
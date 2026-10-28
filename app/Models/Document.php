<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'reg_id',
        'doc_type',
        'file_path',
        'status',
        'revision_note',
    ];

    /**
     * The registration this document belongs to.
     */
    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'reg_id');
    }

    /**
     * Scope query to approved documents.
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope query to pending verification documents.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope query to documents needing revision.
     */
    public function scopeRevisionNeeded(Builder $query): Builder
    {
        return $query->where('status', 'revision_needed');
    }

    /**
     * Check if document is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if document requires revision.
     */
    public function isRevisionNeeded(): bool
    {
        return $this->status === 'revision_needed';
    }

    /**
     * Check if document is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}

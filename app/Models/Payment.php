<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'reg_id',
        'amount',
        'sender_bank',
        'sender_name',
        'proof_file',
        'payment_method',
        'status',
        'verified_by',
        'paid_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    /**
     * The registration this payment belongs to.
     */
    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'reg_id');
    }

    /**
     * The admin/bendahara who verified this payment.
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Scope query to verified payments.
     */
    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('status', 'verified');
    }

    /**
     * Scope query to pending payments.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Check if payment was made via bank transfer.
     */
    public function isTransfer(): bool
    {
        return $this->payment_method === 'transfer';
    }

    /**
     * Check if payment was paid offline with cash.
     */
    public function isCash(): bool
    {
        return $this->payment_method === 'cash';
    }

    /**
     * Check if payment is verified.
     */
    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }
}

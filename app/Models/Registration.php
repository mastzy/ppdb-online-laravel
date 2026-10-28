<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Registration extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'registrations';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'reg_code',
        'nik',
        'nisn',
        'full_name',
        'dob',
        'phone_number',
        'wave_name',
        'cluster_id',
        'is_boarding',
        'status',
        'parent_name',
        'parent_phone',
        'parent_job',
        'sibling_nisn',
        'sibling_name',
        'has_sibling_discount',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'dob' => 'date',
            'is_boarding' => 'boolean',
            'has_sibling_discount' => 'boolean',
        ];
    }

    /**
     * The program cluster selected by the registrant.
     */
    public function cluster(): BelongsTo
    {
        return $this->belongsTo(ProgramCluster::class, 'cluster_id');
    }

    /**
     * Payment records associated with this registration.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'reg_id');
    }

    /**
     * The latest payment transaction.
     */
    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class, 'reg_id')->latestOfMany();
    }

    /**
     * Documents uploaded for this registration.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'reg_id');
    }

    /**
     * Diagnostic assessment score for this registration.
     */
    public function diagnosticScore(): HasOne
    {
        return $this->hasOne(DiagnosticScore::class, 'reg_id');
    }

    /**
     * Scope query to find applicant by Registration Code.
     */
    public function scopeByRegCode(Builder $query, string $regCode): Builder
    {
        return $query->where('reg_code', $regCode);
    }

    /**
     * Scope query to find applicant by NIK and Date of Birth (No password login).
     */
    public function scopeByNikAndDob(Builder $query, string $nik, string $dob): Builder
    {
        return $query->where('nik', $nik)->whereDate('dob', $dob);
    }

    /**
     * Check if registration is still in draft state.
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Check if registration is awaiting payment.
     */
    public function isPendingPayment(): bool
    {
        return $this->status === 'pending_payment';
    }

    /**
     * Check if registration payment has been settled.
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Check if registration has been verified by the committee.
     */
    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }

    /**
     * Check if applicant passed the admission.
     */
    public function isPassed(): bool
    {
        return $this->status === 'passed';
    }

    /**
     * Check if applicant was rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}

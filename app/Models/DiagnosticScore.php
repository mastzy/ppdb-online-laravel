<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiagnosticScore extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'diagnostic_scores';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'reg_id',
        'btq_score',
        'tahfidz_juz',
        'literacy_score',
        'notes',
        'tested_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'btq_score' => 'decimal:2',
            'tahfidz_juz' => 'integer',
            'literacy_score' => 'decimal:2',
        ];
    }

    /**
     * The registration this diagnostic score belongs to.
     */
    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'reg_id');
    }

    /**
     * The teacher/examiner who conducted this diagnostic test.
     */
    public function tester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tested_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'phone',
        'city',
        'email',
        'preferred_time_to_call',
        'interested_in',
        'source',
        'status',
        'remarks',
        'last_contact_at',
        'whatsapp_sent_at',
        'sms_sent_at',
        'email_sent_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'remarks' => 'array',
            'last_contact_at' => 'datetime',
            'whatsapp_sent_at' => 'datetime',
            'sms_sent_at' => 'datetime',
            'email_sent_at' => 'datetime',
        ];
    }

    /**
     * Lead messages, communications, and notes.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(LeadMessage::class)->orderBy('sent_at', 'desc');
    }

    public function getParentNameAttribute(): ?string
    {
        return $this->attributes['parent_name'] ?? $this->attributes['name'] ?? null;
    }

    public function getMobileNumberAttribute(): ?string
    {
        return $this->attributes['mobile_number'] ?? $this->attributes['phone'] ?? null;
    }

    public function getGradeApplyingForAttribute(): ?string
    {
        return $this->attributes['grade_applying_for'] ?? $this->attributes['interested_in'] ?? null;
    }

    /**
     * Add a structured note to remarks.
     */
    public function addNote(string $text, ?string $author = 'Admissions Team', ?string $type = 'note', ?string $date = null): void
    {
        $notes = is_array($this->remarks) ? $this->remarks : [];
        $notes[] = [
            'text' => trim($text),
            'date' => $date ?: now()->format('d M Y, h:i A'),
            'author' => $author ?: 'Admissions Team',
            'type' => $type ?: 'note',
        ];
        $this->remarks = $notes;
        $this->save();
    }
}

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
            'last_contact_at' => 'datetime',
            'whatsapp_sent_at' => 'datetime',
            'sms_sent_at' => 'datetime',
            'email_sent_at' => 'datetime',
        ];
    }

    /**
     * Accessor for remarks: always returns an array of structured notes,
     * even if stored as a plain string, JSON, or null.
     *
     * @param  mixed  $value
     * @return array<int, array<string, mixed>>
     */
    public function getRemarksAttribute($value): array
    {
        if (is_array($value)) {
            $notes = $value;
        } elseif (empty($value)) {
            return [];
        } elseif (is_string($value)) {
            $trimmed = trim($value);
            $decoded = json_decode($trimmed, true);
            if (is_array($decoded)) {
                $notes = $decoded;
            } elseif ($trimmed !== '') {
                return [[
                    'text' => trim($trimmed, '"'),
                    'author' => 'Admissions Team',
                    'date' => $this->created_at ? $this->created_at->format('d M Y, h:i A') : '',
                    'type' => 'note',
                ]];
            } else {
                return [];
            }
        } else {
            return [];
        }

        // Normalize each item so it's always an array with expected keys
        $normalized = [];
        foreach ($notes as $item) {
            if (is_array($item)) {
                $normalized[] = [
                    'text' => (string) ($item['text'] ?? ($item['note'] ?? '')),
                    'author' => (string) ($item['author'] ?? 'Admissions Team'),
                    'date' => (string) ($item['date'] ?? ($this->created_at ? $this->created_at->format('d M Y, h:i A') : '')),
                    'type' => (string) ($item['type'] ?? 'note'),
                ];
            } elseif (is_string($item) && trim($item) !== '') {
                $normalized[] = [
                    'text' => trim($item),
                    'author' => 'Admissions Team',
                    'date' => $this->created_at ? $this->created_at->format('d M Y, h:i A') : '',
                    'type' => 'note',
                ];
            }
        }

        return $normalized;
    }

    /**
     * Mutator for remarks: stores as JSON string.
     *
     * @param  mixed  $value
     */
    public function setRemarksAttribute($value): void
    {
        if (is_array($value)) {
            $this->attributes['remarks'] = json_encode(array_values($value));
        } elseif (is_string($value)) {
            $trimmed = trim($value);
            if ($trimmed === '') {
                $this->attributes['remarks'] = null;

                return;
            }
            $decoded = json_decode($trimmed, true);
            if (is_array($decoded)) {
                $this->attributes['remarks'] = json_encode(array_values($decoded));
            } else {
                $this->attributes['remarks'] = json_encode([[
                    'text' => $trimmed,
                    'author' => 'Admissions Team',
                    'date' => now()->format('d M Y, h:i A'),
                    'type' => 'note',
                ]]);
            }
        } else {
            $this->attributes['remarks'] = null;
        }
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

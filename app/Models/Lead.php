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
     * Lead messages, communications, and notes.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(LeadMessage::class)->orderBy('sent_at', 'desc');
    }
}

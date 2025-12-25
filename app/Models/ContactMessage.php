<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
        'ip_address',
        'user_agent',
    ];

    /**
     * Scopr for Status filtering
     */
    public function scopeStatus(Builder $query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Search by name, email, subject or message
     * @param Builder $query
     * @param mixed $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, $search)
    {
        $searchTerm = '%' . $search . '%';

        return $query->where(function ($q) use ($search, $searchTerm) {
            $q->where('name', 'like', $searchTerm)
                ->orWhere('email', 'like', $searchTerm)
                ->orWhere('subject', 'like', $searchTerm)
                ->orWhere('message', 'like', $searchTerm);
        });
    }
}

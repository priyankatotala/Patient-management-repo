<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\PatientAccountCreated;
use Illuminate\Notifications\Notifiable;

class Patient extends Model
{
    use HasFactory;
    use Notifiable;

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
    ];
}

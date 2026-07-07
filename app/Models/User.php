<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\LoginLog;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// izinn, ini aku nonaktifkan ya karena bukan format Laravel standar, jadi bikin auth loginnya eror
// #[Fillable(['name', 'email', 'password'])]
// #[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // udah aku ganti jadi seperti ini
    protected $fillable = [
        'name',
        'email',
        'profile_photo',
        'language',
        'theme',
        'email_notification',
        'leave_notification',
        'payroll_notification',
    ];
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function loginLogs()
    {
        return $this->hasMany(LoginLog::class);
    }
    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

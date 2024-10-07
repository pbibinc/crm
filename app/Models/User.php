<?php

namespace App\Models;

use App\Events\ReassignedAppointedLead;
use App\Notifications\AssignAppointedLead;
use App\Notifications\AssignPolicyForRenewalNotification;
use App\Notifications\GeneralNotification;
use App\Notifications\LeadNotesNotification;
use App\Notifications\ReassignAppointedLeadNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //notification function
    public function sendAppointedNotification($user, $productCount)
    {
        Notification::send($user, new AssignAppointedLead($productCount));
    }

    public function sendReassignAppointedNotification($user, $productCount, $newOwnerName)
    {
        Notification::send($user, new ReassignAppointedLeadNotification($productCount, $newOwnerName));
    }

    public function sendNoteNotification($user, $noteTitle, $senderUserProfileId, $noteDescription, $leadId)
    {
        Notification::send($user, new LeadNotesNotification($noteTitle, $senderUserProfileId, $noteDescription, $leadId));
    }

    public function sendRenewalPolicyNotification($user, $policy, $count)
    {
        Notification::send($user, new AssignPolicyForRenewalNotification($policy, $count));
    }

    public function sendGeneralNotifcation($user, $link, $notifyBy, $title, $description)
    {
        Notification::send($user, new GeneralNotification($link, $notifyBy, $title, $description));
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole($name): bool
    {
        return $this->role()->where('name', $name)->exists();
    }

    public  function userProfile()
    {
        return $this->hasOne(UserProfile::class);

    }
}

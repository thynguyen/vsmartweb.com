<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordMember;
use App\Notifications\VerifyEmailMember;
use Vsw\Permissions\Models\Permissions;
use Modules\ServicePack\Entities\SVPReg;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cache,Avatar,ThemesFunc;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    protected $table = 'vsw_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'in_group','username', 'email','email_verified_at', 'provider', 'provider_id', 'password','firstname','lastname','gender','avatar','birthday','mobile','address','website','facebook','skype','twitter','youtube','question','answer','about',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $appends = [
        'avatar_link',
        'gender_user'
    ];
    /**
     * Sends the password reset notification.
     *
     * @param  string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordMember($token));
    }
    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailMember);
    }

    public function hasVerifiedEmailmember()
    {
        return !is_null($this->email_verified_at);
    }

    public function markEmailAsVerifiedMember()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }
    public function permissions(){
        return $this->hasOne(Permissions::class,'id','in_group');
    }
    public function getFullNameAttribute() {
        if ($this->firstname && $this->lastname) {
            if(app()->getLocale() == 'vi'){
                return ucfirst($this->lastname).' '.ucfirst($this->firstname);
            } else {
                return ucfirst($this->firstname) . ' ' . ucfirst($this->lastname);
            }
        } else {
            return $this->username;
        }
        
        
    }
    public function getAvatarLinkAttribute()
    {
        if ($this->avatar) {
            return ThemesFunc::GetThumb($this->avatar,50);
        } else {
            return Avatar::create($this->username)->toBase64();
        }
    }
    public function getGenderUserAttribute()
    {
        if ($this->gender=='M') {
            return $this->gender = trans('Langcore::global.Male');
        } elseif ($this->gender=='F') {
            return $this->gender = trans('Langcore::global.Female');
        } else {
            return $this->gender = 'N/A';
        }
    }
    public function svpreg(){
        return $this->hasOne(SVPReg::class,'userid');
    }
}
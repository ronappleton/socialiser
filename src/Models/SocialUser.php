<?php
/**
 * Created by PhpStorm.
 * User: ron
 * Date: 12/4/17
 * Time: 3:42 PM
 */

namespace RonAppleton\Socialiser\Models;

use Illuminate\Database\Eloquent\Model;

class SocialUser extends Model
{
    protected $table = 'socialiser_provider_users';

    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
        'name',
        'nickname',
        'email',
        'avatar',
        'token',
        'refresh_token',
        'expires_in',
    ];

    public function user()
    {
        if (userModel()) {
            $model = userModel();
            return $this->belongsTo($model);
        }
        return null;
    }
}
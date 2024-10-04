<?php

namespace App\Models;

use App\Helpers\DsMail;
use Ds\Foundations\Config\Env;
use Ds\Foundations\Connection\Models\DsModel;

/**
 * User Model
 */
class User extends DsModel
{
    public $table = 'users';
    public $fillable = [
        'id',
        'fullname',
        'username',
        'email',
        'password',
        'phone',
        'birth',
        'birth_place',
        'gender',
        'bio',
        'avatar',
        'updated_at',
        'verified_at',
    ];
    public $hidden = [
        'password',
    ];

    public static function register($data)
    {
        try {
            $data = (array) $data;
            $data['password'] = md5($data['password'] . Env::get('SECRET_KEY'));
            $data['id'] = self::save($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function emailVerification($verifKey)
    {
        $verifData = EmailVerifications::findBy('verif_key', $verifKey);
        if ($verifData != null) {
            $user = User::find($verifData->user_id);
            $user->verified_at = date('Y-m-d h:i:s');
            User::save($user);
            return true;
        } else {
            return false;
        }
    }

    public function authenticate($data)
    {
        $user = $this->select('users')
            ->where('username', $data->username)
            ->where('password', md5($data->password . Env::get('SECRET_KEY')))
            ->row();
        if ($user) {
            $this->hide($user);
            if ($user->verified_at != null || Env::get('STATUS') == 'development') {
                session(['user' => serialize($user)]);
                return $user;
            } else {
                set_flash('fail', 'Check your email for account verification!');
                return null;
            }
            return $user;
        } else {
            set_flash('fail', 'Username or password not found!');
        }
        return null;
    }

    private function hide(&$user)
    {
        if ($this->hidden != null) {
            foreach ($this->hidden as $value) {
                unset($user->{$value});
            }
        }
    }

    public static function auth($input)
    {
        $input = (object) $input;
        $className = get_called_class();
        $obj = new $className();
        $user = $obj->authenticate($input);
        if ($user === null) {
            return false;
        }
        return true;
    }
}

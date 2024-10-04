<?php
namespace App\Models;

use Ds\Foundations\Connection\Models\DsModel;

/**
 * EmailVerifications Model
 */
class EmailVerifications extends DsModel
{
    public $table = 'email_verifications';

    public $fillable = [
        'user_id','email', 'verif_key'
    ];
}
<?php namespace App\models;
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/2/2018
 * Time: 2:01 PM
 */

use Illuminate\Database\Eloquent\Model;

class Particular extends Model
{
    protected $table= 'x_particulars';
    public function debitAccount()
    {
        return $this->belongsTo("App\models\Account", "debitaccount_id", "id");
    }

    public function creditAccount()
    {
        return $this->belongsTo("App\models\Account", "creditaccount_id", "id");
    }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class LoanRefinanceHistory extends Model
{
    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [];

    protected $table = 'loan_refinance_history';

    public function loanaccount()
    {
        return $this->belongsTo('Loanaccount');
    }
}

<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Journal extends Model
{
    protected $table='x_journals';
    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [];

    public function particular()
    {
        return $this->belongsTo("Particular", "particulars_id", "id");
    }

    public function branch()
    {

        return $this->belongsTo('App\models\Branch');
    }

    public function account()
    {

        return $this->belongsTo('App\models\Account');
    }

    /**EmployeeNonTaxableController
     * function fo journal entries
     */

    public function journal_entry($data)
    {
//        dd($data);
        $trans_no = $this->getTransactionNumber();
        // function for crediting
        $this->creditAccount($data, $trans_no);
        // function for crediting
        $this->debitAccount($data, $trans_no);

        // Insert narration
        $confirm = DB::table('x_narration')->where('trans_no', '=', $trans_no)->count();
        if ($confirm <= 0) {
            DB::table('x_narration')->insert(array(
                'trans_no' => $trans_no,
                'member_id' => 1
            ));
        }

    }

    public function getTransactionNumber()
    {
        $date = date('Y-m-d H:m:s');
        $trans_no = strtotime($date);
        return $trans_no;
    }


    public function creditAccount($data, $trans_no)
    {
//        dd($data);
        $journal = new Journal;
        $account = Account::findOrFail($data['credit_account']);
        $journal->account()->associate($account);

        $journal->date = $data['date'];
        $journal->trans_no = $trans_no;
        $journal->initiated_by = $data['initiated_by'];
        $journal->amount = $data['amount'];
        $journal->type = 'credit';
//        $journal->particulars_id = $data['particulars_id'];
        $journal->description = $data['description'];
        $journal->save();
    }


    public function debitAccount($data, $trans_no)
    {
        $journal = new Journal;
        $account = Account::findOrFail($data['debit_account']);
        $journal->account()->associate($account);

        $journal->date = $data['date'];
        $journal->trans_no = $trans_no;
        $journal->initiated_by = $data['initiated_by'];
        $journal->amount = $data['amount'];
        $journal->type = 'debit';
//        $journal->particulars_id = $data['particulars_id'];
        $journal->description = $data['description'];
        $journal->save();
    }


}

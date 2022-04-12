<?php
$period = Input::get('period')
           DB::table('transact')->where('financial_month_year', '=', $_POST['period'])->delete();
           DB::table('transact_allowances')->where('financial_month_year', '=', $period)->delete();
           DB::table('transact_deductions')->where('financial_month_year', '=', $period)->delete();
           DB::table('transact_earnings')->where('financial_month_year', '=', $period)->delete();
        ?>
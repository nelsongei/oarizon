<?php
$period = Input::get('period');
           DB::table('transact_advances')->where('financial_month_year', '=', $period)->delete();
        ?>
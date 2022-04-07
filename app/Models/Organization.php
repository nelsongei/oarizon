<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Organization extends Model
{
    protected $table = 'x_organizations';
    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [];

    public function encode($string)
    {


        $keycode = 7;


        //upper case everything
        $string = strtoupper($string);


        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "P", $string);

        // alphabetic keys
        $alphabets = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $alphabets = str_split($alphabets);


        // organization name characters
        $chars = str_split($string);


        // store the codes
        $code = array();

        foreach ($chars as $char) {

            // find and return the coresspomding number from the alphabet
            $key = array_search($char, $alphabets);

            // add the key value to the key code value
            $codeval = $key + $keycode;


            if ($codeval > 25) {

                $co = $codeval - 25;
                $code[] = $alphabets[$co];

            } else {

                $code[] = $alphabets[$codeval];
            }


        }


        $code = implode('', $code);


        $result = substr($code, 0, 4);


        // encode PAYE

        $encoded = strtoupper($this->unique_id(3)) . '' . $result . '' . strtoupper($this->unique_id(3));

        return $encoded;

    }
    public static function getUserOrganization()
    {

        $organization_id = Auth::user()->organization_id;

        $organization = Organization::find($organization_id);

        return $organization;
    }

    public function decode_annual_subkey($string, $keycode)
    {

        //$splitstring = array_pad(explode('-', $string),2);
        $splitstring = explode('-', $string);
        $first_part = substr($splitstring[0], 0, 3);
        $last_part = substr($splitstring[0], 7, 3);


        //upper case everything
        $string = strtoupper(substr($splitstring[0], 0, 4));

        // alphabetic keys
        $alphanumerics = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $alphanumerics = str_split($alphanumerics);

        // Expiry date  characters
        $datvalues = str_split($splitstring[1]);

        // store the codes
        $exp_code = array();

        foreach ($datvalues as $datev) {

            // find and return the coresspomding number from the alphabet
            $key = array_search($datev, $alphanumerics);

            // add the key value to the key code value
            $codevalues = $key - $keycode;


            if ($codevalues < 0) {

                $co = $codevalues + 35;
                $exp_code[] = $alphanumerics[$co];

            } else {

                $exp_code[] = $alphanumerics[$codevalues];
            }

        }

        $exp_code = implode('', $exp_code);

        return $exp_code;
    }

    public function decode($string, $keycode)
    {

        $first_part = substr($string, 0, 3);
        $last_part = substr($string, 7, 3);

        //upper case everything
        $string = strtoupper(substr($string, 0, 4));

        // alphabetic keys
        $alphabets = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $alphabets = str_split($alphabets);


        // organization name characters
        $chars = str_split($string);

        // store the codes
        $code = array();


        foreach ($chars as $char) {

            // find and return the coresspomding number from the alphabet
            $key = array_search($char, $alphabets);

            // add the key value to the key code value
            $codeval = $key - $keycode;


            if ($codeval < 0) {

                $co = $codeval + 25;
                $code[] = $alphabets[$co];

            } else {

                $code[] = $alphabets[$codeval];
            }
        }
        $code = implode('', $code);

        return $code;
    }

    public function unique_id($l)
    {
        return substr(md5(uniqid(mt_rand(), true)), 0, $l);
    }

    public function license_key_generator($license_code)
    {

        //keycode
        $keycode = 7;

        //get the name part
        $org_name = substr($license_code, 3, 4);
        $first_part = substr($license_code, 0, 3);
        $last_part = substr($license_code, 7, 3);


        //convert the name to its equivalent numbers

        // alphabetic keys
        $alphabets = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $alphabets = str_split($alphabets);

        // organization name characters
        $chars = str_split($org_name);

        // store the codes
        $license_key = array();

        foreach ($chars as $char) {

            // find and return the coresponding number from the alphabet
            $key = array_search($char, $alphabets);

            // add the key value to the key code value
            $codeval = $key - $keycode;


            if ($codeval < 0) {

                $co = $codeval + 25;
                $license_key[] = $alphabets[$co];

            } else {

                $license_key[] = $alphabets[$codeval];
            }


        }

        $license_key = implode('', $license_key);

        //encode license_name with a different keycode
        $chars = str_split($license_key);

        $license_key = array();
        $keycode = 5;

        foreach ($chars as $char) {

            // find and return the corresspomding number from the alphabet
            $key = array_search($char, $alphabets);

            // add the key value to the key code value
            $codeval = $key + $keycode;

            if ($codeval > 25) {
                $co = $codeval - 25;
                $license_key[] = $alphabets[$co];

            } else {
                $license_key[] = $alphabets[$codeval];
            }


        }

        $license_key = implode('', $license_key);

        $license_key = $license_key . '' . $last_part . '' . $first_part;

        return $license_key;
    }

    public function annual_key_validator($license_key, $license_code, $org_name)
    {

        $organization = Organization::find(1);
        $installationdate = date('Y-m-d', strtotime($organization->installationdate));
        // get the necessary parts
        $license_k = explode('-', $license_key);
        $license_code = substr($license_code, 3, 4);
        $license_kk = substr($license_k[0], 0, 4);
        $org_name = strtoupper(substr($org_name, 0, 4));

        $license_code_name = $this->decode($license_code, '7');

        if ($license_code_name == $org_name) {


            $license_key_name = $this->decode($license_kk, '5');
            $annual_key_name = $this->decode_annual_subkey($license_key, '5');

            $year = substr($annual_key_name, 0, 4);
            $month = substr($annual_key_name, 4, 2);
            $day = substr($annual_key_name, 6, 2);

            $date = date('Y-m-d', strtotime($year . '-' . $month . '-' . $day));
            $todaydate = date('Y-m-d');
            $todaydate1 = strtotime($todaydate);
            $date1 = strtotime($date);
            //&&($date1>=$todaydate1)

            if (($license_key_name == $license_code_name) && ($date1 >= $todaydate1)) {

                return true;
            } else {

                return false;
            }
        } else {
            return false;
        }
    }

    public function license_key_validator($license_key, $license_code, $org_name)
    {
        // get the necessary parts
        $license_code = substr($license_code, 3, 4);
        $license_key = substr($license_key, 0, 4);
        $org_name = strtoupper(substr($org_name, 0, 4));

        $license_code_name = $this->decode($license_code, '7');

        if ($license_code_name == $org_name) {


            $license_key_name = $this->decode($license_key, '5');

            if ($license_key_name == $license_code_name) {

                return true;
            } else {

                return false;
            }
        } else {

            return false;
        }
    }
}

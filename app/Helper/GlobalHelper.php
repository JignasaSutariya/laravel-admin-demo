<?php
namespace App\Helper;

use Auth;
use Illuminate\Support\Facades\DB;
use App\Helper\GlobalHelper;
use DateTime;
use DateInterval;
use DatePeriod;
use App\User;
use App\Notification;
use URL;

class GlobalHelper
{
    /**
     * Developed By : Krunal
     * Date         :
     * Description  : Time ago
     */
    public static function humanTiming($time){
        $time = time() - strtotime($time); // to get the time since that moment
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }
    }

    /**
     * @Method		  :	POST
     * @Params		  :
     * @Modified by	:
     * @Comment    : removeNull
     **/

    public static function removeNull($model){
            foreach ($model->toArray() as $key => $value) {
                $model->{$key} = $value==null ? "" : $value;
            }
            return $model;
    }

    /**
     * Developed By : Ajarudin Gugna
     * Date         :
     * Description  : Get formated date
     */
    public static function getFormattedDate($date)
    {
        if(!empty($date)){
            $date = date_create($date);
            return date_format($date, "d-M-Y");
        }
        else {
            return "";
        }
    }

    /**
     * Developed By : Ajarudin Gugna
     * Date         :
     * Description  : Get user by id
     */
    public static function getUserById($id)
    {
        $user = User::where('id','=',$id)
                    ->first();
        return $user;
    }


    /**
     * Developed By : Krunal
     * Date         : 25-8-17
     * Description  : generateRandomNumber
     */
    public static function generateRandomNumber($length = 10) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

     /**
     * Developed By : Jignasa
     * Date         :
     * Description  : sentence teaser
     * this function will cut the string by how many words you want
     */
    public static function word_teaser($string, $count){
      $original_string = $string;
      $words = explode(' ', $original_string);

      if (count($words) > $count){
       $words = array_slice($words, 0, $count);
       $string = implode(' ', $words);
      }

      return $string.'...';
    }

    /**
     * Developed By : Jignasa
     * Date         :
     * Description  : Get user profile image by id
     */
    public static function getUserImageById($id)
    {
        $user = User::select('profile_image')->where('id','=',$id)->first();
        if($user && $user->profile_image){
          return URL::asset('/resources/uploads/profile').'/'.$user->profile_image;
        }else{
          return URL::asset('/resources/assets/front/images/user.png');
        }
    }

    /**
     * Description  : Use to convert large positive numbers in to short form like 1K+, 100K+, 199K+, 1M+, 10M+, 1B+ etc
     */
    public static function number_format_short( $n ) {

        if ($n >= 0 && $n < 1000) {
    		// 1 - 999
    		$n_format = floor($n);
    		$suffix = '';
    	} else if ($n >= 1000 && $n < 10000) {
    		// 1k-999k
        $n_format = floor($n);
    		$suffix = '';
    	}else if ($n >= 10000 && $n < 1000000) {
    		// 1k-999k
    		$n_format = floor($n / 1000);
    		$suffix = 'K+';
    	} else if ($n >= 1000000 && $n < 1000000000) {
    		// 1m-999m
    		$n_format = floor($n / 1000000);
    		$suffix = 'M+';
    	} else if ($n >= 1000000000 && $n < 1000000000000) {
    		// 1b-999b
    		$n_format = floor($n / 1000000000);
    		$suffix = 'B+';
    	} else if ($n >= 1000000000000) {
    		// 1t+
    		$n_format = floor($n / 1000000000000);
    		$suffix = 'T+';
    	}

    	return !empty($n_format . $suffix) ? $n_format . $suffix : 0;
    }
}

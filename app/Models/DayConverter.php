<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayConverter extends Model
{
    use HasFactory;

    public function ConvertDay($EnglishDay)
    {
    	$IndDay = "";

    	switch ($EnglishDay) {
    		case 'Monday':
    			$IndDay = "Senin";
    			break;
    		case 'Tuesday':
    			$IndDay = "Selasa";
    			break;
    		case 'Wednesday':
    			$IndDay = "Rabu";
    			break;
    		case 'Thursday':
    			$IndDay = "Kamis";
    			break;
    		case 'Friday':
    			$IndDay = "Jumat";
    			break;
    		case 'Saturday':
    			$IndDay = "Sabtu";
    			break;
    		case 'Sunday':
    			$IndDay = "Minggu";
    			break;
    		
    		default:
    			$IndDay = "Minggu";
    			break;
    	}

    	return $IndDay;
    }
}

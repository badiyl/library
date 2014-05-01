<?php
class DateTimer
{
	private $date; 
	private $format;
	
	public function __construct($strTime = '')
	{
		$this->format = 'Y-m-d H:i:s';

		if (empty($strTime)) {
			$strTime = date($this->format);
		}
		$this->date = date($this->format, strtotime($strTime));
		return $this;
	}

	public function setDate ($date)
	{
		$this->date = date($this->format, strtotime($date));
		return $this;
	}

	public function getDate ()
	{
		// return $this->date;
		return date($this->format, strtotime($this->date));
	}

	public function setFormat ($format)
	{
		$this->format = $format;
		return $this;
	}

	public function getFormat ()
	{
		return $this->format;
	}

	public function addYear ($n, $op = '+')
	{
		$date = $this->date;
		$strDate = strtotime($date);
		$format = $this->format;
		$new = date($format, strtotime("{$op}{$n} Years", $strDate));
		$this->date = $new;
		return $this;
	}

	public function addMonth ($n, $op = '+')
	{
		$date = $this->date;
		$strDate = strtotime($date);
		$format = $this->format;
		$new = date($format, strtotime("{$op}{$n} Months", $strDate));
		$this->date = $new;
		return $this;
	}

	public function addWeek ($n, $op = '+')
	{
		$date = $this->date;
		$strDate = strtotime($date);
		$format = $this->format;
		$new = date($format, strtotime("{$op}{$n} Week", $strDate));
		$this->date = $new;
		return $this;
	}

	public function addDay ($n, $op = '+')
	{
		$date = $this->date;
		$strDate = strtotime($date);
		$format = $this->format;
		$new = date($format, strtotime("{$op}{$n} Days", $strDate));
		$this->date = $new;
		return $this;
	}

	public function addHour ($n, $op = '+')
	{
		$date = $this->date;
		$strDate = strtotime($date);
		$format = $this->format;
		$new = date($format, strtotime("{$op}{$n} Hours", $strDate));
		$this->date = $new;
		return $this;
	}

	public function addMinute ($n, $op = '+')
	{
		$date = $this->date;
		$strDate = strtotime($date);
		$format = $this->format;
		$new = date($format, strtotime("{$op}{$n} Minutes", $strDate));
		$this->date = $new;
		return $this;
	}

	public function addSecond ($n, $op = '+')
	{
		$date = $this->date;
		$strDate = strtotime($date);
		$format = $this->format;
		$new = date($format, strtotime("{$op}{$n} Seconds", $strDate));
		$this->date = $new;
		return $this;
	}

	public function addTimes ($n, $op = '+')
	{
		$exp = explode(' ', $n);	//Y4 M3 D1 H3 I6 S30
		$date = new DateTimer($this->date);
		$date->setFormat($this->format)->getDate();
		foreach ($exp as $k => $v) {		
			$type = strtoupper(substr($v, 0, 1));
			$typeValue = substr($v, 1);
			switch ($type) {
				case 'Y':
					$this->date = $date->addYear($typeValue, $op)->getDate();
				break;
				
				case 'M':
					$this->date = $date->addMonth($typeValue, $op)->getDate();
				break;
				
				case 'W':
					$this->date = $date->addWeek($typeValue, $op)->getDate();
				break;
				
				case 'D':
					$this->date = $date->addDay($typeValue, $op)->getDate();
				break;
				
				case 'H':
					$this->date = $date->addHour($typeValue, $op)->getDate();
				break;

				case 'I':
					$this->date = $date->addMinute($typeValue, $op)->getDate();
				break;
				
				
				case 'S':
					$this->date = $date->addSecond($typeValue, $op)->getDate();
				break;
			}
		}
		return $this;
	}

	public function toNumber ()
	{
		return strtotime($this->date);
	}

	public function compareTo ($with)
	{
		$new = new DateTimer($with);
		$newNum = $new->toNumber();
		$curNum = $this->toNumber();
		if ($curNum > $newNum) {
			$cek = 1;
		} else if ($curNum < $newNum) {
			$cek = -1;
		} else if ($curNum == $newNum) {
			$cek = 0;
		} else {
	

			$cek = false;
		}
		return $cek;
	}

	public function rangeToday ()
	{
		$now = new DateTimer(date('Y-m-d H:i:s'));
		$nowNum = $now->toNumber();
		$thisNum = $this->toNumber();
		$selisihNum = $thisNum - $nowNum;
		$secInDay = 3600 * 24;
		$day = $selisihNum / $secInDay;
		return round($day);
	}

	public function range ($with, $set = 'D')
	{
		$new = new DateTimer($with);
		$newNum = $new->toNumber();
		$thisNum = $this->toNumber();
		$selisihNum = $thisNum - $newNum;
		$secInDay = 3600 * 24;
		$secInHour = 3600;
		$set = strtoupper($set);
		switch ($set) {
			case 'D':
				$sec = $secInDay;
				break;
			
			case 'H':
				$sec = $secInHour;
				break;

			case 'Y':
				$sec = $secInDay * 365;
				break;
		}
		$result = $selisihNum / $sec;
		$result = abs($result);
		return round($result);
	}

	public function isOld ($nOld, $at = '')
	{
		$personDate = new DateTimer($this->getDate());
		$personDate->setFormat('Y-m-d');
		if (empty($at)) {
			$at = date('Y-m-d');
		}
		$atObj = new DateTimer($at);
		$atObj->setFormat('Y-m-d')->addYear($nOld, '-');
		$cek = $atObj->compareTo($personDate->getDate());
		return $cek;	//0 = tepat, 1 = benar, -1 = salah
	}

	public function ageIs ()
	{
		//date in mm/dd/yyyy format; or it can be in other formats as well
		$theDate = new DateTimer($this->getDate());
		$theDate->setFormat('m/d/Y');
		//explode the date to get month, day and year
		$birthDate = explode("/", $theDate->getDate());
		//get age from date or birthdate
		$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
		return $age;
	}
}

$date = new DateTimer('30-01-1992');
// echo $date->getDate() . '<br>';
// echo $date->addYear(20, '-')->addHour(10)->getDate();
echo $date->ageIs();



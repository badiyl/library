<?php
class String
{
	private $string;
	private $array;
	
	public function __construct ($str)
	{
		$this->string = $str;
		$this->toArray();
	}

	public function toArray ($delim = ' ')
	{
		$arr = explode($delim, $this->string);
		$this->array = $arr;
		return $this;
	}

	public function toLower ()
	{
		$this->string = strtolower($this->string);
		return $this;
	}

	public function toUpper ()
	{
		$this->string = strtoupper($this->string);
		return $this;
	}

	public function replace ($search, $replace)
	{
		$this->string = str_replace($search, $replace, $this->string);
		return $this;
	}

	public function setString ($new_str)
	{
		$this->string = $new_str;
		return $this;
	}

	public function getString ()
	{
		return $this->string;
	}

	public function length ()
	{
		return strlen($this->string);
	}

	public function wordCount ()
	{
		return str_word_count($this->string);
	}

	public function find ($subString, $insensitive = false)
	{
		$str = $this->string;
		$pattern = "/$subString/";
		if ($insensitive) {
			$str = strtolower($str);
			$pattern = "/" . strtolower($subString) . "/";
		}
		//preg_match
		if (preg_match($pattern, $str) === 1)
			return true;
		else
			return false;
	}

	public function sub ($start, $jum = '')
	{
		if (empty($jum))
			$substr = substr($this->string, $start);
		else
			$substr = substr($this->string, $start, $jum);
		$this->string = $substr;
		return $this;
	}

	public function cutFront ($jum)
	{
		$this->sub($jum);
		return $this;
	}

	public function cutEnd ($jum)
	{
		$this->sub(0, -$jum);
		return $this;
	}

	public function removeSpace ()
	{
		$this->string = trim($this->string);
		return $this;
	}

	public function keepHTML ()
	{
		$this->string = htmlentities($this->string);
		return $this;
	}

	public function escape ()
	{
		$this->string = addslashes($this->string);
		return $this;
	}

	public function unEscape ()
	{
		$this->string = stripslashes($this->string);
		return $this;
	}

	public function clean ()
	{
		global $link;
		$clean = mysqli_real_escape_string($link, $this->string);
		$this->string = $clean;
		return $this;
	}

	public function doEncrypt ()
	{
		$en = base64_encode($this->string);
		$this->string = $en;
		return $this;
	}

	public function doDecrypt ()
	{
		$en = base64_decode($this->string);
		$this->string = $en;
		return $this;
	}

	public function append ($appender)
	{
		$this->string .= $appender;
		return $this;
	}

	public function prepend ($prepender)
	{
		$this->string = $prepender . $this->string;
		return $this;
	}

	public function removeTag ()
	{
		$this->string = strip_tags($this->string);
		return $this;
	}

	public function each ($callback)
	{
		$arr = $this->array;
		if (is_object($callback)) {
			foreach ($arr as $k => $v) {
				$callback($k, $v);
			}
		}
	}

	public function getArray ()
	{
		return $this->array;
	}

}

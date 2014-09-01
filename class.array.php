<?php
class Arrays
{
	private $array;
	private $string;
	public function __construct ($array)
	{
		if (is_array($array)) {
			$this->array = $array;
		} else {
			$this->array = array();
		}
		$this->_serialize();
	}
	
	public function getArray ()
	{
		return $this->array;
	}
	
	public function setArray ($array)
	{
		if (is_array($array)) {
			$this->array = $array;
		} else {
			$this->array = array();
		}
		$this->_serialize();
		return $this;
	}

	public function imploder ($delim = '')
	{
		$arr = $this->getArray();
		foreach ($arr as $k => $v) {
			if (! is_array($v)) {
				$imp = implode($delim, $arr);
				break;
			} else {
				$v2 = new Arrays($v);
				$imp[] = $v2->imploder($delim);
			}
		}
		return $imp;		
	}
	
	public function genURL ()
	{
		$arr = $this->getArray();
		$result = '';
		$first = true;
		foreach ($arr as $k => $v) {
			if (! is_array($v)) {
				if ($first)
					$result .= "$k=$v";
				else
					$result .= "&$k=$v";
			} else {
				$v = new Arrays($v);
				$result[] = $v->genURL();
			}
			$first = false;
		}
			return $result;
	}
	
	public function _serialize ()
	{
		$this->string = serialize($this->getArray());
		return $this;
	}
	
	public function getString ()
	{
		return $this->string;
	}
	
	public function _push ($arr)
	{
		array_push($this->array, $arr);
		return $this;
	}
	
	public function each ($callback)
	{
		foreach ($this->getArray() as $k => $v) {
			if (is_object($callback)) {
				$callback($k, $v);
			}
		}
		return $this;
	}
	
	public function add($arr)
	{
		$thisArray = $this->getArray();
		foreach ($arr as $k => $v) {
			$thisArray[$k] = $v;
		}
		$this->setArray($thisArray);
		return $this;
	}

	public function modif ($fungsi, $callback = '')
	{
		$oriArray = $this->getArray();
		$this->setArray($fungsi);
		if (! empty($callback)) {
			$callback($fungsi, $oriArray);
		}
	}

}
$a = array('nama' => 'abdi', 'phone' => '087137264', 'usia' => 31);

$arr = new Arrays($a);

//$arr->modif(array_diff($arr->getArray(), array('nama' => 'abdi', 'test' => 'TT')));


die();

echo "<pre>".print_r($arr->getArray(),1)."</pre>";
$arr->add(array('status' => 'ganteng', 'alamat' => 'Jogja'))->_push(array(1,2,3,4,5));
echo "<pre>".print_r($arr->getArray(),1)."</pre>";
$a2 = array(
	0 => array(
		'a' => array(
				'd' => '10',
				'e' => '11',
				'f' => '12'
			),
		'b' => array(
				'd' => '13',
				'e' => '14',
				'f' => '15'
			),
		'c' => array(
				'd' => '16',
				'e' => '17',
				'f' => '18'
			),
	),
	1 => array(
		'a' => array(
				'd' => '19',
				'e' => '20',
				'f' => '21'
			),
		'b' => array(
				'd' => '22',
				'e' => '23',
				'f' => '24'
			),
		'c' => array(
				'd' => '25',
				'e' => '26',
				'f' => '27'
			),
	),
	2 =>  array(
		'a' => array(
				'd' => '28',
				'e' => '29',
				'f' => '30'
			),
		'b' => array(
				'd' => '31',
				'e' => '32',
				'f' => '33'
			),
		'c' => array(
				'd' => '34',
				'e' => '35',
				'f' => '36'
			)
	),
	3 => array(
		'a' => 'A',
		'b' => 'B',
		'c' => 'C'
	)
);


$arr = new Arrays($a2);

$arr->each(function ($ey, $val) {
		echo "$ey";
	})
	->setArray($a)
	->each(function ($ey, $val) {
		echo "$ey -> $val <br>";
	});

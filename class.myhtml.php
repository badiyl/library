<?php
class MyHtml {
	private $tagName;
	private $attributes;
	private $stringHtml;
	private $htmlExplode;

	public function __construct ($stringHtml) {
		$this->stringHtml = $stringHtml;

		$stringHtml = str_replace('<', '', $stringHtml);
		$stringHtml = str_replace('>', '', $stringHtml);
		$stringHtml = str_replace('/>', '', $stringHtml);
		$expHtml = explode(' ', $stringHtml);

		$this->htmlExplode = $expHtml;
		$this->tagName = $expHtml[0];
		$this->setAttributes($expHtml);
	}

	public function setAttributes ($expHtml) {
		$resAttr = array();
		foreach ($expHtml as $k => $v) {
			if (search_substring('"', $v) || search_substring("'", $v)) {
				$expAttr = explode('=', $v);
				$attrName = $expAttr[0];
				$attrVal = isset($expAttr[1]) ? $expAttr[1] : '';
				$attrVal = str_replace('"', '', $attrVal);
				$attrVal = str_replace("'", '', $attrVal);
				$resAttr[$attrName] = $attrVal;
			}
		}		
		$this->attributes = $resAttr;
	}

	public function getAttributes () {
		return $this->attributes;
	}

	public function getTagName () {
		return $this->tagName;
	}

	public function getString () {
		return $this->stringHtml;
	}

	public function getAttribute ($name) {
		$attributes = $this->getAttributes();
		return $attributes[$name];
	}
}
<?php

namespace DiaReader;

class AttributesDiaElement
{
	private $attributes;
	public function __construct($data)
	{
		$this->attributes = [];
		foreach ($data->children as $elem)
		{
			if ($elem->name === 'dia:attribute')
			{
				;
			}
		}
	}

	public function __get($name) {
		return $this->attributes[$name];
	}
}


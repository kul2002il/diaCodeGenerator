<?php

namespace DiaReader;

class Layer
{
	protected string $name;
	protected $elements;

	public function __construct(XmlElement $data)
	{
		$this->elements = [];
		$this->name = $data->attributes['name'];
		foreach ($data->children as $elem)
		{
			if ($elem->name === 'dia:object')
			{
				$this->elements = array_merge($this->elements,
					[$elem->attributes['id'] => new Element($elem)]);
			}
		}
	}

	public function __get($name) {
		if(in_array($name, [
			'name',
			'elements',
		]))
		{
			return $this->$name;
		}
		else
		{
			$class = __CLASS__;
			throw new \Exception("Свойство $name класса $class недоступно для чтения или не существует.\n");
		}
	}
}

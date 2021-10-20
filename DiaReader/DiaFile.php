<?php

namespace DiaReader;

/*
 * @property SimpleXMLElement $file
 */
class DiaFile
{
	private $layers;
	private $elements;

	public function __construct($filename = null)
	{
		if ($filename)
		{
			$this->open($filename);
		}
	}

	public function open($filename)
	{
		if (!file_exists($filename))
		{
			throw new \Exception("Файла $filename не существует.");
		}
		$data = XmlElement::open($filename);
		$this->load($data);
	}

	public function load($data)
	{
		$this->layers = [];
		$this->elements = [];
		foreach ($data->children as $elem)
		{
			if($elem->name === 'dia:layer')
			{
				$layer = new Layer($elem);
				$this->layers = array_merge($this->layers,[
					$layer->name => $layer,
				]);
				$this->elements = array_merge($this->elements, $layer->elements);
			}
		}
		print_r($this->elements['O0']);
	}
}

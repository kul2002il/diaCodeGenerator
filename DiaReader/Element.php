<?php

namespace DiaReader;

class Element
{
	private string $type;
	private $connection = [];
	private AttributesDiaElement $attributes;
	
	public function __construct(XmlElement $data)
	{
		$this->type = $data->attributes['type'];
		$this->attributes = new AttributesDiaElement($data);
		$this->connection = [];
		$connections = $data->find('dia:connections');
		if($connections)
		{
			foreach ($connections->children as $value) {
				$this->connection = array_merge($this->connection,
					[$value->attributes['handle'] => $value->attributes['to']]
				);
			}
		}
	}
}


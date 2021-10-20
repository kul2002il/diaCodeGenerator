<?php

namespace DiaReader;

/*
 * @property XmlElement[] $children
 */
class XmlElement {
	public string $name;
	public array $attributes = [];
	public string $content = '';
	public array $children = [];

	public function find(string $name): ?self
	{
		foreach ($this->children as $elem)
		{
			if($elem->name === $name)
			{
				return $elem;
			}
		}
		return null;
	}

	/*
	 * https://www.php.net/manual/ru/function.xml-parse-into-struct.php#66487
	 */
	static public function xml2object($xml): self
	{
		$parser = xml_parser_create();
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		$tags = [];
		xml_parse_into_struct($parser, $xml, $tags);
		xml_parser_free($parser);
		$elements = array(); // the currently filling [child] XmlElement array
		$stack = array();
		foreach ($tags as $tag)
		{
			$index = count($elements);
			if ($tag['type'] == "complete" || $tag['type'] == "open")
			{
				$elements[$index] = new XmlElement();
				$elements[$index]->name = $tag['tag'];
				if(isset($tag['attributes']))
				{
					$elements[$index]->attributes = $tag['attributes'];
				}
				if(isset($tag['value']))
				{
					$elements[$index]->content = $tag['value'];
				}
				if ($tag['type'] == "open")
				{ // push
					$elements[$index]->children = array();
					$stack[count($stack)] = &$elements;
					$elements = &$elements[$index]->children;
				}
			}
			if ($tag['type'] == "close")
			{ // pop
				$elements = &$stack[count($stack) - 1];
				unset($stack[count($stack) - 1]);
			}
		}
		return $elements[0]; // the single top-level element
	}

	static public function open($filename): self
	{
		return self::xml2object(file_get_contents($filename));
	}
};


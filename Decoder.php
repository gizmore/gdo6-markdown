<?php
namespace GDO\Markdown;

use cebe\markdown\GithubMarkdown;

final class Decoder
{
    private $message;
    
    public function __construct($message)
    {
        $this->message = $message;
    }
    
    public function decoded()
    {
    	static $parser;
    	if ($parser === null)
    	{
    		$parser = new GithubMarkdown();
    	}
        return $parser->parse($this->message);
    }
    
}

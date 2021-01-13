<?php
namespace GDO\Markdown;

final class Decoder
{
    private $message;
    
    public function __construct($message)
    {
        $this->message = $message;
    }
    
    public function decoded()
    {
        return $this->message; # @TODO: Implement a markdown decoder.
    }
    
}

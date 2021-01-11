<?php
namespace GDO\Markdown\Test;

use GDO\Tests\TestCase;
use GDO\Markdown\Decoder;
use function PHPUnit\Framework\assertEquals;

final class MarkdownTest extends TestCase
{
    public function testHTMLEscape()
    {
        $input = '<hi>';
        $msg = new Decoder($input);
        assertEquals('&lt;hi&gt;', $msg->decoded());
    }
    
}

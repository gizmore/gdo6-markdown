<?php
namespace GDO\Markdown;

use GDO\Core\GDO_Module;
use GDO\UI\GDT_Message;

final class Module_Markdown extends GDO_Module
{
    public function onInit()
    {
        GDT_Message::$DECODER = [self::class, 'decode'];
    }

    public static function decode($input)
    {
        return (new Decoder($input))->decoded();
    }
    
}

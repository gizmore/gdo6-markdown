<?php
namespace GDO\Markdown;

use GDO\Core\GDO_Module;
use GDO\Core\GDT_Array;
use GDO\UI\GDT_Message;
use GDO\Util\Strings;
use GDO\Javascript\Module_Javascript;

/**
 * Markdown editor for gdo6.
 * @author gizmore
 * @version 6.10.2
 * @since 6.10.1
 */
final class Module_Markdown extends GDO_Module
{
    public function getDependencies() { return ['JQuery']; }
    
    public function onInit()
    {
        GDT_Message::$DECODER = [self::class, 'decode'];
        GDT_Message::$EDITOR_NAME = 'Markdown';
        spl_autoload_register([$this, 'autoloadMarkdown']);
    }

    public static function decode($input)
    {
        $html = (new Decoder($input))->decoded();
        return GDT_Message::getPurifier()->purify($html);
    }
    
    public function autoloadMarkdown($class)
    {
        if (Strings::startsWith($class, 'cebe'))
        {
            $path = str_replace('\\', '/', $class);
            $path = $this->filePath('markdown/'.$class);
            require_once $path;
        }
    }
    
    public function onIncludeScripts()
    {
        $min = Module_Javascript::instance()->jsMinAppend();
        $this->addBowerJavascript("editor.md/editormd{$min}.js");
        $this->addJavascript('js/gdo6-markdown.js');
    }
    
    public function hookIgnoreDocsFiles(GDT_Array $ignore)
    {
        $ignore->data[] = 'GDO/Markdown/markdown/**/*';
    }
    
}

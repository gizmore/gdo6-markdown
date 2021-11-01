<?php
namespace GDO\Markdown;

use GDO\Core\GDO_Module;
use GDO\Core\GDT_Array;
use GDO\UI\GDT_Message;
use GDO\Util\Strings;
use GDO\Javascript\Module_Javascript;
use GDO\DB\GDT_Checkbox;
use GDO\Language\Trans;

/**
 * Markdown editor for gdo6.
 * Uses markdown from 
 * 
 * @author gizmore
 * @version 6.10.6
 * @since 6.10.1
 */
final class Module_Markdown extends GDO_Module
{
    public function getDependencies()
    {
        return [
            'JQuery',
            'FontAwesome',
        ];
    }
    
    public function getModuleLicenseFilenames()
    {
        return [
            'markdown/LICENSE',
            'bower_components/editor.md/LICENSE',
            'bower_components/editor.md/lib/codemirror/LICENSE',
            'LICENSE',
        ];
    }
    
    public function getConfig()
    {
        return [
            GDT_Checkbox::make('markdown_decoder')->initial('1'),
            GDT_Checkbox::make('markdown_js_editor')->initial('1'),
        ];
    }
    public function cfgDecoder() { return $this->getConfigVar('markdown_decoder'); }
    public function cfgJSEditor() { return $this->getConfigVar('markdown_js_editor'); }
    
    public function onInit()
    {
        if ($this->cfgDecoder())
        {
            GDT_Message::$DECODERS['Markdown'] =
            GDT_Message::$DECODER = [self::class, 'decode'];
            GDT_Message::$EDITOR_NAME = 'Markdown';
            spl_autoload_register([$this, 'autoloadMarkdown']);
        }
    }

    public static function decode($input)
    {
        $html = (new Decoder($input))->decoded();
        return GDT_Message::getPurifier()->purify($html);
    }
    
    public function autoloadMarkdown($class)
    {
        if (Strings::startsWith($class, 'cebe\\markdown\\'))
        {
            $class = Strings::substrFrom($class, 'cebe\\markdown\\');
            $class = str_replace('\\', '/', $class) . '.php';
            $class = $this->filePath('markdown/'.$class);
            require_once $class;
        }
    }
    
    public function onIncludeScripts()
    {
        if ($this->cfgJSEditor())
        {
            $min = Module_Javascript::instance()->jsMinAppend();
            $this->addBowerJS("editor.md/editormd{$min}.js");
            $this->addJS('js/gdo6-markdown.js');
        }
        $this->addBowerCSS("editor.md/css/editormd{$min}.css");
        $this->addCSS('css/gdo6-markdown.css');
        
        # Load language pack
        switch (Trans::$ISO)
        {
            case 'de':
                $this->addJS('js/editor.md_de.js');
                break;
            default:
                $this->addBowerJS("editor.md/languages/en.js");
                break;
        }
    }
    
    public function hookIgnoreDocsFiles(GDT_Array $ignore)
    {
        $ignore->data[] = 'GDO/Markdown/markdown/**/*';
    }
    
}

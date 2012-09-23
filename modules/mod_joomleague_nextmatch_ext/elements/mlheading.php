<?php

class JElementMLHeading extends JElement
{

    var	$_name = 'mlheading';
 
    function fetchTooltip($label, $description, &$node, $control_name, $name)
    {
        return '&nbsp;';
    }
 
    function fetchElement($name, $value, &$node, $control_name)
    {
        if ($node->attributes('label') OR $node->attributes('description'))
        {
            $txt = ($node->attributes('anchor')) ? '<span id="'.$node->attributes('anchor').'">&nbsp;</span>' : '';
            if ($node->attributes('label')) { $txt .= '<div style="color:#fff;background-color: grey; padding: 0.2em;"><b>'.JText::_($node->attributes('label')).'</b></div>';}
            if ($node->attributes('description')) { $txt .= JText::_($node->attributes('description'));}
            $txt .=  ($node->attributes('anchor')) ? '<br /><span><a href="javascript:void(0)" onclick="scrollToPosition(\'jlmlglobals\');return false;">&#8593;&#8593;&#8593;</a></span>' : '';
            return $txt.'';
        }

        else
        {

            return '<hr />';
        }
    }//function
 
}//class 
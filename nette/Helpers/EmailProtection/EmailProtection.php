<?php
/*
 * Smarty plugin fixed for nette (helper)
 * 
 * DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 * Version 2, December 2004
 * 
 * Copyright (C) 2011 Milan Felix Sulc <rkfelix@gmail.com>
 * 
 * Everyone is permitted to copy and distribute verbatim or modified
 * copies of this license document, and changing it is allowed as long
 * as the name is changed.
 * 
 * DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 * TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 * 
 * 0. You just DO WHAT THE FUCK YOU WANT TO.
 * 
 */

class EmailProtection
{

    /**
     * Smarty {mailto} function plugin
     * @link http://www.smarty.net/manual/en/language.function.mailto.php {mailto}
     *          (Smarty online manual)
     * @version 1.2
     * @author Monte Ohrt <monte at ohrt dot com>
     * @author credits to Jason Sweat (added cc, bcc and subject functionality)
     */

    public static function helper($email, $encoding = 'none', $text = NULL)
    {
        $address = $email;
        $address_text = (is_null($text) ? $address : $text);

        switch ($encoding) {

            // FIXME: (rodneyrehm) document.write() excues me what? 1998 has passed!
            case 'javascript':
                $string = 'document.write(\'<a href="mailto:' . $address . '">' . $address_text . '</a>\');';

                $js_encode = '';
                for ($x = 0, $_length = strlen($string); $x < $_length; $x++) {
                    $js_encode .= '%' . bin2hex($string[$x]);
                }

                return '<script type="text/javascript">eval(unescape(\'' . $js_encode . '\'))</script>';
                break;

            /* smarty javascript charcode */
            case 'javascript_charcode':
                $string = '<a href="mailto:' . $address . '">' . $address_text . '</a>';

                for ($x = 0, $y = strlen($string); $x < $y; $x++) {
                    $ord[] = ord($string[$x]);
                }

                $_ret = "<script type=\"text/javascript\" language=\"javascript\">\n"
                    . "{document.write(String.fromCharCode("
                    . implode(',', $ord)
                    . "))"
                    . "}\n"
                    . "</script>\n";

                return $_ret;
                break;

            /* smarty hex encoding */
            case 'hex':
                preg_match('!^(.*)(\?.*)$!', $address, $match);
                if (!empty($match[2])) {
                    trigger_error("mailto: hex encoding does not work with extra attributes. Try javascript.", E_USER_WARNING);
                    return;
                }
                $address_encode = '';
                for ($x = 0, $_length = strlen($address); $x < $_length; $x++) {
                    if (preg_match('!\w!' . 'u', $address[$x])) {
                        $address_encode .= '%' . bin2hex($address[$x]);
                    } else {
                        $address_encode .= $address[$x];
                    }
                }

                $mailto = "&#109;&#97;&#105;&#108;&#116;&#111;&#58;";
                return '<a href="' . $mailto . $address_encode . '">' . $address_text . '</a>';
                break;

            /* drupal protection */
            case 'drupal':
                $address = str_replace('@', '[at]', $address);
                return '<a href="mailto:' . $address . '">' . $address . '</a>';
                break;

            /* texy protection */
            case 'texy':
                $address = str_replace('@', '<!-- ANTISPAM -->&#64;<!-- /ANTISPAM -->', $address);
                return '<a href="mailto:' . $address . '">' . $address . '</a>';
                break;

            /* no encoding */
            default:
                return '<a href="mailto:' . $address . '">' . $address_text . '</a>';
                break;
        }
    }

}

<?php
/**
 * Copyright (c) 2012-2014 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace NettePlugins\Latte\Helpers\Email;

/**
 * Smarty plugin fixed for nette (helper)
 *
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 1.3
 */
final class EmailHelper
{

    /**
     * Smarty {mailto} function plugin
     *
     * @link     http://www.smarty.net/manual/en/language.function.mailto.php {mailto}
     *           (Smarty online manual)
     * @version  1.2
     * @author   Monte Ohrt <monte at ohrt dot com>
     * @author   credits to Jason Sweat (added cc, bcc and subject functionality)
     *
     * @param string $address
     * @param string $encode [optional]
     * @param string $text [optional]
     *
     * @return string
     */
    public static function mailto($address, $encode = NULL, $text = NULL)
    {
        $text = (is_null($text) ? $address : $text);
        $extra = NULL;

        // FIXME: (rodneyrehm) document.write() excues me what? 1998 has passed!
        if ($encode == 'javascript') {
            $string = 'document.write(\'<a href="mailto:' . $address . '" ' . $extra . '>' . $text . '</a>\');';

            $js_encode = '';
            for ($x = 0, $_length = strlen($string); $x < $_length; $x++) {
                $js_encode .= '%' . bin2hex($string[$x]);
            }

            return '<script type="text/javascript">eval(unescape(\'' . $js_encode . '\'))</script>';
        } elseif ($encode == 'javascript_charcode') {
            $string = '<a href="mailto:' . $address . '" ' . $extra . '>' . $text . '</a>';

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
        } elseif ($encode == 'hex') {
            preg_match('!^(.*)(\?.*)$!', $address, $match);
            if (!empty($match[2])) {
                trigger_error("mailto: hex encoding does not work with extra attributes. Try javascript.", E_USER_WARNING);

                return;
            }
            $address_encode = '';
            for ($x = 0, $_length = strlen($address); $x < $_length; $x++) {
                if (preg_match('!\w!u', $address[$x])) {
                    $address_encode .= '%' . bin2hex($address[$x]);
                } else {
                    $address_encode .= $address[$x];
                }
            }
            $text_encode = '';
            for ($x = 0, $_length = strlen($text); $x < $_length; $x++) {
                $text_encode .= '&#x' . bin2hex($text[$x]) . ';';
            }

            $mailto = "&#109;&#97;&#105;&#108;&#116;&#111;&#58;";

            return '<a href="' . $mailto . $address_encode . '" ' . $extra . '>' . $text_encode . '</a>';
        } else if ($encode == 'drupal') {
            $address = str_replace('@', '[at]', $address);

            return '<a href="mailto:' . $address . '">' . $address . '</a>';
        } else if ($encode == 'texy') {
            $address = str_replace('@', '<!-- ANTISPAM -->&#64;<!-- /ANTISPAM -->', $address);

            return '<a href="mailto:' . $address . '">' . $address . '</a>';
        } else {
            // no encoding
            return '<a href="mailto:' . $address . '" ' . $extra . '>' . $text . '</a>';
        }
    }

}

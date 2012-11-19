<?php
/**
 * Copyright (c) 2012 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace Nette\Forms\Controls;

use \Nette\Utils\Strings;
use \Nette\Forms\Container;

/**
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 1.0
 */
class MoneyControl extends TextInput
{
    /** replacement for &nbsp; */
    const NON_BREAKING_SPACE = ' ';

    /** @var array */
    public $filtersIn = array();

    /** @var array */
    public $filtersOut = array();

    /** @var string */
    private $postfix = '';

    /** @var string */
    private $prefix = '';

    /** @var int */
    private $max_decimals = 4;

    /** @var array */
    private $decimals_count = array(0, 2, 3, 4);

    /** @var string */
    private $decimals_separator = ',';

    /** @var string */
    private $thousands_separator = ' ';

    /** @var bool */
    private $removeTralingZeros = true;

    /** @var bool */
    private $removeLeadingZeros = true;

    /**
     * @param string|null $label
     */
    public function __construct($label = NULL)
    {
        parent::__construct($label);
        $this->filtersOut[] = $this->sanitize;
        $this->filtersOut[] = $this->unformat;
        $this->filtersIn[] = $this->format;
        $this->value = 0;
    }

    /**
     * Returns control's value.
     * @return string
     * @override
     */
    public function getValue()
    {
        $value = parent::getValue();
        foreach ($this->filtersOut as $filter) {
            $value = $filter($value);
        }
        return $value;
    }

    /**
     * Sets control's value.
     * @param $value
     * @return MoneyControl
     * @override
     */
    public function setValue($value)
    {
        foreach ($this->filtersIn as $filter) {
            $value = $filter($value);
        }
        return parent::setValue($value);
    }

    /** GETTERS/SETTERS ********************************************************************************************** */

    /**
     * @param array $decimals_count
     */
    public function setDecimalsCount($decimals_count)
    {
        $this->decimals_count = $decimals_count;
    }

    /**
     * @return array
     */
    public function getDecimalsCount()
    {
        return $this->decimals_count;
    }

    /**
     * @param string $decimals_separator
     */
    public function setDecimalsSeparator($decimals_separator)
    {
        $this->decimals_separator = $decimals_separator;
    }

    /**
     * @return string
     */
    public function getDecimalsSeparator()
    {
        return $this->decimals_separator;
    }

    /**
     * @param int $max_decimals
     */
    public function setMaxDecimals($max_decimals)
    {
        $this->max_decimals = $max_decimals;
    }

    /**
     * @return int
     */
    public function getMaxDecimals()
    {
        return $this->max_decimals;
    }

    /**
     * @param string $postfix
     */
    public function setPostfix($postfix)
    {
        $this->postfix = $postfix;
    }

    /**
     * @return string
     */
    public function getPostfix()
    {
        return $this->postfix;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param boolean $removeLeadingZeros
     */
    public function setRemoveLeadingZeros($removeLeadingZeros)
    {
        $this->removeLeadingZeros = $removeLeadingZeros;
    }

    /**
     * @return boolean
     */
    public function getRemoveLeadingZeros()
    {
        return $this->removeLeadingZeros;
    }

    /**
     * @param boolean $removeTralingZeros
     */
    public function setRemoveTralingZeros($removeTralingZeros)
    {
        $this->removeTralingZeros = $removeTralingZeros;
    }

    /**
     * @return boolean
     */
    public function getRemoveTralingZeros()
    {
        return $this->removeTralingZeros;
    }

    /**
     * @param string $thousands_separator
     */
    public function setThousandsSeparator($thousands_separator)
    {
        $this->thousands_separator = $thousands_separator;
    }

    /**
     * @return string
     */
    public function getThousandsSeparator()
    {
        return $this->thousands_separator;
    }

    /** FILTERS ***************************************************************************************************** */

    /**
     * Filter: format number to defined scheme
     * @param string $value
     * @return string
     */
    public function unformat($value)
    {
        // call common formater
        $value = $this->_format($value);

        return $value;
    }

    /**
     * Filter: format number to defined scheme
     * @param string $value
     * @return string
     */
    public function format($value)
    {
        // call common formater
        $value = $this->_format($value);

        // convert , -> .
        $value = Strings::replace($value, "/,/", ".");

        // format decimals with number_format
        $value = $this->formatDecimals($value);

        // use prefix (if set)
        if ($this->postfix) {
            $value .= self::NON_BREAKING_SPACE . $this->postfix;
        }

        // use postfix (if set)
        if ($this->prefix) {
            $value = $this->prefix . self::NON_BREAKING_SPACE . $value;
        }

        return $value;
    }

    /**
     * Common formater
     * @param $value
     * @return string
     */
    private function _format($value)
    {
        // remove whitespaces
        $value = trim($value);

        // remove all characters except [0-9.,]
        $value = Strings::replace($value, "/[^0-9\.,]/", "");

        // check data
        if ($value == null || strlen($value) == 0) {
            return $value;
        }

        // exists ',' and '.'?
        if (strpos($value, ',') !== false && strpos($value, '.') !== false) {
            $value = str_replace(',', '', $value);
        } else {
            $value = str_replace(',', '.', $value);
        }

        // remove leading decimals zeros
        if ($this->removeLeadingZeros) {
            $value = Strings::replace($value, '/^0*([0-9]*)$/', '${1}');
        }

        // remove trailing decimals zeros
        if ($this->removeTralingZeros) {
            $value = rtrim(Strings::replace($value, '/^([0-9]+[\.|,][0-9]*)0*$/U', '${1}'), '.,');
        }

        return $value;
    }

    /**
     * Filter: format decimals
     * @param $value
     */
    public function formatDecimals($value)
    {
        $match = Strings::match($value, "/.*[\.|,](.*)/");
        if (!$match || strlen($match[1]) == 0) {
            $decimals = 0;
        } else if (strlen($match[1]) >= $this->max_decimals) {
            $decimals = strlen($match[1]);
        } else {
            $decimals = strlen($match[1]);
            foreach ($this->decimals_count as $d) {
                if ($d >= $decimals) {
                    return number_format($value, $d, $this->decimals_separator, $this->thousands_separator);
                }
            }
        }

        return number_format($value, $decimals, $this->decimals_separator, $this->thousands_separator);
    }

    /**
     * Filter: removes unnecessary whitespace
     * @return string
     */
    public function sanitize($value)
    {
        return Strings::trim(strtr($value, "\r\n", '  '));
    }

    /**
     * Register MoneyControl method
     * @param string $methodName
     * @return void
     */
    public static function register($methodName = "addMoney")
    {
        Container::extensionMethod($methodName, function (Container $_this, $name, $label) {
            return $_this[$name] = new MoneyControl($label);
        });
    }
}

MoneyControl::register();
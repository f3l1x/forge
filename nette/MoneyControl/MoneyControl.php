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
    private $maxDecimals = 4;

    /** @var array */
    private $decimalsCount = array(0, 2, 3, 4);

    /** @var string */
    private $decimalsSeparator = ',';

    /** @var string */
    private $thousandsSeparator = ' ';

    /** @var bool */
    private $removeTralingZeros = TRUE;

    /** @var bool */
    private $removeLeadingZeros = TRUE;

    /**
     * @param string|null $label
     */
    public function __construct($label = NULL)
    {
        parent::__construct($label);
        $this->filtersOut[] = $this->sanitize;
        $this->filtersOut[] = $this->unformat;
        $this->filtersIn[] = $this->format;
        $this->value = NULL;
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
     * @param array $decimalsCount
     */
    public function setDecimalsCount($decimalsCount)
    {
        $this->decimalsCount = $decimalsCount;
    }

    /**
     * @return array
     */
    public function getDecimalsCount()
    {
        return $this->decimalsCount;
    }

    /**
     * @param string $decimalsSeparator
     */
    public function setDecimalsSeparator($decimalsSeparator)
    {
        $this->decimalsSeparator = $decimalsSeparator;
    }

    /**
     * @return string
     */
    public function getDecimalsSeparator()
    {
        return $this->decimalsSeparator;
    }

    /**
     * @param int $maxDecimals
     */
    public function setMaxDecimals($maxDecimals)
    {
        $this->maxDecimals = $maxDecimals;
    }

    /**
     * @return int
     */
    public function getMaxDecimals()
    {
        return $this->maxDecimals;
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
     * @param string $thousandsSeparator
     */
    public function setThousandsSeparator($thousandsSeparator)
    {
        $this->thousandsSeparator = $thousandsSeparator;
    }

    /**
     * @return string
     */
    public function getThousandsSeparator()
    {
        return $this->thousandsSeparator;
    }

    /** FILTERS ***************************************************************************************************** */

    /**
     * Filter: format number to defined scheme
     * @param mixed $value
     * @return float|int|null
     */
    public function unformat($value)
    {
        // call common formater
        $value = $this->_format($value);

        return $value;
    }

    /**
     * Filter: format number to defined scheme
     * @param mixed $value
     * @return float|int|null
     */
    public function format($value)
    {
        // call common formater
        $value = $this->_format($value);

        // check data
        if ($value == NULL || strlen($value) == 0) {
            return NULL;
        }

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
     * @param mixed $value
     * @return float|int|null
     */
    private function _format($value)
    {
        // remove whitespaces
        $value = trim($value);

        // remove all characters except [0-9.,]
        $value = Strings::replace($value, "/[^0-9\.,]/", "");

        // exists ',' and '.'?
        if (strpos($value, ',') !== FALSE && strpos($value, '.') !== FALSE) {
            $value = str_replace(',', '', $value);
        } else {
            $value = str_replace(',', '.', $value);
        }

        // remove leading decimals zeros
        if ($this->removeLeadingZeros) {
            $value = Strings::replace($value, '/^0*([0-9]+)$/', '${1}');
        }

        // remove trailing decimals zeros
        if ($this->removeTralingZeros) {
            $value = rtrim(Strings::replace($value, '/^([0-9]+[\.|,][0-9]*)0*$/U', '${1}'), '.,');
        }

        return $value;
    }

    /**
     *
     * Filter: format decimals
     * @param $value
     * @return string
     */
    public function formatDecimals($value)
    {
        $match = Strings::match($value, "/.*[\.|,](.*)/");
        if (!$match || strlen($match[1]) == 0) {
            $decimals = 0;
        } else if (strlen($match[1]) >= $this->maxDecimals) {
            $decimals = $this->maxDecimals;
        } else {
            $decimals = strlen($match[1]);
            foreach ($this->decimalsCount as $d) {
                if ($d >= $decimals) {
                    $decimals = $d;
                    break;
                }
            }
        }

        return number_format($value, $decimals, $this->decimalsSeparator, $this->thousandsSeparator);
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
        Container::extensionMethod($methodName, function (Container $container, $name, $label) {
            return $container[$name] = new MoneyControl($label);
        });
    }
}

MoneyControl::register();
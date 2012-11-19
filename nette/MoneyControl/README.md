# Money Control for Nette Forms

## Info

* @author Milan Felix Sulc
* @license MIT

## Register

Anywhere. (e.q. before you used in a form)

	\Nette\Forms\Controls\MoneyControl::register();

## Usecase

    public function createComponentForm() {
        $form = new \Nette\Application\UI\Form();
        $form->addMoney('money', 'Your cashflow:');
        $form->addSubmit('Merge');
        $form->onSuccess[] = callback($this, 'process');
        return $form;
    }

## Configuration

<table>
  <tr>
    <th>Name (type)</th>
    <th>Desc</th>
    <th>Default</th>
  </tr>
  <tr>
    <td>$postfix (string)</td>
    <td>String after value</td>
    <td>''</td>
  </tr>
  <tr>
    <td>$prefix (string)</td>
    <td>String before value</td>
    <td>''</td>
  </tr>
  <tr>
    <td>$maxDecimals (int)</td>
    <td>Maximum numbers after '.' or ','</td>
    <td>4</td>
  </tr>
  <tr>
    <td>$decimalsSeparator (string)</td>
    <td>Your own decimal point</td>
    <td>,</td>
  </tr>
  <tr>
    <td>$thousandsSeparator (string)</td>
    <td>Your own thousands separator</td>
    <td>' '</td>
  </tr>
  <tr>
    <td>$decimalsCount (array)</td>
    <td>Array of decimals you want to round to.</td>
    <td>[0, 2, 3, 4]</td>
  </tr>
  <tr>
    <td>$removeLeadingZeros (bool)</td>
    <td>Cut zeros from front of value.</td>
    <td>TRUE</td>
  </tr>
  <tr>
    <td>$removeTrailingZeros (bool)</td>
    <td>Cut zeros from end of value.</td>
    <td>TRUE</td>
  </tr>
</table>

## Callbacks

    $input = $form->addMoney('money', 'Your cashflow:');
    $input->filterIn[] = $this->myFilterIn; 
    // fired on $input->setData(), $input->setDefaultData();

    $input->filterOut[] = $this->myFilterOut; 
    // fired on $input->getData()

## Transfer table

### IN -> CONTROL

1.0000 -> 1
1.3000 -> 1,30
1.2340 -> 1,234
1.2345 -> 1,2345
12345.0000 -> 12 345

### CONTROL -> OUT

1 -> 1
1,234 -> 1.234
1,20 -> 1.2
1.23 -> 1.23
1,23 -> 1.23
12 345 -> 12345
12'345 -> 12345


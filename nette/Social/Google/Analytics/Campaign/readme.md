# Google Analytics Campaign Maker

Small utility for creating GA accepted parameters to url.

## Parameters

- source
- medium
- campaign
- term
- content

## Info

* @version 1.2
* @author Milan Felix Sulc <rkfelix@gmail.com>
* @license MIT

## Usage

```php
    // Source, medium, campaign
    $campaign = new NettePlugins\Social\Google\Analytics\Campaign('newsletter', 'website', 'april13');
    $this->link('Card:detail', $campaign->build());

    // Source, medium, campaign, term, content
    $campaign = new NettePlugins\Social\Google\Analytics\Campaign('newsletter', 'website', 'april13', 'term1', 'content');
    $this->link('Product:detail', $campaign->build());

    // Factory (same args as previous)
    $link = NettePlugins\Social\Google\Analytics\Campaign::create('newsletter', 'website', 'april13');
    $this->link('Foto:detail', $link);
```
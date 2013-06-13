# Google Analytics Campaign Maker

Small utility for creating GA accepted parameters to url.

## Parameters

- source
- medium
- campaign
- term
- content

## Info

* @author Milan Felix Sulc
* @license MIT
* @version 1.1

## Usage

    // Source, medium, campaign
    $campaign = new GoogleAnalytics\Campaign('newsletter', 'website', 'april13');
    $this->link('Card:detail', $campaign->build());

    // Source, medium, campaign, term, content
    $campaign = new GoogleAnalytics\Campaign('newsletter', 'website', 'april13', 'term1', 'content');
    $this->link('Product:detail', $campaign->build());

    // Factory (same args as previous)
    $link = GoogleAnalytics\Campaign::create('newsletter', 'website', 'april13');
    $this->link('Foto:detail', $link);
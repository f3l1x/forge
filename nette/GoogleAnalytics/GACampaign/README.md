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

## Usage

    // Source, medium, campaign
    $campaign = new GACampaign('newsletter', 'website', 'april13');
    $this->link('Card:detail', $campaign->build());

    // Source, medium, campaign, term, content
    $campaign = new GACampaign('newsletter', 'website', 'april13', 'term1', 'content');
    $this->link('Product:detail', $campaign->build());

    // Factory (same args as previous)
    $link = GACampaign::create('newsletter', 'website', 'april13');
    $this->link('Foto:detail', $link);
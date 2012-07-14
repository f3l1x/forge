# ifCurrentIn

- Nette macro

## Usage

### Presenter

    public function templatePrepareFilters($template)
    {
        $template->registerFilter($latte = $this->context->nette->createLatte());

        $set = Nette\Latte\Macros\MacroSet::install($latte->getCompiler());
        $set->addMacro('ifCurrentIn', function($node, $writer)
        {
            return $writer->write('foreach (%node.array as $l) { if ($_presenter->isLinkCurrent($l)) { $_c = true; break; }} if (isset($_c)): ');
        }, 'endif; unset($_c);');
    }
    
### Latte
  
    {block content}
    # classic macro
    {ifCurrentIn "Page:default", "Homepage:default"}
      Ahojda
    {/ifCurrentIn}

    # n:macro
    <div n:ifCurrentIn="'Homepage:*', 'Page:default', 'X:y'">
      Cau
    </div>
    {/block}
  
- n:macro needs apostrophes for better PHP parsing
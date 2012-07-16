#FbTools (PHP >= 5.3 namespaces) 

Collection of facebook components override for Nette 2.0

##Usage

### 1) Config (DI)


**list style**

	factories:
		fbToolsLikeButton:
			class: \FbTools\LikeButton
			setup:
				- setUrl('http://www.mojestranka.cz')
				- setWidth(150)
		
**1 array style**

	factories:
		fbToolsLikeButton:
			class: \FbTools\LikeButton
			setup:
				- setAll([
					url: 'http://www.mojestranka.cz',
					font: 'Artial',
					send: false,
					])	
		
**facebook script (you can place it by yourself)**

	factories:
		fbToolsScript:
			class: \FbTools\Script

#### 2) Presenter

	protected function createComponentLikeButton()
	{
		$fb = $this->context->createFbToolsLikeButton();
		$fb->setUrl('http://www.g00gl.c0m');
		return $fb;
	}

	protected function createComponentFbToolsScript()
	{
		return $this->context->createFbToolsScript();
	}

### 3) Template

**all configured**

	{control likeButton}
	
**custom settings**

	{control likeButton, url => "http://www.anypage.com", send => false}
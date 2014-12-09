#FbTools 2.0

![FbTools](https://raw.github.com/f3l1x/nette-plugins/master/FbToolsNS/logo.png)

Collection of facebook components override for Nette 2.0.

##Usage

### 1) Config (DI)

#### Simple factory

	factories:
		likebutton:
			class: \FbTools\LikeButton
			setup:
				- setUrl('http://www.mojestranka.cz')
				- setWidth(150)

#### Simple factory (setAll)

	factories:
		likebutton:
			class: \FbTools\LikeButton
			setup:
				- setAll([
					url: 'http://www.mojestranka.cz',
					font: 'Artial',
					send: false,
					])	
		
#### Facebook script (you can place it manual)

	factories:
		fbscript:
			class: \FbTools\Script

### 2) Presenter

	protected function createComponentLikeButton()
	{
		$fb = $this->context->createLikebutton();
		$fb->setUrl('http://www.g00gl.c0m');
		return $fb;
	}

	protected function createComponentFbScript()
	{
		return $this->context->createFbscript();
	}

### 3) Template

#### Simple control

	{control likebutton}
	
#### Custom settings in template

	{control likebutton, url => "http://www.anypage.com", send => false}
<?php
class Classgen extends NControl
{
	public $template;
	public $data;
	
	public function startup(){
		$this->template = $this->getTemplate();
		$this->template->setFile(dirname(__FILE__) . '/Classgen.latte');
		$this->template->phpTag = "<?php";
		$this->data = NConfigAdapterNeon::load(dirname(__FILE__).'/config.neon');
	}
		
	public function generate(){
		$this->startup();

		$this->template->className = $this->data['className'];
		
		$this->convert();

		$fileName = $this->data['fileName'];
		$file = dirname(__FILE__).'/'.$fileName.'.php';
		fopen($fileName, "w+");
		file_put_contents($file, $this->template->__toString());
	}
	
	public function convert(){
		// konstanty
		$this->processCons();

		// promenne
		$this->processVars();

		// settery
		$this->processSetters();

		// gettery
		$this->processGetters();

		// funkce
		$this->processFuncs();

		// extends
		$this->processExtends();
		
		//implements
		$this->processImplements();
	}

	public function processVars(){
		$arr = array();
		foreach(NArrayTools::get($this->data,'variables',array()) as $name => $vars){
			if(is_numeric($name)){ $name = $vars; $vars = NULL; }
			$arr[] = $this->getVisibility($vars)."$$name".$this->getDefault($vars);
		}
		$this->template->variables = $arr;
	}

	public function processCons(){
		$arr = array();
		foreach(NArrayTools::get($this->data,'constants',array()) as $name => $cons){
			if($this->getDefault($cons) != ";"){
				$arr[] = "$".NString::upper($name).$this->getDefault($cons);
			}
		}
		$this->template->constants = $arr;
	}	

	public function processSetters(){
		$arr = array();
		foreach(NArrayTools::get($this->data,'variables',array()) as $name => $vars){
			$s1 = NArrayTools::get((array)$vars,'setter',true);
			$s2 = NArrayTools::get((array)$vars,'auto',true);
			if( ($s2 !== false) && ($s1 !== false)){
				if(is_numeric($name)){ $name = $vars; $vars = NULL; }
				$arr[] = $this->getVisibility($vars)."function set".NString::firstUpper($name)."($$name){\n\t\t\$this->$name = $$name;\n\t}\n";				
			}
		}
		$this->template->setters = $arr;
	}	
		
	public function processGetters(){
		$arr = array();
		foreach(NArrayTools::get($this->data,'variables',array()) as $name => $vars){
			$g1 = NArrayTools::get((array)$vars,'getter',true);
			$g2 = NArrayTools::get((array)$vars,'auto',true);
			if( ($g2 !== false) && ($g1 !== false)){
				if(is_numeric($name)){ $name = $vars; $vars = NULL; }
				$arr[] = $this->getVisibility($vars)."function get".NString::firstUpper($name)."($$name){\n\t\treturn \$this->$name;\n\t}\n";				
			}
		}
		$this->template->getters = $arr;
	}	

	public function processFuncs(){
		$arr = array();
		foreach(NArrayTools::get($this->data,'functions',array()) as $name => $fn){
			$arr[] = $this->getVisibility($fn)."function $name(".$this->getParams($fn)."){\n\t}\n";
		}
		$this->template->functions = $arr;
	}	
	
	public function processExtends(){
		$this->template->extends = NArrayTools::get($this->data,'extends',false);
	}
	
	public function processImplements(){
		$imp = NArrayTools::get($this->data,'implements',false);
		$imp = (is_array($imp) ? implode(', ',$imp) : $imp);
		$this->template->implements = $imp;
	}	
	
	public function getVisibility($vars){
		if(!is_array($vars) || !NArrayTools::searchKey($vars,'visibility')){
			return "public ";	
		}else{
			return NArrayTools::get($vars,'visibility')." ";
		}
	}
	
	public function getDefault($vars){
		if($vars == NULL){
			return ";";
		}else if(!is_array($vars)){
			return " = ".$this->parseValue($vars).";";
		}else if(($default = NArrayTools::get($vars,'default',NULL)) != NULL){
			return " = ".$this->parseValue($default).";";
		}else{
			return ";";
		}
	}
	
	public function parseValue($value){
		if(is_numeric($value)){
			return $value;
		}else if($value == NULL){
			return "NULL";
		}else{
			return "'".$value."'";
		}		
	}
	
	public function getParams($vars){
		if($vars == NULL || count($vars)==0){
			return "";
		}else{
			$arr = array();
			foreach(NArrayHash::from($vars) as $key=>$item){
				if(is_numeric($key)){
					$arr[] = "$$item";	
				}else{
					$arr[] = "$$key = ".$this->parseValue($item);	
				}
			}
			return implode(', ',$arr);
		}
	}
}
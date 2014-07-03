<?php

	class blockNode {
		public 	$content = '';
		private $children = [];
		public 	$isNew = true;



		public function __construct($name, $parent=null) {
			$this->name = $name;
			$this->parent = $parent ? $parent : $this;
		}



		public function __toString() {

			$trimmer = "\x0B\0\r\n\t";


			$content = ($this->content);
			foreach($this->children as $child) {
				$name = $child->nameTrace();

				if( isset(block::$config['comments']) && block::$config['comments'] === true) {

					$preComment = "<!-- Start '$name' -->\n";
					$postComment = "<!-- End '$name' -->";

					$replacer =
						$preComment .
						$child .
						$postComment;
				} else {
					$replacer = $child;
				}


				$content = str_replace(
					$child->placeholder(),
					$replacer,
					$content
				);
			}
			return $content;
		}




		public function child($name) {
			if($name){

				$name = explode('.', $name);

				if(count($name) > 1) {
					return $this->_getChild($name[0])->child( implode('.', array_splice($name, 1)) );
				} else if(count($name) === 1) {
					return $this->_getChild($name[0]);
				} else {
					return $this;
				}

			}

		}



		private function _getChild($name) {
			if( !isset($this->children[$name]) ) {
				return $this->children[$name] = new self($name, $this);
			} else {
				$this->children[$name]->isNew = false;
				return $this->children[$name];
			}
		}




		public function placeholder() {
			return "<!-- Placeholder for block '".$this->nameTrace()."' -->";
		}




		public function nameTrace() {

			if($this->parent !== $this->parent->parent) {
				$parentTrace = $this->parent->nameTrace().'.';
			}
			return trim($parentTrace.$this->name, '.');

		}




		public function record($type='replace') {
			$block = $this;

			ob_start(function($buffer)use($block, $type){

				switch($type) {
					case 'replace':
						$block->content = $buffer;
					break;
					case 'append':
						$block->content .= $buffer;
					break;
					case 'prepend':
						$block->content = $buffer.$block->content;
					break;
				}

			});
		}




		public function recordOff() {
			ob_end_clean();
		}


	}

 ?>

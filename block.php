<?php

	require 'lib/blockNode.php';

	final class block {
		private static $root;
		private static $stack = [];
		private static $config = [];

		private static function stack_on($block) {
			array_unshift(self::$stack, $block);
			return $block;
		}

		private static function stack_off() {
			return array_shift(self::$stack);
		}

		private static function stack_active() {
			return self::$stack[0];
		}


		public static function init() {
			self::stack_on( self::$root = new blockNode('__rootBlock__') );
		}

		public static function config($config) {
			self::$config = $config;
		}

		public static function start($name) {

			$block = self::stack_on( self::define($name) );

			$block->record('replace');

			return $block;
		}

		public static function append($name) {

			$block = self::stack_on( self::define($name) );

			$block->record('append');

			return $block;
		}

		public static function prepend($name) {

			$block = self::stack_on( self::define($name) );

			$block->record('prepend');

			return $block;
		}

		public static function define($name) {
			$block = self::stack_active()->child($name);

			if($block->isNew) { echo $block->placeholder(); }
			return $block;
		}

		public static function end() {
			self::stack_active()->recordOff();
			self::stack_off();
		}

		public static function render($file, $scope=null) {
			block::init();
			extract( (array) $scope = ($scope ? $scope : []) );

			ob_start();
				include self::$config['basedir'] .DIRECTORY_SEPARATOR. $file;
				$content = ob_get_contents();
			ob_end_clean();

			self::$root->content = $content;
			return self::$root;
		}

	}



 ?>

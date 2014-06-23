#Block
A simple PHP engine for extendable templates.


##Example

Call the following command from your controller to render `example.php` which extends the `block`-areas of `layout.php`.

	echo blog::render('example.php');

**layout.php**
	
	<body>
	<? block::start('body'); ?>

		<header>
			// Header-content
		</header>
		<main>
			<? block::define('main'); ?>
		</main>
		<footer>
			// Footer-content
		</footer>
		
	<? block::end(); ?>
	</body>
	
**example.php**

	<? include 'layout.php'; ?>
	
	<? block::start('main'); ?>
		<h1>Content that goes into `<main>`-tag!</h1>
	<? block::end(); ?>


	
**Output**

	<body>
		<header>
			// Header-content
		</header>
		<main>
			<h1>Content that goes into `<main>`-tag!</h1>
		</main>
		<footer>
			// Footer-content
		</footer>
	</body>


##API

- define($name)
- start($name)
- append($name)
- prepend($name)
- end()
- config($config)
- render($file, $scope=null)



##Contact##

- [mail@platdesign.de](mailto:mail@platdesign.de)
- [platdesign](https://twitter.com/platdesign) on Twitter

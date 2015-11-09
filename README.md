# IPS Development Packager
## Introduction
Development Packager is an IPS application for third party developers that fully automates the task of packaging development files with other IPS applications.

It also has the added benefit of doing all this in a fully transparent manner, meaning you never have to manually include these development files with your application releases again.

## How does it work?
Integrating Development Packager into your own IPS application can be done in three easy steps.

**Step 1:** Install the Development Packager application as normal.

**Step 2:** Now that the hard stuff is out of the way, create a new core **Build** extension for your application in the Development Center.

In this file, replace the **build** method with the following,
```php
/**
 * Build
 *
 * @return	void
 * @throws	\RuntimeException
 */
public function build()
{
	/**
	 * Make sure we have the DevPackager application installed.
	 * If you want to require developers install this application, simply remove this check.
	 */
	if ( !class_exists( 'IPS\devpackager\Packager' ) )
	{
		return;
	}

	/**
	 * Package our development files and build our extraction class
	 */
	$devPackager = new \IPS\devpackager\Packager( 'yourAppDirHere' );
	$devPackager->packageDevFiles();
	$devPackager->createDevFilesClass();
}
```
Naturally, replace **yourAppDirHere** with your actual application directory.

**Step 3:** In your applications Application.php file, add the following method,
```php
/**
 * Extract developer resources on installation
 */
public function installOther()
{
	try
	{
		\IPS\yourAppDirHere\DevFiles::extract();
	}
	catch ( \Exception $e ) {}
}
```
Again, replace **yourAppDirHere** respectively.

Once that's done, build your application. That's it!

Now whenever your application is built, all of your development resources should be re-packages and saved to your applications **data** directory.

These files are always included with your applications installation file. Not only this, but any time your application is installed in an environment where ```\IPS\IN_DEV``` is enabled, your development releases will be *automatically* extracted on installation.

This means you no longer have to maintain copies of your development files with every release, and other developers no longer ave to manually extract these files every time they install or upgrade your application in their development environments. Awesome!

<?php

namespace IPS\devpackager;

class _Packager
{
	/**
	 * @brief   The loaded application instance
	 */
	public $app;

	/**
	 * @brief   The application directory
	 */
	public $appDir = '';

	/**
	 * @brief   The full application path
	 */
	public $appPath = '';

	/**
	 * @brief   Path to the dev files tarball
	 */
	public $devPath = '';

	/**
	 * @brief   Development files should always be extracted on installation
	 */
	public $alwaysInclude = FALSE;

	/**
	 * Package development files
	 *
	 * @param string        $appDir         The application directory
	 * @param bool|FALSE    $alwaysInclude  When TRUE, development resources will always be extracted on install,
	 *                                      even when the IPS installation does not have IN_DEV mode enabled.
	 */
	public function __construct( $appDir, $alwaysInclude=FALSE )
	{
		/* Set our paths */
		$this->appDir  = $appDir;
		$this->appPath = join( \DIRECTORY_SEPARATOR, [ \IPS\ROOT_PATH, 'applications', $this->appDir ] );
		$this->devPath = join( \DIRECTORY_SEPARATOR, [ $this->appPath, 'data', 'dev.tar' ] );

		/* Load our application instance */
		$applications = \IPS\Application::applications();
		foreach ( $applications as $application )
		{
			if ( $application->directory === $this->appDir )
			{
				$this->app = $application;
			}
		}

		$this->alwaysInclude = $alwaysInclude;
	}

	/**
	 * Package development files
	 *
	 * @return  void
	 */
	public function packageDevFiles()
	{
		/* Package our development files */
		$devFiles = new \PharData( $this->devPath, 0, 'dev.tar', \Phar::TAR );
		/*$appIterator = new \RecursiveDirectoryIterator(
				join( \DIRECTORY_SEPARATOR, [ $this->appPath, 'dev' ] ), \RecursiveDirectoryIterator::SKIP_DOTS
		);*/
		//$devFiles->buildFromIterator( $appIterator );
		join( \DIRECTORY_SEPARATOR, [ $this->appPath, 'dev' ]);
		$devFiles->buildFromDirectory( join( \DIRECTORY_SEPARATOR, [ $this->appPath, 'dev' ] ), '/^[^.].*$/' );
	}

	/**
	 * Create a new DevFiles class for the application
	 *
	 * @return  void
	 */
	public function createDevFilesClass()
	{
		$templatePath = join( \DIRECTORY_SEPARATOR, [
				\IPS\ROOT_PATH, 'applications', 'devpackager', 'data', 'defaults', 'DevFiles.txt'
		] );

		/* Construct our template */
		$appTitle = \IPS\Member::loggedIn()->language()->get( "__app_{$this->appDir}" );
		$template = file_get_contents( $templatePath );
		$template = str_replace( '{app}', $this->appDir, $template );
		$template = str_replace( '{subpackage}', $appTitle, $template );
		$template = str_replace( '{in_dev_only}', $this->alwaysInclude ? 'FALSE' : 'TRUE', $template );

		/* Make sure our source directory exists */
		$sourcePath = join( \DIRECTORY_SEPARATOR, [ $this->appPath, 'sources', 'DevFiles' ] );

		if ( !is_dir($sourcePath) ) {
			mkdir( $sourcePath, 0777, true);
		}

		/* Create our class file */
		\file_put_contents( join( \DIRECTORY_SEPARATOR, [ $sourcePath, 'DevFiles.php' ] ), $template );
	}
}
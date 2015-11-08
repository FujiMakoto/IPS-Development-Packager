<?php
/**
 * @brief		Dev Packager Application Class
 * @author		<a href='https://www.Makoto.io'>Makoto Fujimoto</a>
 * @copyright	(c) 2015 Makoto Fujimoto
 * @package		IPS Social Suite
 * @subpackage	Dev Packager
 * @since		08 Nov 2015
 * @version		
 */
 
namespace IPS\devpackager;

/**
 * Dev Packager Application Class
 */
class _Application extends \IPS\Application
{
	public function installOther()
	{
		/* Set our paths */
		$appPath = join( \DIRECTORY_SEPARATOR, 'applications', $this->app_directory );
		$devFiles = join( \DIRECTORY_SEPARATOR, $appPath, 'data', 'dev.tar' );

		/* Load and extract our tarball */
		try
		{
			$devFiles = new \PharData( $devFiles, 0, NULL, \Phar::TAR );
			$devFiles->extractTo( $appPath, NULL, TRUE );
		}
		catch ( \Exception $e )
		{
			\IPS\Log::i( \LOG_ERR )->write( "Error : " . $e->getMessage() . "\n" . $e->getTraceAsString(), 'devpackager_error' );
		}

		parent::installOther();
	}
}
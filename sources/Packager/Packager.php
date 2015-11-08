<?php

namespace IPS\devpackager;

class _Packager
{
	/**
	 * Package development files
	 *
	 * @param string    $appDir The application directory
	 */
	public static function packageDevFiles( $appDir )
	{
		/* Set our paths */
		$appPath = join( \DIRECTORY_SEPARATOR, 'applications', $appDir );
		$devPath = join( \DIRECTORY_SEPARATOR, $appPath, 'data', 'dev.tar' );

		/* Package our development files */
		$devFiles = new \PharData( $devPath );
		$appIterator = new \RecursiveDirectoryIterator(
				join( \DIRECTORY_SEPARATOR, $appPath, 'dev' ), \RecursiveDirectoryIterator::SKIP_DOTS
		);
		$devFiles->buildFromIterator( $appIterator );
	}
}
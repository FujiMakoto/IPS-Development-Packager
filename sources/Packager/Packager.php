<?php

namespace IPS\devpackager;

class _Packager
{
	/**
	 * @brief   The packaged applications namespace
	 */
	public $namespace = '';

	/**
	 * @brief   Always extract development resources, even when not IN_DEV
	 */
	public $alwaysInclude = FALSE;

	/**
	 * Construct a new dev tools packager
	 *
	 * @param string     $namespace     The namespace of the application being packaged. (e.g. 'IPS\devpackager')
	 * @param bool|FALSE $alwaysInclude When TRUE, development resources will always be extracted on install, even when
	 *                                  the IPS installation does not have IN_DEV mode enabled.
	 */
	public function __construct( $namespace, $alwaysInclude=FALSE )
	{
		$this->namespace = $namespace;
		$this->alwaysInclude = $alwaysInclude;
	}

	public function packageDevFiles()
	{

	}
}
<?php
namespace Debug\Toolbar\Service;

/*                                                                        *
 * This script belongs to the FLOW3 framework.                            *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * 
 * @FLOW3\Scope("singleton")
 */
class Debugger {
	/**
	 * @var \TYPO3\FLOW3\Reflection\ReflectionService
	 * @author Marc Neuhaus <apocalip@gmail.com>
	 * @FLOW3\Inject
	 */
	protected $reflectionService;

	/**
	 *
	 * @var array
	 **/
	protected $debugger = array();

	public function __construct(\TYPO3\FLOW3\Reflection\ReflectionService $reflectionService) {
		foreach($reflectionService->getAllImplementationClassNamesForInterface('Debug\Toolbar\Debugger\DebuggerInterface') as $debuggerClass) {
			$debugger = new $debuggerClass();
			$this->debugger[] = $debugger;
		}
	}

	public function getDebuggers() {
		return $this->debugger;
	}
}

?>
<?php
/**
 * MethodRequest
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    support@onecde.gr
 */

namespace Onecode\WebApiLogger\Model\System\Config;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class MethodRequest
 * @package Onecode\WebApiLogger\Model\System\Config
 */
class MethodRequest implements ArrayInterface {

	/**
	 * @return array
	 */
	public function toOptionArray () {
		return [
			"GET"     => "GET",
			"POST"    => "POST",
			"PUT"     => "PUT",
			"HEAD"    => "HEAD",
			"DELETE"  => "DELETE",
			"PATCH"   => "PATCH",
			"OPTIONS" => "OPTIONS",
		];
	}
}

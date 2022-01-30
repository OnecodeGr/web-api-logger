<?php

namespace Onecode\WebApiLogger\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class HttpMethods implements OptionSourceInterface {
	/**
	 * Options getter
	 *
	 * @return array
	 */
	public function toOptionArray() {
		$option_array = [];
		$arr          = [
			'CONNECT',
			'DELETE',
			'GET',
			'HEAD',
			'OPTIONS',
			'PATCH',
			'POST',
			'PUT',
			'TRACE'
		];
		foreach ( $arr as $label ) {
			$option_array[ $label ] = [
				'value' => $label,
				'label' => $label
			];
		}

		return $option_array;
	}
}

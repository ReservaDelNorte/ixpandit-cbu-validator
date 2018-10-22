<?php

namespace Ixpandit\IxpanditCbuValidator;

use Illuminate\Support\ServiceProvider;
use Ixpandit\IxpanditCbuValidator\CbuValidatorService;
use Ixpandit\IxpanditCbuValidator\CbuValidatorAdapter;

class IxpanditCbuValidatorServiceProvider extends ServiceProvider
{
	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->app['validator']->extend('ixpandit_cbu', function ($attribute, $value, $parameter, $validator)
		{
			$data = $validator->getData();
			$cbuValidatorService = new CbuValidatorService(new CbuValidatorAdapter());
			$validate = $cbuValidatorService->validate($data['cbu'], $data['uniqueIdentifier']);

			if(isset($data['business']) && $data['business'] != "grouit" && $validate['validated'] && $validate['type'] == "CC")
			{
				$validator->setFallbackMessages([
					'ixpandit_cbu' => "El CBU ingresado corresponde a una Cuenta Corriente."
				]);
				return false;
			}

			if(isset($validate['owners']) && $validate['owners'] > 1)
			{
				$validator->setFallbackMessages([
					'ixpandit_cbu' => "El CBU ingresado tiene más de un titular."
				]);
				return false;
			}

			if(!$validate['validated'])
			{
				$validator->setFallbackMessages([
					'ixpandit_cbu' => $validate['message']
				]);
			}

			return $validate['validated'];
		});

		$this->app['validator']->replacer('ixpandit_cbu', function ($message, $attribute, $rule, $parameters) {
			return $message;
		});
	}
}

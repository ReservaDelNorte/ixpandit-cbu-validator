<?php 

namespace ReservaDelNorte\IxpanditCbuValidator;

use Illuminate\Support\ServiceProvider;
use ReservaDelNorte\IxpanditCbuValidator\CbuValidatorService;

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
			$cbuValidatorService = new CbuValidatorService();
			$validate = $cbuValidatorService->validate($data['cbu'], $data['uniqueIdentifier']);

			return $validate['validated'];
		});
	}
}

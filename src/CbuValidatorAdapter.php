<?php

namespace ReservaDelNorte\IxpanditCbuValidator;

use Ixudra\Curl\Facades\Curl;

class CbuValidatorAdapter
{
	public function validate($cbu, $cuil)
	{
		if (!env('CBU_VALIDATOR_ENABLED') || !env('CBU_VALIDATOR_URL'))
		{
			return false;
		}

		$url = env('CBU_VALIDATOR_URL')."api/validator?cbu={$cbu}&cuil={$cuil}";

		$curl = Curl::to($url);
		$response = $curl->asJsonRequest()
					->returnResponseObject()
					->withTimeout(60)
					->withHeader('x-api-key: '.env('X_API_KEY_CBU_VALIDATOR'))
					->get();

		if (property_exists($response, 'error'))
		{
			\Log::error($response->error);
			return false;
		}
		
		return json_decode($response->content);
	}
}

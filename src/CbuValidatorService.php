<?php

namespace Ixpandit\IxpanditCbuValidator;

use Ixpandit\IxpanditCbuValidator\CbuValidatorAdapter;

class CbuValidatorService {

	protected $cbuValidatorAdapter;

	public function __construct(CbuValidatorAdapter $cbuValidatorAdapter)
	{
		$this->cbuValidatorAdapter = $cbuValidatorAdapter;
	}

	public function validate($cbu, $cuil)
	{
		if (!$cbuValidatorService = $this->cbuValidatorAdapter->validate($cbu, $cuil))
		{
			return ['validated' => false, 'message' => "Hubo un problema, por favor contactanos"];
		}
		
		if ($cbuValidatorService->message == "NO_MATCH")
		{
			return ['validated' => false, 'message' => "El CBU ingresado no corresponde con el DNI de la solicitud, verifique el CBU e intente nuevamente."];
		}
		
		if ($cbuValidatorService->message == "NO_ACTIVE")
		{
			return ['validated' => false, 'message' => "El CBU ingresado no se encuentra activo, verifique el CBU e intente nuevamente."];
		}
		
		if ($cbuValidatorService->message == "NOT_FOUND")
		{
			return ['validated' => false, 'message' => "El CBU ingresado no se encuentra activo, verifique el CBU e intente nuevamente."];
		}

		if ($cbuValidatorService->message == "PENDING_APIBANK_VALIDATION")
		{
			return ['validated' => false, 'message' => "Hubo un problema, por favor contactanos"];
		}
		
		if ($cbuValidatorService->message == "ACTIVE")
		{
			return ['validated' => true];
		}

		return ['validated' => false, 'message' => "Hubo un problema, por favor contactanos"];
	}
}
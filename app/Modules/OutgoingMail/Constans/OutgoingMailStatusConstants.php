<?php

namespace App\Modules\OutgoingMail\Constans;

class OutgoingMailStatusConstants
{
	const DRAFT = 0;
	const SEND_TO_REVIEW = 1;
	const REVIEW = 2;
	const APPROVED = 3;
	const SIGNED = 4;
	const PUBLISH = 5;

	const IS_NOT_ARCHIVE = 0;
	const IS_ARCHIVE = 1;

	const INTERNAL = 1;
	const EXTERNAL = 2;
}

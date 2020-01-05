<?php

namespace CompassHB\Ccb\Enums;

use CompassHB\Ccb\Traits\Enum;

class GroupStatus {

	use Enum;

	public const ADD = 'add';

	public const INVITE = 'invite';

	public const REQUEST = 'request';

}
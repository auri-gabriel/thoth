<?php

namespace Models;

enum SelectionStatus: int
{
	case Accepted     = 1;
	case Rejected     = 2;
	case Unclassified = 3;
	case Duplicate    = 4;
	case Removed      = 5;

	public static function fromValue(int $value): ?self
	{
		return match ($value) {
			1 => self::Accepted,
			2 => self::Rejected,
			3 => self::Unclassified,
			4 => self::Duplicate,
			5 => self::Removed,
			default => null,
		};
	}
}

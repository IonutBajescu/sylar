<?php

if ( ! function_exists('config_merge'))
{
	/**
	 * @Laravel
	 *
	 * Sensibly merge configuration arrays.
	 *
	 *
	 * @param  array  ...$args
	 * @return array
	 */
	function config_merge()
	{
		$result = [];

		foreach (func_get_args() as $arg)
		{
			foreach ($arg as $key => $value)
			{
				if (is_numeric($key))
				{
					$result[] = $value;
				}
				elseif (array_key_exists($key, $result) && is_array($result[$key]) && is_array($value))
				{
					$result[$key] = config_merge($result[$key], $value);
				}
				else
				{
					$result[$key] = $value;
				}
			}
		}

		return $result;
	}
}
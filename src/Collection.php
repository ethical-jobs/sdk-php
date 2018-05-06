<?php

namespace EthicalJobs\SDK;

/**
 * Response selector
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class Collection extends \Illuminate\Support\Collection
{
	/**
	 * Api response selector
	 *
	 * @return $this
	 */
	public function select(): ResponseSelector
	{
		return new ResponseSelector($this);
	}	
}

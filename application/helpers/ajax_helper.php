<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * An open source Content Management System based on the 
 * Codeigniter framework (http://codeigniter.com)
 *
 * @author		Amr Soliman
 * @link		http://www.mezatech.com
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * FUEL Ajax Helper
 *
 * Helper function for AJAX requests.
 *
 * @package		FUEL CMS
 * @subpackage	Helpers
 * @category	Helpers
 * @author		David McReynolds @ Daylight Studio
 * @link		http://docs.getfuelcms.com/helpers/ajax_helper
 */


// --------------------------------------------------------------------

/**
 * Returns a boolean value based on whether the page was requested via AJAX or not
 *
 * @access	public
 * @return	boolean
 */	
function is_ajax(){
	return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest");
}

// --------------------------------------------------------------------

/**
 * Sets the HTTP headers for 
 *
 * @access	public
 * @param	boolean	Sets the no cache headers
 * @return	boolean
 */	
function json_headers($no_cache = TRUE)
{
	if ($no_cache)
	{
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	}
	header('Content-type: application/json');
}

/* End of file ajax_helper.php */
/* Location: ./modules/fuel/helpers/ajax_helper.php */

<?php

class BaseController extends Controller {

    protected $client = null;
    
    // Added by Hieu Nguyen on 2016-03-15
    function __construct() {
        if(Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        
        $this->client = SugarUtil::getClient();
    }
    // End Hieu Nguyen
    
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}

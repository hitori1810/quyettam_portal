<?php

/*
*   Class HomeController
*   Auhor: Hieu Nguyen
*   Date: 2016-03-15
*   Purpose: To handle dashboard logic
*/

class HomeController extends BaseController {

    // Render the index page
	public function index() {
        $feedUrl = Config::get('app.rss_url');
        $feed = RssUtil::fetch($feedUrl);

		return View::make('home.index')->with(array('feed'=>$feed));
	}
}

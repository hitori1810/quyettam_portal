<?php

    /*
    *   Class RssUtil
    *   Auhor: Hieu Nguyen
    *   Date: 2016-03-18
    *   Purpose: To handle RSS client
    */

    class RssUtil {
        
        static $itemClass = array(
            'item-orange', 'item-red',  'item-blue', 'item-gray', 
            'item-green', 'item-orange', 'item-red',  
            'item-blue', 'item-gray', 'item-green', 
        );
        
        static function fetch($url) {
            // Suppress XML errors
            libxml_use_internal_errors(true);
            $rssDoc = simplexml_load_file($url);
            
            // Return back the error message if the loading wasn't successful
            if (!$rssDoc) return 'Cannot load RSS.';

            $output = '';
            $itemClass = self::$itemClass;
            $i = 0;
            
            if (isset($rssDoc->channel)) {
                foreach ($rssDoc->channel as $channel) {
                    if (isset($channel->item )) {
                        foreach ($channel->item as $item) {
                            $output .= '
                                <li class="'. $itemClass[$i] .'">
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <span class="lbl"><h5><a href="'. $item->link .'" target="_child">'. $item->title .'</a></h5></span>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <span>'. $item->description .'</span>
                                        </div>
                                    </div>
                                </li>';
                                
                            $i++;
                        }
                    }
                }
            } 
            else {
                foreach ($rssDoc->entry as $entry) {
                    $link = trim($entry->link);
                    
                    if (empty($link)) {
                        $link = $entry->link[0]['href'];
                    }
                    
                    $output .= '
                        <li class="'. $itemClass[$i] .'">
                            <div class="row-fluid">
                                <div class="span12">
                                    <span class="lbl"><h4><a href="'. $item->link .'" target="_child">'. $item->title .'</a></h4></span>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <span>'. $item->description .'</span>
                                </div>
                            </div>
                        </li>';
                    $i++;
                }
            }
            $output .= '';

            return $output;
        }
    }
?>

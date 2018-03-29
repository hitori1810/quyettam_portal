<?php

    /*
    *   Class ViewUtil
    *   Auhor: Hieu Nguyen
    *   Date: 2016-03-16
    *   Purpose: To handle view's util methods
    */

    class ViewUtil {
        
        // Util function to render js language into the view
        public static function renderJsLanguage($langFile) {
            $strings = Lang::get($langFile);
            
            return '<script type="text/javascript">Lang.'. $langFile .' = '. json_encode($strings) .'</script>';    
        }
    }
?>

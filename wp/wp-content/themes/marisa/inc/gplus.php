<?php

            require_once('../../../../wp-config.php'); 
            $theme_opts = get_option('marisa_options');
    
            // JDR: who you are, and how many results you want
            $myGooglePlusUser 	= $theme_opts['marisa_gplus']; 
            $myGooglePlusUserId = "102871295536734184397";
            $myGoogleAPIkey 	= "AIzaSyB2n09Exv7Lcgpr5vVd7WZUKOuMsm16HHc";

            $id = "102871295536734184397";
            $key = "AIzaSyB2n09Exv7Lcgpr5vVd7WZUKOuMsm16HHc";
            $feed = json_decode(file_get_contents('https://www.googleapis.com/plus/v1/people/'.$id.'/activities/public?key='.$key));

            foreach ($feed->items as $item) {

                $url = $item->url;
                $title = $item->title;
                $content = $item->object->content;
                $published = $item->published;
                $displayName = $item->actor->displayName;
                $imageProfile = $item->actor->image->url;
                $image = $item->object->attachments[0]->image->url;


              echo '<li><h2><img src="'.$imageProfile.'" />'.$displayName.'<br><span>'.date('F jS Y @ H:i:s',strtotime($item->published)).'</span></h2>'
                .'<p><a href="'.$url.'" taget="_blank">'.$url.'</a></p>'
                .'<a href="'.$url.'" taget="_blank"><img src="'.$image.'" class="postImage" /></a>'
                .'<br /><br /></li>';
            }
    
?>
<?php

            require_once('../../../../wp-config.php'); 
            $theme_opts = get_option('marisa_options');

            function FacebookFeed($pagename, $count, $postlength) {
                $pageID = file_get_contents('https://graph.facebook.com/?ids='.$pagename.'&fields=id');
                $pageID = json_decode($pageID,true);
                $pageID = $pageID[$pagename]['id'];

                ini_set('user_agent', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');
                $rssUrl = 'http://www.facebook.com/feeds/page.php?format=rss20&id='.$pageID;
                $xml = simplexml_load_file($rssUrl);
                $entry = $xml->channel->item;
                for ($i = 0; $i < $count; $i++) {
                    $description_original = $entry[$i]->description;
                    $description_striphtml = strip_tags($description_original);
                    $description = substr($description_striphtml, 0, $postlength);
                    
                    $title_original = $entry[$i]->title;
                    $title_striphtml = strip_tags($title_original);
                    $title = substr($title_striphtml, 0, $postlength);
                    
                    $link = $entry[$i]->link;

                    $date_original = $entry[$i]->pubDate;
                    $date = date('d-m-Y, H:i', strtotime($date_original));

                    $FB_feed .= "<li>";
                    $FB_feed .= $description."&hellip;<br>";
                    $FB_feed .= "<small><a href='".$link."'>".$date."</a></small>";
                    $FB_feed .= "</li>";
                }
                return $FB_feed;
            }

            echo FacebookFeed($theme_opts['marisa_facebook'], 4, 5000 );
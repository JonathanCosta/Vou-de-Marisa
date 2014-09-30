<?php

            require_once('../../../../wp-config.php'); 
            $theme_opts = get_option('marisa_options');
    
            require_once("twitteroauth.php"); //Path to twitteroauth library
    
            function getTweets($twitteruser) { 
                $notweets = 6;
                $consumerkey = "91VWoS0052BKjczqL9LMNKumm";
                $consumersecret = "YPrff3DTDtUw0i3iSRlGQGaGEEG2kW6CqwBFA5PV0Hfs62NDY7";
                $accesstoken = "27766009-jWBg4UotrwxP4f3WWYuwHFlwZeg6fJrrKmXOu52CF";
                $accesstokensecret = "1bAeS1A2wBzkqkPbQZOxViqDb2sOPblPe9IugMz9YsMnI";

                function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
                  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
                  return $connection;
                }

                $connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
                $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
                return ($tweets);
            }

            $tweets = getTweets($theme_opts['marisa_twitter']);
            foreach ($tweets as $line){
                $status = $line->text;
                $tweetTime =  $line->created_at;
                $tweetId = $line->id_str;
                $tweetImg = $line->user->profile_image_url;
                $outputTweet = '<li><img src="'.$tweetImg.'"/>'.$status.'</span> <a style="font-size:85%" href="http://twitter.com/'.$twitteruser.'/statuses/'.$tweetId.'">'. $tweetTime .'</a></li>';
                echo $outputTweet;    
            }
    
?>
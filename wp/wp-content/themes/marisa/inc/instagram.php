<?php

            require_once('../../../../wp-config.php'); 
            $theme_opts = get_option('marisa_options');
    
            function instagran_feeds_fn($user){

                //SECRET: f7a23d3958c6421cb59fe1326f7527d8
                //CLIENTE-ID: f09df43a57a547deaa1d1873dfa3c7d8

                $CLIENT_ID = 'f09df43a57a547deaa1d1873dfa3c7d8';
                $CLIENT_SECRET = 'f7a23d3958c6421cb59fe1326f7527d8';

                require_once 'instagram.class.php';

                // initialize client
                try {
                    $instagram = new Instagram($CLIENT_ID);
                    // get and display popular images
                    $user = $instagram->searchUser($user);
                    // search for user's photos
                    $media = $instagram->getUserMedia($user->data[0]->id);  
                        if (count($media->data) > 0) {
                            foreach ($media->data as $item) {
                                echo '<li>
                                <a target="_target" href="' . $item->link . '"><img src="' . 
                                $item->images->thumbnail->url . 
                                '" /></a>';
                                //echo 'By: <em>' . $item->user->username . '</em> <br/>';
                                //echo 'Date: ' . date ('d M Y h:i:s', $item->created_time) . '<br/>';
                                //echo $item->comments->count . ' comment(s). ' . 
                                //$item->likes->count . ' likes. </li>';
                            }
                        }
                    } catch (Exception $e) {
                        echo 'ERROR: ' . $e->getMessage() . print_r($client);
                        exit;
                }

            }
            instagran_feeds_fn($theme_opts[marisa_instagram]);
    
?>
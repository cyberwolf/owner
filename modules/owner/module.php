<?php

$Module = array( 'name' => 'Owner' );

$ViewList = array();

$ViewList['change'] = array(
                                'script' => 'change.php',
                                'params' => array( 'ObjectID', ),
                                'unordered_params' => array( 'group' => 'StartNode' ),
                                'ui_context' => 'edit',
                                'post_actions' => array( 'BrowseActionName' ),
                                'single_post_actions' => array( 'BrowseCancelButton' => 'Cancel' ),
                                'post_action_parameters' => array(
                                    'Cancel' => array( 'CancelURI' => 'BrowseCancelURI' )
                                )
                           );
?>

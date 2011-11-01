<?php

$http = eZHTTPTool::instance();

$Module = $Params['Module'];
$moduleName = $Params['ModuleName'];
$functionName = $Params['FunctionName'];

$objectID = $Params['ObjectID'];

// if browse was cancelled, redirect
if ( $Module->isCurrentAction( 'Cancel' ) )
{
    if ( $Module->hasActionParameter( 'CancelURI' ) )
    {
        return $Module->redirectTo( $Module->actionParameter( 'CancelURI' ) );
    }
    else
    {
        return $Module->redirectTo( $http->sessionVariable( 'LastAccessesURI' ) );
    }
}

if ( $objectID )
{
    $object = eZContentObject::fetch( $objectID );
}

if ( !$objectID or !$object )
{
    return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
}

if ( $Module->isCurrentAction( 'ChangeOwner' ) )
{
    $selectedObjectIDArray = eZContentBrowse::result( 'ChangeOwner' );

    if ( is_array( $selectedObjectIDArray ) and count( $selectedObjectIDArray ) > 0 )
    {
        $object->setAttribute( 'owner_id', $selectedObjectIDArray[0] );
        $object->store();

        // Clean up content cache
        eZContentCacheManager::clearContentCache( $object->attribute( 'id' ) );
    }

    return $Module->redirectTo( $http->sessionVariable( 'LastAccessesURI' ) );
}
else
{
    $browseParams = array();
    $browseParams['action_name'] = 'ChangeOwner';
    $browseParams['from_page'] = '/owner/change/' . $objectID;
    $browseParams['description_template' ] = 'design:content/browse_owner.tpl';
    $browseParams['content'] = array( 'object_id' => $objectID );

    $currentOwner = $object->attribute( 'owner' );

    if ( $currentOwner )
    {
        $currentOwnerNodes = $currentOwner->attribute( 'assigned_nodes' );

        $ignoreNodeIDList = array();
        foreach ( $currentOwnerNodes as $currentOwnerNode )
        {
            $ignoreNodeIDList[] = $currentOwnerNode->attribute( 'node_id' );
        }

        $browseParams['ignore_nodes_select'] = $ignoreNodeIDList;
    }

    if ( $Params['StartNode'] )
    {
        $browseParams['start_node'] = $Params['StartNode'];
        $browseParams['from_page'] .= '/group/' . $Params['StartNode'];
    }
    $browseParams['cancel_page'] = $http->sessionVariable( 'LastAccessesURI' );
    return eZContentBrowse::browse( $browseParams, $Module );
}

?>

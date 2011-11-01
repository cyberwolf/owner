Owner extension for eZ publish

Copyright (C) 2006 SCK-CEN
Written by Kristof Coomans ( http://blog.kristofcoomans.be )

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.


 Features
************

The owner extension allows you to change the owner of a content object.
This extension uses the content browser to let the user choose the new owner.


 Usage
************

The extension adds a menu "Change owner" to the context sensitive popup menu in the admin interface.
Read http://ez.no/doc/ez_publish/user_manual/3_6/the_administration_interface/the_content_structure_tab for more
information about the usage of this menu.


You can also add a button for changing the owner to your own templates.
In a view template for a node, you can put the following code:

{def $currentUser=fetch('user','current_user')
     $canChangeOwner=fetch( 'user', 'has_access_to', hash( 'module', 'owner', 'function', 'all') )}

{if $canChangeOwner}
<form action={concat('owner/change/', $node.contentobject_id)|ezurl} method="post">
    <input type="submit" class="button" value="Change owner" />
</form>
{/if}
{undef $canChangeOwner $currentUser}



Additionally, you can specify where the content browser has to start when browsing for a new owner.
The following code makes the content browser start at the parent node of the current owner's main node.

{def $currentOwner=$node.object.owner
     $currentOwnerGroup=$currentOwner.main_node.parent
     $currentUser=fetch('user','current_user')
     $canChangeOwner=fetch( 'user', 'has_access_to', hash( 'module', 'owner', 'function', 'all') )}

{if $canChangeOwner}
<form action={concat('owner/change/', $node.contentobject_id, '/group/', $currentOwnerGroup.node_id)|ezurl} method="post">
    <input type="submit" class="button" value="Change owner" />
</form>
{/if}
{undef $canChangeOwner $currentUser $currentOwnerGroup $currentOwner}



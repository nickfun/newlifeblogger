NEWLIFE BLOGGING SYSTEM
BY SEVENGRAFF
VERSION 3.2.2
MARCH 2004



=====[ LICENSE ]=================================

The full license is located in the included file license.txt

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

!!!
Easy Template System is LGPL. That license is at the end of ets.pdf.
Same for phpMailer. ETS & phpMailer were not written by sevengraff!



=====[ NEW INSTALL ]=============================

1] Edit config.php. Follow it's instructions. There are 7 things you need to 
	edit.
2] Upload everything
3] Use new_install.sql in phpMyAdmin
4] Chmod the /skin_cache and /avatars folders to 777
5] Register a new user. It should make you an admin. If it does not, 
	then use phpMyAdmin, find your user row in the table nlb3_users and 
	add the text :admin to the end of the access field.
6] Log in and goto the AdminCP, click "Site Config", and change settings where needed.
7] Goto "Mail Config", also in AdminCP, and make sure things are okay there.



=====[ UPGRADE FROM 3.X ]========================

Upload all the .php files to your website, excpet for config.php


=====[ UPGRADE FROM 2.5.2 ]======================

First of all, make a backup! Make a few! You can NEVER have too many :-)

1] Follow steps 1 - 4 of the New Install below:
2] Edit & upload the file convert_2_3.php (it would be wise to rename 
	it to something else for security reasons)
3] Point your browser to www.sample.com/convert_2_3.php (or where you uploaded
	it to) and follow it's instructions.
4] The converter does not make anyone an admin. To make someone an admn, you
	must go back into phpMyAdmin and add the text admin: to the beginning
	of the "access" field for the user you want to be an admin.
	If there were any errors during install, use the second link provided on 
	the page, AFTER following it's other instructions.
5] Follow steps 6 & 7 of New Install above.



=====[ CONTACT ]=================================

for support, use the forums located at:
	http://www.sevengraff.com/phpBB2/
For other info, contact sevengraff directly by email:
	nick@sevengraff.com



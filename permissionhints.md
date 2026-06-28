Just to state the obvious for anyone viewing this discussion.... if you give any of your folders 777 permissions, you are allowing ANYONE to read, write and execute any file in that directory.... what this means is you have given ANYONE (any hacker or malicious person in the entire world) permission to upload ANY file, virus or any other file, and THEN execute that file...

IF YOU ARE SETTING YOUR FOLDER PERMISSIONS TO 777 YOU HAVE OPENED YOUR SERVER TO ANYONE THAT CAN FIND THAT DIRECTORY. Clear enough??? :)

There are basically two ways to setup your ownership and permissions. Either you give yourself ownership or you make the webserver the owner of all files.

Webserver as owner (the way most people do it):

assuming www-data is your webserver user.

   sudo chown -R www-data:www-data /path/to/your/laravel/root/directory
if you do that, the webserver owns all the files, and is also the group, and you will have some problems uploading files or working with files via FTP, because your FTP client will be logged in as you, not your webserver, so add your user to the webserver user group:

  sudo usermod -a -G www-data ubuntu
Of course, this assumes your webserver is running as www-data (the Homestead default), and your user is ubuntu (it's vagrant if you are using Homestead).

Then you set all your directories to 755 and your files to 644... SET file permissions

sudo find /path/to/your/laravel/root/directory -type f -exec chmod 644 {} \;    
SET directory permissions

sudo find /path/to/your/laravel/root/directory -type d -exec chmod 755 {} \;
Your user as owner

I prefer to own all the directories and files (it makes working with everything much easier), so I do:

sudo chown -R my-user:www-data /path/to/your/laravel/root/directory
Then I give both myself and the webserver permissions:

sudo find /path/to/your/laravel/root/directory -type f -exec chmod 664 {} \;    
sudo find /path/to/your/root/directory -type d -exec chmod 775 {} \;
Then give the webserver the rights to read and write to storage and cache

Whichever way you set it up, then you need to give read and write permissions to the webserver for storage, cache and any other directories the webserver needs to upload or write too (depending on your situation), so run the commands from bashy above :

sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache
Now, you're secure and your website works, AND you can work with the files fairly easily

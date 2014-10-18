Web based File and Folder Browser

Built on jQuery and PHP 5.3

This is web based file and folder Browser supposed to look and feel similar with the OS X Finder.

To set the folder to browse on your webserver, open src\Core and adjust cons BROWSE_URL path. In this example it is set to folder 'files'

I am using browser.php as a server which will deliver JSON encoded data to browser.js
These data will be then show on page as a directory structure.
All calls are made via ajax call, so page is loaded onlyonce.
When you click on any file, it will download it on your computer.
Click on a closed folder, will open conent of clicked folder and arrow side next to folder image will be set to arrow-down as folder is now expanded.
Click again on same folder, will remove content from browser memory and close content of clicked folder.
Ever of above operation will fire up ajax loader gif. Do not worry if you dont see it in example, reading folder content in this example is light speed,
so ajax loader is gone before you can notice it :) But i ensure you its there. If you debug it in firebug and place break point on line 79 in browser.js you will see it





INSTALLATION
1) clone this repo on your webserver
2) cd to root and run composer install
3) point URL to your webserver
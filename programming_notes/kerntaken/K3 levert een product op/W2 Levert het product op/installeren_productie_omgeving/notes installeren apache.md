#instalatie notities

installeer apache haus in C:\Apache24
open bin/httpd.config

1. activeer -> LoadModule rewrite_module modules/mod_rewrite.so
2. zet AllowOverride op all
3. test de server (httpd -t)

optional
pas het de server root aan
pas de apps root aan
pas aan op welke poort hij start

#apache commandos
test de config met C:\Apache24/bin/httpd -t

start apache met test C:\Apache24/bin/httpd -k start
stop apache met test C:\Apache24/bin/httpd -k stop

installeer als service met C:\Apache24/bin/httpd -k instal
uninstalleer als service met C:\Apache24/bin/httpd -k uninstal

vraag apache commandos op met C:\Apache24/bin/httpd -h

#Als php gebruikt wordt
Verander de volgende zaken in conf/httpd.conf

Verander: DirectoryIndex index.html naar DirectoryIndex index.php

type onderstaande module onderaan in de config
-# PHP5 Module
LoadModule php5_module "c:/php/php5apache2_4.dll"
AddType application/x-httpd-php .php
PHPIniDir "C:/php"

#installatie
1.
    maak de volgende 2 mappen aan
    c:/mysql
    c:/mysqlData

2.
    download mysql from dev.mysql.com

3.  
    move the dataFolder

4.  
    create a configuration file

    create a my.ini file inside mysql/bin

    add the following code to the file
    [mysqld]
    # installation directory
    basedir="c:/mysql/"

    # data directory
    datadir="c:/mysqlData"

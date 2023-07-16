#Start the service
service mysql start
#Execute script that adds server user into mysql users base
mysql -u root -proot mysql < create-server-user.sql
mysql -u root -proot mysql < initialize-database.sql
#Infinite waiting because tty: true doesn't work
sh -c tail -f /dev/null

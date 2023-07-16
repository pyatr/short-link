CREATE USER IF NOT EXISTS 'server-user'@'short-link-server.short-link-net' IDENTIFIED BY '1234';
GRANT ALL PRIVILEGES ON *.* TO 'server-user'@'short-link-server.short-link-net' WITH GRANT OPTION;
FLUSH PRIVILEGES;

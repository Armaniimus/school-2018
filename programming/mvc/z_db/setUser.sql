CREATE USER 'mvc'@'localhost' IDENTIFIED by 'awsomeness';

GRANT ALL ON mvc.* TO 'mvc'@'localhost';
FLUSH PRIVILEGES;

#Counter
###What it 'Counter'? 
"Counter" is this a simple class where are stored my solutions about tasks what I received.  It's something like qualifying test, which is necessary to pass next step :D
____
###How to install this?
  1. **Install Composer** 

Instal composer after cloning this repository.
```sh
php composer.phar install
```
Composer should download twing framewoork ( for templates )
  2. **Replace fileds**
   
Please fill fields in **config.php** with your: database name, host, login and passord 
   
```php
$config = Array(

  'ENGINE' => 'mysql',
  'HOST'   => 'localhost',
  'USER'   => 'user',
  'PASS'   => 'password',
  'DBNAME' => 'dbname',
  'PORT'   => '3306',
   );
```
   3. You should see nice page ;-)



____
###SAMPLE MYSQL DATA
```php
CREATE TABLE `ELECTRICITY_METER_READS` (
`ID` INT(11) NOT NULL AUTO_INCREMENT,
`READ` DECIMAL(10,2) NOT NULL,
`DATE` DATE NOT NULL,
PRIMARY KEY (`ID`)
) ENGINE=INNODB;

INSERT INTO `ELECTRICITY_METER_READS` (`ID`, `READ`, `DATE`) VALUES
(1, 0.00, '2014-01-01'),
(2, 149.90, '2014-01-30'),
(3, 222.22, '2014-02-15'),
(4, 340.10, '2014-03-03'),
(5, 552.99, '2014-04-15'),
(6, 670.04, '2014-05-10'),
(7, 920.24, '2014-07-01'),
(8, 1000.01,'2014-07-15'),
(9, 1060.40,'2014-08-14'),
(10, 1129.50,'2014-09-02'),
(11, 1290.87,'2014-10-02'),
(12, 1460.16,'2014-11-05'),
(13, 1626.44,'2014-12-01'),
(14, 1818.18,'2014-12-31');

```

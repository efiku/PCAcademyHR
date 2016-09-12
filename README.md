#Counter
###What it 'Counter'? 
"Counter" is this a simple class where are stored my solutions about tasks what I received.  It's something like qualifying test, which is necessary to pass next step :D
____
###How to install this?
1. **Install Composer** 

  Instal composer after cloning this repository.
  ```sh
  php composer.phar update
  ```
  Composer should download twig framewoork ( for templates ) 

2. **Replace fileds**
   
  Please fill fields in **config.php** with your: database name, host, login and password 
     
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
  
3. **Import Table to database from counters.sql file**
4. **You should see nice page**  

:-)

### Based on similar task: 

* https://gist.github.com/efiku/985d617630dbc9006c7e
* https://gist.github.com/efiku/77c57bad5576a93335c5



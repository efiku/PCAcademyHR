**POCZĄTEK ZADANIA**

----------

poniżej znajdziesz zrzut tabeli z bazy mysql z odczytami z wirtualnego licznika prądu. tabela posiada 3 kolumny: id odczytu, wartość wyrażona
w kwh) oraz datę odczytu. twoim zadaniem będzie napisanie skryptu w
języku php, który odczyta i przetworzy te dane.

**1.Napisz kod/funkcję/klasę (wg uznania), która będzie miała za zadanie odbierać z tabeli odczyty z danego okresu i zwracać je w formie tablicy asocjacyjnej (data => odczyt).**

zakładamy że godziny odczytów nie są ważne - na potrzeby późniejszych
zadań możesz założyć, że odczyty miały miejsce zawsze o 00:00:00
danego dnia. jednego dnia może być tyko jeden odczyt. uwaga! jeśli
wybierzemy daty od 10 stycznia do 20 stycznia to skrypt powinien
również pobrać ostatni odczyt z przed 10 stycznia (jeśli nie było tego
dnia odczytu - jest to potrzebne do wykonania kolejnego punktu). dla
ułatwienia załóż, że daty mogą być tylko z 2014 roku.

np. dla wybranego przedziału od 2014-01-15 do 2014-02-15 powinien zwrócić

```php
   ARRAY('
   2014-01-01'=>0,
   '2014-01-30'=>149.90,
   '2014-02-15'=>222.22
   )
```
**2.napisz kod/funkcję/klasę (wg uznania), która używając tablicy zwróconej w pkt. 1 zwróci tablicę zawierającą średnie zużycie energii (z dokładnością do 2 miejsc po przecinku) dla każdego dnia z danego przedziału.**


**dla ułatwienia załóż że daty mogą być tylko z 2014 roku.** 
np. mając trzy przykładowe odczyty: 
1 stycznia 2015 - 200kwh
11. stycznia 2015 - 300kwh 
22. stycznia 2015 - 350kwh. 
 
chcemy poznać średnie dzienne zużycie energii dla przediału 8 do 15 stycznia:

**rozwiązanie:**
między 1 a 11 stycznia zużyto w sumie 100kwh - biorąc pod uwagę że było to 10 dni, to dzienne średnie zużycie wyniosło 10kwh
między 11 a 22 sycznia zużyto w sumie 50kwh - również było to 10 dni więc dzienne średnie zużycie wyniosło 5kwh, więc kod powinien zwrócić tablicę
```php
ARRAY( 
'2015-01-08'=>10.0,
'2015-01-09'=>10.0,
'2015-01-10'=>10.0,
'2015-01-11'=>5.0,
'2015-01-12'=>5.0,
'2015-01-13'=>5.0,
'2015-01-14'=>5.0,
'2015-01-15'=>5.0
);
```
**3.(nieobowiązkowe) - wybierz dowolny system wykresów napisany w języku javascript (np. chart.js, highcharts itp.) i pokaż wykres średniego dziennego zużycia prądu w danym przedziale (wg danych z pkt 2.)**

rozwiązaniem niech będzie jeden plik php lub paczka w formacie zip (w
przypadku jeśli twoje rozwiązanie będzie zawierało więcej niż 1 plik).
wyślij je na adres polcode.hr@polcode.net.

___
**Zrzut tabeli i danych**
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
____

**KONIEC ZADANIA**
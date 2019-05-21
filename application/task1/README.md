PHP OOP / TDD
====================
Stwórz prosty, obiektowy mechanizm koszyka zakupowego wraz z testami jednostkowymi. W tym celu musisz napisać klasy `Product`, `Cart` oraz `Item` oraz odpowiadające im testy.

### Product
- Każdy produkt ma swoją nazwę i cenę. 
- Produkt posiada minimalną liczbę sztuk jaką można zamówić, domyślnie ta wartość wynosi 1

### Cart
- Do koszyka można produkt dodać i usunąć
- Podczas dodawania produktu do koszyka podajemy liczbę sztuk
- Pojedyncza pozycja w koszyku to `Item`, który składa się z produktu oraz ilości sztuk
- Po dodaniu kolejny raz tego samego produktu do koszyka, zwiększana jest wyłącznie jego ilość
- Koszyk powinien posiadać metodę, która zwraca wartość całkowitą zamówienia

### Item
- Powinien składać się z produktu oraz liczby sztuk
- Produkt będący częścią tego obiektu, powinien być niemutowalny
- Powinien pozwalać na zmianę liczby sztuk
- Jeśli zostanie wybrana mniejsza liczba sztuk niż wartość minimalna, która jest zdefiniowana przy produkcie, powinien zostać rzucony wyjątek.


Pilnuj formatowania zgodnego z PSR-2, aby zaakceptował je PHP Code Sniffer.
Koszyk powinien operować na groszach, aby uniknąć błędów operacji zmiennoprzecinkowych.
W pliku composer.json znajdują się potrzebne zależności oraz skonfigurowany autoloading PSR-4

Aby uprościć zadanie, nie przejmuj się przechowywaniem koszyka w sesji ani w bazie danych.
Nie musisz pisać kontrolerów ani widoków.
Zadanie polega tylko na wykonaniu modelu oraz testów jednostkowych.
#include <iostream>

using namespace std;

/*
RESULT:
Promenna a = 10
Ukazatel b = 0x22ac64
Adresa a = 0x22ac64
Hodnota b = 10
Adresy: 0x22ac64=0x22ac64
Honoty: 20=20
 */

/**
 * @param argc
 * @param argv
 * @return
 */
int main(int argc, char** argv) {

    // Inicializace
    int a;
    int *b;

    // Prirazeni
    a = 10;
    b = &a;

    // Vypsani
    cout << "Promenna a = " << a << endl;
    cout << "Ukazatel b = " << b << endl;
    cout << endl;

    cout << "Adresa a = " << &a << endl;
    cout << "Hodnota b = " << *b << endl;
    cout << endl;

    // Zmena hodnoty
    *b = 20;

    cout << "Adresy: " << &a << "=" << b << endl;
    cout << "Honoty: " << a << "=" << *b << endl;

    return 0;
}

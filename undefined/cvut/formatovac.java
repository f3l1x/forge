package FormatovaniTextu;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileWriter;
import java.io.IOException;
import java.util.Scanner;

/**
 *
 * @author Felix
 */
public class FormatovaniTextu {

    // Scanner na cteni ze souboru
    private Scanner scannerFile;
    // pro jednodussi praci pouzijeme StringBuffer
    private StringBuffer dlouhyText = new StringBuffer();
    // defaultni sirka je 20
    private int sirka = 20;

    // Nastavuje sirku
    private void setSirka(int sirka) {
        this.sirka = sirka;
    }

    // Vraci sirku
    private int getSirka() {
        return this.sirka;
    }

    // Vraci dlouhy text
    private String getDlouhyText() {
        return this.dlouhyText.toString();
    }

    private void nacistSoubor(String filename) {
        try {
            // nacteme pres Scanner soubor
            this.scannerFile = new Scanner(new File(filename));

            // pokud mame nejaka data, tak probehne..
            while (scannerFile.hasNext()) {
                // pridame cely radek na konec
                this.dlouhyText.append(this.scannerFile.nextLine());
            }
        } catch (FileNotFoundException ex) {
            System.out.println("Soubor nenalezen");
        }
    }

    private String zformatovat(String text, int sirka) {
        StringBuilder upravenyText = new StringBuilder();

        // pokud je sirka textu mensi nez pozadovana sirka nebo je 0,
        // tak se rovnou vypise
        if (text.length() == 0 || text.length() < sirka) {
            return text;
        }

        // inicializujeme si indexi iOd a iDo, podle kterych dany text rozdelovat
        int iOd = 0;
        int iDo = text.length();

        // cyklus jde tolikrat, kolikrat je potreba dlouhy text rozdelit
        for (int i = 0; i < (text.length() / sirka); i++) {
            iOd = i * sirka;
            iDo = (i + 1) * sirka;

            // aby nam nepretekl index..
            if (iDo > text.length()) {
                iDo = text.length();
            }

            // pridame automaticky na konec
            // novy radek udelame pres \r\n
            upravenyText.append(text.substring(iOd, iDo).trim()).append("\r\n");
        }

        return upravenyText.toString();
    }

    private void ulozitSoubor(String filename, String data) {
        try {
            FileWriter fw = new FileWriter(new File(filename));

            // zapiseme data
            fw.write(data);

            // zavreme fw
            fw.close();

            System.out.println("Data byla ulozena do souboru " + filename);
        } catch (IOException ex) {
            System.out.println("Chyba pri ukladani do souboru.");
        }

    }

    public static void main(String[] args) {
        // vytvorime instanci nasi aplikace
        FormatovaniTextu ft = new FormatovaniTextu();

        // cesta k souborum
        String cesta = "D:/JAVA/CVUT/src/FormatovaniTextu/";

        // nastavime prislusnou sirku
        ft.setSirka(50);

        // nacteme soubor s dlouhym textem
        ft.nacistSoubor(cesta + "data.txt");

        // nechame zformatovat dlouhy text na pozadovanou sirku
        String vystup = ft.zformatovat(ft.getDlouhyText(), ft.getSirka());

        // vsechny data ulozime do souboru
        ft.ulozitSoubor(cesta + "vystup.txt", vystup);
    }
}

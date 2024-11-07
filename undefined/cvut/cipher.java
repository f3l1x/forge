package ALG.Semestralka;

/*
 * 6. Transpoziční šifra: napište program, který pomocí transpozice zašifruje
 * nebo rozšifruje vstupní text ze souboru. Rozměry a přeházení sloupců zadává uživatel heslem.
 *
 * Parametry: vstupní a výstupní soubory, heslo.
 */

import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileWriter;
import java.io.IOException;
import java.util.Arrays;
import java.util.Scanner;

/**
 *
 * @author sulcmil1
 */
public class Cipher {

    // Store password
    private String password;
    // References table (Letter to Position, Position to Letter)
    private int[] stateTable;

    Cipher() {
    }

    TranspozicniSifra(String password) {
        this.setPassword(password);
    }

    private void setPassword(String password) {
        this.password = this.cleanUp(password);
    }

    private int[] getStateTable() {
        return this.stateTable;
    }

    /*
     * Clean string from czech typo, specials chars, etc.
     * @param String str
     * @return String
     */
    private String cleanUp(String str) {
        return str.replaceAll("[^a-zA-Z]", "").replaceAll(" ", "").toUpperCase();
    }

    /*
     * Return int array according to alphabet
     * @param String pw
     * @return int[]
     */
    private int[] getEncryptTable(String pw) {
        int[] table = new int[pw.length()];
        char[] sortmap = pw.toCharArray();
        char[] wordmap = pw.toCharArray();
        // Alphabet sorting..
        Arrays.sort(sortmap);

        // For e.q
        /*
         * Word:     HOUSE
         * Alphabet: 12430
         * Sequence: 40132
         * Return: [4,0,1,3,2]
         */
        for (int i = 0; i < sortmap.length; i++) {
            for (int y = 0; y < wordmap.length; y++) {
                if ((int) sortmap[i] == (int) wordmap[y]) {
                    table[i] = y;
                    wordmap[y] = (char) 0;
                    break;
                }
            }
        }

        return table;
    }

    /*
     * Return overturn encrypt table
     * @param String pw
     * @return int[]
     */
    private int[] getDecryptTable(String pw) {
        int[] table = this.getEncryptTable(pw);
        int[] newTable = new int[table.length];

        // keys become values and values become keys
        for (int i = 0; i < table.length; i++) {
            newTable[table[i]] = i;
        }

        return newTable;
    }


    /*
     * Encryp input string
     * @param String text
     * @return String
     */
    private String encrypt(String text) {
        // Protection
        if (this.password == null) {
            return null;
        }

        // Get reference table
        this.stateTable = this.getEncryptTable(this.password);
        text = this.cleanUp(text);

        // Better then String..
        StringBuilder sb = new StringBuilder();

        // How many cols we have..?
        int cols = (int) Math.ceil((double) text.length() / (double) this.password.length());
        /*
         * Principe:
         * Text: This is my house!
         * Pw: DOG -> 021 (alphabet index of letters)
         * 021
         * DOG
         * ___
         * THI
         * SIS
         * MYH
         * OUS
         * Exx
         * 0 1 2 3 4 5 6 7 8 9 10 11 12 13 14
         * T H I S I S M Y H O U  S  E  x  x
         * Double cycled (password * cols):
         * COL + (ROW*PW.LENGTH) => LETTER
         * 0 + (0*3) => T(0)
         * 0 + (1*3) => S(3)
         * ..
         * 1 + (0*3) => H(1)
         * 1 + (1*3) => I(4)
         * ..
         * 2 + (3*3) => S(11)
         * 2 + (4*3) => x(14)
         * if is index bigger then lenght of text -> put x
         * ..
         * Result: TSMOEISHSXHIYUX
         */
        for (int i = 0; i < this.password.length(); i++) {
            for (int y = 0; y < cols; y++) {
                if (this.stateTable[i] + (y * this.password.length()) >= text.length()) {
                    sb.append("X");
                } else {
                    sb.append(text.charAt(this.stateTable[i] + (y * this.password.length())));
                }
            }
        }

        return sb.toString();
    }

    /*
     * Decryp input string
     * @param String text
     * @return String
     */
    private String decrypt(String text) {
        // Protection
        if (this.password == null) {
            return null;
        }

        // Get reference table
        this.stateTable = this.getDecryptTable(this.password);
        text = this.cleanUp(text);

        // Better then String..
        StringBuilder sb = new StringBuilder();

        // How many cols we have..?
        int cols = (int) Math.ceil((double) text.length() / (double) this.password.length());
        /*
         * Principe:
         * Text: This is my house!
         * Pw: DOG -> 021 (alphabet index of letters)
         * Secured: TSMOEISHSXHIYUX
         * THI
         * SIS
         * MYH
         * OUS
         * Exx
         * Sort pw: DGO -> 021 (index of origin letters) !! (can be different, mostly)
         * 0 1 2 3 4 5 6 7 8 9 10 11 12 13 14
         * T S M O E I S H S X H  I  Y  U  X
         * Double cycled (cols * password):
         * (COLS * POSITION) + ROW => LETTER
         * (5*0) + 0 => T(0)
         * (5*2) + 0 => H(10)
         * (5*1) + 0 => I(5)
         * ..
         * (5*0) + 1 => S(1)
         * (5*2) + 1 => I(11)
         * (5*1) + 1 => S(6)
         * ..
         * ..
         * Result: THISISMYHOUSEXX
         */
        for (int i = 0; i < cols; i++) {
            for (int y = 0; y < this.password.length(); y++) {
                sb.append(text.charAt((cols * this.stateTable[y]) + i));
            }
        }

        return sb.toString();
    }

    /*
     * Read data from file
     * @param String filename
     * @return String
     */
    private String fromFile(String filename) {
        try {
            Scanner sc = new Scanner(new File(filename));
            StringBuilder sb = new StringBuilder();
            while (sc.hasNext()) {
                sb.append(sc.next());
            }

            return sb.toString();
        } catch (FileNotFoundException ex) {
            return "";
        }
    }

    /*
     * Save data to file
     * @param String filename
     * @return String
     */
    private void saveFile(String data, String filename) {
        FileWriter fw = null;
        try {
            fw = new FileWriter(filename);
            fw.write(data);
        } catch (IOException ex) {
        } finally {
            try {
                fw.close();
            } catch (IOException ex) {
            }
        }
    }

    public static void main(String[] args) {

        // Instance
        Cipher cipher = new Cipher();

        Scanner sc = new Scanner(System.in);
        String pw, text;


        System.out.println("Heslo: ");
        cipher.setPassword(sc.next());

        System.out.println("Ze souboru:");
        text = cipher.fromFile(sc.next());

        System.out.println("Do souboru:");
        String filename = sc.next();

        System.out.println("Vyberte volbu:");
        System.out.println("1 = Sifrovat, 2 = Desifrovat");

        int type = sc.nextInt();

        if (type == 1) {
            // Encrypting..
            cipher.saveFile(cipher.encrypt(text), filename);
        } else {
            // Decrypting.
            cipher.saveFile(cipher.decrypt(text), filename);
        }

        /*
         * MANUAL

        // Password
        pw = "test";
        // Crypting text..
        text = "Tohle je nejaky text";



        System.out.println("Encrypt: " + sifra.encrypt(text));
         *
         */
    }
}

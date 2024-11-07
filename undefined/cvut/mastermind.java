import java.util.Arrays;
import java.util.Random;
import java.util.Scanner;

/**
 *
 * @author Felix
 */
public class Game {

    enum GameType {

        NORMAL,
        EASY
    }

    // Constants
    private static final char RIGHT_POSITION = '*';
    private static final char BAD_POSITION = 'o';
    private static final int MIN_NUMBER = 1;
    private static final int MAX_NUMBER = 6;

    // Vars - final
    private final int level;
    private final int[] numbers;

    // Vars
    private int guesses;
    private GameType type;

    public Game(int level) {
        this.level = level;
        this.numbers = new int[level];

        this.guesses = 0;
    }

    public void start() {
        start(GameType.NORMAL);
    }

    public void startEasy() {
        start(GameType.EASY);
    }

    private void start(GameType type) {
        this.type = type;

        // Generate numbers
        generate();

        // Guess numbers
        play();
    }

    private void generate() {
        Random r = new Random();
        for (int i = 0; i < level; i++) {
            numbers[i] = 1 + r.nextInt(MAX_NUMBER - 1);
        }

        if (type == GameType.EASY) {
            System.out.println("***************");
            System.out.println(Arrays.toString(numbers));
            System.out.println("***************");
        }
    }

    private void play() {
        Scanner sc = new Scanner(System.in);
        System.out.println("You have to guess " + level + " numbers.");

        int[] guessNumbers = new int[level];
        int successGuesses = 0;
        int tempGuess;

        do {
            // Increase guesses
            guesses++;

            // Listen for user guessing
            System.out.println("Guess numbers [#" + guesses + "][" + level + " numbers]: ");
            for (int i = 0; i < level; i++) {
                tempGuess = sc.nextInt();

                while (tempGuess < MIN_NUMBER || tempGuess > MAX_NUMBER) {
                    System.out.println("Please guess number in range <" + MIN_NUMBER + "," + MAX_NUMBER + ">:");
                    tempGuess = sc.nextInt();
                }

                guessNumbers[i] = tempGuess;
            }

            // Compare to securite numbers
            System.out.print("Result: ");
            for (int i = 0; i < level; i++) {

                if (guessNumbers[i] == numbers[i]) {
                    // If match number and position
                    System.out.print(RIGHT_POSITION);
                    successGuesses++;
                } else {
                    for (int y = 0; y < level; y++) {
                        // If match number at least
                        if (guessNumbers[i] == numbers[y]) {
                            System.out.print(BAD_POSITION);
                        }
                    }
                }
            }
            System.out.println();
            System.out.println("---------- next round ----------");
        } while (successGuesses != level);

        System.out.println("Finished with " + guesses + " guesses.");
        System.out.println(Arrays.toString(numbers));
    }

}

import java.util.*;

public class BasicAlgorithm {

    WordAnalyzer wa;
    char[] solvedLetters;

    public BasicAlgorithm(WordAnalyzer wa) {
		 solvedLetters = new char[10];
        this.wa = wa;
    }

    /**
     * This method use pretty inefficient way how to find word you're looking
     * for It simply tests every position of 10 characters word to every single
     * letter in an alphabet. Try to beat this and write algorithm with can find
     * the 10 letters long word in fewer steps.
     *
     * @return steps needed to find
     */
    public int solve() {


        char testingLetter = 'a';

        do {

            for (int i = 0; i < 10; i++) {
                if (wa.isLetterAtPosition(testingLetter, i) == true) {
                    solvedLetters[i] = testingLetter;
                }
            }

            testingLetter++;

        } while (wa.testWholeWord(new String(solvedLetters)) != true);
        return wa.doFinal(new String(solvedLetters));
    }
}

public class WebExpoWords {

    public static void main(String[] args) {
        WordAnalyzer wa = new WordAnalyzer();
        BasicAlgorithm ba = new BasicAlgorithm(wa);
        int baSteps = ba.solve();
        System.out.println("Basic algorithm found searched word in " + baSteps + " steps. Can you do better?");

        YourAlgorithm ya = new YourAlgorithm(wa);
        int yaSteps = ya.solve();

    if(yaSteps == 0) {
		System.out.println("Your algorithm can't find searched word in zero steps.");
	} else {
        System.out.println("Your algorithm found searched word in " + yaSteps + " steps.");
        System.out.println("Your have recieved " + (baSteps - yaSteps) + " points");
	}
  }
}

public class WordAnalyzer {

    private int stats;
    private String choosenWord;


    public WordAnalyzer() {
		this.choosenWord = "";
         for (int i = 0; i < 10; i++) {
				Random r = new Random();
				choosenWord += (char) (r.nextInt(26) + 'a');
         }
    }

    public int howMany(char letter) {
        int counter = 0;
		for( int i=0; i<choosenWord.length(); i++ ) {
			if( choosenWord.charAt(i) == letter ) {
				counter++;
			}
		}
		stats++;
		return counter;
    }

    public boolean isLetterAtPosition(char letter, int position) {
        if (choosenWord.charAt(position) == letter) {
            stats++;
            return true;
        } else {
            stats++;
            return false;
        }
    }

    public boolean testWholeWord(String word) {
		stats++;
        if (word.equalsIgnoreCase(choosenWord)) {
            return true;
        } else {
            return false;
        }
    }

    public int getAndNullStats() {
        int steps = stats;
        stats = 0;
        return steps;
    }

    public int doFinal(String foundString) {
		if(testWholeWord(foundString)) {
			System.out.println("You have found the right word");
			return this.getAndNullStats();
          } else {
			  System.out.println("You haven't found the right word");
            return 0;
        }
     }
}

public class YourAlgorithm {

    WordAnalyzer wa; // contains word witch you're looking for
    char[] solvedLetters;

    YourAlgorithm(WordAnalyzer wa) {
        this.solvedLetters = new char[10];
        this.wa = wa;
    }

    /**
     * Implement your algorithm here, get inspitation in BasicAlgorithm.java
     * class.
     *
     * @return steps needed to find
     */
    public int solve() {

        int wordLength = 10;
        int letterCount = 0;
        int letters = 0;
        int steps = 0;
        List<ExpoLetter> lettersList = new ArrayList<>();

        for (int i = (char) 'a'; i <= (char) 'z'; i++) {
            // Break cycle
            if (letters >= wordLength) {
                //System.out.println("Steps: " + steps);
                break;
            }

            // Find letters count
            letterCount = wa.howMany((char) i);
            if (letterCount > 0) {
                lettersList.add(new ExpoLetter((char) i, letterCount));
                letters += letterCount;
            }

            steps++;
        }

        Collections.sort(lettersList);

//        for (ExpoLetter letter : lettersList) {
//            System.out.println(letter.getLetter() + "-" + letter.getCount());
//        }

        for (int i = 0; i < lettersList.size(); i++) {
            ExpoLetter letter = lettersList.get(i);

            int num = 0;
            for (int y = 0; y < wordLength; y++) {

                if (solvedLetters[y] == Character.UNASSIGNED && num < letter.getCount()) {

                    if (i == lettersList.size() - 1) {
                        //System.out.println("Last letter: " + letter.getLetter());
                        solvedLetters[y] = letter.getLetter();
                    } else if (wa.isLetterAtPosition(letter.getLetter(), y)) {
                        solvedLetters[y] = letter.getLetter();
                        num++;
                    }
                }

            }
        }

        // insert your algorithm implementation in here, don't forget to return steps count
        // use mothods from WordAnalyer class

        return wa.doFinal(new String(solvedLetters)); // don't change this
    }

    private class ExpoLetter implements Comparable<ExpoLetter> {

        private char letter;
        private int count;

        public ExpoLetter(char letter, int count) {
            this.letter = letter;
            this.count = count;
        }

        public char getLetter() {
            return letter;
        }

        public int getCount() {
            return count;
        }

        @Override
        public int compareTo(ExpoLetter o) {
            if (count > o.getCount()) {
                return -1;
            } else if (count < o.getCount()) {
                return 1;
            }
            return 0;
        }
    }
}

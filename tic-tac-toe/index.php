<?php
session_start();

// Check if a new game should be started
if (isset($_POST['new_game'])) {
    $_SESSION['board'] = [
        ['', '', ''],
        ['', '', ''],
        ['', '', ''],
    ];
    $_SESSION['currentPlayer'] = PLAYER_X;
    $_SESSION['gameOver'] = false;
    $_SESSION['gameMessage'] = '';
}

// Initialize the game board if it's not set
if (!isset($_SESSION['board'])) {
    $_SESSION['board'] = [
        ['', '', ''],
        ['', '', ''],
        ['', '', ''],
    ];
    $_SESSION['currentPlayer'] = PLAYER_X;
    $_SESSION['gameOver'] = false;
    $_SESSION['gameMessage'] = '';
}

// Define the player symbols
define('PLAYER_X', 'X');
define('PLAYER_O', 'O');

// Function to check if the game is over
function isGameOver($board) {
    return checkWinner(PLAYER_X, $board) || checkWinner(PLAYER_O, $board) || checkTie($board);
}

// Function to check for a win
function checkWinner($player, $board) {
    for ($i = 0; $i < 3; $i++) {
        if (
            ($board[$i][0] === $player && $board[$i][1] === $player && $board[$i][2] === $player) ||
            ($board[0][$i] === $player && $board[1][$i] === $player && $board[2][$i] === $player)
        ) {
            return true;
        }
    }

    if (
        ($board[0][0] === $player && $board[1][1] === $player && $board[2][2] === $player) ||
        ($board[0][2] === $player && $board[1][1] === $player && $board[2][0] === $player)
    ) {
        return true;
    }

    return false;
}

// Function to check for a tie
function checkTie($board) {
    foreach ($board as $row) {
        if (in_array('', $row)) {
            return false;
        }
    }
    return true;
}

// Function to make the AI (player O) move
function makeAIMove($board) {
    $bestMove = minimax($board, PLAYER_O)['move'];
    $board[$bestMove['x']][$bestMove['y']] = PLAYER_O;
    return $board;
}

// Minimax algorithm with Alpha-Beta pruning
function minimax($board, $player, $depth = 0, $alpha = -PHP_INT_MAX, $beta = PHP_INT_MAX) {
    $availableMoves = [];

    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            if ($board[$i][$j] === '') {
                $move = ['x' => $i, 'y' => $j];
                $board[$i][$j] = $player;
                $score = ($player === PLAYER_O) ? -1 : 1;

                if (isGameOver($board)) {
                    if (checkWinner(PLAYER_O, $board)) {
                        $score = 1;
                    } elseif (checkWinner(PLAYER_X, $board)) {
                        $score = -1;
                    } else {
                        $score = 0; // It's a tie
                    }
                } else {
                    $nextPlayer = ($player === PLAYER_O) ? PLAYER_X : PLAYER_O;
                    $result = minimax($board, $nextPlayer, $depth + 1, $alpha, $beta);
                    $score = $result['score'];
                }

                $board[$i][$j] = '';
                $move['score'] = $score;

                if ($player === PLAYER_O) {
                    if ($score > $alpha) {
                        $alpha = $score;
                    }
                } else {
                    if ($score < $beta) {
                        $beta = $score;
                    }
                }

                if ($alpha >= $beta) {
                    break 2;
                }

                $availableMoves[] = $move;
            }
        }
    }

    if ($player === PLAYER_O) {
        $bestScore = -PHP_INT_MAX;
        foreach ($availableMoves as $move) {
            if ($move['score'] > $bestScore) {
                $bestScore = $move['score'];
                $bestMove = $move;
            }
        }
    } else {
        $bestScore = PHP_INT_MAX;
        foreach ($availableMoves as $move) {
            if ($move['score'] < $bestScore) {
                $bestScore = $move['score'];
                $bestMove = $move;
            }
        }
    }

    return ['move' => $bestMove, 'score' => $bestScore];
}

// Handle player moves
if (isset($_POST['x'], $_POST['y']) && !$_SESSION['gameOver']) {
    $x = intval($_POST['x']);
    $y = intval($_POST['y']);

    if ($_SESSION['board'][$x][$y] === '' && $x >= 0 && $x < 3 && $y >= 0 && $y < 3) {
        $_SESSION['board'][$x][$y] = $_SESSION['currentPlayer'];

        if (checkWinner($_SESSION['currentPlayer'], $_SESSION['board'])) {
            $_SESSION['gameMessage'] = 'Player ' . $_SESSION['currentPlayer'] . ' wins!';
            $_SESSION['gameOver'] = true;
        } elseif (checkTie($_SESSION['board'])) {
            $_SESSION['gameMessage'] = "It's a tie!";
            $_SESSION['gameOver'] = true;
        } else {
            // Switch to the other player
            $_SESSION['currentPlayer'] = ($_SESSION['currentPlayer'] === PLAYER_X) ? PLAYER_O : PLAYER_X;
            // Make AI move
            $_SESSION['board'] = makeAIMove($_SESSION['board']);
            if (checkWinner(PLAYER_O, $_SESSION['board'])) {
                $_SESSION['gameMessage'] = 'Player O wins!';
                $_SESSION['gameOver'] = true;
            } elseif (checkTie($_SESSION['board'])) {
                $_SESSION['gameMessage'] = "It's a tie!";
                $_SESSION['gameOver'] = true;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tic-Tac-Toe</title>
    <style>
        table {
            border-collapse: collapse;
        }

        td {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 24px;
            border: 1px solid #000;
        }

        button {
            width: 100%;
            height: 100%;
            border: none;
            background-color: transparent;
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Tic-Tac-Toe</h1>
    <?php if (!$_SESSION['gameOver']) : ?>
        <table>
            <?php for ($i = 0; $i < 3; $i++) : ?>
                <tr>
                    <?php for ($j = 0; $j < 3; $j++) : ?>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="x" value="<?php echo $i; ?>">
                                <input type="hidden" name="y" value="<?php echo $j; ?>">
                                <button type="submit" <?php echo ($_SESSION['board'][$i][$j] !== '') ? 'disabled' : ''; ?>>
                                    <?php echo $_SESSION['board'][$i][$j]; ?>
                                </button>
                            </form>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        </table>
    <?php endif; ?>
    <p><?php echo $_SESSION['gameMessage']; ?></p>
    <form method="POST">
        <button type="submit" name="new_game">Start New Game</button>
    </form>
</body>
</html>

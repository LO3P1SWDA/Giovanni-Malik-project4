let playerRed = "You";
let playerYellow = "Computer/Friend";
let currPlayer = playerRed;

let gameOver = false;
let board;
let currColumns;
let startTime;
let calculatedHighscore; // Global variable to store the calculated highscore
let playerWon = false; // Flag to indicate if the player won

let rows = 6;
let columns = 7;

window.onload = function() {
    setGame();
}

function setGame() {
    board = [];
    currColumns = [5, 5, 5, 5, 5, 5, 5];
    gameOver = false;
    currPlayer = playerRed;
    startTime = new Date();
    calculatedHighscore = null; // Reset highscore at the beginning of the game
    playerWon = false; // Reset the win flag

    document.getElementById("board").innerHTML = "";

    for (let r = 0; r < rows; r++) {
        let row = [];
        for (let c = 0; c < columns; c++) {
            row.push(' ');

            let tile = document.createElement("div");
            tile.id = r.toString() + "-" + c.toString();
            tile.classList.add("tile");
            tile.addEventListener("click", setPiece);
            document.getElementById("board").append(tile);
        }
        board.push(row);
    }

    document.getElementById("winner").innerText = "";
    document.getElementById("restartBtn").style.display = "none"; // Hide restart button initially
    hideHighscore(); // Initially hide highscore and related buttons
}

async function setPiece() {
    if (gameOver) {
        return;
    }

    let coords = this.id.split("-");
    let r = parseInt(coords[0]);
    let c = parseInt(coords[1]);

    r = currColumns[c];
    if (r < 0) {
        return;
    }

    board[r][c] = currPlayer;
    let tile = document.getElementById(r.toString() + "-" + c.toString());

    if (currPlayer == playerRed) {
        tile.classList.add("red-piece");
        currPlayer = playerYellow;
    } else {
        tile.classList.add("yellow-piece");
        currPlayer = playerRed;
    }

    currColumns[c] = r - 1;

    checkWinner();
}

function checkWinner() {
    // Check for horizontal wins
    for (let r = 0; r < rows; r++) {
        for (let c = 0; c <= columns - 4; c++) {
            if (
                board[r][c] !== ' ' &&
                board[r][c] === board[r][c + 1] &&
                board[r][c] === board[r][c + 2] &&
                board[r][c] === board[r][c + 3]
            ) {
                gameOver = true;
                document.getElementById("winner").innerText = `${board[r][c]} wins!`;
                playerWon = board[r][c] === playerRed;
                displayHighscoreAndOptions();
                return;
            }
        }
    }

    // Check for vertical wins
    for (let c = 0; c < columns; c++) {
        for (let r = 0; r <= rows - 4; r++) {
            if (
                board[r][c] !== ' ' &&
                board[r][c] === board[r + 1][c] &&
                board[r][c] === board[r + 2][c] &&
                board[r][c] === board[r + 3][c]
            ) {
                gameOver = true;
                document.getElementById("winner").innerText = `${board[r][c]} wins!`;
                playerWon = board[r][c] === playerRed;
                displayHighscoreAndOptions();
                return;
            }
        }
    }

    // Check for diagonal wins (positive slope)
    for (let r = 0; r <= rows - 4; r++) {
        for (let c = 0; c <= columns - 4; c++) {
            if (
                board[r][c] !== ' ' &&
                board[r][c] === board[r + 1][c + 1] &&
                board[r][c] === board[r + 2][c + 2] &&
                board[r][c] === board[r + 3][c + 3]
            ) {
                gameOver = true;
                document.getElementById("winner").innerText = `${board[r][c]} wins!`;
                playerWon = board[r][c] === playerRed;
                displayHighscoreAndOptions();
                return;
            }
        }
    }

    // Check for diagonal wins (negative slope)
    for (let r = 3; r < rows; r++) {
        for (let c = 0; c <= columns - 4; c++) {
            if (
                board[r][c] !== ' ' &&
                board[r][c] === board[r - 1][c + 1] &&
                board[r][c] === board[r - 2][c + 2] &&
                board[r][c] === board[r - 3][c + 3]
            ) {
                gameOver = true;
                document.getElementById("winner").innerText = `${board[r][c]} wins!`;
                playerWon = board[r][c] === playerRed;
                displayHighscoreAndOptions();
                return;
            }
        }
    }

    // Check for tie
    let isTie = true;
    for (let r = 0; r < rows; r++) {
        for (let c = 0; c < columns; c++) {
            if (board[r][c] === ' ') {
                isTie = false;
                break;
            }
        }
        if (!isTie) break;
    }
    if (isTie) {
        gameOver = true;
        document.getElementById("winner").innerText = "It's a tie!";
        displayRestartButton();
        return;
    }
}

function calculateHighscore() {
    let endTime = new Date(); 
    let timeTakenInSeconds = Math.floor((endTime - startTime) / 1000);
    let highscore = 1500 - timeTakenInSeconds; // Calculate highscore
    console.log("Calculated Highscore inside calculateHighscore: ", highscore); // Log highscore here
    return Math.max(0, highscore); // Ensure highscore is non-negative
}

function displayHighscoreAndOptions() {
    // Calculate highscore and store it in the global variable
    calculatedHighscore = calculateHighscore();
    console.log("Highscore in displayHighscoreAndOptions: ", calculatedHighscore); // Log highscore here

    // Display the highscore using the stored value
    document.getElementById("highscore").innerText = "Your Highscore: " + calculatedHighscore;

    // Show the options based on whether the player won
    if (playerWon) {
        document.getElementById("saveBtn").style.display = "block";
        document.getElementById("deleteBtn").style.display = "block";
    } else {
        document.getElementById("saveBtn").style.display = "none";
        document.getElementById("deleteBtn").style.display = "none";
        hideHighscore(); // Hide highscore and related buttons
        displayRestartButton(); // Show restart button when player loses or ties
    }
}

function displayRestartButton() {
    // Display the restart button
    document.getElementById("restartBtn").style.display = "block";
}

function hideHighscore() {
    // Hide highscore display and buttons
    document.getElementById("highscore").innerText = "";
    document.getElementById("saveBtn").style.display = "none";
    document.getElementById("deleteBtn").style.display = "none";
}

function restart() {
    // Reset all game variables and elements
    setGame();

    // Hide the restart button again
    document.getElementById("restartBtn").style.display = "none";
}

function saveHighscore() {
    // Use the stored highscore value
    console.log("Highscore in saveHighscore: ", calculatedHighscore); // Log highscore here
    let data = {
        game_id: 2, // Example game ID, replace with your actual game ID
        highscore: calculatedHighscore
    };

    $.ajax({
        url: 'save_highscore.php',
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function(response) {
            console.log(response);
            alert("Highscore saved successfully!");
            location.reload(); // Refresh the page
        },
        error: function(xhr, status, error) {
            console.error('Error saving highscore:', error);
            alert("Error saving highscore!");
        }
    });
}

function deleteHighscore() {
    $.ajax({
        url: 'delete_highscore.php',
        type: 'POST',
        success: function(response) {
            console.log(response);
            alert("Highscore deleted successfully!");
            location.reload(); // Refresh the page
        },
        error: function(xhr, status, error) {
            console.error('Error deleting highscore:', error);
            alert("Error deleting highscore!");
        }
    });
}

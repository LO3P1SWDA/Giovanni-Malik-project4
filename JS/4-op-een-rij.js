let playerRed = "You";
let playerYellow = "Computer/Friend";
let currPlayer = playerRed;

let gameOver = false;
let board;
let currColumns;
let startTime; // Declare startTime globally

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
    startTime = new Date(); // Set startTime when the game begins

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
        displayHighscoreAndOptions();
        return;
    }
}

function calculateHighscore() {
    let endTime = new Date(); 
    let timeTakenInSeconds = Math.floor((endTime - startTime) / 1000);
    let highscore = 1500 - timeTakenInSeconds; // Calculate highscore
    return Math.max(0, highscore); // Ensure highscore is non-negative
}
function displayHighscoreAndOptions() {
    // Get the dynamically calculated highscore
    let highscore = calculateHighscore(); // Replace with your function to calculate highscore

    // Display the highscore
    document.getElementById("highscore").innerText = "Your Highscore: " + highscore;

    // Show the options to save or delete the highscore
    document.getElementById("saveBtn").style.display = "block";
    document.getElementById("deleteBtn").style.display = "block";
}

function saveHighscore() {
    let highscore = calculateHighscore();
    let data = {
        game_id: 2, // Example game ID, replace with your actual game ID
        highscore: highscore
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

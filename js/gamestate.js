function saveGameState(gameState, gameName) {
    localStorage.setItem(gameName + 'GameState', JSON.stringify(gameState));
}

function loadGameState(gameName) {
    const gameState = localStorage.getItem(gameName + 'GameState');
    return gameState ? JSON.parse(gameState) : null;
}

function clearGameState(gameName) {
    localStorage.removeItem(gameName + 'GameState');
}
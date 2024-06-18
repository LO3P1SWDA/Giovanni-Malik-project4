document.addEventListener('DOMContentLoaded', () => {
    const cardArray = [
        { name: 'img1', img: '../img/abdel.png' },
        { name: 'img1', img: '../img/abdel.png' },
        { name: 'img2', img: '../img/hachim.png' },
        { name: 'img2', img: '../img/hachim.png' },
        { name: 'img3', img: '../img/anass.png' },
        { name: 'img3', img: '../img/anass.png' },
        { name: 'img4', img: '../img/mo.png' },
        { name: 'img4', img: '../img/mo.png' },
        { name: 'img5', img: '../img/amine.png' },
        { name: 'img5', img: '../img/amine.png' },
        { name: 'img6', img: '../img/gio.png' },
        { name: 'img6', img: '../img/gio.png' },
        { name: 'img7', img: '../img/aleksa.png' },
        { name: 'img7', img: '../img/aleksa.png' },
        { name: 'img8', img: '../img/mehmet.png' },
        { name: 'img8', img: '../img/mehmet.png' }
    ];
    cardArray.sort(() => 0.5 - Math.random());

    const gameBoard = document.getElementById('gameBoard');
    const cardsChosen = [];
    const cardsChosenId = [];
    let cardsMatched = JSON.parse(localStorage.getItem('cardsMatched')) || [];

    function createBoard() {
        cardArray.forEach((item, index) => {
            const card = document.createElement('div');
            card.setAttribute('class', 'card');
            card.setAttribute('data-id', index);
            card.addEventListener('click', flipCard);

            const back = document.createElement('img');
            back.setAttribute('src', 'https://images.samsung.com/is/image/samsung/p6pim/nl/mb-sy256s-ww/gallery/nl-memory-cardpro-ultimate-sd-card-476547-mb-sy256s-ww-538071692?$650_519_PNG$');
            back.setAttribute('class', 'back');

            const front = document.createElement('img');
            front.setAttribute('src', item.img);
            front.setAttribute('class', 'front');

            card.appendChild(back);
            card.appendChild(front);
            gameBoard.appendChild(card);

            // Check if this card is already matched and update UI
            if (cardsMatched.includes(item.name)) {
                card.classList.add('matched', 'disabled');
            }
        });
    }

    function checkForMatch() {
        const cards = document.querySelectorAll('.card');
        const [optionOneId, optionTwoId] = cardsChosenId;

        if (cardsChosen[0] === cardsChosen[1]) {
            cards[optionOneId].classList.add('matched', 'disabled');
            cards[optionTwoId].classList.add('matched', 'disabled');
            cardsMatched.push(cardArray[optionOneId].name);

            // Save matched images to localStorage
            localStorage.setItem('cardsMatched', JSON.stringify(cardsMatched));
        } else {
            cards[optionOneId].classList.add('mismatch');
            cards[optionTwoId].classList.add('mismatch');
            setTimeout(() => {
                cards[optionOneId].classList.remove('flipped', 'mismatch');
                cards[optionTwoId].classList.remove('flipped', 'mismatch');
            }, 1000);
        }

        cardsChosen.length = 0;
        cardsChosenId.length = 0;

        if (cardsMatched.length === cardArray.length / 2) {
            setTimeout(() => {
                alert('Congratulations! You found all matches!');
                localStorage.removeItem('cardsMatched'); // Clear saved matches on completion
                window.location.reload();
            }, 500);
        }
    }

    function flipCard() {
        if (this.classList.contains('disabled') || cardsChosen.length === 2) {
            return;
        }

        const cardId = this.getAttribute('data-id');
        if (!cardsChosenId.includes(cardId) && cardsChosen.length < 2) {
            this.classList.add('flipped');
            cardsChosen.push(cardArray[cardId].name);
            cardsChosenId.push(cardId);

            if (cardsChosen.length === 2) {
                setTimeout(checkForMatch, 500);
            }
        }
    }

    createBoard();
});
const choices = document.querySelectorAll('#rock, #paper, #scissors');
const options = ['rock', 'paper', 'scissors'];
const text = document.getElementById('hover-text');
let userOption;
let compChoice;
let userWon;

choices.forEach((k) => {
    k.addEventListener('click', () => {
        userOption = k.id;
        compChoice = options[Math.floor(Math.random() * (options.length))];
        if (userOption === compChoice) {
            userWon = 'draw';
            text.textContent = `I guess we drew I chose ${compChoice}`;
        } else if ((userOption === 'rock' && compChoice === 'scissors') ||
            (userOption === 'scissors' && compChoice === 'paper') ||
            (userOption === 'paper' && compChoice === 'rock')
        ) {
            userWon = true;
        } else {
            userWon = false;
        }

        if (userWon === true && userWon !== 'draw') {
            text.textContent = `Oh you beat me I chose ${compChoice}`;
        } else if (userWon === false) {
            text.textContent = `ha ha I win I chose ${compChoice}`;
        }
    });
});
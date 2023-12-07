const fs = require('node:fs');
let answerA = 0;

const quickSort = (arr) => {
    if(arr.length <= 1) {
        return arr;
    }
    let pivot = arr[0];
    let leftArr = [];
    let rightArr = [];

    for(let i = 1; i < arr.length; i++) {
        //is arr[i] a better hand than pivot?
        if(arr[i].score < pivot.score) {
            leftArr.push(arr[i]);
        }
        else if(arr[i].score > pivot.score) {
            rightArr.push(arr[i]);
        }
        else {
            if(arr[i].hex < pivot.hex) {
                leftArr.push(arr[i]);
            }
            else {
                rightArr.push(arr[i]);
            }
        }
    }
    return [...quickSort(leftArr), pivot, ...quickSort(rightArr)];
}

const handType = (cards) => {
    let score = 0;
    let found = new Map();
    cards.forEach((card) => {
        found.set(card, found.has(card) ? found.get(card) + 1 : 1);
    });
    switch(found.size) {
         //five of a kind
        case 1: score = 7; break;
        //four of a kind OR full house
        case 2:
            let foak = false;
            found.forEach((count, card) => { if(count == 4) foak = true; });
            score = foak ? 6 : 5;
            break;
        //three of a kind OR two pair
        case 3:
            let toak = false;
            found.forEach((count, card) => { if(count == 3) toak = true; });
            score = toak ? 4 : 3;
            break; 
        case 4: score = 2; break; //one pair
        case 5: score = 1; break; //high card

    }
    return score;
}

const handTotal = (cards) => {
    let total = 0;
    for(i = 1; i <= cards.length; i++) {
        let cardText = cards[cards.length - i]
        let cardValue = cardText.replace("T","10").replace("J","11").replace("Q","12").replace("K","13").replace("A","14") * 1;
        total += cardValue * (16 ** (i-1));
    }
    return total;
}

try {
    const input = fs.readFileSync('07-input.txt', 'utf8');
    const lines = input.split("\r\n");
    let hands = [];
    lines.forEach((line) => {
        let hand = line.substring(0,5);
        let cards = hand.split('');
        let strength = line.substring(5) * 1;
        let score = handType(cards);
        let hex = handTotal(cards);
        hands.push({hand:hand,cards:cards,strength:strength,score:score,hex:hex});
    });
    //console.log(hands);
    const sorted = quickSort(hands);
    //console.log(sorted);
    for(let i = 0; i<sorted.length; i++) {
        console.log(i+1, sorted[i].strength)
        answerA += sorted[i].strength * (i+1);
    }
}
catch(e) {
    console.error(e);
}

console.log("The answer to part 1 is:", answerA);
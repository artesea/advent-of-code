const fs = require('node:fs');
let answerB = 0;
try {
    const input = fs.readFileSync('04-input.txt', 'utf8');
    const lines = input.split("\r\n");
    let cardCount = Array(lines.length + 1).fill(1);
    cardCount[0] = 0; //set this to zero as we aren't using the zero index
    for(let row = 0; row<lines.length; row++) {
        const line = lines[row];
        console.log(line);
        //Card   1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53
        const cardId = line.match(/\d+/)[0] * 1;
        const winningNumbers = line.split(":")[1].split("|")[0].match(/(\d+)/g);
        const myNumbers = line.split(":")[1].split("|")[1].match(/(\d+)/g);
        let found = 0;
        winningNumbers.forEach((winningNumber) => {
            if( myNumbers.includes(winningNumber)) {
                found++;
            }
        });
        let lineScore = 0;
        if(found > 0) lineScore = 2**(found-1);
        console.log({line,cardId,winningNumbers,myNumbers,found,lineScore});
        for(let i = 1; i <= found; i++) {
            cardCount[cardId + i] += cardCount[cardId];
        }
    };
    console.log(cardCount);
    cardCount.forEach((val) => {
        answerB += val;
    });
}
catch(e) {
    console.error(e);
}

console.log("The answer to part 2 is:", answerB);
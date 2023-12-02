const fs = require('node:fs');
let answerA = 0;
try {
    const input = fs.readFileSync('02-input.txt', 'utf8');
    const lines = input.split("\r\n");
    lines.forEach((line) => {
        const gameId = line.match(/Game (\d+):/)[1] * 1;
        const picks = line.substring(line.indexOf(':') + 1).split(";");
        let greenMax = 0;
        let redMax = 0;
        let blueMax = 0;
        picks.forEach((pick) => {
            const greenPick = findColour(pick, 'green');
            const redPick = findColour(pick, 'red');
            const bluePick = findColour(pick, 'blue');
            greenMax = Math.max(greenMax, greenPick);
            redMax = Math.max(redMax, redPick);
            blueMax = Math.max(blueMax, bluePick);
            //console.log({pick, greenPick, redPick, bluePick});
        });
        if(redMax <= 12 && greenMax <= 13 && blueMax <= 14) {
            //console.log({line, gameId, redMax, greenMax, blueMax});
            answerA += gameId;
        }
        const bits = line.match(/(\d+) (red|green|blue)/g);
    });
}
catch(e) {
    console.error(e);
}

function findColour(pick, colour) {
    let res = 0;
    const regex = new RegExp('\(\\d+\) ' + colour);
    const found = pick.match(regex);
    if(found) res = found[1] * 1;
    return res;
}

console.log("The answer to part 1 is:", answerA);


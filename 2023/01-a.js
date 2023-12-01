const fs = require('node:fs');
let answerA = 0;
try {
    const input = fs.readFileSync('01-input.txt', 'utf8').replaceAll("\r","");
    const lines = input.split("\n");
    lines.forEach((line) => {
        const digits = line.match(/\d/g);
        let lineScore = (10 * digits[0]) + (1 * digits[digits.length - 1]);
        //console.log(line, digits, lineScore);
        answerA += lineScore;
    });
}
catch(e) {
    console.error(e);
}

console.log("The answer to part 1 is:", answerA);


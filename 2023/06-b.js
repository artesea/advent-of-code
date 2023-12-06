const fs = require('node:fs');
let answerB = 1;
try {
    const input = fs.readFileSync('06-input.txt', 'utf8').replaceAll(" ","");
    const lines = input.split("\r\n");
    const times = lines[0].match(/\d+/g);
    const distances = lines[1].match(/\d+/g);
    for(let i = 0; i<times.length; i++) {
        let raceWays = 0;
        for(let t = 0; t<= (times[i] * 1); t++) {
            const speed = t;
            const time = (times[i] * 1) - t;
            if((distances[i] * 1) < (speed * time)) {
                raceWays++;
            }
        }
        console.log({i,raceWays});
        answerB *= raceWays;
    }
}
catch(e) {
    console.error(e);
}

console.log("The answer to part 2 is:", answerB);
const fs = require('node:fs');
let answerB = 0;
let gears = [];
try {
    const input = fs.readFileSync('03-input.txt', 'utf8');
    const lines = input.split("\r\n");
    for(let row = 0; row<lines.length; row++) {
        const line = lines[row];
        //console.log(line);
        const matches = line.matchAll(/(\d+)/g);
        for(const wholeNumber of matches) {
            //need to scan around the match
            let adjacent = false;
            let xMin = Math.max(0, wholeNumber.index - 1);
            let xMax = Math.min(line.length - 1, wholeNumber.index + wholeNumber[0].length);
            let yMin = Math.max(0, row-1);
            let yMax = Math.min(lines.length - 1, row+1);
            for(let x = xMin; x <= xMax; x++) {
                for(let y = yMin; y <= yMax; y++) {
                    if(lines[y][x].match(/\*/)) {
                        if(gears[y] === undefined) gears[y] = [];
                        if(gears[y][x] === undefined) gears[y][x] = [];
                        gears[y][x].push(wholeNumber[0] * 1);
                    }
                }
            }
            if(adjacent) answerA += (wholeNumber[0] * 1);
            //console.log(row, wholeNumber[0], adjacent);
        };
    };
    //find any gears with exactly two numbers
    gears.forEach((row, y) => {
        row.forEach((vals, x) => {
            if(vals.length == 2) {
                let gearRatio = vals[0] * vals[1];
                //console.log({y,x,vals,gearRatio});
                answerB += gearRatio;
            }
        })
    });
}
catch(e) {
    console.error(e);
}

console.log("The answer to part 2 is:", answerB);
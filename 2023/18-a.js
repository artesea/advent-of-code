const st = new Date().getTime();
const fs = require('node:fs');
let answer = 0;
try {
    const input = fs.readFileSync('18-sample.txt', 'utf8').trim();
    const lines = input.split("\r\n");
    let lagoon = [];
    let col = 0;
    let row = 0;
    let maxcol = 0;
    let maxrow = 0;
    let mincol = 0;
    let minrow = 0;
    lagoon[0] = ['#'];
    lines.forEach((line) => {
        let [,dir, metres, colour] = line.match(/([UDLR]) (\d+) \(#([\da-f]{6})\)/);
        metres *= 1;
        //console.log({dir,metres,colour});
        switch(dir) {
            case 'U':
                for(let r = row - 1; r >= row - metres; r--) {
                    if(lagoon[r] === undefined) lagoon[r] = [];
                    lagoon[r][col] = '#'; //should be mapping edge colours around here!
                }
                row -= metres;
                break;
            case 'D':
                for(let r = row + 1; r <= row + metres; r++) {
                    if(lagoon[r] === undefined) lagoon[r] = [];
                    lagoon[r][col] = '#'; //should be mapping edge colours around here!
                }
                row += metres;
                break;
            case 'L':
                for(let c = col - 1; c >= col - metres; c--) {
                    lagoon[row][c] = '#'; //should be mapping edge colours around here!
                }
                col -= metres;
                break;
            case 'R':
                for(let c = col + 1; c <= col + metres; c++) {
                    lagoon[row][c] = '#'; //should be mapping edge colours around here!
                }
                col += metres;
                break;
        }
        mincol = Math.min(mincol, col);
        maxcol = Math.max(maxcol, col);
        minrow = Math.min(minrow, row);
        maxrow = Math.max(maxrow, row);
    });
    let temp = "";
    for(r=minrow;r<=maxrow;r++) {
        for(c=mincol;c<=maxcol;c++) {
            if(lagoon[r][c] === undefined) lagoon[r][c] = '.';
            temp+=lagoon[r][c];
        }
        temp+="\n";
    }
    //let temp = lagoon.map((row) => row.join("")).join("\n");
    console.log(temp);        
}
catch(e) {
    console.error(e);
}
const et = new Date().getTime();
const tt = (et-st)/1000;

console.log("The answer is:", answer,`\nTime taken ${tt}s`);
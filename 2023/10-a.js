const fs = require('node:fs');
let answer = 0;
try {
    const input = fs.readFileSync('10-input.txt', 'utf8');
    let lines = input.split("\r\n");
    let padding = "".padStart(lines[0].length,".");
    lines.unshift(padding);
    lines.push(padding);
    let cells = [];
    let start = [0,0];
    for(let y=0;y<lines.length;y++) {
        let line = "." + lines[y] + "."
        cells.push(line.split(""));
        if(line.indexOf("S") != -1) {
            start = [y,line.indexOf("S")];
        }
    }

    let x = start[1];
    let y = start[0];
    let direction = 'X';
    if(['F','7','|'].indexOf(cells[y-1][x]) != -1) {
        direction = 'N'; 
        y--;
    }
    else if(['-','7','J'].indexOf(cells[y][x+1]) != -1) {
        direction = 'E';
        x++;
    }
    else if(['|','L','J'].indexOf(cells[y+1][x]) != -1) {
        direction = 'S';
        y++;
    }
    answer++;

    //now loop until we reach back to S
    while(true) {
        let next = cells[y][x];
        if(next == 'S') break;
        let command = direction + next;
        switch(command) {
            case 'NF':
            case 'E-':
            case 'SL': direction = 'E'; x++; break;
            case 'N|':
            case 'EJ':
            case 'WL': direction = 'N'; y--; break;
            case 'N7':
            case 'SJ':
            case 'W-': direction = 'W'; x--; break;
            case 'E7':
            case 'S|':
            case 'WF': direction = 'S'; y++; break;
            default: let hi = "ryan";
        }
        answer++;
    }
    answer /= 2;

}
catch(e) {
    console.error(e);
}

console.log("The answer is:", answer);
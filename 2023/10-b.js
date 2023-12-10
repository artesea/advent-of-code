const fs = require('node:fs');
let answer = 0;
try {
    const input = fs.readFileSync('10-sample.txt', 'utf8');
    let lines = input.split("\r\n");
    let padding = "".padStart(lines[0].length,".");
    lines.unshift(padding);
    lines.push(padding);
    let cells = [];
    let iop = new Array(lines.length*2).fill(0).map(() => new Array((lines[0].length+2)*2).fill('.'));
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
    let a = x*2;
    let b = y*2;
    iop[b][a] = '#';
    let direction = 'X';
    if(['F','7','|'].indexOf(cells[y-1][x]) != -1) {
        direction = 'N'; 
        y--;
        iop[b-1][a] = '#';
    }
    else if(['-','7','J'].indexOf(cells[y][x+1]) != -1) {
        direction = 'E';
        iop[b][a+1] = '#';
        x++;
    }
    else if(['|','L','J'].indexOf(cells[y+1][x]) != -1) {
        direction = 'S';
        iop[b+1][a] = '#';
        y++;
    }

    //now loop until we reach back to S
    while(true) {
        a = x*2; b = y*2;
        iop[b][a] = '#';
        let next = cells[y][x];
        if(next == 'S') break;
        let command = direction + next;
        switch(command) {
            case 'NF':
            case 'E-':
            case 'SL': direction = 'E'; x++; iop[b][a+1] = '#'; break;
            case 'N|':
            case 'EJ':
            case 'WL': direction = 'N'; y--; iop[b-1][a] = '#'; break;
            case 'N7':
            case 'SJ':
            case 'W-': direction = 'W'; x--; iop[b][a-1] = '#'; break;
            case 'E7':
            case 'S|':
            case 'WF': direction = 'S'; y++; iop[b+1][a] = '#'; break;
        }
    }

    let bmax = iop.length - 1;
    let amax = iop[0].length - 1;

    /*
    //BAD FUNCTION GIVES
    //RangeError: Maximum call stack size exceeded
    const fillmap = (b,a) => {
        if(a >= 0 && b >= 0 && a <= amax && b <= bmax && iop[b][a] == '.') {
            iop[b][a] = 'O';
            fillmap(b-1,a);
            fillmap(b+1,a);
            fillmap(b,a+1);
            fillmap(b,a-1);
        }
    }
    */

    const fillmap = (b,a) => {
        let stack = [{b:b,a:a}];
        const directions = [[0,1],[0,-1],[1,0],[-1,0]]
        while(stack.length > 0) {
            let current = stack.pop();
            for (let i = 0; i < 4; i++) {
                let child = {b:current.b + directions[i][0], a:current.a+directions[i][1]}
                if(child.a >= 0 && child.a <= amax && child.b >= 0 && child.b <= bmax && iop[child.b][child.a] == '.') {
                    iop[child.b][child.a] = 'O';
                    stack.push(child);
                }
            }
        }
    }

    fillmap(0,0);

    //find inners
    for(let b = 0; b < bmax; b+=2) {
        for(let a = 0; a < amax; a+=2) {
            if(iop[b][a] == '.') {
                answer++;
                iop[b][a] = 'I';
            }
        }
    }
}
catch(e) {
    console.error(e);
}

console.log("The answer is:", answer);
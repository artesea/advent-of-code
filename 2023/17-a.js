const st = new Date().getTime();
const fs = require('node:fs');
let answer = 0;
try {
    const input = fs.readFileSync('17-sample.txt', 'utf8').trim();
    const grid = input.split("\r\n").map((row) => row.split(""));

    let starts = [];
    for(let c = 0; c < grid[0].length; c++) {
        starts.push({col:c,row:0,dir:180});
        starts.push({col:c,row:grid.length-1,dir:0});
    }
    for(let r = 0; r < grid.length; r++) {
        starts.push({col:0,row:r,dir:90});
        starts.push({col:grid[0].length-1,row:r,dir:270});
    }
    starts.forEach((start) => {
        let shift = [];
        shift[0]   = [-1, 0];
        shift[90]  = [ 0, 1];
        shift[180] = [ 1, 0];
        shift[270] = [ 0,-1];
        let nodes = new Map();
        let output = [...Array(grid.length)].map(_=>Array(grid[0].length).fill("."));  
        let queue = [start];
        while(queue.length > 0) {
            let check = queue.pop();
            let row = check.row;
            let col = check.col;
            let dir = check.dir;
            let key = `${row}/${col}/${dir}`;
            if(nodes.has(key)) {
                //do nothing, already have this
                //console.log('Hit mapping',check);
                continue;
            }
            nodes.set(key, 1);
            if(row < 0 || row >= grid.length || col < 0 || col >= grid[0].length) {
                //out of bounds, end;
                //console.log('Out of bounds', check);
            }
            else {
                let cell = grid[row][col];
                let newdirs = [];
                output[row][col] = '#';
                if(cell == "|" && (dir == 90 || dir == 270)) {
                    newdirs = [0,180];
                }
                else if(cell == "-" && (dir == 0 || dir == 180)) {
                    newdirs = [90,270];
                }
                else if(cell == "/") {
                    switch(dir) {
                        case 0: newdirs = [90]; break;
                        case 90: newdirs = [0]; break;
                        case 180: newdirs = [270]; break;
                        case 270: newdirs = [180]; break;
                    }
                }
                else if(cell == "\\") {
                    switch(dir) {
                        case 0: newdirs = [270]; break;
                        case 90: newdirs = [180]; break;
                        case 180: newdirs = [90]; break;
                        case 270: newdirs = [0]; break;
                    }
                }
                else { //if(cell == ".") {
                    newdirs = [dir];
                    //pass through in same direction
                }
                newdirs.forEach((newdir) => queue.push({col:col+shift[newdir][1],row:row+shift[newdir][0],dir:newdir}));

            }
        }
        //let temp = output.map((row) => row.join("")).join("\n");
        //console.log(temp);
        let startanswer = output.flat().filter((x) => x == '#').length;
        //console.log(start,startanswer);
        answer = Math.max(startanswer, answer);
    });
}
catch(e) {
    console.error(e);
}
const et = new Date().getTime();
const tt = (et-st)/1000;

console.log("The answer is:", answer,`\nTime taken ${tt}s`);
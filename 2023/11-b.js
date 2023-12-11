const fs = require('node:fs');
let answer = 0;
try {
    const expansion = 1000000 - 1;
    const input = fs.readFileSync('11-input.txt', 'utf8');
    const lines = input.split("\r\n");
    const grid = lines.map((line) => line.split(""));
    let expandedcols = [];
    let expandedrows = [];
    let colcache = [];
    let galaxies = [];
    for(let r = 0; r < grid.length; r++) {
        if(grid[r].includes("#") == false) {
            expandedrows.push(r);
        }
        for(let c = 0; c < grid[0].length; c++) {
            if(r==0) colcache[c] = true;
            if(grid[r][c] == '#') {
                galaxies.push([r,c]);
                colcache[c] = false;
            }
        }
    }
    colcache.forEach((v,k) => {
        if(v == true) expandedcols.push(k);
    });
    //console.log(grid);


    for(a = 0; a < galaxies.length - 1; a++) {
        for(b = a+1; b < galaxies.length; b++) {
            let dist = Math.abs(galaxies[a][0] - galaxies[b][0]) + Math.abs(galaxies[a][1] - galaxies[b][1]);
            expandedcols.forEach((col) => {
                if(Math.min(galaxies[a][1],galaxies[b][1]) < col && Math.max(galaxies[a][1],galaxies[b][1]) > col) {
                    dist += expansion;
                }
            });
            expandedrows.forEach((row) => {
                if(Math.min(galaxies[a][0],galaxies[b][0]) < row && Math.max(galaxies[a][0],galaxies[b][0]) > row) {
                    dist += expansion;
                }
            });
            //console.log(a,galaxies[a],b,galaxies[b],dist);
            answer+= dist;
        }
    }
}
catch(e) {
    console.error(e);
}

console.log("The answer is:", answer);
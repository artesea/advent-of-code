const fs = require('node:fs');
let answer = 0;
try {
    const input = fs.readFileSync('11-input.txt', 'utf8');
    const lines = input.split("\r\n");
    let expanded = []
    lines.forEach((line) => {
        const points = line.split("");
        if(points.includes("#") == false) {
            expanded.push(points);
        }
        expanded.push(points);
    });

    let flipped = expanded[0].map((col,c) => expanded.map((row, r) => expanded[r][c]));

    expanded = []
    flipped.forEach((points) => {
        if(points.includes("#") == false) {
            expanded.push(points);
        }
        expanded.push(points);
    });

    flipped = expanded[0].map((col,c) => expanded.map((row, r) => expanded[r][c]));

    let galaxies = []
    let debug = '';
    for(let r = 0; r < flipped.length; r++) {
        debug += flipped[r].join('') + "\n";
        for(let c = 0; c < flipped[0].length; c++) {
            if(flipped[r][c] == '#') {
                galaxies.push([r,c]);
            }
        }
    }
    //console.log(debug);
    //console.log(galaxies);

    for(a = 0; a < galaxies.length - 1; a++) {
        for(b = a+1; b < galaxies.length; b++) {
            let dist = Math.abs(galaxies[a][0] - galaxies[b][0]) + Math.abs(galaxies[a][1] - galaxies[b][1]);
            console.log(a,b,dist);
            answer+= dist;
        }
    }
}
catch(e) {
    console.error(e);
}

console.log("The answer is:", answer);
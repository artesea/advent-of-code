const fs = require('node:fs');
let answer = 0;
try {
    const input = fs.readFileSync('13-input.txt', 'utf8');
    const patterns = input.split("\r\n\r\n");
    let p = 0;
    patterns.forEach((pattern) => {
        const rows = pattern.split("\r\n");
        const grid = rows.map((rows) => rows.split(""));
        const flipped = grid[0].map((col,c) => grid.map((row, r) => grid[r][c]));
        const cols = flipped.map((col) => col.join(""));

        let fr = 0; let fc = 0;
        //hunt for reflection
        for(let c=1;c<cols.length;c++) {
            let maxLength = Math.min(c, cols.length - c);
            let left = cols.slice(c-maxLength,c);
            let right = cols.slice(c,c+maxLength);
            right.reverse();
            if(left.toString() === right.toString()) {
                if(fc != 0) {
                    console.log("TWO COLUMN REFLECTIONS", pattern, fc, c);
                }
                answer += c;
                fc = c;
            }
        }        
        for(let r=1;r<rows.length;r++) {
            let maxLength = Math.min(r, rows.length - r);
            let top = rows.slice(r-maxLength,r);
            let bottom = rows.slice(r,r+maxLength);
            bottom.reverse();
            if(top.toString() === bottom.toString()) {
                if(fr != 0) {
                    console.log("TWO ROW REFLECTIONS", pattern, fr, r);
                }
                answer += (r * 100);
                fr = r;
            }
        }

        if(fr != 0 && fc != 0) {
            console.log("HERE");
        }
        if(fr == 0 && fc == 0) {
            console.log(`\n${p} NO REFLECTIONS\n`, pattern);
        }
        //console.log(pattern, fr, fc, answer);
        //console.log("\n\n");
        p++;
    });
}
catch(e) {
    console.error(e);
}

console.log("The answer is:", answer);
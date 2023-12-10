const fs = require('node:fs');
let answer = 0;
try {
    const input = fs.readFileSync('09-input.txt', 'utf8');
    const lines = input.split("\r\n");
    lines.forEach((line) => {
        let i = 0;
        let track = [];
        const nums = line.match(/\-?\d+/g).map((n) => n * 1);
        track.push(nums);
        while(true) {
            let allzero = true;
            for(let x = 0; x < track[i].length - 1; x++) {
                let diff = track[i][x+1] - track[i][x];
                if(x==0) track[i+1] = [];
                track[i+1][x] = diff;
                allzero = allzero && (diff == 0);
            }
            i++;
            if(allzero) break;
        }
        //console.log(track);
        track[i].unshift(0);
        //work backwards through track
        for(i--;i>=0;i--) {
            lineanswer = track[i][0] - track[i+1][0];
            track[i].unshift(lineanswer);
        }
        //console.log(track);
        console.log(lineanswer, line);
        answer += lineanswer;
    });
}
catch(e) {
    console.error(e);
}

console.log("The answer is:", answer);
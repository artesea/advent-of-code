const fs = require('node:fs');
let answerB = -1;
try {
    let mem = new Map();
    const input = fs.readFileSync('05-input.txt', 'utf8') + "\r\n"; //hack to add new lines to end to trigger output cal at end of loop
    const lines = input.split("\r\n");
    const seeds = lines[0].match(/\d+/g);
    for(let a = 0; a < seeds.length; a+=2) {
        console.log(`Checkings seeds`, (seeds[a]*1), `to`, (seeds[a]*1)+(seeds[a+1]*1)-1);
        for(let b = 0; b < (seeds[a+1] * 1); b++) {
            let input = (seeds[a] * 1) + b;
            let output = -1;
            let seed = input;
            //console.log("\nLOOKING AT SEED", input);
            if(mem.has(seed) == false) {
                for(let row = 1; row<lines.length; row++) {
                    const line = lines[row];
                    if(line.trim() == '') {
                        if(output == -1) output = input;
                        //console.log(`${input} ==> ${output}`);
                        input = output;
                        output = -1;
                    }
                    else {
                        if(line.indexOf(":") != -1) {
                            //console.log(line);
                        }
                        else if(output == -1) {
                            const bits = line.match(/\d+/g);
                            if(input >= (bits[1] * 1) && input < (bits[1] * 1) + (bits[2] * 1)) {
                                output = input + (bits[0] * 1) - (bits[1] * 1);
                            }
                        }
                    }
                }
                //console.log(input);
                if(answerB == -1) {
                    answerB = input;
                }
                else {
                    answerB = Math.min(answerB, input);
                }
                mem.set(seed, input);
            }
        }
    }
}
catch(e) {
    console.error(e);
}

console.log("The answer to part 2 is:", answerB);
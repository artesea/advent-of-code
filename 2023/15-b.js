const fs = require('node:fs');
let answer = 0;
try {
    const input = fs.readFileSync('15-input.txt', 'utf8').trim();
    const hashes = input.split(",");
    let hashmap = [];
    hashes.forEach((hash) => {
        const [,label,action,lens] = hash.match(/([a-z]+)([\-=])(\d?)/);
        let cs = 0;
        for(let i=0; i<label.length;i++) {
            let ac = label.charCodeAt(i);
            cs += ac;
            cs *= 17;
            cs = cs % 256;
        }
        console.log(hash, label, action, lens, cs);
        let i = -1;
        if(hashmap[cs] === undefined) hashmap[cs] = [];
        if(hashmap[cs].length > 0) {
            i = hashmap[cs].findIndex((e) => e.label == label);
        }
        if(i == -1) {
            if(action == '=') {
                hashmap[cs].push({label:label,lens:lens});
            }
        }
        else {
            if(action == '=') {
                hashmap[cs][i].lens = lens;
            }
            else {
                hashmap[cs].splice(i,1);
            }
        }
    });

    //calc focusing power
    for(let i=0;i<256;i++) {
        if(hashmap[i] !== undefined) {
            for(let j=0;j<hashmap[i].length;j++) {
                let power = (i+1)*(j+1)*(hashmap[i][j].lens);
                console.log(i,j,hashmap[i][j],power);
                answer += power;
            }
        }
    }

}
catch(e) {
    console.error(e);
}

console.log("The answer is:", answer);
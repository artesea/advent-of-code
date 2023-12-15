const fs = require('node:fs');
let answer = 0;
try {
    const input = fs.readFileSync('15-input.txt', 'utf8').trim();
    const hashes = input.split(",");
    hashes.forEach((hash) => {
        let cs = 0;
        for(let i=0; i<hash.length;i++) {
            let ac = hash.charCodeAt(i);
            cs += ac;
            cs *= 17;
            cs = cs % 256;
        }
        console.log(hash, cs);
        answer += cs;
    });

}
catch(e) {
    console.error(e);
}

console.log("The answer is:", answer);
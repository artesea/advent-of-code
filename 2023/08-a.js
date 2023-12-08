const fs = require('node:fs');
let answer = 0;
try {
    const input = fs.readFileSync('08-input.txt', 'utf8');
    const lines = input.split("\r\n");
    const lr = lines[0].trim().split("");
    let camelmap = new Map();

    for(i=2;i<lines.length;i++) {
        const bits = lines[i].match(/\w{3}/g);
        camelmap.set(bits[0],[bits[1],bits[2]]);
    }

    let location = 'AAA';

    while(location != 'ZZZ') {
        let lor = lr[answer%lr.length];
        const options = camelmap.get(location)
        location = (lor == 'L') ? options[0] : options[1];
        answer++;
    }
}
catch(e) {
    console.error(e);
}

console.log("The answer to part 1 is:", answer);
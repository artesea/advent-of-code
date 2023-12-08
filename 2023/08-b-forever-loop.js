const fs = require('node:fs');
let answer = 0;
start = new Date();
try {
    const input = fs.readFileSync('08-input.txt', 'utf8');
    const lines = input.split("\r\n");
    const lr = lines[0].trim().split("");
    let camelmap = new Map();
    let locations = [];

    for(i=2;i<lines.length;i++) {
        const bits = lines[i].match(/\w{3}/g);
        camelmap.set(bits[0],[bits[1],bits[2]]);
        if(bits[0].charAt(2) == 'A') locations.push(bits[0]);
    }
    console.log(locations);

    while(true) {
        let atend = true;
        let lor = lr[answer%lr.length];
        let newLocations = [];
        locations.forEach((step) => {
            location = (lor == 'L') ? camelmap.get(step)[0] : camelmap.get(step)[1];
            atend = atend && (location.charAt(2) == 'Z');
            newLocations.push(location);
        });
        answer++;
        //console.log({answer,lor,newLocations})
        locations = newLocations;
        if(answer%1000000 == 0) console.log(answer.toLocaleString());
        if(atend) break;
    }
}
catch(e) {
    console.error(e);
}

console.log("The answer to part 2 is:", answer);
console.log("Started:",start,"Ended:",new Date());
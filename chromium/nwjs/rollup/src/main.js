import fs from "fs";

console.log(fs.readFileSync(process.cwd() + "/public/bundle.js").toString());
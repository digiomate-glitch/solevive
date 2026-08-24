const fs = require('fs');
const path = require('path');

const dir = './';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.html'));

files.forEach(file => {
    const filePath = path.join(dir, file);
    let content = fs.readFileSync(filePath, 'utf-8');

    // Replace the incorrectly formed background-image inline style with the proper background shorthand
    const regex = /style="background-image:\s*linear-gradient\([^)]+\),\s*url\('([^']+)'\)"/g;
    
    content = content.replace(regex, (match, url) => {
        return `style="background: linear-gradient(180deg, rgba(10,55,51,0.85), rgba(15,92,87,0.95)), url('${url}') center/cover no-repeat;"`;
    });

    fs.writeFileSync(filePath, content, 'utf-8');
});

console.log("Fixed inline backgrounds.");

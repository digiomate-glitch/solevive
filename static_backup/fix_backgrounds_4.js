const fs = require('fs');
const path = require('path');

const dir = './';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.html'));

files.forEach(file => {
    const filePath = path.join(dir, file);
    let content = fs.readFileSync(filePath, 'utf-8');

    // Replace the style background completely. We use [\s\S]*? to handle newlines!
    // We look for style="background... url('...') ..."
    const regex = /style="background(?:-image)?:\s*linear-gradient\([\s\S]*?url\('([^']+)'\)[\s\S]*?"/g;
    
    content = content.replace(regex, (match, url) => {
        return `style="background-image: linear-gradient(180deg, rgba(10,55,51,0.3), rgba(15,92,87,0.5)), url('${url}'); background-repeat: no-repeat; background-size: cover; background-position: center;"`;
    });

    fs.writeFileSync(filePath, content, 'utf-8');
});

console.log("Fixed backgrounds (handling newlines)!");

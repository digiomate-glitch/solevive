const fs = require('fs');
const path = require('path');

const dir = './';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.html'));

files.forEach(file => {
    const filePath = path.join(dir, file);
    let content = fs.readFileSync(filePath, 'utf-8');

    // Revert the `background:` shorthand back to `background-image:` and append the repeat and size properties inline
    const regex = /style="background:\s*linear-gradient\([^)]+\),\s*url\('([^']+)'\)\s*center\/cover\s*no-repeat;"/g;
    
    content = content.replace(regex, (match, url) => {
        return `style="background-image: linear-gradient(180deg, rgba(10,55,51,0.85), rgba(15,92,87,0.95)), url('${url}'); background-repeat: no-repeat; background-size: cover; background-position: center;"`;
    });

    fs.writeFileSync(filePath, content, 'utf-8');
});

console.log("Fixed inline backgrounds to use background-image, repeat, and size.");

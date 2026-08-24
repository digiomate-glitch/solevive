const fs = require('fs');
const path = require('path');

const dir = './';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.html'));

files.forEach(file => {
    const filePath = path.join(dir, file);
    let content = fs.readFileSync(filePath, 'utf-8');

    // This regex looks for ANY style="background-image: linear-gradient(..., url('...')" or style="background: ..."
    // Let's use string manipulation to be safer since the format is very predictable but might vary slightly.
    
    // We want to replace:
    // style="background-image: linear-gradient(180deg, rgba(10,55,51,0.85), rgba(15,92,87,0.95)), url('assets/images/epic_voyage_hq.jpg')"
    // with:
    // style="background-image: linear-gradient(180deg, rgba(10,55,51,0.3), rgba(15,92,87,0.5)), url('assets/images/epic_voyage_hq.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center;"
    
    const regex = /style="background(?:-image)?:\s*linear-gradient\([^)]+\),\s*url\('([^']+)'\)[^"]*"/g;
    
    content = content.replace(regex, (match, url) => {
        return `style="background-image: linear-gradient(180deg, rgba(10,55,51,0.3), rgba(15,92,87,0.5)), url('${url}'); background-repeat: no-repeat; background-size: cover; background-position: center;"`;
    });

    fs.writeFileSync(filePath, content, 'utf-8');
});

console.log("Fixed backgrounds with lighter gradient and strict sizing.");

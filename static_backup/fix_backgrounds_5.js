const fs = require('fs');
const path = require('path');

const dir = './';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.html'));

files.forEach(file => {
    const filePath = path.join(dir, file);
    let content = fs.readFileSync(filePath, 'utf-8');

    // Just replace the specific opacity values in the inline styles
    content = content.replace(/rgba\(10,55,51,0\.3\)/g, "rgba(10,55,51,0.45)");
    content = content.replace(/rgba\(15,92,87,0\.5\)/g, "rgba(15,92,87,0.65)");

    fs.writeFileSync(filePath, content, 'utf-8');
});

console.log("Increased overlay opacity by 15%!");

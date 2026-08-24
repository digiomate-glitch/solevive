const fs = require('fs');
const path = require('path');

const directoryPath = '.';

fs.readdir(directoryPath, function (err, files) {
    if (err) {
        return console.log('Unable to scan directory: ' + err);
    } 
    files.forEach(function (file) {
        if (path.extname(file) === '.html') {
            const filePath = path.join(directoryPath, file);
            let content = fs.readFileSync(filePath, 'utf8');
            
            // Additional replacements for remaining mojibake
            content = content.replace(/â†’/g, '→');
            content = content.replace(/Â©/g, '©');
            content = content.replace(/Â®/g, '®');
            
            // sometimes they show up differently depending on terminal encoding:
            content = content.replace(/\+'/g, '→'); // just in case
            
            fs.writeFileSync(filePath, content, 'utf8');
            console.log('Fixed: ' + file);
        }
    });
});

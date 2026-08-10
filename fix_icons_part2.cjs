const fs = require('fs');
const path = require('path');

function walkSync(dir, filelist = []) {
    fs.readdirSync(dir).forEach(file => {
        const filepath = path.join(dir, file);
        if (fs.statSync(filepath).isDirectory()) {
            filelist = walkSync(filepath, filelist);
        } else {
            filelist.push(filepath);
        }
    });
    return filelist;
}

const files = walkSync('resources/views').filter(f => f.endsWith('.blade.php'));

files.forEach(f => {
    let content = fs.readFileSync(f, 'utf8');
    let original = content;

    // Fix $statusInfo arrays in savings views
    content = content.replace(/<x-heroicon-s-check-circle.*? Tercapai!/g, '✅ Tercapai!');
    content = content.replace(/<x-heroicon-s-check-circle.*? Tercapai/g, '✅ Tercapai');
    content = content.replace(/<x-heroicon-o-fire.*? Hampir!/g, '🔥 Hampir!');
    content = content.replace(/<x-heroicon-o-fire.*? Hampir/g, '🔥 Hampir');
    content = content.replace(/<x-heroicon-o-exclamation-triangle.*?\? Terlambat/g, '⚠ Terlambat');
    content = content.replace(/<x-heroicon-o-hand-thumb-up.*? Berjalan/g, '💪 Berjalan');
    
    // Fix dashboard savings goal icon
    content = content.replace(/<x-heroicon-o-trophy.*? \/>/g, '🏆');
    content = content.replace(/<x-heroicon-o-bullseye.*? \/>/g, '🎯');
    
    // Fix premium arrays (X and Check)
    content = content.replace(/'<x-heroicon-o-x-mark.*?>'/g, "'✗'");
    content = content.replace(/'<x-heroicon-o-check.*?>'/g, "'✓'");
    
    // Fix mobile accounts innerHTML
    content = content.replace(/'<x-heroicon-o-check.*?> Disalin'/g, "'✓ Disalin'");
    
    // Fix huge icons by injecting inline style
    // We only want to inject it if it doesn't already have a style attribute.
    // Actually, adding it to the class string might be safer or just appending style.
    // Let's replace class="..." with class="..." style="width:1.2em; height:1.2em;"
    content = content.replace(/(<x-heroicon-[a-z0-9-]+[^>]*class="[^"]+")(\s*\/>)/g, '$1 style="width:1.2em; height:1.2em;" $2');

    // Remove the weird character after the heart and triangle
    content = content.replace(/,\?/g, '');
    
    if (content !== original) {
        fs.writeFileSync(f, content);
        console.log('Fixed ' + f);
    }
});

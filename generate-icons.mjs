import sharp from "sharp";
import { mkdirSync } from "fs";

mkdirSync("public/icons", { recursive: true });

const sizes = [72, 96, 128, 144, 152, 192, 384, 512];

for (const size of sizes) {
    await sharp("public/icons/icon-512.png")
        .resize(size, size)
        .png()
        .toFile(`public/icons/icon-${size}.png`);
    console.log(`✓ icon-${size}.png`);
}

// Maskable icons (dengan padding 20% untuk safe zone)
await sharp("public/icons/icon-512.png")
    .resize(154, 154) // 512 * 0.3 = safe zone
    .extend({
        top: 179,
        bottom: 179,
        left: 179,
        right: 179,
        background: { r: 1, g: 75, b: 170, alpha: 1 }, // #014BAA
    })
    .resize(512, 512)
    .png()
    .toFile("public/icons/icon-maskable-512.png");
console.log("✓ icon-maskable-512.png");

await sharp("public/icons/icon-maskable-512.png")
    .resize(192, 192)
    .png()
    .toFile("public/icons/icon-maskable-192.png");
console.log("✓ icon-maskable-192.png");

console.log("Semua icon berhasil di-generate!");

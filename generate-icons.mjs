import sharp from "sharp";
import { mkdirSync } from "fs";

mkdirSync("public/icons", { recursive: true });

const source = "public/icons/icon-512.png";

// Generate ukuran standar
const sizes = [72, 96, 128, 144, 152, 192, 384, 512];
for (const size of sizes) {
    await sharp(source)
        .resize(size, size)
        .png()
        .toFile(`public/icons/icon-${size}.png`);
    console.log(`✓ icon-${size}.png`);
}

// Maskable 512 - icon dengan safe zone 20%
// Icon asli di-resize ke 60% dari total, sisanya background biru
const iconSize = Math.round(512 * 0.6);
const padding = Math.round((512 - iconSize) / 2);

await sharp(source)
    .resize(iconSize, iconSize)
    .extend({
        top: padding,
        bottom: padding,
        left: padding,
        right: padding,
        background: { r: 1, g: 75, b: 170, alpha: 1 },
    })
    .png()
    .toFile("public/icons/icon-maskable-512.png");
console.log("✓ icon-maskable-512.png");

await sharp("public/icons/icon-maskable-512.png")
    .resize(192, 192)
    .png()
    .toFile("public/icons/icon-maskable-192.png");
console.log("✓ icon-maskable-192.png");

console.log("\nSemua icon berhasil dibuat!");

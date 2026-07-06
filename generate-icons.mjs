import { createCanvas } from "canvas";
import { writeFileSync, mkdirSync } from "fs";

mkdirSync("public/icons", { recursive: true });

function generateIcon(size) {
    const canvas = createCanvas(size, size);
    const ctx = canvas.getContext("2d");

    // Background biru
    ctx.fillStyle = "#014BAA";
    ctx.beginPath();
    ctx.roundRect(0, 0, size, size, size * 0.22);
    ctx.fill();

    // Lingkaran putih
    const cx = size / 2;
    const cy = size / 2;
    const r = size * 0.28;
    ctx.strokeStyle = "rgba(255,255,255,0.9)";
    ctx.lineWidth = size * 0.07;
    ctx.beginPath();
    ctx.arc(cx, cy, r, 0, Math.PI * 2);
    ctx.stroke();

    // Tanda Rp (teks)
    ctx.fillStyle = "#fff";
    ctx.font = `bold ${size * 0.28}px Arial`;
    ctx.textAlign = "center";
    ctx.textBaseline = "middle";
    ctx.fillText("Rp", cx, cy);

    writeFileSync(
        `public/icons/icon-${size}.png`,
        canvas.toBuffer("image/png"),
    );
    console.log(`Generated icon-${size}.png`);
}

generateIcon(192);
generateIcon(512);

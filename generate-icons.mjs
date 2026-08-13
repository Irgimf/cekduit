// generate-maskable-icons.mjs
import sharp from "sharp";

const SIZE_LARGE = 512;
const SIZE_SMALL = 192;
const BG_COLOR = "#014BAA"; // samain dengan theme_color
const SOURCE_LOGO = "public/icons/icon-512.png"; // logo sumber, resolusi tinggi

async function generateMaskable(size) {
    // Maskable butuh safe zone ~20% padding di semua sisi
    const logoSize = Math.round(size * 0.6); // logo isi 60% canvas, sisanya padding aman

    const logo = await sharp(SOURCE_LOGO)
        .resize(logoSize, logoSize, { fit: "contain" })
        .toBuffer();

    await sharp({
        create: {
            width: size,
            height: size,
            channels: 4,
            background: BG_COLOR,
        },
    })
        .composite([{ input: logo, gravity: "center" }])
        .png()
        .toFile(`public/icons/icon-maskable-${size}.png`);

    console.log(`✅ icon-maskable-${size}.png generated`);
}

await generateMaskable(SIZE_LARGE);
await generateMaskable(SIZE_SMALL);

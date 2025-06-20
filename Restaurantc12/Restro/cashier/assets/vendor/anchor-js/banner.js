const fs = require('fs');
const path = require('path');

// 🔧 Configuration
const filename = 'anchor.min.js'; // <-- replace with your actual JS file
const projectName = 'Restaurant management system';
const version = '1.0.0';
const homepage = 'https://example.com';
const author = 'c12';
const license = 'MIT';

// 🗓️ Generate current date
const padStart = str => ('0' + str).slice(-2);
const dateObj = new Date();
const date = `${dateObj.getFullYear()}-${padStart(dateObj.getMonth() + 1)}-${padStart(dateObj.getDate())}`;

// 🏷️ Create banner
const banner = `/**
 * ${projectName} - v${version} - ${date}
 * ${homepage}
 * Copyright (c) ${dateObj.getFullYear()} ${author}; Licensed ${license}
 */
`;

try {
  const filePath = path.resolve(__dirname, filename);
  const script = fs.readFileSync(filePath, 'utf8');

  // 👀 Check if banner is already added
  if (!script.trim().startsWith('/**')) {
    const newScript = banner + '\n' + script;
    fs.writeFileSync(filePath, newScript);
    console.log(`✅ Banner added to ${filename}`);
  } else {
    console.log(`ℹ️ ${filename} already has a banner. Skipped.`);
  }
} catch (err) {
  console.error(`❌ Error: ${err.message}`);
}

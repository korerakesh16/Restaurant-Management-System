const fs = require('fs');
const path = require('path');
const pkg = require('./package.json');

// 👇 Change this to your target file
const filename = 'yourfile.min.js';

// Read the file content
const script = fs.readFileSync(filename, 'utf8');

// Format the current date
const padStart = str => ('0' + str).slice(-2);
const dateObj = new Date();
const date = `${dateObj.getFullYear()}-${padStart(dateObj.getMonth() + 1)}-${padStart(dateObj.getDate())}`;

// Create the banner using values from package.json
const banner = `/**
 * ${pkg.name} - v${pkg.version} - ${date}
 * ${pkg.homepage || ''}
 * Copyright (c) ${dateObj.getFullYear()} ${pkg.author || 'c12'}; Licensed ${pkg.license}
 */
`;

// Add banner only if not already present
if (!script.startsWith('/**')) {
  fs.writeFileSync(filename, banner + script, 'utf8');
  console.log(`✅ Banner added to ${filename}`);
} else {
  console.log(`ℹ️ Banner already exists in ${filename}`);
}

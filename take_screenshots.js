const puppeteer = require('puppeteer');
const path = require('path');
const fs = require('fs');

const outputDir = 'C:/Users/FAJAR/.gemini/antigravity-ide/brain/ef60b522-bd75-4fe7-9226-7d99cb303934/screenshots';
if (!fs.existsSync(outputDir)) fs.mkdirSync(outputDir, { recursive: true });

const mobileWidth = 390;
const mobileHeight = 844;

async function screenshot(page, name) {
  await page.setViewport({ width: mobileWidth, height: mobileHeight });
  await new Promise(r => setTimeout(r, 1500));
  await page.screenshot({ path: path.join(outputDir, name + '_mobile.png'), fullPage: true });
  console.log('Saved: ' + name + '_mobile.png');
}

(async () => {
  const browser = await puppeteer.launch({ headless: true, args: ['--no-sandbox'] });
  const page = await browser.newPage();
  
  // Login page
  await page.goto('http://127.0.0.1:8000/login', { waitUntil: 'networkidle2', timeout: 15000 });
  await screenshot(page, '01_login');
  
  // Login with credentials
  await page.type('#email', 'admin@agristock.com');
  await page.type('#password', 'password');
  await page.click('button[type="submit"]');
  await page.waitForNavigation({ waitUntil: 'networkidle2', timeout: 10000 });
  await screenshot(page, '02_dashboard');
  
  // Items index
  await page.goto('http://127.0.0.1:8000/items', { waitUntil: 'networkidle2', timeout: 10000 });
  await screenshot(page, '03_items_index');
  
  // Categories
  await page.goto('http://127.0.0.1:8000/categories', { waitUntil: 'networkidle2', timeout: 10000 });
  await screenshot(page, '04_categories_index');
  
  // Incoming goods
  await page.goto('http://127.0.0.1:8000/incoming-goods', { waitUntil: 'networkidle2', timeout: 10000 });
  await screenshot(page, '05_incoming_index');
  
  // Outgoing goods
  await page.goto('http://127.0.0.1:8000/outgoing-goods', { waitUntil: 'networkidle2', timeout: 10000 });
  await screenshot(page, '06_outgoing_index');
  
  // Reports
  await page.goto('http://127.0.0.1:8000/reports', { waitUntil: 'networkidle2', timeout: 10000 });
  await screenshot(page, '07_reports');
  
  // Items create
  await page.goto('http://127.0.0.1:8000/items/create', { waitUntil: 'networkidle2', timeout: 10000 });
  await screenshot(page, '08_items_create');

  // Incoming create
  await page.goto('http://127.0.0.1:8000/incoming-goods/create', { waitUntil: 'networkidle2', timeout: 10000 });
  await screenshot(page, '09_incoming_create');

  // Outgoing create
  await page.goto('http://127.0.0.1:8000/outgoing-goods/create', { waitUntil: 'networkidle2', timeout: 10000 });
  await screenshot(page, '10_outgoing_create');

  await browser.close();
  console.log('All screenshots done!');
})();

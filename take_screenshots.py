import urllib.request
import urllib.parse
import http.cookiejar
import re
import os
import subprocess
import tempfile
import time
import json

SCREENSHOT_DIR = r"C:\Users\FAJAR\.gemini\antigravity-ide\brain\ef60b522-bd75-4fe7-9226-7d99cb303934\screenshots"
CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
BASE_URL = "http://127.0.0.1:8000"

# Setup cookie jar
cj = http.cookiejar.CookieJar()
opener = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(cj))
opener.addheaders = [
    ('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'),
    ('Accept', 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'),
]

# Step 1: Get login page to get CSRF token
print("Getting login page...")
response = opener.open(BASE_URL + "/login")
html = response.read().decode('utf-8')
csrf_match = re.search(r'name="_token" value="([^"]+)"', html)
csrf_token = csrf_match.group(1)
print(f"CSRF token acquired")

# Step 2: Login
print("Logging in...")
login_data = urllib.parse.urlencode({
    'email': 'admin@agristock.com',
    'password': 'password',
    '_token': csrf_token
}).encode('utf-8')

login_req = urllib.request.Request(BASE_URL + "/login", data=login_data, method='POST')
login_req.add_header('Content-Type', 'application/x-www-form-urlencoded')
login_req.add_header('Referer', BASE_URL + '/login')

try:
    response = opener.open(login_req)
    print(f"Logged in! Current URL: {response.geturl()}")
except Exception as e:
    print(f"Note: {e}")

# Get cookie values
cookies_dict = {c.name: c.value for c in cj}
print(f"Cookies: {list(cookies_dict.keys())}")

# Step 3: Create a Chrome user data dir with pre-set cookies
profile_dir = os.path.join(SCREENSHOT_DIR, "chrome_profile")
os.makedirs(profile_dir, exist_ok=True)
default_dir = os.path.join(profile_dir, "Default")
os.makedirs(default_dir, exist_ok=True)

# Use Python to fetch each page and save as static HTML, then screenshot
def fetch_and_screenshot(url, filename):
    """Fetch page content using our authenticated session, save as temp HTML, screenshot it"""
    print(f"\nFetching: {url}")
    try:
        response = opener.open(url)
        html_content = response.read().decode('utf-8')
        actual_url = response.geturl()
        
        if '/login' in actual_url:
            print(f"  -> Redirected to login, skipping")
            return False
        
        # Fix relative URLs in the HTML to use the base URL
        html_content = html_content.replace('href="/', f'href="{BASE_URL}/')
        html_content = html_content.replace('src="/', f'src="{BASE_URL}/')
        html_content = html_content.replace("href='/", f"href='{BASE_URL}/")
        html_content = html_content.replace("src='/", f"src='{BASE_URL}/")
        
        # Save to temp file
        temp_file = os.path.join(SCREENSHOT_DIR, f"temp_{filename}.html")
        with open(temp_file, 'w', encoding='utf-8') as f:
            f.write(html_content)
        
        # Screenshot
        output_path = os.path.join(SCREENSHOT_DIR, filename)
        cmd = [
            CHROME,
            "--headless=new",
            "--no-sandbox",
            "--disable-gpu",
            "--window-size=390,844",
            "--hide-scrollbars",
            "--disable-web-security",
            f"--screenshot={output_path}",
            f"file:///{temp_file}"
        ]
        
        result = subprocess.run(cmd, capture_output=True, timeout=30)
        os.unlink(temp_file)
        
        size = os.path.getsize(output_path) if os.path.exists(output_path) else 0
        print(f"  -> Saved {filename}: {size} bytes")
        time.sleep(0.5)
        return True
    except Exception as e:
        print(f"  -> Error: {e}")
        return False

# Pages to screenshot
pages = [
    (BASE_URL + "/dashboard", "02_dashboard_mobile.png"),
    (BASE_URL + "/items", "03_items_index_mobile.png"),
    (BASE_URL + "/categories", "04_categories_mobile.png"),
    (BASE_URL + "/incoming-goods", "05_incoming_mobile.png"),
    (BASE_URL + "/outgoing-goods", "06_outgoing_mobile.png"),
    (BASE_URL + "/reports", "07_reports_mobile.png"),
    (BASE_URL + "/items/create", "08_items_create_mobile.png"),
    (BASE_URL + "/incoming-goods/create", "09_incoming_create_mobile.png"),
    (BASE_URL + "/outgoing-goods/create", "10_outgoing_create_mobile.png"),
]

print("\nTaking screenshots...")
for url, filename in pages:
    fetch_and_screenshot(url, filename)

print("\nAll done!")

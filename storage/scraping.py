import time
import json
import os
from datetime import datetime
import requests
import re
import logging
from bs4 import BeautifulSoup

def scrape_and_store(youtube_url, output_json):
    try:
        response = requests.get(youtube_url)
        response.raise_for_status() 
        soup = BeautifulSoup(response.text, 'html.parser')

        script_tags = soup.find_all('script')

        url_pattern = re.compile(r'\'?(/watch[^\'"]+)')
        matched_urls = []

        for script in script_tags:
            script_content = script.string
            if script_content:
                matches = url_pattern.findall(script_content)
                matched_urls.extend(matches)
        
        data = matched_urls[1] if matched_urls else None

        if data:
            script_dir = os.path.dirname(os.path.abspath(__file__))
            output_path = os.path.join(script_dir, output_json)

            with open(output_path, 'w') as json_file:
                json.dump({'link': data}, json_file)

        return data
    except Exception as error:
        print('Error scraping:', error)
        raise error
    
youtube_url = 'https://www.youtube.com/@24Horas_TVNChile'
output_json = 'scraped_links.json'
current_datetime = datetime.now()
current_time = str(current_datetime.strftime("%H:%M:%S"))
valid_filename = re.sub(r'[^a-zA-Z0-9]', '_',current_time)
valid_filename = valid_filename.replace(':', '-')
print("Starting ",current_time)
start_time = time.time()
try:
    result = scrape_and_store(youtube_url, output_json)
    if result:
        print('Scraped links:', result)
    else:
        print('No links were scraped.')
    
except Exception as e:
    script_dir = os.path.dirname(os.path.abspath(__file__))
    log_file_path = os.path.join(script_dir, f'{valid_filename}.txt')
    log_file_path = os.path.join(script_dir, f'{valid_filename}.txt')
    logging.basicConfig(filename=log_file_path, level=logging.ERROR, format='%(asctime)s - %(levelname)s: %(message)s')
    logging.error(f'An error occurred: {str(e)}')
end_time = time.time()
print('Time taken:', end_time - start_time, 'seconds')
print("Finishing")


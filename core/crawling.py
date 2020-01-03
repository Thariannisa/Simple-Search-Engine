from bs4 import BeautifulSoup
from datetime import datetime, timedelta
from pathlib import Path
import requests

url = 'https://www.tempo.co/indeks/'
date = datetime.today()

i=1
limit=120
print('Processed..')
with open ('../data/link/link.txt','w') as file:
    while i != limit:
        data = BeautifulSoup(requests.get(
            f'{url}{date.strftime("%Y/%m/%d")}').text, 'html.parser')

        print(f'url      : {url}{date.strftime("%Y/%m/%d")}')
        print('found :',len(data.select('.card-type-1')))
        for urls in data.select('.card-type-1'):
            urls = urls.find('a')['href']
            file.write (urls+'\n')
            try:
                soup = BeautifulSoup(requests.get(
                    urls
                ).text,'html.parser')
                title = soup.find('article').find('h1').getText().strip()
                content = soup.select_one('#isi')
                for j in content('script'):
                    j.decompose()
                src = Path()/'../data/crawl'/f'data{i}.txt'
                with open(src,'w') as dokumen:
                    dokumen.write(title+'\n')
                    dokumen.write(content.getText().strip())
            except(AttributeError, UnicodeEncodeError):
                pass

            if i == limit:
                break
            i+=1
        else:
            date+= timedelta(days=-1)
    print(f'done {limit} url')
## Models

books
 - id
 - author_id
 - title
 - olid #nullable, used to get OpenLibrary cover

authors
- id
- name 
- olid #nullable

logs
- id
- book_id
- user_id
- log_date #date only, no time
- created_date #date and time
- duration #convert to minutes, accept 10m, 1h, 1h 30m, 1h30m, 10 m, 1 h, etc

## OpenLibrary API

Authors: https://openlibrary.org/search.json?author=tolkien&sort=new

Books: https://openlibrary.org/search.json?title=the+lord+of+the+rings

Covers: https://covers.openlibrary.org/b/olid/OL7440033M-S.jpg

## Add UserAgent for 3x Rate Limit

```
const url = "https://openlibrary.org/search.json?q=test";
const headers = new Headers({
    "User-Agent": "MyAppName/1.0 (myemail@example.com)"
});
const options = {
    method: 'GET',
    headers: headers
};
fetch(url, options)
    .then(response => response.json())
    .then(data => console.log(data))
    .catch(error => console.error('Error:', error));
```
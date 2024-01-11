# EcoTrek

This web application is aimed at addressing the pressing need for sustainable travel and to promote a greener future. The application aims to ensure that users can make more informed and environmentally conscious decisions when traveling, and reduce their overall carbon footprint. Our application helps to track carbon footprint and incentivize Singaporeans to engage in eco-friendly initiatives, with an attractive reward system. With the looming issue of climate change, this project seeks to raise awareness and highlight the importance and significance of every individual’s action and impact.

## Installation

1. Ensure that the folder is placed in a local server like WAMP, MAMP, XAMP or equivalent. For wamp, the repo should be placed inside wamp64/www folder

2. After placing the folder inside, you will need to set up the database using the SQL script provided in the database folder. You can run it in MySQL workbench, and remember to edit the ConnectionManager.php in the database folder accordingly. 
The default server, username, password and port for the database connection are 'localhost', 'root', ''  and '3306' respectively.

## Setup and Customization

1. Update Google Maps API key in createTable.js (if required)

2. Change multiplier accordingly to scale points (Line 150) of createTable.js

## Usage

1. To access and use the website, you can enter localhost/'filepath'/EcoTrek into the address bar on your browser while running the server. Remember to change the filepath to what it is from the www folder if you are using WAMP. Our landing page is located at "index.html"

2. You can register new accounts and use them to login, or use existing accounts in the database to login and use the website.
On the maps (base.html), you plan your journey and take the carbon friendly routes, you have to update your location and destination, hit "Enter" and the routes will be shown. (For this page ensure that you have enabled CORS, if you do not have a CORS extension, you can install "allow cors extension" on chrome at the following link https://chrome.google.com/webstore/detail/allow-cors-access-control/lhobafahddgcelffkeicbaginigeejlf?utm_source=ext_sidebar&hl=en-US)

3. On profile (profile.html), users can edit profile, add friends by searching their emails, search their friends list, and also see their points history.

4. On store (store.html), they can redeem their points for various products/vouchers

5. On leaderboard (leaderboard.html), they are able to view the current national ranking and ranking among friends, for both rankings it will show the top 10 as well as where the user is if they arent in top 10.

## User Credentials

Here are some user accounts to use to try out our web application.

1. Email: johndoe@example.com (Most preferred)
Password: password123

2. Email: alice.smith@example.com
Password: pass456

3. Email: bob.j@example.com
Password: bobpass

4. Email: eva.w@example.com
Password: evapass

5. Email: david.lee@example.com
Password: lee123


## Contributing

Contributors - Benson, Jun Hao, Wen Xiang, Varshan

## References

Bootstrap. (n.d., n.d.). Get started with Bootstrap. Retrieved from Bootstrap: https://getbootstrap.com/docs/5.3/getting-started/introduction/

Codehal. (2022, October 17). CSS Parallax Scrolling Website | How to Make Website using HTML CSS and Javascript. Retrieved from Youtube: https://www.youtube.com/watch?v=kmM6mqvnxcs

Eco-Business. (2010, October 21). Singapore's MRT lines to be graded on green-ness. Retrieved from Eco-Business: https://www.eco-business.com/news/singapores-mrt-lines-be-graded-green-ness/

Google. (n.d., n.d.). Directions API. Retrieved from Google Maps Platform: https://developers.google.com/maps/documentation/directions/get-directions

Google. (n.d., n.d.). Geolocation API. Retrieved from Google Maps Platform: https://developers.google.com/maps/documentation/geolocation/requests-geolocation

Land Transport Authority. (2022, August 26). LTA. Retrieved from https://www.lta.gov.sg/content/ltagov/en/who_we_are/statistics_and_publications/Connect/greenmrtstations.html

Vue. (n.d., n.d.). Introduction. Retrieved from Vue: https://vuejs.org/guide/introduction.html

Favicon
https://favicon.io/favicon-generator

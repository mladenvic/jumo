JUMO ASSESMENT:

-------------------------------------------
INTODUCTION
- Used the PHP programming language since i wanted to write a web application.
- The application is already hosted can be viewed with a browser(Chrome/IE) by going to this public url: http://41.185.91.126/jumo/

- The source code is downloadable from GitHub: https://github.com/mladenvic/jumo
- If one desires to run it on localhost, then apache and PHP installation is required. 
- In case of running the application on a windows server: download & install an easyphp devserver app from http://www.easyphp.org/ 
- This will allow one to install apache locally.

- When browsing to view the application, index.php page will display the options to view the reports such as Total Per Network, etc.
- Once inside the report, the results can be downloaded in PDF ans CSV format. As per assesment, results are downloadable as Output.csv

-------------------------------------------
PROJECT
- Requirement is to be able to summarise the total cost and count per network, product and month.
- I've managed to achive this with reports: TOTALS PER NETWORK, TOTALS PER PRODUCT, TOTALS PER DATE and also include all the groupings by TOTALS PER NETWORK, PRODUCT & DATE.

-------------------------------------------
PROGRAMMING AND STYLE
- Created a class (class_jumo_loan.php) with different methods to group the summarised results per network, product, date.
- Other php pages such as index.php, reference the class_jumo_loan.php to generate the results into the HTML div and table elements. In case of reprts, get's pushed into the Output.csv

- Since we're not allowed to use the SQL 'group by' or aggregate libraries - i had to write a class_jumo_loan.php which takes care of this with array management in PHP.
- The code file: class_jumo_loan.php converts the simple array into associative array.
- This is done by taking the heading of the csv file and making the headings into key index for the array.

-------------------------------------------
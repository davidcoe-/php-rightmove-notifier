php-rightmove-notifier
======================

Allows you to setup a custom Rightmove search and emailer. It looks for a single page of Rightmove results and emails you any new properties added to the site since the last time the script was run. Setup as a cron.

## Purpose
To find be alerted of new properties as soon as they become available on Rightmove.

## Usage
To use the script setup the variables in the callme.php file and run the call me file in cron.

### Configuration
Update the config variables to match you requirements

```php
$rightmove_url	= "Rightmove Website Search Address you want to track. (sorted by newest first)";
$file_location	= "Default is the location this script is called, file name houses_found.csv;
$from			= "Email address you want the script to send from";
$to				= "Email address you want the script to send new houses too";
end
```

Note: The Rightmove URL must show a list of houses and sorted by house first. A limitation of
this script is that it will only search for 1 pages worth of results. Sorting by highest price
will limit the number of houses the script can find.

#CCB PHP Client

[![Build Status](https://travis-ci.org/CompassHB/ccb-php-client.svg)](https://travis-ci.org/CompassHB/ccb-php-client)

A simple PHP client interface for the Community Church Builder (CCB) HTTP API.

## Usage

```
composer require compasshb/ccb-php-client
```
To get started, initialize the API:

```
use CompassHB\Ccb\Ccb;
Ccb::init("CCB_SUBDOMAIN", ["CCB_USER", "CCB_PASSWORD"]);
```

Now you can call any of APIs available in the library

```
$calendarListing = Ccb::Calendar()->publicCalendarListing($date_start, $date_end);  //returns SimpleXMLElement
```

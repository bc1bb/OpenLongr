# OpenLongr

![OpenLongr](OpenLongr.gif)

OpenLongr is a user-friendly privacy-focused alternative to TwitLonger and sites like this.

No account or login require, just type your text (OpenLongr supports markdown) and it'll be published in a second.

The database only stores three information about messages, they are the ID of the message, the content and the country of the user that sent it (based on IP, but IP isn't stored).

## Installation
### Requirements
- a MySQL Database,
- `composer` (to install [Parsedown](https://github.com/erusev/parsedown)),
- PHP 7 or better,
- PHP's `curl`.
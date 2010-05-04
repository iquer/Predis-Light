# Predis Light #

## About ##

Predis Light is a slim down version of Predis 0.5.1 for PHP 5.2.
It implements enough functionality for Redis-Sessions, where 
most of the Predis and Redis features are not needed.

## Features ##

- Small code size (3.1K vs 42K)

## Quick examples ##

Basically it is used like Predis for PHP 5.2, but limited to 

    AUTH,SELECT,SET,GET,INCR,DECR,DEL,EXISTS,EXPIRE,TTL

operations. 

See the [Predis Wiki](http://wiki.github.com/nrk/predis) of the 
Predis project for a more complete coverage of all the features
available in Predis.

### Connecting to a local instance of Redis ###

Predis Light needs to be told, where to connect to. Also 
authentication and database selection must be done after
connection.

    $redis = new Predis\Client(
		array('host' => 'localhost', 'port' => '6379'));
    $redis->set('library', 'predis');
    $value = $redis->get('library');

## Dependencies ##

- PHP >= 5.2.6 (for the Light client library)


## Related ##
- [Redis](http://code.google.com/p/redis/)
- [PHP](http://php.net/)
- [Git](http://git-scm.com/)
- [Predis](http://github.com/nrk/predis/)

## Author ##
[Joachim Staeck](mailto:js@iquer.net)

## Derived form Predis v 0.5.1 for PHP 5.2 by ## 
[Daniele Alessandri](mailto:suppakilla@gmail.com)

## License ##

The code for Predis Light is distributed under the terms of the MIT license (see LICENSE).
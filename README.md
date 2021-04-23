# GeoJson PHP Library

This library implements the
[GeoJSON format specification](http://www.geojson.org/geojson-spec.html).

The `GeoJson` namespace includes classes for each data structure defined in the GeoJSON specification. Core GeoJSON objects include geometries, features, and collections. Geometries range from primitive points to more complex polygons. Classes also exist for bounding boxes and coordinate reference systems.

## Installation

```
$ composer require "artisanweblab/geojson"
```

## Usage

Classes in this library are immutable.

### GeoJson Constructors

Geometry objects are constructed using a single coordinates array. This may be a tuple in the case of a `Point`, an array of tuples for a `LineString`, etc. Constructors for each class will validate the coordinates array and throw an
`InvalidArgumentException` on error.

More primitive geometry objects may also be used for constructing complex objects. For instance, a `LineString` may be constructed from an array of
`Point` objects.

Feature objects are constructed from a geometry object, associative properties array, and an identifier, all of which are optional.

Feature and geometry collection objects are constructed from an array of their respective types.

### JSON Serialization

Each class in the library implements PHP 5.4's
[JsonSerializable](http://php.net/manual/en/class.jsonserializable.php)
interface, which allows objects to be passed directly to `json_encode()`.

```php
use ArtisanWebLab\GeoJson\Geometry\Point;
$point = new Point([1, 1]);
$json = json_encode($point);
```

Printing the `$json` variable would yield (sans whitespace):

```json
{
    "type": "Point",
    "coordinates": [1, 1]
}
```

A stub interface is included for compatibility with PHP 5.3, although lack of core support for the interface means that `jsonSerialize()` will need to be manually called and its return value passed to `json_encode()`.

### JSON Unserialization

The core `GeoJson` class implements an internal `JsonUnserializable` interface, which defines a static factory method, `jsonUnserialize()`, that can be used to create objects from the return value of `json_decode()`.

```php
use ArtisanWebLab\GeoJson\GeoJson;
$json = '{ "type": "Point", "coordinates": [1, 1] }';
$point = GeoJson::jsonUnserialize($json);
```

If errors are encountered during unserialization, an `UnserializationException`
will be thrown by `jsonUnserialize()`. Possible errors include:

* Missing properties (e.g. `type` is not present)
* Unexpected values (e.g. `coordinates` property is not an array)
* Unsupported `type` string when parsing a GeoJson object or CRS

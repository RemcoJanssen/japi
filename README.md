J!API
====

Test API for Joomla, only basic tags are supported at this stage

This API use SlimFramework : http://www.slimframework.com
and swagger for documentation : http://swagger.io/

### Usage
Upload the all the content at the root of a Joomla 3 website

### To start
Documentation and live testing can be done at : /apidoc-v1/index.html

### Verbs
Five HTTP verbs are supported:

We support 4 differents format for output. If you don’t specify an accept header, the API will return JSON format by default:
* GET requests to retrieve information
* POST to add new records
* PUT to update records
* DELETE requests to remove records
* OPTIONS used by some framework to test a route

### Format
* XML
/ HTTP-Header Accept: application/xml
* JSON
/ HTTP-Header Accept: application/json
* JSONP
/ HTTP-Header Accept: application/json
/ For JSONP, add the ?callback parameter to any GET call to have the results wrapped in a JSON function. For example: https://mysite.ch/api/v1/sites?callback=myfunction
* Serialized
/ HTTP-Header Accept: text/plain 

We support content negociation : http://en.wikipedia.org/wiki/Content_negotiation
Done with http://williamdurand.fr/Negotiation/

### Errors
API return status booth in body and header

* 400	Bad Request	
* 403	Forbidden	
* 404	Not Found	

```JSON
{
"error": true,
"msg": "ERROR: Invalid Route",
"status": 404
} 
```

```XML
<api>
<error>1</error>
<msg>ERROR: Invalid Route</msg>
<status>404</status>
</api>
```
#### Field selection
Give the API consumer the ability to choose returned fields

GET v1/tags?fields=id,title

#### Paging
Use limit and limitstart like in Joomla. All response have the total of objects

GET v1/tags?limit=5&offset=5



### Swagger UI output
<img src="https://monosnap.com/image/OTlYewNGvbGpDHpq8q2wykEzK4MZxA.png">


This is only a test to show the general concept. ACL and other things are missing

J!API
====

Test API for Joomla, only basic tags are supported at this stage

This API use SlimFramework : http://www.slimframework.com

### Usage
Upload the all the content at the root of a Joomla 3 website


### Verbs
Five HTTP verbs are supported:
* GET requests to retrieve information
* POST to add new records
* PUT to update records
* DELETE requests to remove records
* OPTIONS used by some framework to test a route

Method Override

Some browser/framework don't  support all this method. In this case, you can send a POST with _METHOD='PUT' as parameter

you may also override the HTTP method by using the X-HTTP-Method-Override header

### Formats
We support 4 differents format for output. If you don’t specify an accept header, the API will return JSON format by default:
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
#### Plugins
You can extend the API by plugins
see plgJapiUsers as basic exemple

This is only a test to show the general concept

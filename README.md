JAPI
====

Test API for Joomla 

This API use SlimFramework : http://www.slimframework.com
and swagger for documentation : http://swagger.io/

### Usage
Upload the all the content at the root of a Joomla 3 website

### To start
Documentation and live testing can be done at : /apidoc-v1/index.html

### Verbs
Five HTTP verbs are supported:

* GET requests to retrieve information
* POST to add new records
* PUT to update records
* DELETE requests to remove records
* OPTIONS used by some framework to test a route

### Format
This API can return 
* JSON
* JSONP
* XML
* Serialize txt. 

We support content negociation : http://en.wikipedia.org/wiki/Content_negotiation
Done with http://williamdurand.fr/Negotiation/
More info about content negociation : 


This is only a test to show the general concept. ACL and a lot of things are missing

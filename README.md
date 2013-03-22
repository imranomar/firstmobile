Some notes on the solution:

Diagrams
--------
The diagrams of the solution are available in the diagrams folder. The rough diagrams include the dataflow diagram and the uml diagram.

Architecture
-------------
The main class is the 'geo_app' class. The logic for fetching the data from the geonames.com rest based service has been encapsulated in the 'geonames_data_provider' class which implements the 'i_geo_provider' interface. The reason this is done is so that later in the future we might want to get the data from any other source than geonames, maybe from a local database, so then we would just need a class to implement the  'i_geo_provider' interface and then that can easily replace the genames_data_provider with that class .

On the other hand the soap service has been implemented in the 'geo_app_soap_wrapper' class, which wraps the main 'geo_app' class to expose its functionality as a soap service. The reason for this is later on we can replace this soap wrapper with any other wrapper ( e.g. json wrapper ) which could consume the service of our application.

Unit Testing
------------
Do find the unit tests in the test/tests folder ( some simple tests to showcase )

PHPDo
-----
Do find the phpdoc documentation in the phpdoc folder
# Data Exchange Web Services V

- revision 24. 6 .1-WS 2 -


## Table of Contents




- ABOUT DATA EXCHANGE WEB SERVICES
   - WSDL
   - JSON/JSONP
- 1. AUTHENTICATION
- 2. IDENTIFICATION
   - 2.1. Structure
   - 2.2. Operations
      - 2.2.1. Fetching the Makes via getIdentificationTreeV2()
      - 2.2.2. Fetching Models and Types via getIdentificationTreeV2()
      - 2.2.3. Fetching vehicle details by id via getIdentificationTreeV2()
      - 2.2.4. Fetching vehicles based on TecDoc ids via getIdentificationByTecdocNumberV2()
      - 2.2.5. getCarTypesUpdateStatus
      - 2.2.6. FindCarTypesV2
      - 2.2.7. findCarTypesByDetailsV3
      - 2.2.8. decodeVINV4()
      - 2.2.9. getCarTypesByTecdocNumberV3()
      - 2.2.10. getCarTypesByKBAV3()
   - 2.3. Truck/trailer configuration
      - 2.3.1. getAxleComponents()
- 3. GENERAL INFORMATION
   - 3.1. Structure
   - 3.2. Operations
      - 3.2.1. getGeneralInformationLinks()
      - 3.2.2. getGeneralInformationLinksByGroup()
      - 3.2.3. getGeneralInformationLinksExtMap() and getGeneralInformationLinksByGroupExtMap()
- 4. ADJUSTMENTS
   - 4.1. Structure
   - 4.2. Operations
      - 4.2.1. getAdjustmentsV7()
      - 4.2.2. getAdjustmentsEnvOnlyV3()
      - 4.2.3. getAdjustmentsExtraInfo
- 5. MAINTENANCE
   - 5.1. Structure
      - 5.1.1. Maintenance Intervals default data structure
      - 5.1.2. Wear Parts Intervals
      - 5.1.3. Maintenance Overview
      - 5.1.4. Timing belt replacements
   - 5.2. Operations
      - 5.2.1. getMaintenanceSystemsV7()
      - 5.2.2. getMaintenanceTasksV9()
      - 5.2.3. getMaintenanceForms()
      - 5.2.4. Smart Links
   - 5.3. Maintenance Service Times
      - 5.3.1. getTimingBeltMaintenanceTasksV5()
      - 5.3.2. getWearPartsIntervalsV3()
      - 5.3.3. getMaintenanceSystemOverviewV2
      - 5.3.4. getMaintenancePartsForPeriod
      - 5.3.5. getCalculatedMaintenanceV4()
      - 5.3.6. getTimingBeltReplacementIntervals()
- 6. LUBRICANTS
   - 6.1. Structure
   - 6.2. Operations
      - 6.2.1. getLubricantsV5()
      - 6.2.2. getLubricantCapacitiesV4()
- 7. TECHNICAL DRAWINGS
   - 7.1. Structure
   - 7.2. Operations
      - 7.2.1. getDrawingsV4()
      - 7.2.2. Highlighting Parts
- 8. REPAIR MANUALS
   - 8.1. Structure
   - 8.2. Operations
      - 8.2.1. getStoryOverview()
      - 8.2.2. getStoryOverviewByGroupV2()
      - 8.2.3. getStoryInfoV6()
      - 8.2.4. getStoryInfoByGenart()
      - 8.2.5. getWarningLightsV2()
   - 8.3. Maintenance Stories
      - 8.3.1. getMaintenanceStories()
      - 8.3.2. getMaintenanceServiceReset()
      - 8.3.3. getMaintenanceKeys()
      - 8.3.4. getMaintenanceExtraInfo()
      - 8.3.5. getTimingStoriesOverviewV2()
      - 8.3.6. getStoryGeneralArticlesV2()...........................................................................................................................
      - 8.3.7. getDisclaimerV2()...........................................................................................................................................
      - 8.3.8. getFuelTypeDisclaimers()
- 9. MANAGEMENT
   - 9.1. Structure – main elements (systems, schema and components)
   - Operations – for systems, schema, and components
      - 9.1.1. getManagementSystems()
      - 9.1.2. getSchemaLocation()
      - 9.1.3. getSchemaLocations2()
      - 9.1.4. getManagementComponents()
      - 9.1.5. getManagementComponentExtraInfo
   - 9.2. Structure – Physical Location
      - 9.2.1. getPhysicalLocations()....................................................................................................................................
   - 9.3. Error Codes
      - 9.3.1. getManagementFaultCode()
   - 9.4. Diagnostics
      - 9.4.1. getDiagnosis()
      - 9.4.2. getDiagnosisAvailableCodes()
   - 9.5. EOBD Locations
      - 9.5.1. getEobdLocations()
      - 9.5.2. getEobdLocationsForModel()
- 10. ENGINE AND FUSE LOCATIONS...............................................................................................................
   - 10.1. Structure
      - 10.1.1. getFuseLocationsV3()
      - 10.1.2. getEngineLocation()
- 11. REPAIR TIMES
   - 11.1. Structure
   - 11.2. Operations
      - 11.2.1. getRepairtimeTypesV2()
      - 11.2.2. getRepairtimeSubnodesByGroupV4()
      - 11.2.3. getRepairtimeInfosV4()
      - 11.2.4. processRepairTasksV4()
      - 11.2.5. getRepairtimeNodesByGenartsV4()
      - 11.2.6. getRepairtimeNodesV4
      - 11.2.7. getRepairtimeSubnodesTextSearchV4()
      - 11.2.8. getRepairtimeSubnodesSpecificTimesV4
      - 11.2.9. getDisclaimerV2
- 12. COMFORT ELECTRONICS AND AIR-CONDITIONING WIRING DIAGRAMS
   - 12.1. Structure
   - 12.2. Operations
      - 12.2.1. getWiringDiagramTypesByGroup()
      - 12.2.2. getWiringDiagramSystems()
      - 12.2.3. getWiringDiagramSchemes()
      - 12.2.4. getWiringComponents()
   - 12.3. Annex – colour codes
- 13. CONVERTER
   - 13.1. Introduction
   - 13.2. Operations
      - 13.2.1. Converting toe
      - 13.2.2. convertTorqueNmToFtPerLbs
      - 13.2.3. convertPressureBarToPsi
      - 13.2.4. convertVolumeLitersToPints
      - 13.2.5. convertLengthMmToInches
      - 13.2.6. convertSpeedKphToMph
- 14. DATA EXPORT
   - 14.1. exportIdentification
- 15. EUROPEAN TYPE APPROVAL SEARCH
   - 15.1. findTecdocByEtk()
   - 15.2. findVarcodesAndImplCodesByTypeApprovalNumber
   - 15.3. findCarTypesByEtk
- 16. TECHNICAL SERVICE BULLETINS (TSB)
   - 16.1. Structure
   - 16.2. Operations
      - 16.2.1. getTSBSystemsV3
      - 16.2.2. getTSBDataV4, getRecallDataV3 and getSmartCaseDataV3
      - 16.2.3. filterTSBSystemsV3
      - 16.2.4. getSmartPackFaultCodes()
      - 16.2.5. getRecallSystemsV3(), filterRecallSystemsV3(), getCasesSystemsV3() and filterCasesSystemsV3()
      - 16.2.6. getTSBCasesRecallsSystemsV4() and filterTSBCasesRecallsSystemsV4()
      - 16.2.7. filterTSBCasesRecallsStories()
- 17. IDENTIFICATION LOCATION
   - 17.1. Structure
   - 17.2. Fetching the id-location data via getIdLocationV3()
- 18. PROFIT TOPICS
   - 18.1. Structure
   - 18.2. Calling Operations
      - 18.2.1. getProFitTopics
      - 18.2.2. getProFitDataById


## ABOUT DATA EXCHANGE WEB SERVICES

**Data Exchange Web-Services** is a set of operations that were created to provide the same data that the web-
application WorkshopData Touch (https://www.workshopdata.com/touch/) also provides and elements that

help integration with other applications, especially in the car-type identification part.

The main advantage of the web-services is the fact that they provide the data model exclusively. This means
that anyone who uses these web-services can integrate them in any graphical interface and with any control

(reaction of the application after a user event).

Another major advantage is the fact that web-services, in general, were thought to be platform independent.
So, either you want to use Java, C#, Python, PHP, or any other programming language for your application or if

you want to run it on a distribution of Linux or Windows, you should be able to use them and have no
compatibility problem.

### WSDL

The fact that the data is coded into XML and sent over the network does not affect the speed. The requests and
responses contain only specific data and no other styling, behavior information or other things that HTML use.

Furthermore, web-service servers provide a file called **WSDL** that describes the structure of all messages that
can be transmitted by this web-service. This way, the client and the server know what to expect and the parsing

methods are well optimized. It is recommended that the client be generated by a tool based on the WSDL file
because it will be optimized for speed, and it will make the migration to newer versions much easier.

The Data Exchange Web-Services tries to provide the same structure as WorkshopData Touch does, meaning
that the interface of the web-services will be in closer relation with the graphical interface than with the

database structure that it relies on. You will see in the next chapters this relation specifically pointed out to see
clearly where the information retrieved by the operations is displayed in our online application.

The address of said description file (WSDL) is:

- [http://www.haynespro-services.com/workshopServices3/services/DataServiceEndpoint?wsdl](http://www.haynespro-services.com/workshopServices3/services/DataServiceEndpoint?wsdl)

### JSON/JSONP

Another type of service interface these days is **JSON/JSONP**. The JavaScript Object Notation is well supported
by many libraries, and it makes integration in many online applications a lot easier if the required processing is
not so large. For the JSON/JSONP requests, you can make a GET or POST request at the following URL:


7

- [http://www.haynespro-services.com/workshopServices3/rest/jsonendpoint/{operation}](http://www.haynespro-services.com/workshopServices3/rest/jsonendpoint/{operation}) where the
    {operation} is the name of the operation.

Example URL using request _getMaintenanceTasksV7_ :

- [http://www.haynespro-](http://www.haynespro-)
    services.com/workshopServices3/rest/jsonendpoint/getMaintenanceTasksV7?vrid=1671D4894D2C5B
    B29B4D402FFE2574E&descriptionLanguage=en&carTypeId=319001025&repairtimesTypeId=120226&rt
    TypeCategory=CAR&systemId=319003435&periodId=319062051&includeSmartLinks=true&includeServ
    iceTimes=true&maintenanceBasedType=SUBJECT_BASED

For JSONP request you need to add an extra parameter named “callback” and the server will return a function
with the value of the “callback” parameter and the normal result as parameter for the callback function

(libraries like jQuery add this parameter automatically).

**Important note:** '<br>' text can appear in some descriptions due to internal implementation. Users of these

web services could modify the text they receive to have it in any format they want.


8

## 1. AUTHENTICATION

The authentication is done by using one of the following operations:

###  getAuthenticationVrid

###  getAuthenticationUserVrid

The authentication is done by the operation “getAuthenticationVrid”. It requires the following

parameters:

⚫ **distributorUsername** : this is a text that identifies the distributor

⚫ **distributorPassword** : this password will be specific to each distributor

```
⚫ username : the name of the user whose licence will be checked and used (the user that is
stored in VOLT )
```
This operation will return:

```
⚫ vrid : this is a string (that comes from Vivid Registration Identification) which is stored together with
the username and the licence information. After this call, the vrid will be required for all the other
operations of the webservice. Here are some rules about the vrid:
```
```
 the vrid can be used more than once
```
```
 the vrid is valid for 8 hours since its last use
```
```
 once a new vrid is generated for one user, all the previous ones for that username become
obsolete (even if they have been used in the past hour)
```
```
⚫ statusCode : this is an integer that is 0 when everything goes well and another number to show
an error:
```
```
 - 1 – unknown or unexpected error
```
```
 0 – OK
```
```
 1 – unknown company identification
```
```
 2 – incorrect password
```
```
 3 – username not found
```
```
 4 – user has no active licence
```

9

```
 5 – incorrect or expired vrid
```
```
 6 – you don't have the rights to call this operation
```
```
 7 – the user has been banned for 20 minutes
```
The first operation, **getAuthenticationVrid** , is recommended when the web-service authentication is called

from a server because of the password at the distributor level (the same password for all the users that belong
to a certain distributor). This one is recommended on servers because you don't need to store the password of

each user and it is secure because the password always stays on the server and cannot be found by malicious
users.

The other authentication operation, **getAuthenticationUserVrid** , uses the password at the user level (each user

may have a different level) and this is recommended when the authentication takes place on the user's
computer (like a desktop application). This operation returns the same values, but requires the following
parameters:

⚫ **distributorUsername** : this is a text that identifies the distributor

```
⚫ username : the name of the user whose licence will be checked and used (the user that is
stored in VOLT )
```
⚫ **password** : this password will be specific to each username


10

## 2. IDENTIFICATION

### 2.1. Structure

Identification means the identification of a car. In order to display information about a car, it is

necessary to identify the exact type first.

Identification is based on objects with this structure:

ExtWsIdentificationElement {
// the general part:
Integer id;
String level;
Integer order;

// the description of the vehicle:
String name;
String fullName;
String madeFrom;
String madeUntil;
String engineCode;
String[] fuelType;
Integer capacity;
Integer output;
Integer tonnage;
String image;

// the tree:
Integer superElementId;
String superElementLevel;
ExtWsIdentificationElement[] subElements;

// subjects:
String[] subjects;
ExtMap subjectsByGroup;

// the criteria for the vehicle:
ExtWSCriteria[] criteria;

// web-service call status:
ExtStatus status;
}

This object can contain information about a MAKE (like ALFA ROMEO, AUDI, VOLKSWAGEN ...),

a MODEL (like Golf IV is for VOLKSWAGEN) and a TYPE (like the 1.4 16V AKQ is for Golf IV):


11

Figure 3.1.1 – Make selection

Figure 3.1.2 – Model selection


12

Figure 3.1.3 -Type selection

This is a general object for all the 3 levels (make, model and type) and there are some

elements that are specific to only one of them and elements (for example, the model picture will be

filled only for a model) that are used for all of them (like the name).

Next, we will give an explanation for each element in the object:

```
Variable name Variable type Description
Id Integer Unique identifier for the element (unique only on the
specified level)
```
```
Level Text/Enum ROOT, MAKE, MODEL_GROUP, MODEL, TYPE
```
```
Order Integer number The sort order
```
```
Name Text The name of the element (ex. “Astra”)
```
```
FullName Text The full name (ex.: “Opel Astra”)
```

13

```
MadeFrom Text Start date (yyyy-MM and yyyy for latest versions)
```
```
MadeUntil Text End date (yyyy-MM, where MM=12 and yyyy for latest
versions)
```
```
EngineCode Text The code of the engine (if there is one)
```
```
FuelType Text Fuel type (“PETROL”, “DIESEL”)
```
```
Capacity Integer The capacity of the engine (if there is one)
Output Integer The output of the engine (if one; in case there is a range,
this will contain the lower/min value); the power in KW
```
```
Tonnage Integer number The number of Kg (for trucks) or null if unknown
```
```
Image Text The URL to an image representing the element (for
models and model_groups)
```
```
super_element_id Integer The id of the superior identification element (MAKE for a
MODEL_GROUP, MODEL for a TYPE, ...)
```
```
super_element_level Text/Enum MAKE for a MODEL_GROUP, MODEL for a TYPE, ...
Subjects Text[] The available subjects; new ones can appear; at the
moment they are ADJUSTMENTS, MAINTENANCE,
LUBRICANTS, DRAWINGS, EOBD_LOCATIONS,
FUSE_LOCATIONS, ENGINE_LOCATIONS, MANAGEMENT,
STORIES, WARNING_LIGHTS WIRING_DIAGRAMS,
REPAIR_TIMES, TIMING_REPAIR_MANUALS,
VESA_ENGINE, VESA_ABS, VESA_EXT_INT, VESA_TRANSM,
VESA_OTHER, SHOW_VESA, TSB
```
```
SubjectsByGroup Complex[] The available subjects by groups (ENGINE,
TRANSMISSION, STEERING, BRAKES, EXTERIOR,
ELECTRONICS, QUICKGUIDES)
```
```
Criteria Complex[] A list of complex objects that include the criteria
information, including, for trucks, the “Build type”, the
“Axle configuration”
```
```
SubElements ExtIdentificationElement list The makes for root, the model groups for makes, ...
```
In the next table you can see the relations between the operations of the web-service and

these subjects:

```
Operation name Subject
```

14

```
getAdjustments() ADJUSTMENTS
```
```
getMaintenanceSystems() MAINTENANCE
```
```
getLubricants() LUBRICANTS
```
```
getDrawings() DRAWINGS
```
```
GetEobdLocations(), getEobdLocationsForModel() EOBD_LOCATIONS
```
```
getFuseLocations() FUSE_LOCATIONS
```
```
getEngineLocations() ENGINE_LOCATIONS
```
```
getManagementSystems() MANAGEMENT
```
```
getStoriesOverview() STORIES
```
```
getWiringDiagrams() WIRING_DIAGRAMS
```
```
getRepairtimeTypes() REPAIR_TIMES
```
```
getTimingStoryOverview() TIMING_REPAIR_MANUALS
```
```
getTSBSystems() TSB
getCasesSystems() CASES
```
```
GetRecallsSystems() RECALLS
```
Table 3.1.1 – Main subjects

The elements that contain VESA (VESA_ENGINE, VESA_ABS, VESA_EXT_INT, VESA_TRANSM, VESA_OTHER and
SHOW_VESA) are related to data that is not provided by this web-service. All, except SHOW_VESA, are a direct result of
existing data. We recommend using the flash component that we provide (please contact us for it) that shows the VESA
data only when “SHOW_VESA” is present in the subjects.

###  subjectsByGroup : we divide information into 7 main groups. These groups are:

### ◦ ENGINE

### ◦ TRANSMISSION

### ◦ STEERING

### ◦ BRAKES

### ◦ EXTERIOR

### ◦ ELECTRONICS

### ◦ QUICKGUIDES

This property is a map that has as key one of these elements as a string and as value an array

of strings with a new set of subjects (the array will be represented in this case as a String of elements

separated by comas). See the next table for the relations between these subjects and the operations

that the web-service offers:


15

Group Subject Operation

ENGINE ADJUSTMENTS getAdjustmentsByGroup(..., “ENGINE”)

(^) LUBRICANTS getLubricantsByGroup(..., “ENGINE”)
(^) STORIES getStoryOverviewByGroup(..., “ENGINE”)
(^) DRAWINGS getDrawingsByGroup(..., “ENGINE”)
(^) MANAGEMENT getManagementSystems()
(^) REPAIR_TIMES getRepairtimeSubnodesByGroup(...,”ENGINE”)
(^) TSB GetTSBSystems(...,”ENGINE”)
(^) CASES GetCasesSystems(...,”ENGINE”)
TRANSMISSION ADJUSTMENTS getAdjustmentsByGroup(..., “TRANSMISSION”)
(^) LUBRICANTS getLubricantsByGroup(..., “TRANSMISSION”)
(^) STORIES getStoryOverviewByGroup(..., “TRANSMISSION”)
(^) DRAWINGS getDrawingsByGroup(..., “TRANSMISSION”)
(^) AUTOMATIC_TRANSMISSION getManagementSystems()
(^) REPAIR_TIMES getRepairtimeSubnodesByGroup(...,”TRANSMISSION”)
(^) TSB GetTSBSystems(...,”TRANSMISSION”)
(^) GetCasesSystems(...,”ENGINE”)
STEERING ADJUSTMENTS getAdjustmentsByGroup(..., “STEERING”)
(^) LUBRICANTS getLubricantsByGroup(..., “STEERING”)
(^) STORIES getStoryOverviewByGroup(..., “STEERING”)
(^) DRAWINGS getDrawingsByGroup(..., “STEERING”)
(^) REPAIR_TIMES getRepairtimeSubnodesByGroup(...,”STEERING”)
(^) TSB GetTSBSystems(...,”STEERING”)
(^) CASES GetCasesSystems(...,”ENGINE”)
BRAKES ADJUSTMENTS getAdjustmentsByGroup(..., “BRAKES”)
(^) LUBRICANTS getLubricantsByGroup(..., “BRAKES”)
(^) STORIES getStoryOverviewByGroup(..., “BRAKES”)
(^) DRAWINGS getDrawingsByGroup(..., “BRAKES”)
(^) ABS_ELECTRONICAL getManagementSystems()
(^) REPAIR_TIMES getRepairtimeSubnodesByGroup(...,”BRAKES”)
(^) TSB GetTSBSystems(...,”STEERING”)


16

(^) CASES GetCasesSystems(...,”ENGINE”)
EXTERIOR ADJUSTMENTS getAdjustmentsByGroup(..., “EXTERIOR”)
(^) LUBRICANTS getLubricantsByGroup(..., “EXTERIOR”)
(^) STORIES getStoryOverviewByGroup(..., “EXTERIOR”)
(^) DRAWINGS getDrawingsByGroup(..., “EXTERIOR”)
(^) ABS_ELECTRONICAL getManagementSystems()
(^) REPAIR_TIMES getRepairtimeSubnodesByGroup(...,”EXTERIOR”)
(^) AIRCO_WIRING_DIAGRAMS GetWiringDiagramsByGroup(...,”EXTERIOR”)
(^) TSB GetTSBSystems(...,”EXTERIOR”)
(^) CASES GetCasesSystems(...,”ENGINE”)
ELECTRONICS MANAGEMENT getManagementSystems()
(^) ABS_ELECTRONICAL getManagementSystems()
(^) AUTOMATIC_TRANSMISSION getManagementSystems()
(^) WIRING_DIAGRAMS getWiringDiagramsByGroup(...,”ELECTRONICS”)
(^) FUSES getFuseLocations()
(^) TSB GetTSBSystems(...,”ELECTRONICS”)
(^) CASES GetCasesSystems(...,”ENGINE”)
(^) WARNING_LIGHTS getWarningLights()
QUICKGUIDES ADJUSTMENTS getAdjustmentsByGroup(..., “QUICKGUIDES”)
(^) LUBRICANTS getLubricantsByGroup(..., “QUICKGUIDES”)
(^) STORIES getStoryOverviewByGroup(..., “QUICKGUIDES”)
(^) DRAWINGS getDrawingsByGroup(..., “QUICKGUIDES”)
(^) TSB GetTSBSystems(...,”QUICKGUIDES”)
(^) CASES GetCasesSystems(...,”ENGINE”)
Table 3.1.2 – Subjects by groups
Next, we will show, based on a real example, where each element of this structure is used in
WorkshopData Touch. For this example, we will use “Volkswagen Golf IV 1.4 16V AKQ” (the same one
that is selected in image 3.1.3.
The structure returned by the web-service is (it can be returned different operations, but for
this example we suggest calling the “getIdentificationTree” operation with the parameters “en” for
language, “26650” as vehicle_id and “TYPE” as vehicle_level):


17

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getIdentificationTreeResponse xmlns="http://data.webservice.workshop.vivid.nl">
4. <getIdentificationTreeReturn>
5. <capacity>1390</capacity>
6. <criteria xsi:nil="true"/>
7. < **engineCode** > **AKQ** </engineCode>
8. <fuelType>
9. <item>PETROL</item>
10. </fuelType>
11. < **fullName** > **VOLKSWAGEN Golf IV (1J) 1.4** </fullName>
12. <id>26650</id>
13. <image>http://www.haynespro-services.com/workshop/images/golf_4_dba_soest.jpg</image>
14. <level>TYPE</level>
15. < **madeFrom** > **1998 - 01** </madeFrom>
16. < **madeUntil** > **2001 - 12** </madeUntil>
17. <name>1.4</name>
18. <order>0</order>
19. <output>55</output>
20. <status xsi:nil="true"/>
21. <subElements xsi:nil="true"/>
22. < **subjects** >
23. <item>ADJUSTMENTS</item>
24. <item> **MAINTENANCE** </item>
25. <item>LUBRICANTS</item>
26. <item>DRAWINGS</item>
27. <item>EOBD_LOCATIONS</item>
28. <item>FUSE_LOCATIONS</item>
29. <item>ENGINE_LOCATIONS</item>
30. <item>MANAGEMENT</item>
31. <item>ABS_ELECTRONICAL</item>
32. <item>STORIES</item>
33. <item>WIRING_DIAGRAMS</item>
34. <item> **REPAIR_TIMES** </item>
35. <item>TIMING_REPAIR_MANUALS</item>
36. <item>VESA_ENGINE</item>
37. <item>VESA_ABS</item>
38. <item>SHOW_VESA</item>
39. <item>CASES</item>
40. </subjects>
41. < **subjectsByGroup** >
42. <mapItems>
43. <item>
44. <key> **ENGINE** </key>
45. <value> **ADJUSTMENTS,LUBRICANTS,STORIES,MANAGEMENT,REPAIR_TIMES** </value>


18

46. </item>
47. <item>
48. <key>TRANSMISSION</key>
49.
    <value>ADJUSTMENTS,LUBRICANTS,STORIES,DRAWINGS,AUTOMATIC_TRANSMISSION,REPAIR_TIMES</value>
50. </item>
51. <item>
52. <key>STEERING</key>
53. <value>ADJUSTMENTS,LUBRICANTS,DRAWINGS,REPAIR_TIMES,CASES</value>
54. </item>
55. <item>
56. <key>BRAKES</key>
57. <value>ADJUSTMENTS,LUBRICANTS,DRAWINGS,ABS_ELECTRONICAL,REPAIR_TIMES,CASES</value>
58. </item>
59. <item>
60. <key>EXTERIOR</key>
61.
    <value>ADJUSTMENTS,LUBRICANTS,STORIES,DRAWINGS,AIRCO_WIRING_DIAGRAMS,REPAIR_TIMES</value>
62. </item>
63. <item>
64. <key>ELECTRONICS</key>
65.
    <value>STORIES,FUSE_LOCATIONS,MANAGEMENT,AUTOMATIC_TRANSMISSION,ABS_ELECTRONICAL,WIRING_DIAGRA
    MS,VESA_ENGINE,VESA_ABS,SHOW_VESA,CASES</value>
66. </item>
67. <item>
68. <key>QUICKGUIDES</key>
69. <value>ADJUSTMENTS,LUBRICANTS,STORIES,DRAWINGS,REPAIR_TIMES,CASES</value>
70. </item>
71. </mapItems>
72. </subjectsByGroup>
73. <superElementId>7250</superElementId>
74. <superElementLevel>MODEL</superElementLevel>
75. <tonnage xsi:nil="true"/>
76. </getIdentificationTreeReturn>
77. </getIdentificationTreeResponse>
78. </soapenv:Body>
79. </soapenv:Envelope>


19

Figure 3.1.4 – Car Home for Volkswagen Golf IV 1.4 16V (AKQ)

The header:

Figure 3.1.5 - Header
1 - <fullName> **VOLKSWAGEN Golf IV 1.4 16V** </fullName> (line 11)
2 - <engineCode> **AKQ** </engineCode> (line 7)
3 - <madeFrom> **1997 - 01** </madeFrom> (line 15)
4 - <madeUntil> **2000 - 12** </madeUntil> (line 16)


20

Maintenance panel:

Figure 3.1.6 – Maintenance panel
1 - <subjects> ... <item> **MAINTENANCE** </item> ... </subjects> (line 24)
2 - <subjects> ... <item> **REPAIR_TIMES** </item> ... </subjects> (line 34)

Engine group panel:

Figure 3.1.6 – Engine group panel


21

<item xmlns="">
<key xsi:type="xsd:string"> **ENGINE** </key>
<value xsi:type="xsd:string">
**ADJUSTMENTS** , - 1
**LUBRICANTS** , - 2
**STORIES** , - 3
**MANAGEMENT** , - 4
**REPAIR_TIMES** </value> - 5
</item>

Note: You can see that at point 3 (Repair manuals), there are details about how the repair

manuals are named. You can get this information by calling one of the operations. They will be

detailed in the next chapters (getStoryOverviewByGroup() in this case).

For the rest of the groups (Transmission, Steering, Brakes, Exterior, Electronics and

Quickquides), the relation is the same as for Engine (if you check “Engine group panel” and the 3.1.2

table, you can get the relations between WorkshopData Touch and the web service for the car-type

object structure.


22

### 2.2. Operations

#### 2.2.1. Fetching the Makes via getIdentificationTreeV2()

The difference between this version and the previous one is that in the new version the

madeFrom and madeUntil fields of the returned ExtWsIdentificationElement objects contain only years.

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  vehicle_id – numeric (this should be the id of the vehicle) – in this case it can be empty or null

###  vehicle_level – String (this can be ROOT, MAKE, MODEL, TYPE and MODEL_GROUP) – in this

case it will be ROOT

###  filter_dataset – String[] (this can be any combination of “WORKSHOP”, “TRUCKS”,

```
“TRUCKS_WITH_LCV” and “MOTORCYCLE”, but new ones can be added in time) – in this case
we will use “WORKSHOP”
```
###  filter_category – String[] (this can be any combination of “PASSENGER”, “LCV”, “TRUCK”,

```
“TRAILER” and “MOTORCYCLE”) - in this case we will leave it empty because we do not want to
filter based on category
```
###  filter_toVehicleLevel – String (this can have the same values as vehicle_level) – if we leave it

```
null, it will return only one level; in this case we will set it to “MAKE” in order to set the makes
as “subElements” for the ROOT
```
###  filter_criteriaKeys and filter_criteriaValues – String[] - they are not used at the moment, but it

```
is a placeholder for future development when we will be able to filter based on more criteria
(for example, based on the body type, or the type of axle that a truck has, or engine codes)
```
**It returns an array of ExtWsIdentificationElement** objects that represent all the car makes that

we have in the database.

This is a real example to show the relation between WorkshopData Touch and this operation:

1. <fullName>ROOT Car Type</fullName>
2. <id>0</id>
3. <image xsi:nil="true"/>
4. <level>ROOT</level>
5. <madeFrom xsi:nil="true"/>
6. <madeUntil xsi:nil="true"/>
7. <name>ROOT Car Type</name>


23

8. <order>0</order>
9. <output>0</output>
10. <status xsi:nil="true"/>
11. <subElements>
12. <item>
13. <...
14. < **fullName** > **ALFA ROMEO** </fullName>
15. < **id** > **110** </id>
16. <image xsi:nil="true"/>
17. < **level** > **MAKE** </level>
18. <madeFrom xsi:nil="true"/>
19. <madeUntil xsi:nil="true"/>
20. <name>ALFA ROMEO</name>
21. ...
22. </item>
23. <item>
24. ...
25. <fullName>AUDI</fullName>
26. < **id** > **120** </id>
27. <image xsi:nil="true"/>
28. < **level** > **MAKE** </level>
29. <madeFrom xsi:nil="true"/>
30. <madeUntil xsi:nil="true"/>
31. <name>AUDI</name>
32. ...
33. </item>
34. ...

The used properties for a Make are:

###  fullName - the name that is displayed

###  id – this is used to find the models that belong to this Make

###  level – in this case, it is a Make

#### 2.2.2. Fetching Models and Types via getIdentificationTreeV2()

The difference between this version and the previous one is that in the new version the

madeFrom and madeUntil fields of the returned ExtWsIdentificationElement objects contain only years.


24

To get the **Models** that belong to a Make we need to specify the id of the Make, the

vehicle_level as “ **MAKE** ” and the filter_toVehicleLevel as “ **MODEL** ”.

To get the **Types** that belong to a Model we need to specify the id of the Model, the

vehicle_level as “ **MODEL** ” and the filter_toVehicleLevel as “ **TYPE** ”.

First we will present the call and the response for the models.

###  descriptionLanguage - String - “en”

###  vehicle_id – numeric – from the previous call, the number “110” for “Alfa Romeo”

###  vehicle_level – String – “MAKE”

###  filter_dataset – String[] – “WORKSHOP”

###  filter_category – String[] - empty

###  filter_toVehicleLeve – “MODEL”

###  filter_criteriaKeys and filter_criteriaValues - empty

**It returns an array of ExtWsIdentificationElement objects** that represent all the sub-types (all

the Models of a Make or all the Types of a Model).

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getIdentificationTreeV2Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getIdentificationTreeV2Return>
5. ...
6. < **fullName** > **ALFA ROMEO** </fullName>
7. <id>110</id>
8. ...
9. < **subElements** >
10. <item>
11. ...
12. < **fullName** > **ALFA ROMEO 145 (130)** </fullName>
13. < **id** > **200** </id>
14. < **image** > **[http://www.haynespro-services.com/workshop/images/145_dba_soest.jpg](http://www.haynespro-services.com/workshop/images/145_dba_soest.jpg)** </image>
15. < **level** > **MODEL** </level>
16. < **madeFrom** > **1994** </madeFrom>
17. < **madeUntil** > **2000<** /madeUntil>
18. < **name** > **145** </name>
19. ...


25

20. </item>
21. <item>
22. <fullName>ALFA ROMEO 146 (130)</fullName>
23. <id>220</id>
24. <image>http://www.haynespro-services.com/workshop/images/146_dba_soest.jpg</image>
25. <level>MODEL</level>
26. <madeFrom>1995</madeFrom>
27. <madeUntil>2000</madeUntil>
28. <name>146</name>
29. ...
30. </item>
31. ...
32. </subElements>
33. ...
34. </getIdentificationTreeV2Return>
35. </getIdentificationTreeV2Response>
36. </soapenv:Body>
37. </soapenv:Envelope>

The used properties of this objects are:

###  fullName: ALFA ROMEO 145 (130) (this is the full name of the Model – it is used to be

displayed)

###  id : 200 (this is the id of the model – it is used to get the Types related to this Model)

###  level : MODEL

###  madeFrom : 1994 (In previous version was the date when the Model's production started:

January 1994; now the date is only the year)

###  madeUntil : 2000 (in previous version was the date when the Model's production stopped:

```
December 2000; now the date is only the year; note: this value can be null for other models, if
the model is still in production)
```
###  modelPictureMimeDataName: http://www.haynespro-

```
services.com/workshop/images/145_dba_soest.jpg (this is the URL of the picture that
represents the model; this property can be null for other models if no picture of the model is
available)
```
###  superCarTypeId: 110 (this is the id of the Make that this model belongs to)

This image is from Workshop ATI Online:


26

1 - this is the name of the Make from the previous example
2 - <fullName> **ALFA ROMEO 145 (130)** </fullName> (line 12)
3 - <madeFrom> **1994** </madeFrom> (line 16)
4 - <madeUntil> **2000 <** /madeUntil> (line 17)

Now, let us call the same operation for “ALFA ROMEO 145” to get its Types.

We call the operation with these parameters:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  vehicle_id – numeric – from the previous call, the number “110” for “Alfa Romeo”

###  vehicle_level – String – “MODEL”

###  filter_dataset – String[] – “WORKSHOP”

###  filter_category – String[] - empty

###  filter_toVehicleLeve – “TYPE”

###  filter_criteriaKeys and filter_criteriaValues - empty

The result of calling this operation is:


27

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getIdentificationTreeV2Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getIdentificationTreeV2Return>
5. ...
6. <fullName>ALFA ROMEO 145 (130)</fullName>
7. <id>200</id>
8. <image>http://www.haynespro-services.com/workshop/images/145_dba_soest.jpg</image>
9. <level>MODEL</level>
10. <madeFrom>1994</madeFrom>
11. <madeUntil>2000</madeUntil>
12. <name>145</name>
13. ...
14. < **subElements** >
15. <item>
16. < **capacity** > **1351** </capacity>
17. <criteria xsi:nil="true"/>
18. < **engineCode** > **AR 33501** </engineCode>
19. < **fuelType** >
20. <item> **PETROL** </item>
21. </fuelType>
22. < **fullName** > **ALFA ROMEO 145 (130) 1.3 / 1.4** </fullName>
23. < **id** > **22410** </id>
24. <image>http://www.haynespro-services.com/workshop/images/145_dba_soest.jpg</image>
25. < **level** > **TYPE** </level>
26. < **madeFrom** > **1994** </madeFrom>
27. < **madeUntil** > **1996** </madeUntil>
28. < **name** > **1.3 / 1.4** </name>
29. <order>0</order>
30. < **output** > **66** </output>
31. <status xsi:nil="true"/>
32. <subElements xsi:nil="true"/>
33. <subjects>
34. <item>ADJUSTMENTS</item>
35. <item>MAINTENANCE</item>
36. <item>LUBRICANTS</item>
37. <item>DRAWINGS</item>
38. <item>EOBD_LOCATIONS</item>
39. <item>FUSE_LOCATIONS</item>
40. <item>ENGINE_LOCATIONS</item>
41. <item>MANAGEMENT</item>
42. <item>STORIES</item>
43. <item>WIRING_DIAGRAMS</item>
44. <item>REPAIR_TIMES</item>
45. <item>TIMING_REPAIR_MANUALS</item>


28

46. </subjects>
47. <subjectsByGroup>
48. <mapItems>
49. <item>
50. <key>ENGINE</key>
51. <value>ADJUSTMENTS,LUBRICANTS,STORIES,MANAGEMENT,REPAIR_TIMES</value>
52. </item>
53. ...
54. <item>
55. <key>QUICKGUIDES</key>
56. <value>ADJUSTMENTS,LUBRICANTS,STORIES,DRAWINGS,REPAIR_TIMES</value>
57. </item>
58. </mapItems>
59. </subjectsByGroup>
60. <superElementId>200</superElementId>
61. <superElementLevel>MODEL</superElementLevel>
62. <tonnage xsi:nil="true"/>
63. </item>
64. ...
65. </subElements>
66. ...
67. </getIdentificationTreeV2Return>
68. </getIdentificationTreeV2Response>
69. </soapenv:Body>
70. </soapenv:Envelope>

The description of each property in Type objects is described in detail in chapter 3.1. Here we

will give a brief description only to the properties that affect the identification:

###  capacity – int – value: 1351 (this is the capacity of the engine; this is used to be displayed)

###  engineCode – String – value: “ AR 33501 ” (this is the code of the engine; this is used to be

displayed)

###  fullName – String – value: “ ALFA ROMEO 145 1.4 ” (this is the full name of the Type; this is used

to be displayed)

###  id – int – value: 22420 (this is the id of the Type; this is used to get other information about this

type)

###  level – int – value: 3 (based on this value we know that this object is a Type)

###  madeFrom – String – value: “ 1994 ” (In previous version was the date when the Type's

production started: January 1994; now the date is only the year)

###  madeUntil – String – value: “ 1996 ” (in previous version was the date when the Type's


29

```
production stopped: December 1994; now the date is only the year; note: this value can be
null for other types in case the Type is still in production)
```
###  superCarType – int – value: 200 (this is the id of the Model that this type belongs to)

1 - this is a combination of the Model (from the previous example) name and Type name
<name>1.3 / 1.4</name> (line 28)
2 - <madeFrom>1994-01</madeFrom> (line 26)
3 - <madeUntil>1996-12</madeUntil> (line 27)
4 - <engineCode>AR 33501</engineCode> (line 18)
5 - <capacity>1351</capacity> (line 16)
6 - <output>66</output> (line 30)

#### 2.2.3. Fetching vehicle details by id via getIdentificationTreeV2()

The difference between this version and the previous one is that in the new version the

madeFrom and madeUntil fields of the returned ExtWsIdentificationElement objects contain only years.

Using the same operation, by setting the filter_toVehicleLevel to the same value as the

vehicle_level, we can obtain the details of the vehicle. Here is an example for a car-type with the id

“ **22410** ”

###  descriptionLanguage - en

###  vehicle_id – numeric – 22410 (the id from the previous call)


30

###  vehicle_level – String – “TYPE”

###  filter_dataset – String[] – “WORKSHOP”

###  filter_category – String[] - empty

###  filter_toVehicleLeve – “TYPE” (or empty in this case)

###  filter_criteriaKeys and filter_criteriaValues – empty

#### 2.2.4. Fetching vehicles based on TecDoc ids via getIdentificationByTecdocNumberV2()

The difference between this version and the previous one is that in the new version the

madeFrom and madeUntil fields of the returned ExtWsIdentificationElement objects contain only years.

This operation retrieves an ExtWsIdentificationElement array based on an id that belongs to

TecDoc. It works **only for Types**. It requires the following parameters when calling:

###  descriptionLanguage - en

###  tecdoc_id – numeric – 8799

###  tecdoc_vehicleType – String – “ CAR ” (can be “CAR” of “TRUCK”)

###  filter_dataset – String[] – (can be any combination of “WORKSHOP” and “TRUCK”) - empty

###  filter_category – String[] - (can be any combination of “PASSENGER”,”LCV”,”TRUCK”,”TRAILER”

and “AXLE”) - in this case, **empty**

###  filter_criteriaKeys and filter_criteriaValues – empty

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getIdentificationByTecdocNumberV2Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getIdentificationByTecdocNumberV2Return>
5. <capacity>1390</capacity>
6. <criteria xsi:nil="true"/>
7. <engineCode>AHW</engineCode>
8. <fuelType>
9. <item>PETROL</item>
10. </fuelType>


31

11. <fullName>VOLKSWAGEN Golf IV (1J) 1.4</fullName>
12. <id>26640</id>
13. <image>http://www.haynespro-services.com/workshop/images/golf_4_dba_soest.jpg</image>
14. <level>TYPE</level>
15. <madeFrom> **1998** </madeFrom>
16. <madeUntil> **2003** </madeUntil>
17. <name>1.4</name>
18. <order>0</order>
19. <output>55</output>
20. <status xsi:nil="true"/>
21. <subElements xsi:nil="true"/>
22. <subjects>
23. <item>ADJUSTMENTS</item>
24. <item>MAINTENANCE</item>
25. <item>LUBRICANTS</item>
26. ...
27. </subjects>
28. <subjectsByGroup>
29. <mapItems>
30. <item>
31. <key>ENGINE</key>
32. <value>ADJUSTMENTS,LUBRICANTS,STORIES,MANAGEMENT,REPAIR_TIMES</value>
33. </item>
34. ...
35. </mapItems>
36. </subjectsByGroup>
37. <superElementId>7250</superElementId>
38. <superElementLevel>MODEL</superElementLevel>
39. <tonnage xsi:nil="true"/>
40. </getIdentificationByTecdocNumberReturn>
41. <getIdentificationByTecdocNumberReturn>
42. <capacity>1390</capacity>
43. <criteria xsi:nil="true"/>
44. <engineCode>AKQ</engineCode>
45. <fuelType>
46. <item>PETROL</item>
47. </fuelType>
48. <fullName>VOLKSWAGEN Golf IV (1J) 1.4</fullName>
49. <id>26650</id>
50. <image>http://www.haynespro-services.com/workshop/images/golf_4_dba_soest.jpg</image>
51. <level>TYPE</level>
52. <madeFrom>1998</madeFrom>
53. <madeUntil>2001</madeUntil>
54. <name>1.4</name>
55. ...
56. </getIdentificationByTecdocNumberReturn>


32

57. <getIdentificationByTecdocNumberReturn>
58. <capacity>1390</capacity>
59. <criteria xsi:nil="true"/>
60. <engineCode>APE</engineCode>
61. <fuelType>
62. <item>PETROL</item>
63. </fuelType>
64. <fullName>VOLKSWAGEN Golf IV (1J) 1.4</fullName>
65. <id>31380</id>
66. <image>http://www.haynespro-services.com/workshop/images/golf_4_dba_soest.jpg</image>
67. <level>TYPE</level>
68. <madeFrom>1999</madeFrom>
69. <madeUntil>2001</madeUntil>
70. <name>1.4</name>
71. <order>0</order>
72. <output>55</output>
73. ...
74. </getIdentificationByTecdocNumberV2Return>
75. ...
76. </getIdentificationByTecdocNumberV2Response>
77. </soapenv:Body>
78. </soapenv:Envelope>

#### 2.2.5. getCarTypesUpdateStatus

This operation retrieves an ExtCarTypeUpdateStatus array of objects which have the following

structure:

ExtCarTypeUpdateStatus {
Integer carTypeId;
String updateStatus;
String[] newSubjects;
ExtMapItem[] newSubjectsByGroup;
}

The meaning of the elements are:

###  carTypeId: it is the id of the car for which the update status is presented. The carTypeId is

```
included in the list of ids in the request and it should be used to determine to which car the
update status belongs to.
```
###  updateStatus: is a text that shows the status of the car. It can have 3 values (constants, not

translated based on the language):

### ◦ normal: no new subject has been added to this car compared to the previous update of the

database


33

### ◦ updated: at least one new subject (adjustments, maintenance, lubricants, etc.) has been

added to the car compared to the previous update of the database

### ◦ new: the car has been added compared to the previous update of the database

###  newSubjects: this is an array of texts which shows what are the new subjects that have been

```
added compared to the previous update of the database (for updateStatus “NORMAL”, it will
be null/empty, for updateStatus “UPDATED” it will contain only the subjects that were not
covered before, for updateStatus “NEW” it will contain all the subjects that the car has). This
will be empty when the operation is called for Makes or Models (it will have values only for
Types)
```
###  newSubjectsByGroup: this is a “map” (key-value array) that shows which are the new subjects

```
based on the groups (ENGINE, TRANSMISSION, etc.). It presents almost the same information
as “newSubjects”, but in a more refined way. For example, a “LUBRICANTS” can be a new
subject in “newSubject”, but it could appear only for “ENGINE”. Or, “LUBRICANTS” can be new
for “TRANSMISSION”, but the car could have had “LUBRICANTS” for “ENGINE”, so it will not
appear in “newSubjects”, but it will appear in “newSubjectsByGroup”. This will be empty when
the operation is called for Makes or Models (it will have values only for Types)
```
Important note: If a car gets updates on a subject that it already had in a previous version, it

will not appear as “updated”. “Updated” means only that the subject (or the subject for a group) was

not there before. For example, if a car had “Wheel alignment” but no information about “Tyre

pressure” and the “Tyre pressure” is added in the new update of the database, the car will not have

ADJUSTMENTS in newSubjects or in newSubjectsByGroup in “STEERING” group.

This operation requires the following parameters:

###  descriptionLanguage – String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  level – Integer (this is the number that specifies if the wanted ExtCarType is a Make – level = 1

- a Model – level = 2 – or a Type – level = 3)

###  carTypeId – Integer[] (this is the id of the wanted ExtCarType)

Example:

Request:

1. <data:descriptionLanguage>en</data:descriptionLanguage>


34

2. <data:level> **3** </data:level>
3. <!--1 or more repetitions:-->
4. <data:carTypeId> **105000147** </data:carTypeId>
5. <data:carTypeId> **23** </data:carTypeId>

Response:

1. <getCarTypesUpdateStatusReturn>
2. <carTypeId> **105000147** </carTypeId>
3. < **newSubjects** >
4. <item>LUBRICANTS</item>
5. <item>DRAWINGS</item>
6. <item>EOBD_LOCATIONS</item>
7. <item>ENGINE_LOCATIONS</item>
8. </newSubjects>
9. < **newSubjectsByGroup** >
10. <item>
11. <key>ENGINE</key>
12. <value>LUBRICANTS</value>
13. </item>
14. <item>
15. <key>TRANSMISSION</key>
16. <value>LUBRICANTS</value>
17. </item>
18. <item>
19. <key>BRAKES</key>
20. <value>LUBRICANTS</value>
21. </item>
22. <item>
23. <key>EXTERIOR</key>
24. <value>LUBRICANTS,DRAWINGS</value>
25. </item>
26. <item>
27. <key>QUICKGUIDES</key>
28. <value>LUBRICANTS,DRAWINGS</value>
29. </item>
30. </newSubjectsByGroup>
31. <updateStatus>NEW</updateStatus>
32. </getCarTypesUpdateStatusReturn>

#### 2.2.6. FindCarTypesV2

The difference between this version and the previous one is that in the new version the

madeFrom and madeUntil fields of the returned ExtCarType objects contain only years.

This operation requires the following parameters:


35

###  descriptionLanguage – String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  searchString – String - this text will be split into words and searched in the full description and

engine code of all cars. If one word in the search string is not found, the result will be empty

Note!

The searchString should have at least 4 characters.

#### 2.2.7. findCarTypesByDetailsV3

This operation searches for cars based on specific elements, as brand, model name, type

description and engine code. It can look for full words or for parts of words.

The difference between this version and the previous one is that in the new version the

madeFrom and madeUntil fields of the returned ExtCarType objects contain only years.

This operation requires the following parameters:

###  descriptionLanguage – String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  makeDescription – String – this text will be searched in the description of all brands; if null or

empty, it will be ignored

###  wholeWordMakes – boolean – this can be “true” or “false”. If true, the searched word should

```
be found fully in the searched cars. For example, if true, in case the makeDescription value (for
example “alf”) is found in one of the brands name but it is not the full word (for example “alfa
romeo”), it will not be included in the results (it would if the makeDescripton would be set to
“alfa”).
```
###  modelDescription – String – this text will be searched in the description of all models; if null or

empty, it will be ignored

###  wholeWordModels – boolean – this can be “true” or “false”. If true, it will include a type only if

its model contains the modelDescription as a whole word (same as for wholeWordMakes)

###  modelCode – String – this text will be searched in the description of all models; if null or

empty, it will be ignored

###  wholeWordModelCode – boolean – this can be “true” or “false”. If true, it will include a type

only if its model contains the mode code as a whole word (same as for wholeWordMakes)

###  typeDescription – String – this text will be searched in the description of all types; if null or

empty, it will be ignored


36

###  wholeWordTypes – boolean – this can be “true” or “false”. If true, it will include a type only if it

contains the typeDescription as a whole word (same as for wholeWordMakes)

###  engineCode – String – this text will be searched in the engine codes ; if null or empty, it will be

ignored

###  wholeWordEngineCode – boolean – this can be “true” or “false”. If true, it will include a type

only if it contains the engineCode as a whole word (same as for wholeWordMakes)

###  engineCapacity – Integer– this text will be searched in the engine capacity of all types; if null or

empty, it will be ignored

###  engineOutput – Integer– this text will be searched in the engine output of all types; if null or

empty, it will be ignored

###  year – Integer– this text will filter types by built year; if null or empty, it will be ignored

Note!

If the only the makeDescription is set, the operation will return an empty result. It will not attempt to

do a search because the result would be too large (all the cars of a brand). The purpose of this

operation is to provide a better match, to identify, if possible, a single car.

Example:

Request:

1. <data:findCarTypesByDetailsV3>
2. <data:vrid>${vrid}</data:vrid>
3. <data:descriptionLanguage>en</data:descriptionLanguage>
4. <data:makeDescription>audi</data:makeDescription>
5. <data:wholeWordMakes>true</data:wholeWordMakes>
6. <data:modelDescription>q3</data:modelDescription>
7. <data:wholeWordModels>false</data:wholeWordModels>
8. <data:modelCode>8U</data:modelCode>
9. <data:wholeWordModelCode>false</data:wholeWordModelCode>
10. <data:typeDescription>1.4 TSi</data:typeDescription>
11. <data:wholeWordTypes>false</data:wholeWordTypes>
12. <data:engineCode>CHPB</data:engineCode>
13. <data:wholeWordEngineCode>false</data:wholeWordEngineCode>
14. <data:engineCapacity>1395</data:engineCapacity>
15. <data:engineOutput>110</data:engineOutput>
16. <data:year>2014</data:year>
17. </data:findCarTypesByDetailsV3>


37

Response:

18. <findCarTypesByDetailsV3Response xmlns="http://data.webservice.workshop.vivid.nl">
19. <findCarTypesByDetailsV3Return>
20. <capacity>1395</capacity>
21. <engineCode>CHPB</engineCode>
22. <fuelType>PETROL</fuelType>
23. <fullName>AUDI Q3 (8U) 1.4 TSI</fullName>
24. <id>301000621</id>
25. <level>3</level>
26. <madeFrom> **2014** </madeFrom>
27. <madeUntil> **2014** </madeUntil>
28. <modelPictureMimeDataName>http://www.haynespro-
    assets.com/workshop/images/319006177.svgz</modelPictureMimeDataName>
29. <name>1.4 TSI</name>
30. <order>0</order>
31. <output>110</output>
32. <remark xsi:nil="true"/>
33. <status xsi:nil="true"/>
34. <subjects>
35. <item>ADJUSTMENTS</item>
36. ...
37. <superCarTypeId>200000005</superCarTypeId>
38. </findCarTypesByDetailsV3Return>
39. </findCarTypesByDetailsV3Response>
40.

#### 2.2.8. decodeVINV4()

This operation decodes a Vehicle Identification Number (VIN) and returns the HaynesPro

CarTypes that match the encoded information, together with the repair time information associated to

each CarType.

The difference between this version and V3 is that in the new version the madeFrom and
madeUntil fields of the returned ExtCarTypeV3 objects contain only years.

This operation requires the following parameters:

###  descriptionLanguage – String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  vin – String - this text represents the VIN number that will be decoded into the HaynesPro Car


38

Types

The operation returns an array of ExtCarTypeV3 objects, if the code is recognized, or

empty/null if it is not. The returned objects have the following structure :

ExtCarTypeV3 {
Integer order;
Integer id;
String name;
String remark;
String fullName;
Integer level;
String madeFrom;
String madeUntil;
String engineCode;
Integer capacity;
Integer output;
String modelPictureMimeDataName;
Integer superCarTypeId;
String fuelType;
String[] subjects;
ExtMap subjectsByGroup;
ExtRepairtimeTypeV3[] repairTimeTypes;
ExtEtkSuggestion[] etkSuggestions;
ExtStatus status;
}

ExtEtkSuggestion {
String eggVarCode;
String[] eggImplementationCodes;
}

Comparing with the previous version we now also send ETK suggestions based on the make

and model identified by de vin decoder.

Request :

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:data="http://data.webservice.workshop.vivid.nl">
2. <soapenv:Header/>
3. <soapenv:Body>
4. <data:decodeVINV3>
5. <data:descriptionLanguage>en</data:descriptionLanguage>
6. <data:vin>WAUZZZ8L63A002427</data:vin>
7. </data:decodeVINV3>
8. </soapenv:Body>


39

9. </soapenv:Envelope>

Response:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <decodeVINV3Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <decodeVINV3Return>
5. <capacity>1595</capacity>
6. <engineCode>BFQ</engineCode>
7. **<etkSuggestions>**
8. <item xmlns:ns1="http://etk.data.webservices.workshop.vivid.nl">
9. **<ns1:eggImplementationCodes>**
10. <item>FM52K028R8L71T2L</item>
11. <item>FM52K028R8L60T4M</item>
12. <item>FM52K028R8L60T2L</item>
13. <item>FA41M034R8L60T2M</item>
14. <item>FA41M034R8L60T2L</item>
15. <item>FM52K028R8L60T4L</item>
16. <item>FA41M034R8L60T4M</item>
17. <item>FA41M034R8L60T4L</item>
18. <item>FA41M034R8L73T4L</item>
19. **</ns1:eggImplementationCodes>**
20. **<ns1:eggVarCode>** LBFQF1 **</ns1:eggVarCode>**
21. </item>
22. **</etkSuggestions>**
23. <fuelType>PETROL</fuelType>
24. <fullName>AUDI A3 (8L) 1.6</fullName>
25. <id>50700</id>
26. <level>3</level>
27. <madeFrom>2002-01</madeFrom>

#### 2.2.9. getCarTypesByTecdocNumberV3()

This operation retrieves an ExtWsIdentificationElement array based on a TecDoc number and

an engine number. The engine number is optional and if it is not specified the results are searched

based on the TecDoc number.

The difference between this version and V2 is that in the new version the madeFrom and

madeUntil fields of the returned ExtCarType objects contain only years.


40

It requires the following parameters when calling:

- descriptionLanguage – **en**
- tecdocNumber – numeric – **27526**
- rtTypeCategory – string – **CAR** (can be “CAR” or “TRUCK”)
- motnr – numeric – **25647**

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getCarTypesByTecdocNumberV3Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getCarTypesByTecdocNumberV3Return>
5. <capacity>1995</capacity>
6. <engineCode>M9R-786 (M7)</engineCode>
7. <fuelType>DIESEL</fuelType>
8. <fullName>OPEL/VAUXHALL Vivaro (X83) 2.0 CDTi 16V 90</fullName>
9. <id>102002417</id>
10. <level>3</level>
11. <madeFrom> **2009** </madeFrom>
12. <madeUntil> **2014** </madeUntil>
13. <modelPictureMimeDataName>http://localhost:8080/
workshop/images/vivaro_dba_soest.jpg</modelPictureMimeDataName>
14. <name>2.0 CDTi 16V 90</name>
15. <order>0</order>
16. <output>66</output>
17. <remark xsi:nil="true"/>
18. <status xsi:nil="true"/>
19. <subjects>
20. <subjects>ADJUSTMENTS</subjects>
21. <subjects>MAINTENANCE</subjects>
22. <subjects>LUBRICANTS</subjects>
23. <subjects>DRAWINGS</subjects>
24. <subjects>EOBD_LOCATIONS</subjects>
25. <subjects>FUSE_LOCATIONS</subjects>
26. <subjects>ENGINE_LOCATIONS</subjects>
27. <subjects>STORIES</subjects>
28. <subjects>WARNING_LIGHTS</subjects>
29. <subjects>REPAIR_TIMES</subjects>
30. <subjects>TIMING_REPAIR_MANUALS</subjects>
31. <subjects>VESA_ENGINE</subjects>
32. <subjects>VESA_ABS</subjects>


41

33. <subjects>VESA_EXT_INT</subjects>
34. <subjects>SHOW_VESA</subjects>
35. <subjects>RECALLS</subjects>
36. </subjects>
37. <subjectsByGroup>
38. <mapItems>
39. <mapItems>
40. <key>ENGINE</key>
41. <value>ADJUSTMENTS,LUBRICANTS,STORIES,
REPAIR_TIMES,COMMONRAIL</value>
42. </mapItems>
43. <mapItems>
44. <key>TRANSMISSION</key>
45. <value>ADJUSTMENTS,LUBRICANTS,STORIES,
REPAIR_TIMES</value>
46. </mapItems>
47. <mapItems>
48. <key>STEERING</key>
49. <value>ADJUSTMENTS,LUBRICANTS,STORIES,
DRAWINGS,REPAIR_TIMES</value>
50. </mapItems>
51. <mapItems>
52. <key>BRAKES</key>
53. <value>ADJUSTMENTS,LUBRICANTS,DRAWINGS,
REPAIR_TIMES</value>
54. </mapItems>
55. <mapItems>
56. <key>EXTERIOR</key>
57. <value>ADJUSTMENTS,LUBRICANTS,STORIES,
DRAWINGS,REPAIR_TIMES</value>
58. </mapItems>
59. <mapItems>
60. <key>ELECTRONICS</key>
61. <value>STORIES,WARNING_LIGHTS,FUSE_LOCATIONS,
VESA_ENGINE,VESA_ABS,VESA_EXT_INT,SHOW_VESA</value>
62. </mapItems>
63. <mapItems>
64. <key>QUICKGUIDES</key>
65. <value>ADJUSTMENTS,LUBRICANTS,STORIES,
WARNING_LIGHTS,DRAWINGS,REPAIR_TIMES</value>
66. </mapItems>
67. </mapItems>
68. </subjectsByGroup>
69. <superCarTypeId>4710</superCarTypeId>
70. </getCarTypesByTecdocNumberV3Return>
71. </getCarTypesByTecdocNumberV3Response>


42

72. </soapenv:Body>
73. </soapenv:Envelope>

#### 2.2.10. getCarTypesByKBAV3()

This operation retrieves an ExtWsIdentificationElement array based on a KBA identifier.

The difference between this version and V2 is that in the new version the madeFrom and

madeUntil fields of the returned ExtCarType objects contain only years.

It requires the following parameters when calling:

### ✦ descriptionLanguage - en

### ✦ KBA - numeric – 1234

### ✦ typeCategory - String

```
The difference between V2 and initial version is that we have added in request a parameter
called typeCategory so that we can filter the data and retrieve search results for MOTO. In order
to activate search by KBA for motorcycle typeCategory should be used with the value
“ MOTORCYCLE ”. Any other value used will get to PASSENGER-LCV search.
```
The request for the new operation (MOTO) is:

Request :

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
xmlns:data="http://data.webservice.workshop.vivid.nl">
2. <soapenv:Header/>
3. <soapenv:Body>
4. <data:getCarTypesByKBAV3>
5. <data:vrid>${vrid}</data:vrid>
6. <data:descriptionLanguage>en</data:descriptionLanguage>
7. <data:KBA>1008ac</data:KBA>
8. < **data:typeCategory** >MOTORCYCLE</d **ata:typeCategory** >
9. </data:getCarTypesByKBAV3>
10. </soapenv:Body>
11. </soapenv:Envelope>

The result of calling this operation is:


43

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getCarTypesByKBAV3Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getCarTypesByKBAV3Return>
5. <capacity>1202</capacity>
6. <engineCode>EVOLUTION (3)</engineCode>
7. <fuelType>PETROL</fuelType>
8. <fullName>HARLEY DAVIDSON 1200 Custom /-Limited (XL1200C, XL1200CA, XL1200CB, XL1200CP) 1200
EFI</fullName>
9. <id>619008951</id>
10. <level>3</level>
11. <madeFrom> **2014** </madeFrom>
12. <madeUntil xsi:nil="true"/>
13. <modelPictureMimeDataName>http://www.haynespro-
assets.com/workshop/images/319039629.svgz</modelPictureMimeDataName>
14. <name>1200 EFI</name>
15. <order>0</order>
16. <output>50</output>
17. <remark xsi:nil="true"/>
18. <status xsi:nil="true"/>
19. <subjects>
20. <subjects>ADJUSTMENTS</subjects>
21. <subjects>MAINTENANCE</subjects>
22. <subjects>LUBRICANTS</subjects>
23. <subjects>DRAWINGS</subjects>
24. <subjects>EOBD_LOCATIONS</subjects>
25. <subjects>FUSE_LOCATIONS</subjects>
26. <subjects>STORIES</subjects>
27. <subjects>REPAIR_TIMES</subjects>
28. <subjects>VESA_ENGINE</subjects>
29. <subjects>SHOW_VESA</subjects>
30. </subjects>
31. <subjectsByGroup>
32. <mapItems>
33. <mapItems>
34. <key>ENGINE</key>
35. <value>ADJUSTMENTS,LUBRICANTS,REPAIR_TIMES</value>
36. </mapItems>
37. <mapItems>
38. <key>TRANSMISSION</key>
39. <value>ADJUSTMENTS,LUBRICANTS,REPAIR_TIMES</value>
40. </mapItems>
41. <mapItems>
42. <key>STEERING</key>
43. <value>ADJUSTMENTS,LUBRICANTS,DRAWINGS,REPAIR_TIMES</value>


44

44. </mapItems>
45. <mapItems>
46. <key>BRAKES</key>
47. <value>ADJUSTMENTS,LUBRICANTS,DRAWINGS,REPAIR_TIMES</value>
48. </mapItems>
49. <mapItems>
50. <key>EXTERIOR</key>
51. <value>ADJUSTMENTS,STORIES,REPAIR_TIMES</value>
52. </mapItems>
53. <mapItems>
54. <key>ELECTRONICS</key>
55. <value>FUSE_LOCATIONS</value>
56. </mapItems>
57. <mapItems>
58. <key>QUICKGUIDES</key>
59. <value>ADJUSTMENTS,LUBRICANTS,STORIES,DRAWINGS,REPAIR_TIMES</value>
60. </mapItems>
61. </mapItems>
62. </subjectsByGroup>
63. <superCarTypeId>319000974</superCarTypeId>
64. </getCarTypesByKBAV3Return>
65....


45

### 2.3. Truck/trailer configuration

#### 2.3.1. getAxleComponents()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carTypeId – int (this number is the “id” of the Type found in ExtCarType; you can check chapter

3 for more information about this object)

**It returns an array of ExtAxleComponent** that represents all the axle components that a truck

or trailer can have. The returned axle components ids can be used furthermore to retrieve specific

information based on axle selection. The following operations have been added to retrieve data based

on this selection: getDrawingsV3(), getAdjustmentsV7() and getLubricantsV4().

The returned object have the following structure:

ExtAxleComponent {
Integer id;
String description;
String remark;
ExtStatus oem;
String[] axleType;
String[] componentCodes;
Integer sortOrder;
ExtStatus status;
}

The meaning of the above elements are:

###  id : identification number of the axle component

###  description : full description of the axle

###  remark : this is a string that can give additional information.

###  oem : original equipment manufacturer that produces the axle components

###  axleType : an array of strings that specify the categories that the axle is part of (Front axle/Rear

axle/Self steering axle/ etc.)

###  componentCodes : codes that can differentiate type of axles

###  sortOrder : this number gives the order in which the elements should be shown. When

receiving the request, elements should be already ordered. It is used mainly to give a clue in


46

case the client does not preserve the order in which the elements are received.

###  status : the status will contain 0 if the request was successful or another number if there was

an error (the possible errors are presented in chapter 2.1)

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carTypeId – int – 301000862

The result of calling this operation is:

1. <getAxleComponentsReturn>
2. <axleType>
3. <item>Front axle</item>
4. </axleType>
5. <componentCodes>
6. <item>739.505</item>
7. </componentCodes>
8. <description>MERCEDES-BENZ, Actros MP4/Antos, Front axle, (739.505)</description>
9. <id> 306000454 </id>
10. <oem>MERCEDES-BENZ</oem>
11. <remark>Actros MP4/Antos</remark>
12. <sortOrder> 90 </sortOrder>
13. <status xsi:nil="true"/>
14. </getAxleComponentsReturn>


47

## 3. GENERAL INFORMATION

### 3.1. Structure

The “general information” operation return links to static HTML pages that contain information

about general things, so the same links are shown for all cars.

This is the car-home page form Workshop ATI Online:

Figure 4.1.1 – Car-Home – General information

The only difference that could appear between two cars related to general information is in


48

case the fuel of the two cars are different. For example, if the engine is a PETROL engine, you will see

the “Spark plug diagnosis” link. If the engine is a DIESEL engine, you will see the “Diesel Pump” link.

### 3.2. Operations

#### 3.2.1. getGeneralInformationLinks()

**This operation returns a map** that has as key the description of the link and as value, the URL

of the HTML file.

The keys that the operation can return are:

###  SPARK_PLUG_DIAGNOSIS

###  DIESEL_PUMP

###  COMM_RAIL

###  CLUTCH_FAULT_DIAGNOSIS

###  SHOCK_ABSORBER

###  WHEEL_ALIGNMENT

###  TYRE_SPECIFICATIONS

###  AIR_BAGS

###  AIR_CONDITIONING

It requires the following parameters when calling:

###  descriptionLanguage - String – (this should be a 2 - character string, established by the 639- 1

ISO; for example, for English it is “en”, for French it is “fr”)

We will call this operation with the descriptionLanguage set to “en”. The result of this request

would be:

15. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
16. <soapenv:Body>
17. <getGeneralInformationLinksResponse xmlns="http://data.webservice.workshop.vivid.nl">
18. <getGeneralInformationLinksReturn>
19.
20. <item xmlns="" xmlns:ns1="http://xml.apache.org/xml-soap">
21. <key xsi:type="xsd:string"> **CLUTCH_FAULT_DIAGNOSIS** </key>
22. <value xsi:type="xsd:string"> **[http://www.haynespro-](http://www.haynespro-)**
    **services.com:8080/workshop/static_html/en/clutch/clutcha.html** </value>


49

23. </item>
24. <item xmlns="">
25. <key xsi:type="xsd:string"> **WHEEL_ALIGNMENT** </key>
26. <value xsi:type="xsd:string"> **[http://www.haynespro-](http://www.haynespro-)**
    **services.com:8080/workshop/static_html/en/wheel/wheel.html** </value>
27. </item>
28. <item xmlns="">
29. <key xsi:type="xsd:string"> **TYRE_SPECIFICATIONS** </key>
30. <value xsi:type="xsd:string"> **[http://www.haynespro-](http://www.haynespro-)**
    **services.com:8080/workshop/static_html/en/tyre/tyre_specifications.html** </value>
31. </item>
32. <item xmlns="">
33. <key xsi:type="xsd:string"> **SPARK_PLUG_DIAGNOSIS** </key>
34. <value xsi:type="xsd:string"> **[http://www.haynespro-](http://www.haynespro-)**
    **services.com:8080/workshop/static_html/en/spark_plug/sparkplug.html** </value>
35. </item>
36. <item xmlns="">
37. <key xsi:type="xsd:string"> **DIESEL_PUMP** </key>
38. <value xsi:type="xsd:string"> **[http://www.haynespro-](http://www.haynespro-)**
    **services.com:8080/workshop/static_html/en/diesel_pump/dieselpump.html** </value>
39. </item>
40. <item xmlns="">
41. <key xsi:type="xsd:string"> **SHOCK_ABSORBER** </key>
42. <value xsi:type="xsd:string"> **[http://www.haynespro-](http://www.haynespro-)**
    **services.com:8080/workshop/static_html/en/shock_absorber/shocka.html** </value>
43. </item>
44. <item xmlns="">
45. <key xsi:type="xsd:string"> **AIR_CONDITIONING** </key>
46. <value xsi:type="xsd:string"> **[http://www.haynespro-](http://www.haynespro-)**
    **services.com:8080/workshop/static_html/en/airco/airco_basic_principle.html** </value>
47. </item>
48. <item xmlns="">
49. <key xsi:type="xsd:string"> **AIR_BAGS** </key>
50. <value xsi:type="xsd:string"> **[http://www.haynespro-](http://www.haynespro-)**
    **services.com:8080/workshop/static_html/en/airbags/srs_systemen.html** </value>
51. </item>
52. </getGeneralInformationLinksReturn>
53. </getGeneralInformationLinksResponse>
54. </soapenv:Body>
55. </soapenv:Envelope>

You can check the 4.1.1 figure to identify where each link goes or call the next operation which

returns the links for each group.

There are two of these links that are different from the others:


50

###  DIESEL_PUMP

###  COMM_RAIL

You can find an indication in the subjectsByGroup, in the group ENGINE, if they should be

displayed or not. If “DIESELPUMP” appears in subjectsByGroup, then the link for the DIESEL_PUMP

should be shown. If “COMMONRAIL” appears in subjectsByGroup, then the link for the “COMM_RAIL”

should be shown.

#### 3.2.2. getGeneralInformationLinksByGroup()

**This operation returns a map** that has as key the description of the link and as value, the URL

of the HTML file. The keys that the operation can return are the same as for 4.2.1

getGeneralInformationLinks().

It requires the following parameters when calling:

###  descriptionLanguage - String – (this should be a 2 - character string, established by the 639- 1

ISO; for example, for English it is “en”, for French it is “fr”)

###  carTypeGroup – String – (this group is the same as in table 3.1.2). It can be any of:

### ◦ ENGINE

### ◦ TRANSMISSION

### ◦ STEERING

### ◦ EXTERIOR

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carTypeGroup – String – ENGINE

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getGeneralInformationLinksByGroupResponse xmlns="http://data.webservice.workshop.vivid.nl">
4. <getGeneralInformationLinksByGroupReturn>
5. <item xmlns="" xmlns:ns1="http://xml.apache.org/xml-soap">
6. <key xsi:type="xsd:string"> **SPARK_PLUG_DIAGNOSIS** </key>
7. <value xsi:type="xsd:string"> **[http://www.haynespro-](http://www.haynespro-)**
    **services.com:8080/workshop/static_html/en/spark_plug/sparkplug.html** </value>
8. </item>
9. <item xmlns="">
10. <key xsi:type="xsd:string"> **DIESEL_PUMP** </key>
11. <value xsi:type="xsd:string"> **[http://www.haynespro-](http://www.haynespro-)**


51

```
services.com:8080/workshop/static_html/en/diesel_pump/dieselpump.html </value>
```
12. </item>
13. </getGeneralInformationLinksByGroupReturn>
14. </getGeneralInformationLinksByGroupResponse>
15. </soapenv:Body>
16. </soapenv:Envelope>

#### 3.2.3. getGeneralInformationLinksExtMap() and getGeneralInformationLinksByGroupExtMap()

These two operations require the same parameters and return the same information as

getGeneralInformationLinks() and getGeneralInformationLinksByGroup(), but in a format which is

compatible with Microsoft .NET web-services library.


52

## 4. ADJUSTMENTS

### 4.1. Structure

Adjustments is one of the subjects available for a car. You can have adjustments for Engine,

Transmission, Steering & Suspension, Brakes, Exterior / Interior (and Quickguides, where all the

information for adjustments is presented in the same page).

This image is the Car-Home page from Workshop ATI Online. It shows where the links to

adjustments are:

Figure 5.1.1 – Car Home - Adjustments

In Web-Services, for Adjustments, there is only one structure, but the same structure can


53

represent different levels in the data.

There are two structures:

ExtAdjustmentV3 {
String name;
int order;
String remark;
String unit;
String value;
ExtAdjustmentV3[] subAdjustments;
String imageName;
Integer descriptionId;
ExtStatus status;
Integer extraInfoId;
ExtSmartLink[] smartLinks;
}

ExtAdjustmentV6 {
String name;
int order;
String remark;
String unit;
String value;
ExtAdjustmentV6[] subAdjustments;
String imageName;
Integer descriptionId;
ExtStatus status;
Integer extraInfoId;
ExtSmartLink[] smartLinks;
ExtGeneralArticle[] genarts;
ExtCriteriaGroup[] generalCriterias;
boolean visible;
}

All the elements inside the two structures will be explained below:

###  name : this element is the one that is shown. It is dependent on the language, and it can

```
contain the name of the group (“Engine”, “Cooling system”, “Belt layout” ...) or the name of the
adjustment (“Engine code”, “Capacity”, “Idle speed”)
```
###  order : this number gives the order in which the elements should be shown. When receiving

```
the request, elements should be already ordered. It is used mainly to give a clue in case the
client does not preserve the order in which the elements are received.
```
###  remark : this is a string that can give additional information. It is language dependent, and you

can see it in the above image (figure 5.1.2) written in italics (for “Injection pressure / system


54

```
pressure (With vacuum hose off)”, the name is “Injection pressure / system pressure” and the
remark is “With vacuum hose off”). This element can be null.
```
###  unit : this elements represent the unit of measurement for that adjustment. You can see it in

```
the above image as the last column (for example: “bar”, “mm”, “rpm”). This element can be
null if the value of the adjustment does not have a measurement unit (for example an engine
code does not have one)
```
###  value : this element represent the value of the adjustment. In the image above it is on the

```
second column (for example “AKQ”, 1390, 700-800). It is a string because it can represent any
kind of value, not only numeric ones. It can be null.
```
###  subAdjustments : the adjustment information is split in three. The first level, which is

```
represented by the groups (“Engine”, “Capacity”, “Idle speed”) and the main adjustments (like
“Engine code”, “Capacity”, “Idle speed”) the next two levels. The first level, the groups, have
information only in name , where the name of the group is specified, and in subAdjustments.
Here, each group have the main adjustments. The main adjustments (or the sub-adjustments
of each group) give the real adjustments information. Only at this level you will find units,
values, or images. The third level is present when there is indentation.
```
###  imageName : there are adjustments that can refer in their content to an image. This property

can contain the URL to such an image.

###  descriptionId : this is a number that helps identify some key elements related to Environmental

data, so the recognition is not dependent on the language. These numbers are:

### ◦ 1000 for Emission code

### ◦ 1001 for Emission standard

### ◦ 1002 for CO2 average

### ◦ 1003 for CO

### ◦ 1004 for HC

### ◦ 1005 for NOx

### ◦ 1006 for HC Nox

###  status : the status will contain 0 if the request was successful or another number if there was

an error (the possible errors are presented in chapter 2.1)

###  extraInfoId : this is a number that should be used with “getAdjustmentExtraInfo” to get the

```
information. It usually appears on sentences with this content: “Refer to extra info” (for
example, the extra info can be “Height measurement”). It is recommended that the content of
```

55

the extra info is displayed only on user request

###  smartLinks : this is a true/false value. It shows links from adjustments to other subjects (like

```
lubricants, technical drawings and so on). See chapter “6.2.3 Smart Links” for more details
about Smart Links.
```
###  genarts : this is a true/false value. This is an array of complex objects that can contain numbers

(ids) of General Article Numbers (genArt numbers, provided by TecDoc).

###  generalCriterias : this property contains an array of ExtCriteriaGroup objects. Each object stores

```
adjustment criteria grouped by criteria groups. Each criteria group can have more than one
general criteria linked. These criteria's can be linked both to a description and a remark and we
can find out which criteria level is by using the field criteriaLevel.
```
###  visible : this is a true/false value. This shows if an adjustment component is visible (has a

measurement unit and a value) or not.

### 4.2. Operations

#### 4.2.1. getAdjustmentsV7()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639- 1

```
ISO; for example, for English it is “en”, for French it is “fr”)
```
###  carType – Integer (this number is the “id” of the Type found in ExtCarType; you can check chapter 3 for

```
more information about this object)
```
###  carTypeGroup – String – (this group is the same as in table 3.1.2). It can be:

### ◦ ENGINE

### ◦ TRANSMISSION

### ◦ STEERING

### ◦ BRAKES

### ◦ EXTERIOR

### ◦ ELECTRONICS

### ◦ QUICKGUIDES

###  includeSmartLinks – Boolean – indicates if the Smart Links should be included or not

###  includeGenarts – Boolean – indicates if genarts should be included or not


56

###  includeCriterias – Boolean – indicates if criteria should be included or not

###  axleComponents – Integer – a list of axle components ids taken from “getAxleComponents” operation.

```
It is showing information for the selected axle components. These axle components should be linked to
requested carType. If no axle component is provided, then all the adjustment information is, otherwise
it will be filtered using the provided axle components.
```
**This operation returns an array of ExtAdjustmentV6** that represent all the adjustments for the specified

type. Before calling this operation, you can check ExtCarType.subjects to see if it contains

“ADJUSTMENTS”. If it does, the operation will return information. If not, it will return null.

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carType – Integer – 301000862 (MERCEDES-BENZ ACTROS MP4 (963) 1830 L 2011-)

###  carTypeGroup – String - QUICKGUIDES

###  includeSmartLinks – Boolean – false

###  includeGenarts – Boolean – false

###  includeCriterias – Boolean – false

###  axleComponents – Integer – 305005545 (MERCEDES-BENZ, Rear axle, (748.595))

The difference between **_getAdjustmentsV6_** and **_getAdjustmentsV7_** is that the last one has the

option to filter the adjustment data with provided axle components ids. The result of calling this

operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getAdjustmentsV7Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getAdjustmentsV7Return>
5. <descriptionId xsi:nil="true"/>
6. <extraInfoId xsi:nil="true"/>
7. <genarts xsi:nil="true"/>
8. <generalCriterias xsi:nil="true"/>
9. <imageName xsi:nil="true"/>
10. <name>Capacities</name>


57

11. <order>0</order>
12. <remark xsi:nil="true"/>
13. <smartLinks xsi:nil="true"/>
14. <status xsi:nil="true"/>
15. <subAdjustments>
16. ...
17. <item>
18. <descriptionId>comp_2699</descriptionId>
19. <extraInfoId xsi:nil="true"/>
20. <genarts xsi:nil="true"/>
21. <generalCriterias xsi:nil="true"/>
22. <imageName xsi:nil="true"/>
23. <name> **MERCEDES-BENZ, Rear axle, (748.595)** </name>
24. <order>11</order>
25. <remark xsi:nil="true"/>
26. <smartLinks xsi:nil="true"/>
27. <status xsi:nil="true"/>
28. <subAdjustments>
29. <item>
30. <descriptionId>470</descriptionId>
31. <extraInfoId xsi:nil="true"/>
32. <genarts xsi:nil="true"/>
33. <generalCriterias xsi:nil="true"/>
34. <imageName xsi:nil="true"/>
35. <name>Differential</name>
36. <order>0</order>
37. <remark xsi:nil="true"/>
38. <smartLinks xsi:nil="true"/>
39. <status xsi:nil="true"/>
40. <subAdjustments xsi:nil="true"/>
41. <unit>(l)</unit>
42. <value>14.0</value>
43. <visible>true</visible>
44. </item>
45. </subAdjustments>
46. <unit xsi:nil="true"/>
47. <value xsi:nil="true"/>
48. <visible>false</visible>
49. </item>
50. ....
51. </subAdjustments>
52. <unit xsi:nil="true"/>
53. <value xsi:nil="true"/>
54. <visible>true</visible>
55. </getAdjustmentsV7Return>
56. </getAdjustmentsV7Response>


58

57. </soapenv:Body>
58. </soapenv:Envelope>

#### 4.2.2. getAdjustmentsEnvOnlyV3()

This operation returns exactly the same type of objects (the same structure), and it takes the same

parameters, but it there are two differences:

###  it returns results only for groups: ENGINE and QUICKGUIDES

###  it filters the data so that only the environmental data is shown

#### 4.2.3. getAdjustmentsExtraInfo

This operation is deprecated. Extra info adjustment is in fact a repair manual and the

extraInfoId parameter required by this method is analogous to storyId. The same information can be

obtained by calling getStoryInfoVx methods. More details on how to call those operations on chapter

9.2.3.


59

## 5. MAINTENANCE

### 5.1. Structure

Maintenance is one of the subjects available for a car. It is not split into groups, as it is in

Adjustments.

Figure 6.1.1 Car Home – Maintenance

Maintenance information is divided in 4 levels. The first two levels are included in two different

objects and the last two levels into another object.


60

This is a screenshot from Workshop ATI Online. Based on it, we will describe each element of

Maintenance.

Figure 6.1.2 – Maintenance – Systems(1), Periods(2), Task-groups(3) and Tasks(4)

Next, we will describe each level:

###  level 1 : The first level is called System. Normally, there should be only one system, but if there

```
are conditions that make the maintenance procedure different, more systems appear. One of
these conditions is usually the change in specifications (so you could have a system that
contains maintenance for cars that were built before a year and another for those built after
that year). Another criteria could be the type of maintenance (for example “long life” or
“time/distance dependent”). If there is only one system, the name is not important (it can
even be null) because maintenance systems bring in information only when you have to
distinguish between two or more. When there is only one system, it is used just as a container
```

61

for level 2.

###  level 2 : The second level is called Period. It contains information about when the maintenance

```
procedure should be done or about what the procedure refers to (for example: “Every 12
months”, or “Every 60,000 km” or “Timing belt intervals”. This level can never be null (it always
contains at least 2 elements).
```
###  level 3 : The third level is called Task-group. It groups the next level into groups. For example, it

```
can be “Engine” or “Clutch, gearbox and final drives”. This level is also not null for all existing
periods.
```
###  level 4 : The fourth level is the last level. It contains the description of each actual task. For

example: “Renew the oil filter”

#### 5.1.1. Maintenance Intervals default data structure

Next, we will describe the structures that contain the information for these levels:

ExtMaintenanceSystemV6 {
**int** id;
**String** name;
**ExtMaintenancePeriodV6** [] maintenancePeriods;
**ExtCriteria[]** criteria;
**ExtCriteriaGroup[]** generalCriterias;

}

###  id : this is an identifier for the Maintenance System. At the moment, it is used only for the

```
operation that returns maintenance times (getMaintenanceTasksWithTimes and
getMaintenanceTasksWithSmartLinksAndTimes).
```
###  name : if there are two or more systems, based on this name, the user can select the

appropriate system. It is language dependent

###  maintenancePeriods : each system contains a set of periods. These periods are contained by

this array.

###  criteria : the criteria is a relation of the Maintenance Systems to the Criteria objects defined

and maintained by TecDoc

###  generalCriterias : this property contains an array of ExtCriteriaGroup objects. Each object stores

```
all maintenance criteria grouped by criteria groups. Each criteria group can have more than
one general criteria linked. These criteria's can be linked both to a description and a remark
and we can find out which criteria level is by using the field criteriaLevel.
```

62

ExtCriteria {
**Integer** kritnr;
**Integer** tabnr;
**String** keyValue;
**String** attributeTypeDescription;
**String** keyTableDescription;
**String** keyValueDescriptions;
}

###  kritnr : the id as described by TecDoc

###  tabNr : the id as described by TecDoc

###  keyValue : the id as described by TecDoc

###  attributeTypeDescription : the description for the kritnr;

###  keyTableDescription : the description for the tabNr

###  keyValueDescription : the value for the (kritnr, tabNr, keyValue) combination

ExtCriteriaGroup {
**Integer** groupId;
**String** groupDescription;
**ExtCriteriaGeneral[]** groupCriterias;
}

###  groupId : the id of the criteria group

###  groupDescription : the description of the criteria group. Some of the criteria group descriptions

```
will not be translated. We can identify these types of non-translated group descriptions by
having in front of the text the “@” e.g., ”@unit.”
```
###  groupCriterias : this represents an array containing all maintenance criteria's which are linked

to a certain group

ExtCriteriaGeneral {
**Integer** criteriaId;
**String** description;
**Integer** value1;
**Integer** value2;
**String** criteriaLevel;

}

###  criteriaId : the id of the criteria

###  description : the description of the criteria


63

###  value1 : this represents the value associated with a certain criteria ex :when criteria is

@months the value1 is 72. This should be implemented as 72 months

###  value2 : this represents the value associated with a certain criteria ex :when criteria is

```
@months the value2 is 36. This should be implemented as 36 months. When value1 and
value2 are both not null it means that criteria applies for both values.
```
###  criteriaLevel : this represents the level of how the criteria is linked to maintenance. These

```
criteria can be linked both to a description and remark. So, it results 2 possible criteria levels:
DESCRIPTION and REMARK
```
ExtMaintenancePeriodV6 {
**String** name;
**int** id;
**Integer** periodSentenceId;
**ExtTime[]** times;
**boolean** combinable;
**ExtCriteriaGroup[]** generalCriterias;

##### }

###  name : the name is language dependent and based on it the user selects the appropriate

period

###  id : this is a number that is used to relate the tasks to each period

###  periodSentenceId: this is a number that represents the id of the period sentence

###  combinable : There are cars for which the maintenance periods of a system can be performed

```
together. Only periods from the same system can be combined. To combine them, you only
need to set the ids of the periods that the user wants to combine as “periodId”
```
###  times : this property contains the time it takes to perform the maintenance tasks of the period.

```
It can contain more values, but only one is “selected” and that one should be used. It is
represented by a structure that will be presented next
```
###  generalCriterias : this property contains an array of ExtCriteriaGroup objects. Each object stores

```
all maintenance criteria grouped by criteria groups. Each criteria group can have more than
one general criteria linked. These criteria's can be linked both to a description and a remark
and we can find out which criteria level is by using the field criteriaLevel.
```
ExtTime {
**int** value;
**String** type;
**String** code;


64

**boolean** selected;
}

###  value : this represent the time and it is encoded as an integer having the last two digits as

```
decimal values (100 means 1.00, 133 means 1.33, 50 means 0.5) and the time is expressed in
hours (0.5 means 30 minutes, 1.20 means 1 hour and 0.2 * 60 = 12 minutes)
```
###  type : this is a text that can contain only one of the three values:

### ◦ COMPUTED_TIME: this is calculated based on repair times

### ◦ COMMERCIAL_TIME: this is the official time presented by the producer of the car in the

official documentation

### ◦ REGIONAL_TIME: this is the official time for a certain country; we establish the region at

authentication based on the country of the distributor of our product;

###  code : this is a text that represents a code provided by the manufacturer (also known as the

```
“manufacturer-code”) of the car related to the time; it can be null, and it is not language
dependent
```
###  selected : when we have more types of times, we present all of them and we set as selected

```
the most appropriate one (we consider them is this order: REGIONAL_TIME,
COMMERCIAL_TIME, COMPUTED_TIME; the first one in this order that exists will become the
“selected” one)
```
ExtMaintenanceTaskV8 {
**String** name;
**int** order;
**String** remark;
**String[]** longDescriptions;
**boolean** mandatoryReplacement;
**ExtGeneralArticle[]** generalArticles;
**ExtMaintenanceTaskV8[]** subTasks;
**ExtSmartLink[]** smartLinks;
**ExtTime[]** times;
**ExtRepairtimeNodeV4[]** followUpRepairs;
**String** repairTimesTaskId;
**ExtCriteria[]** criteria;
**String** descriptionId;
**boolean** includeByDefault;
**boolean** overrulingRemark;
**ExtCriteriaGroup[]** generalCriterias;

}

###  name : the name is the description of the Task-group or the description of the Task. It is

language dependent

###  order : this is a number that establishes the order in which the returned element should be


65

displayed.

###  remark : this is a string that can complete the description provided by “name”. It is language

```
dependent, and it is separated from the name to provide the possibility to provide a special
styling to this text (for example to show it in italics)
```
###  longDescription : some tasks can have more detailed description than the “name” property

```
provides. This property, if it is not null, provides an array of descriptions that describe the same
action but split into more lines. (for example, instead of “Check the brake lines, hoses and
connections for leaks and damage”, you can get all these lines: “Brake lines and hoses:”,
“Inspect the brake lines for damage, leaks and corrosion”, “Inspect all hoses for damage, leaks
and cracks”, “Inspect all connections for damage and leaks”, “Inspect the attachment of all
hoses and lines”, “Check all hoses for excessive bending and or kinks”, “Check that the brake
lines and hoses are routed with an adequate clearance from sharp edges, moving parts and the
exhaust”);
```
###  mandatoryReplacement : this property is set to “true” if the task requires a part of the car to

```
be replaced (for example “Renew the oil filter”, this property is set to “true”, while for “Check
the brake fluid level, top up if necessary” this property is set to “false”)
```
###  serviceTaskParts : this property is an array of ExtServiceTaskPart objects. If the task refers to

```
known parts of the car (that could require replacement), you will find a number or a list of
numbers that represent those parts (for example, 7 stands for “Oil filter”, 39 stands for “Trailer
Hitch”). We do not create these numbers. We only create a link between them and the
Maintenance Tasks. The part ids can come from different authorities (for example: “TECDOC”,
“ETAI”).
```
###  subTasks : Tasks are divided in two categories: one is Group-tasks (which is in fact a name of a

```
group of tasks – for example “Engine” or “Electrical systems”) and the other is Tasks (the
description of what needs to be done – for example “Replace oil filter” or “Check air filter”).
The Group-task have this property not-null, and it contains the Tasks that are related to this
group. Because the Tasks have the same structure as Group-task, they have this property, but it
will always be null.
```
###  smartLinks : this property is an array of custom objects of type ExtSmartLink. It can contain

```
information (this means that many times it will be null) that relates a task (the object that
contains it) to other subjects (like adjustments, technical drawings, or repair manuals). Because
getting these links from the database increases the time to retrieve the information, there are
two operations that retrieve the tasks: one includes these “smartLinks”
(getMaintenanceTasksWithSmartLinks) and one that returns the tasks without these links
(getMaintenanceTasks). Both of them will return the same type of objects, but for the second
one, all “smartLinks” properties will be null.
```

66

###  time : this property is set only when one of the operations that retrieves times is called

```
(getMaintenanceTasksWithTimes and getMainteanceTasksWithSmartLinksAndTimes). If this
property is not null, it means that the value is added to the total time (from the
ExtMaintenancePeriod)
```
###  followUpRepairs : this property is set only when one of the operations that retrieves times is

```
called (getMaintenanceTasksWithTimes and getMainteanceTasksWithSmartLinksAndTimes). If
this property is not null, it contains an array of ExtRepairtimesNode. These tasks are optional,
and the times are not included in the total time of the period.
```
###  repairTimesTaskId : this is a text that represents the id of the repair task (from repair times)

```
that is equivalent. This will be null for all mandatory tasks, but it can be null also for optional
tasks. This property will be used to calculate combined tasks for maintenance and repair times.
```
###  criteria : the criteria is a relation of the maintenance task to the Criteria objects defined and

maintained by TecDoc; the structure of ExtCriteria is defined above (in this chapter).

###  descriptionId : this is a text which appears for the lowest level of ExtMaintenanceTaskV5 and

```
uniquely identifies the description. If the same description appears in another interval, the
descriptionId should be the same.
```
###  includeByDefault : this is a true/false value, and it specifies if the task is included by default in

the service interval

###  overrulingRemark : this is a true/false value, and it specifies if the remark is overruling (if it

```
contains a condition that could make the task optional); at the moment it is the opposite of
“includedByDefault” but in the future the condition for including a task by default in an
interval may be different
```
###  generalCriterias : this property contains an array of ExtCriteriaGroup objects. Each object stores

```
all maintenance criteria grouped by criteria groups. Each criteria group can have more than
one general criteria linked. These criteria's can be linked both to a description and a remark
and we can find out which criteria level is by using the field criteriaLevel.
```

67

Figure 6.1.3 – Maintenance – compare normal/long descriptions

In the next picture (Figure 6.1.3), you can see the difference between the normal description

(which is in the “name” property) and the long description (which is in the “longDescription”

property). The green squares, marked with 1 and 2, show two tasks that have both descriptions


68

(normal and long). The blue square, marked with 3, shows a task that only has the normal description

(no long description). For this one, even if “Detailed description” is selected, the normal description is

shown.

ExtGeneralArticle {
**Integer** id;
**boolean** mandatory;
**String** description;
}

###  id : this is the number that uniquely identifies a general article

###  mandatory : this is a boolean value that shows if the replacement is mandatory or not;

###  description : this is a language dependent description of the general article (for example, 7

stands for “Oil filter”, 39 stands for “Trailer Hitch”)

#### 5.1.2. Wear Parts Intervals

Another structure that is related to the Maintenance is WearPartsIntervalsV 3

ExtWearPartsIntervalV 3 {
**ExtGeneralArticle** article;
**String** interval;
**Integer** additionalTime;
**ExtRepairtimeNodeV3[]** repairNodes;
}

###  article : this is a list of general articles objects; the structure of the object is described above

###  interval : this is a description of the interval when the article first appears in a maintenance task

###  additionalTime: the time of the maintenance task the wear parts belongs to. This is a number The

```
additionalTime has the same encoding as for ExpRepairtimeNode (for example: value = 125, the
estimated time is 1.25 hours = 1 hour and 0.25 * 60 minutes = 1hour and 15 minutes)
```
###  repairNodes: a list of repair times nodes linked to the wear part

#### 5.1.3. Maintenance Overview

For Maintenance we also offer an overview of all the maintenance tasks that can be performed

for a car (in the conditions specified for a system). It has a tabular structure where the column-

headers are the periods (the intervals), the row-headers are the tasks, and the content of the table is

true/false (true if a task is part of a period).

This is a screen from our online application with this view:


69

Figure 6.1.3.1 – Periods Overview for system “Time/distance dependent service (→ 1999)”

In the Legend you can see each period of the system on each row. Under the Legend, the

Groups and the tasks in each group are shown. If a task is included in a period, a check-sign is

displayed at the row intersection with the column for that period.

The structure for this data is as it follows:

ExtMaintenanceSystemOverviewV2 {


70

**String** systemDescription;
**ExtMaintenanceSystemOverviewPeriodV2[]** periods;
**ExtMaintenanceSystemOverviewGroupV2[]** groups;
}

### • systemDescription : this is a text, language dependent, which describes the Maintenance

System

### • periods : this is a complex structure that describe the Maintenance Periods (name and id)

### • groups : this is a complex structure that contain the data, starting with the groups

ExtMaintenanceSystemOverviewPeriodV2 {
**String** periodDescription;
**String** columnId;
**Integer** periodId;
}

### • periodDescription : this is a text, language dependent, which describes the Maintenance

Period

### • periodId : this is a number that uniquely identifies the Maintenance Period (represents the

maintenance relation id from the database)

### • columnId : this is a number that uniquely identifies the Maintenance Period (represents the

periodId from the database). There are periods with different periodId but the same columnId.

ExtMaintenanceSystemOverviewGroupV2 {
**String** groupDescription;
**ExtMaintenanceSystemOverviewTaskV2[]** tasks;
}

### • groupDescription : this is a text, language dependent, which describes the group of tasks

(“Engine”, “Clutch, gearbox and final drives” and others)

### • tasks : this is a complex object that contains information about the tasks and the inclusion in

the Maintenance Periods

ExtMaintenanceSystemOverviewTaskV2 {
**String** taskDescription;
**Integer[]** columnIds;
**String** columnsAsBits;
}

### • taskDescription : this is a text, language dependent, which contains the description of the Maintenance

```
Task
```
### • columnIds : this is a list of ids of Maintenance Periods that contain this task

### • columnsAsBits : this is text that contain as bits (0 and 1 characters) corresponding to each period, in the


71

```
same order as they are presented by the ExtMaintenanceSystemOverviewPeriod (0 if the task is not
included in a period, 1 if the task is included in a period; the first bit is for the first period, the second
bit is for the second period and so on)
```
#### 5.1.4. Timing belt replacements

```
For Maintenace we also offer a way to retrieve all maintenance timing belt intervals and their
associated maintenance systems. This operation can be used in case you want to show maintenance
timing belt replacement intervals in repair manuals.
```
```
This is a screen from our online touch application where we show this (this is a timing belt repair
manual where we added Timing belt replacement Intervals)
```
```
The structure for this data is as follows:
```
ExtTimingBeltReplacementInterval {
**String[]** maintenanceSystemsNames;
**String[]** maintenanceIntervalsNames;
}


72

### • maintenanceSystemsNames : this is an array that contains all translated maintenance system

names

### • maintenanceIntervalsNames : this is an array that contains all translated maintenance intervals

names

### 5.2. Operations

#### 5.2.1. getMaintenanceSystemsV7()

This operation returns the first two levels: Maintenance Systems and each system contains a

set of Maintenance Periods.

When calling this operation, the following parameters need to be specified:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carTypeId – int (this number is the “id” of the Type found in ExtCarType; you can check chapter

3 for more information about this object)

###  repairtimesTypeId – Integer *optional (this is the “id” of another type of identification, and it

```
can be specified to get a more refined set of general articles and a more specific calculated
service time. You can find these repair times ids by calling “getRepairtimesTypes” described in
chapter 12 )
```
###  typeCategory – String *optional – this is a text that should have one of the two values: CAR or

```
TRUCK. If empty or null, it will be used as “CAR”. It is strictly in relation with repairtimesTypeId
which in this case is the TecDoc id. If the repairtimesTypeId represents a TecDoc id of a car,
then it should be set as “CAR”, otherwise it should be set as “TRUCK”.
```
###  countryCodes – String[] -- this is an array of strings containing country codes used to filter or

```
select the maintenance system(s).(ex:it, fo). If left null no filtering on maintenance systems will
be done
```
###  useImperial – boolean (this establishes if metric system – KM – should be used, when this is set

to “false”, or if the imperial system should be used – Miles – when this is set to “true”)

###  includeServiceTimes – boolean (this establishes if the service times should be included; if you

```
do not have Service Times in your contract, you will receive an error when setting this to true
and the message will state that you do not have the rights to call this operation)
```
**This operation returns an array of ExtMaintenanceSystemV6 objects**. Before calling this

operation, you can check ExtCarType.subjects to see in it contains “MAINTENANCE”. If it does, the

operation will return information. If not, it will return null or an empty array.


73

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carType – int – 77250 (you should find “daihatsu sirion ej-ve” and make sure it is the same id; if

it is not, replace **77250** with the id that you find in the response).

###  repaitimesTypeId – Integer – 15537

###  typeCategory – String – CAR

###  countryCodes – String[] - it

###  useImperial – boolean - “false”

###  includeServiceTimes – boolean - “true”

The result of calling this operation is:

<getMaintenanceSystemsV 7 Return>

1. <criteria xsi:nil="true"/>
2. < **generalCriterias** >
3. <item>
4. <groupCriterias>
5. <item>
6. <criteriaId>1006356</criteriaId>
7. <criteriaLevel>DESCRIPTION</criteriaLevel>
8. <description>2001-12</description>
9. <value1 xsi:nil="true"/>
10. <value2 xsi:nil="true"/>
11. </item>
12. </groupCriterias>
13. <groupDescription> **End date** </groupDescription>
14. <groupId> **301000002** </groupId>
15. </item>
16. <item>
17. <groupCriterias>
18. <item>
19. <criteriaId>1006360</criteriaId>
20. <criteriaLevel>DESCRIPTION</criteriaLevel>
21. <description>Normal conditions</description>
22. <value1 xsi:nil="true"/>
23. <value2 xsi:nil="true"/>
24. </item>
25. </groupCriterias>
26. <groupDescription>Operating conditions</groupDescription>
27. <groupId>301000019</groupId>
28. </item>
29. </generalCriterias>
30. < **id** > **1196623** </id>
31. < **name** > **Every 20,000 km/12 months** </name>


74

32. < **periodSentenceId** > **480** </periodSentenceId>
33. < **times** >
34. <item>
35. <code xsi:nil="true"/>
36. < **selected** > **true** </selected>
37. <type>COMPUTED_TIME</type>
38. < **value** > **100** </value>
39. </item>
40. </times>
41. < **name** > **Normal conditions, ( - 12/2001), (API SG)** </name>

This is a screenshot from Workshop ATI Online:

Figure 6.2.1.1 – Maintenance Systems(1) and Periods(2)

1 - < **name** > **Normal conditions, ( - 12/2001), (API SG)** </name>
2 - < **name** > **Every 20,000 km/12 months** </name>


75

At line 30 you can see that the Maintenance Period has an id. You can use that id with the

following operation to get the tasks related to the “Every 20,000 km/12 months” period of “Normal

conditions, ( - 12/2001), (API SG) **”** ).

Service times: at line 32 you can see the value 100 which means 1.0 hours; at line 36 you can

see that the type of time is “COMPUTED_TIME” and at line 35 you can see that it is the selected one

(the select is important when there are more types of times available for the same period).

General criteria's: The difference between V4 and V5 versions is that the last one contains all

maintenance criteria's which are linked both to maintenance system and maintenance periods on a

description or remark level. The linking level type is mentioned by criteriaLevel which can be

DESCRIPTION or REMARK.

#### 5.2.2. getMaintenanceTasksV9()

This operation returns the last two levels: Maintenance Task-Groups and each Task-Group

contains a set of Maintenance Task.

When calling this operation, the following parameters need to be provided:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  cartypeId – Integer (this number is the “id” of the Type found in ExtCarType; you can check

chapter 3 for more information about this object)

###  repairtimesTypeId – Integer *optional (this is the “id” of another type of identification, and it

```
can be specified to get a more refined set of general articles and a more specific calculated
service time. You can find these repair times ids by calling “getRepairtimesTypes” described in
chapter 12 )
```
###  typeCategory – String *optional – this is a text that should have one of the two values: CAR or

```
TRUCK. If empty or null, it will be used as “CAR”. It is strictly in relation with repairtimesTypeId
which in this case is the TecDoc id. If the repairtimesTypeId represents a TecDoc id of a car,
then it should be set as “CAR”, otherwise it should be set as “TRUCK”.
```
###  systemId – int (this is the ExtMaintenanceSystemV4.id that you get from a system when calling

the previous operation – getMaintenanceSystemsV4())

###  periodId – int or int[] (this is the ExtMaintenancePeriodV4.id that you get from a period when

```
calling the previous operation – getMaintenanceSystemsV4() ). You should set more than one
value for this parameter only if the periods that they represent are combinable.
```
###  includeSmartLinks – boolean (this is a boolean value which establishes if the result should

include smart links or not)

###  includeServiceTimes – boolean (this establishes if the service times should be included; if you


76

```
do not have Service Times in your contract, you will receive an error when setting this to true
and the message will state that you do not have the rights to call this operation)
```
###  maintenanceBasedType – String (this is the way maintenance tasks will be displayed. This can

```
get 2 possible values: SUBJECT_BASED and LOCATION_BASED. When no
maintenanceBasedType field is set it will use SUBJECT_BASED as default. We have added a new
field to avoid using a new call for getting location-based maintenance tasks)
```
**This operation returns an array of ExtMaintnenanceTaskV9 objects.**

We will call this operation with the following parameters:

###  descriptionLanguage – String – value: “en”

###  cartypeId – int – value: 26650

###  repairtimesTypeId – Integer – 8799

###  typeCategory – String - CAR

###  systemId – int- 319018637

###  periodId – int – 319394238

###  includeSmartLinks – boolean - true

###  includeServiceTimes – boolean – true

###  maintenanceBasedType – String – SUBJECT_BASED

This result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"

```
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
```
2. <soapenv:Body>
3. <getMaintenanceTasksV9Response xmlns="http://data.webservice.workshop.vivid.nl">
41.
4. ...
5. < **name** > **Engine** </name>
6. ...
7. < **subTasks** >
8. <item>
9. <followUpRepairs xsi:nil="true"/>
10. < **descriptionId** > **112** </descriptionId>


77

11. < **serviceTaskParts** >
12. <item>
13. <mandatory>true</mandatory>
14. < **part** >
15. < **authority** > **TECDOC** </authority>
16. <description>Engine oil</description>
17. <fitmentCriteria xsi:nil="true"/>
18. < **id** > **3224** </id>
19. </part>
20. </item>
21. <item>
22. <mandatory>false</mandatory>
23. <part>
24. <authority>TECDOC</authority>
25. <description>Sealing plug, oil sump</description>
26. <fitmentCriteria xsi:nil="true"/>
27. <id>593</id>
28. </part>
29. </item>
30. ...
31. <item>
32. <mandatory>true</mandatory>
33. < **part** >
34. < **authority** > **ETAI** </authority>
35. <description>Engine oil</description>
36. <fitmentCriteria xsi:nil="true"/>
37. < **id** > **15028** </id>
38. </part>
39. </item>
40. ...
41. </serviceTaskParts>
42. <longDescriptions xsi:nil="true"/>
43. < **mandatoryReplacement** > **true** </mandatoryReplacement>
44. < **name** > **Renew the engine oil** </name>
45. <order>0</order>
46. <remark xsi:nil="true"/>
47. < **smartLinks** >
48. <item>
49. <filter xsi:nil="true"/>


78

50. < **id1** > **0** </id1>
51. <id2 xsi:nil="true"/>
52. <operation xsi:nil="true"/>
53. < **text** >
54. < **item** >Engine sump, incl. filter</item>
55. < **item** >3.2</item>
56. < **item** >(l)</item>
57. </text>
58. </item>
59. <item>
60. <filter xsi:nil="true"/>
61. < **id1** > **26650** </id1>
62. < **id2** > **ENGINE** </id2>
63. < **operation** > **getLubricantsByGroup** </operation>
64. <text xsi:nil="true"/>
65. </item>
66. </smartLinks>
67. <includeByDefault>true</includeByDefault>
68. <overrulingRemark>false</overrulingRemark>
69. <status xsi:nil="true"/>
70. <subTasks xsi:nil="true"/>
71. <times xsi:nil="true"/>
72. </item>
73. <item>
74. ...
75. < **descriptionId** > **113** </descriptionId>
76. < **name** > **Renew the oil filter** </name>
77. ...
78. </item>
79. <item>
80. ...
81. <name>Renew the air filter(s)</name>
82. <order>3</order>
83. <overrulingRemark>true</overrulingRemark>
84. <remark>every 60,000 km/48 months</remark>
85. <repairTimesTaskId>1F11101000WV0</repairTimesTaskId>
42. ...
86. < **times** >
87. <item>


79

88. < **code** > **24 24 19 56** </code>
89. < **selected** > **true** </selected>
90. < **type** > **COMMERCIAL_TIME** </type>
91. < **value** > **10** </value>
92. </item>
93. <item>
94. <code xsi:nil="true"/>
95. <selected>false</selected>
96. <type>COMPUTED_TIME</type>
97. <value>10</value>
98. </item>
99. </times>
100. </item>
101. ....
102. <item>
103. < **followUpRepairs** >
104. <descriptionId>947</descriptionId>
105. <followUpRepairs>
106. <item>
107. <awNumber>1D04003000WV0 </awNumber>
108. <description>Renew timing belt</description>
109. <description>Renew the coolant pump</description>
110. <genarts>
111. <item>
112. <description>Water pump</description>
113. <id>1260</id>
114. <mandatory>true</mandatory>
115. </item>
116. <item>
117. <description>Antifreeze</description>
118. <id>3356</id>
119. <mandatory>true</mandatory>
120. </item>
121. </genarts>
122. <hasInfoGroups>true</hasInfoGroups>
123. <hasSubnodes>false</hasSubnodes>
124. <id>1D04003000WV0 </id>
125. <order>0</order>
126. <status xsi:nil="true"/>


80

127. <value>250</value>
128. </item>
129. ...
130. </followUpRepairs>
131. ...
132. <name>Analyse the exhaust gas</name>
133. <order>4</order>
134. <remark>first check at 36 months, then every 24 months</remark>
135. ...
136. </item>
137. ...
138. <item>
139. ...
140. < **longDescriptions** >
141. <item> **Timing belt(s):** </item>
142. <item> **Check the belt for cracks, damage and wear** </item>
143. <item> **Check the teeth for irregularities** </item>
144. <item> **Check the tension of the belt(s), adjust if necessary** </item>
145. <item> **Check the condition of the tensioner(s)** </item>
146. <item> **Check the condition of the idler pulley(s), if fitted** </item>
43. </ **longDescriptions** >
147. <mandatoryReplacement>false</mandatoryReplacement>
148. < **name** > **Check the timing belt condition and tension; renew or adjust if necessary**

</name>

149. <order>5</order>
150. <overrulingRemark>true</overrulingRemark>
151. < **remark** > **first check at 90,000 km; then every 30,000 km** </remark>
152. <repairTimesTaskId xsi:nil="true"/>
153. ...
154. </item>
155. ....
156. < **generalCriterias** >
157. <item>
158. <groupCriterias>
159. <item>
160. <criteriaId>303000014</criteriaId>
161. <criteriaLevel>REMARK</criteriaLevel>
162. <description>every</description>
163. <value1 xsi:nil="true"/>


81

164. <value2 xsi:nil="true"/>
165. </item>
166. </groupCriterias>
167. <groupDescription>Interval type</groupDescription>
168. <groupId>303000009</groupId>
169. </item>
170. <item>
171. <groupCriterias>
172. <item>
173. <criteriaId>303000013</criteriaId>
174. <criteriaLevel>REMARK</criteriaLevel>
175. <description>months</description>
176. <value1>48</value1>
177. <value2 xsi:nil="true"/>
178. </item>
179. <item>
180. <criteriaId>303000010</criteriaId>
181. <criteriaLevel>REMARK</criteriaLevel>
182. <description>km</description>
183. <value1>60000</value1>
184. <value2 xsi:nil="true"/>
185. </item>
186. </groupCriterias>
187. <groupDescription>Unit</groupDescription>
188. <groupId>303000008</groupId>
189. </item>
190. </ **generalCriterias** >
191. ...
192. <item>
193. <criteria xsi:nil="true"/>
194. <descriptionId>371</descriptionId>
195. <followUpRepairs>
196. <followUpRepairs>
197. <awNumber>1O00409950WV0</awNumber>
198. < **description** > **Renew the sliding/tilting roof** </ **description** >
199. <genarts/>
200. < **generalCriterias** xsi:nil="true"/>
201. <hasInfoGroups>true</hasInfoGroups>
202. <hasSubnodes>false</hasSubnodes>


82

203. <id>1O00409950WV0</id>
204. <jobType xsi:nil="true"/>
205. < **oeCode** > **60051950** </ **oeCode** >
206. <order>0</order>
207. <status xsi:nil="true"/>
208. <value>229</value>
209. </followUpRepairs>
210. </followUpRepairs>
211. <generalArticles xsi:nil="true"/>
212. < **generalCriterias** xsi:nil="true"/>
44.

213.

The next screenshot is from Workshop ATI Online and it shows Maintenance Tasks for “Volkswagen

Golf IV AKQ”, Maintenance System “Time/distance dependent service, -> 1999”, period “60,000 km/24

months (OE: 01 03 00 04)”:


83

Figure 6.2.3.1 – Maintenance Tasks – normal descriptions

1 - < **name** > **Engine** </name> (line 5)
2 - < **mandatoryReplacement** > **true** </mandatoryReplacement> (line 43)
3 - < **name** > **Renew the engine oil** </name> (line 61)


84

Figure 6.2.3.2 - Maintenance Tasks – detailed descriptions (long description)

1 - < **name** > **Engine** </name> (line 5)
2 - < **mandatoryReplacement** > **true** </mandatoryReplacement> (line 43)
3 - < **name** > **Check the timing belt condition and tension; renew or adjust if necessary** </name>
(line 148)

4 - < **longDescriptions** > (line 140)
<item> **Timing belt(s):** </item>
<item> **Check the belt for cracks, damage and wear** </item>
<item> **Check the teeth for irregularities** </item>
<item> **Check the tension of the belt(s), adjust if necessary** </item>
<item> **Check the condition of the tensioner(s)** </item>
<item> **Check the condition of the idler pulley(s), if fitted** </item>
</longDescriptions>
5 - < **remark** > **first check at 90,000 km; then every 30,000 km** </remark> (line 151)


85

```
Figure 6.2.3.3 - Maintenance Follow ups OE Codes
1 - < name > Renew the sliding/tilting roof </name> (line 198)
2 - < oeCode > 60051950 </oeCode> (line 205)
```
#### 5.2.3. getMaintenanceForms()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carTypeId – int (this number is the “id” of the Type found in ExtCarType; you can check chapter

3 for more information about this object)

**This operation returns an array of ExtStoryListContainerV2** that represents all the

maintenance forms for the specified type. The returned object have the following structure :

ExtStoryListContainerV2 {
String name;
ExtStoryLineV5[] storyLines;


86

ExtStatus status;
}

The meaning of the above elements are:

###  name : the name of the maintenance form

###  storyLines : this is an array of ExtStoryLineV5 which represents all the story lines linked to a

maintenance form

###  status : the status will contain 0 if the request was successful or another number if there was

an error (the possible errors are presented in chapter 2.1)

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carTypeId – int – 26650

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getMaintenanceFormsResponse xmlns="http://data.webservice.workshop.vivid.nl">
4. <getMaintenanceFormsReturn>
5. <name> **Forms** </name>
6. <status xsi:nil="true"/>
7. <storyLines>
8. <item>
9. <id xsi:nil="true"/>
10. <mimeData xsi:nil="true"/>
11. <name>General</name>
12. <order>0</order>
13. <paragraphContent xsi:nil="true"/>
14. <remark xsi:nil="true"/>
15. <sentenceGroupType xsi:nil="true"/>
16. <sentenceStyle xsi:nil="true"/>
17. <smartLinks xsi:nil="true"/>
18. <specialTool xsi:nil="true"/>
19. <status xsi:nil="true"/>
20. <subStoryLines>


87

21. <item>
22. <id xsi:nil="true"/>
23. <mimeData xsi:nil="true"/>
24. <name>Forms Car</name>
25. <order>0</order>
26. <paragraphContent xsi:nil="true"/>
27. <remark xsi:nil="true"/>
28. <sentenceGroupType>TABLE</sentenceGroupType>
29. <sentenceStyle>SENTENCE_STYLE</sentenceStyle>
30. <smartLinks xsi:nil="true"/>
31. <specialTool xsi:nil="true"/>
32. <status xsi:nil="true"/>
33. <subStoryLines xsi:nil="true"/>
34. <tableContent>
35. <numberOfColumns>8</numberOfColumns>
36. <numberOfRows>2</numberOfRows>
37. <tableCells>
38. <item>
39. <order>0</order>
40. <value>Make</value>
41. </item>
42. <item>
43. <order>1</order>
44. <value>Model</value>

#### 5.2.4. Smart Links

ExtSmartLink {

String operation;

String[] text;

int id1;

String id2;

String filter;

}

This is the general description of the properties (next, we will present all the existing cases):

###  operation : this property contains the name of the operation that needs to be called in order to

get the linked data (for example, “getAdjustments” if the link refers to adjustments). This


88

```
property can also be null, in which case the “text'' property will contain directly the linked
information. This property can also be a String (for now only IMAGE, but can be TABLE, LIST,
etc) representing a link to a specific element. If operation is IMAGE then id2 will contain the
link to the image. If the link is null, it is recommended that the text to be displayed together
with the task description. Otherwise, it is recommended that the “smartLink” to be shown as a
link and call the specified operation only if necessary.
```
###  text : this property is an array of String objects. If it is not null, it contains information about the

```
link. For example, in adjustments it can be an item (text, value, measure unit), in repair
manuals it is the title of the manual (e.g.: “Timing belt”). For TSB this array has 4 fields
(1.adjustment link description, 2.value, 3.unit and 4.component description of the linked
adjustment sentence, see getTSBDataV4, getRecallDataV3, getSmartCaseDataV3).
```
###  id1 : this property is a number that should be used if the operation is not null. It represents

```
value of one of the parameters that needs to be set when calling the operation (for example:
the carTypeId for adjustments, or the storyId for repairManuals). If it is 0, it should not be
used.
```
###  id2 : this property is a String object that is used when one of the ids that needs to be set as

```
parameters of the target operation is of type String. For example, it is used for “lubricants”
subject to set the group (“ENGINE”, “STEERING”...). When operation param is IMAGE, id2 will
contain a link to that image.
```
###  filter : this property is a String object that is used (if it is not null) to filter the result you get

```
after calling the specified information. For example, it is used in “adjustments” to specify only
one group that is related to this maintenance-task, or in “technical drawings” to show which
group of all the groups that are retrieved by “getDrawings” operation is related to this
maintenance-task.
```
Because the size of the response text is too large, we will show parts of the response for each

existing type of link.

1. ...

**_5.2.4.1. Repair Manuals links_**

2. <item>
3. <genArtNumbers xsi:nil="true"/>
4. <longDescriptions xsi:nil="true"/>
5. <mandatoryReplacement>false</mandatoryReplacement>
6. <name> **Reset the service interval indicator** </name>
7. <order>4</order>
8. <remark xsi:nil="true"/>
9. <smartLinks>
10. <item>
11. <filter xsi:nil="true"/>


89

12. <id1> **3969** </id1>
13. <id2 xsi:nil="true"/>
14. <operation> **getStoryInfo** </operation>
15. <text>
16. <item> **Service reset** </item>
17. </text>
18. </item>
19. </smartLinks>
20. <status xsi:nil="true"/>
21. <subTasks xsi:nil="true"/>
22. </item>
23. </subTasks>
24. </getMaintenanceTasksWithSmartLinksReturn>
25. <getMaintenanceTasksWithSmartLinksReturn>
26. <genArtNumbers xsi:nil="true"/>
27. <longDescriptions xsi:nil="true"/>
28. <mandatoryReplacement>false</mandatoryReplacement>
29. <name>Interior</name>
30. ...

Figure 6.2.4.1.1 – Maintenance – Repair Manuals link

1 - <name> **Reset the service interval indicator** </name> (line 6)


90

2 - <operation> **getStoryInfo** </operation> (line 14)

If you call this operation (getStoryInfo) with these parameters:
getStoryInfo(vrid, “en”, **3969** )
you will get the content of the target page of this link.

<id1> **3969** </id1> (line 12)
3 - <item> **Service reset** </item> (line 16)

**_5.2.4.2. Technical drawings links_**

1. <item>
2. <genArtNumbers>
3. <item>1339</item>
4. </genArtNumbers>
5. <longDescriptions>
6. <item> **Brakes inspection:** </item>
7. <item>Inspect the brake pad thickness, renew if necessary</item>
8. <item>Check for brake fluid or grease contamination</item>
9. </longDescriptions>
10. <mandatoryReplacement>false</mandatoryReplacement>
11. <name> **Check the brake pad thickness** </name>
12. <order>3</order>
13. <remark xsi:nil="true"/>
14. <smartLinks>
15. <item>
16. <filter>Brakes</filter>
17. <id1>26650</id1>
18. <id2 xsi:nil="true"/>
19. <operation>getAdjustments</operation>


91

20. <text xsi:nil="true"/>
21. </item>
22. <item>
23. <filter> **Brakes** </filter>
24. <id1> **26650** </id1>
25. <id2 xsi:nil="true"/>
26. <operation> **getDrawings** </operation>
27. <text xsi:nil="true"/>
28. </item>
29. <item>
30. <filter> **ABS (mechanical)** </filter>
31. <id1> **26650** </id1>
32. <id2 xsi:nil="true"/>
33. <operation> **getDrawings** </operation>
34. <text xsi:nil="true"/>
35. </item>
36. </smartLinks>

This example is special for 2 reasons:

- it contains links to two subjects (“adjustments” and “technical drawings”)
- it has two groups linked for the same subject (both “Brakes” and “ABS” for technical

drawings)

Figure 6.2.4.2.1 – Maintenance – Technical Drawings link


92

1 - <item> **Brakes inspection:** </item> (line 6)
2 - <operation> **getDrawings** </operation> (lines 26 and 33)

Figure 6.2.4.2.2 – Technical Drawings linked page

3 - <filter> **Brakes** </filter> (line 23)
4 - <filter> **ABS (mechanical)** </filter> (line 30)

Calling the getDrawings() operation would return these groups: “Brakes", "ABS (mechanical)”,

“Steering”, “Suspension front”, “Suspension rear”, “Clutch”... The “filter” property is used to select

which groups should be shown as links to the maintenance task.

**_5.2.4.3. Lubricants link_**

1. ...
2. <item>
3. <genArtNumbers>
4. <item>2059</item>
5. </genArtNumbers>
6. <longDescriptions xsi:nil="true"/>
7. <mandatoryReplacement>true</mandatoryReplacement>
8. <name> **Renew the engine oil** </name>


93

9. <order>0</order>
10. <remark xsi:nil="true"/>
11. <smartLinks>
12. <item>
13. <filter/>
14. <id1> **26650** </id1>
15. <id2> **ENGINE** </id2>
16. <operation> **getLubricantsByGroup** </operation>
17. <text xsi:nil="true"/>
18. </item>
19. </smartLinks>
20. <status xsi:nil="true"/>
21. <subTasks xsi:nil="true"/>
22. </item>
23. ...

Figure 6.2.4.3.1 – Maintenance – Lubricants link

1 - <name> **Renew the engine oil** </name> (line 8)
2 - <operation> **getLubricantsByGroup** </operation> (line 16)

This link requires calling the “getLubricantsByGroup” operation having the following

parameters: “en”, 26650, “ENGINE” (language, id1, id2)

<id1> **26650** </id1> (line 14)
<id2> **ENGINE** </id2> (line 15)

**_5.2.4.4. Adjustments link – by group_**

This type of link makes a relation between the maintenance-task and a group in adjustments.


94

This is the same example as for “Technical Drawings” links:

1. <item>
2. <genArtNumbers>
3. <item>1339</item>
4. </genArtNumbers>
5. <longDescriptions>
6. <item> **Brakes inspection:** </item>
7. <item>Inspect the brake pad thickness, renew if necessary</item>
8. <item>Check for brake fluid or grease contamination</item>
9. </longDescriptions>
10. <mandatoryReplacement>false</mandatoryReplacement>
11. <name> **Check the brake pad thickness** </name>
12. <order>3</order>
13. <remark xsi:nil="true"/>
14. <smartLinks>
15. <item>
16. <filter> **Brakes** </filter>
17. <id1> **26650** </id1>
18. <id2 xsi:nil="true"/>
19. <operation> **getAdjustments** </operation>
20. <text xsi:nil="true"/>
21. </item>
22. <item>
23. <filter>Brakes</filter>
24. <id1>26650</id1>
25. <id2 xsi:nil="true"/>
26. <operation>getDrawings</operation>
27. <text xsi:nil="true"/>
28. </item>
29. <item>
30. <filter>ABS (mechanical)</filter>
31. <id1>26650</id1>
32. <id2 xsi:nil="true"/>
33. <operation>getDrawings</operation>
34. <text xsi:nil="true"/>
35. </item>
36. </smartLinks>


95

Figure 6.2.4.4.1 – Maintenance – Adjustments link

1 - <item> **Brakes inspection:** </item> (line 6)
2 - <operation> **getAdjustments** </operation> (line 19)

This link requires the getAdjustments to be called with the following parameters: “en”, “26650”

(language, carTypeId)

<id1> **26650** </id1> (line 17)

This operation would return the following groups: “Engine”, “Cooling System”, “Electrical”, “Brakes”,

“Steering and wheel alignment”, “Wheels and tyres”...

Using the specified filter, you can select the appropriate group from the result:

<filter> **Brakes** </filter> (line 16)

Figure 6.2.4.4.2 – Adjustment data – maintenance-task link


96

**_5.2.4.5. Adjustments link – by item_**

This type of link is a special one. Even though it is a relation between a maintenance-task and

an element in adjustments, it is not really shown as a link. The text is included directly in the

“smartLink” element of the task, and no other operation needs to be called.

1. <item>
2. <genArtNumbers>
3. <item>686</item>
4. </genArtNumbers>
5. <longDescriptions>
6. <item> **Spark plugs:** </item>
7. <item>Renew the spark plugs</item>
8. <item>Tighten as specified</item>
9. </longDescriptions>
10. <mandatoryReplacement>true</mandatoryReplacement>
11. <name>Renew the spark plugs</name>
12. <order>3</order>
13. <remark>every 60,000 km / 48 months</remark>
14. <smartLinks>
15. <item>
16. <filter xsi:nil="true"/>
17. <id1>0</id1>
18. <id2 xsi:nil="true"/>
19. <operation xsi:nil="true"/>
20. <text>
21. <item> **Spark plugs (make &amp; type)** </item>
22. <item> **NGK BKUR 6 ET-10&lt;br>NGK PFR6Q** </item>
23. <item xsi:nil="true"/>
24. </text>
25. </item>
26. </smartLinks>
27. <status xsi:nil="true"/>
28. <subTasks xsi:nil="true"/>
29. </item>


97

Figure 6.2.4.5.1 – Maintenance – Adjustments included link

1 - <item> **Spark plugs:** </item> (line 6)

2 - <text> <item> **Spark plugs (make &amp; type)** </item> (line 21)

3 - <item> **NGK BKUR 6 ET-10&lt;br>NGK PFR6Q** </item> (line 22)

The first element of the “text” array is, for this kind of link, the description, the second one is

the value and the third one is the measure unit (in this example the measure unit is null).

**_5.2.4.6. Adjustment link to image_**

All inline smart links can have an image linked. The image is a special smart links with the
operation name IMAGE and id2 parameter containing the link to the image.

45. ...
46. <smartLinks>
47. <filter xsi:nil="true"/>
48. <id1>0</id1>
49. <id2 xsi:nil="true"/>
50. <operation xsi:nil="true"/>
51. <text>
52. <text>Refrigerant</text>
53. <text>450</text>
54. <text>(g)</text>


98

55. </text>
56. </smartLinks>
57. <smartLinks>
58. <filter xsi:nil="true"/>
59. <id1>0</id1>
60. < **id2** > **[http://test.vivid-services.com/workshop/images/300008414.svgz](http://test.vivid-services.com/workshop/images/300008414.svgz)** </id2>
61. < **operation** > **IMAGE** </operation>
62. <text xsi:nil="true"/>
63. </smartLinks>

Figure 6.2.4.5.2– Lubricants – Adjustments image link

```
1 - < id2 >http://test.vivid-services.com/workshop/images/300008414.svgz</id2> </id2>
(line 16)
```
**_5.2.4.7. Common Rail link_**

The common rail is a link to a static html. You can find the link in the result set of any of the

following operations: getGeneralInformationLinks, getGeneralInformationLinksByGroup(ENGINE),


99

getGeneralInformationLinksExtMap, getGeneralInformationLinksByGroupExtMap(ENGINE). Being just

a static html, the same for all cars, you do not need any other parameter, so the link information in the

ExtMaintenanceTask(V1,V2 or V3) will look like this:

1. ...
2. <item>
3. <followUpRepairs xsi:nil="true"/>
4. <generalArticles/>
5. <longDescriptions xsi:nil="true"/>
6. <mandatoryReplacement>false</mandatoryReplacement>
7. < **name** > **Reprogram the fuel injectors** </name>
8. <order>1</order>
9. < **remark** > **Refer to 'General information/Common Rail'** </remark>
10. <smartLinks>
11. <item>
12. < **filter** > **COMM_RAIL** </filter>
13. <id1>0</id1>
14. <id2 xsi:nil="true"/>
15. < **operation** > **getGeneralInformationLinksExtMap** </operation>
16. <text xsi:nil="true"/>
17. </item>
18. </smartLinks>
19. </item>
20. ...

**_5.2.4.8. Identification link_**

We can have two types of identification links. One link points to identification general and the

other one points to identification equipment code. These types of links appear only in adjustment data

sentences. You can find these links in the result set of any of the following operations: getAdjustments

(V3, V4), getAdjustmentsEnvOnlyV3, getAdjustmentsGeneral.


100

Figure 6.2.3.7 – Adjustment – Identification equipment link

The Smart link information will look like this:

1. <smartLinks>
2. <filter>EQUIPMENT</filter>
3. <id1>102000037</id1>
4. <id2 xsi:nil="true"/>
5. <operation>getIdLocationV2</operation>
6. <text xsi:nil="true"/>
7. </smartLinks>

This link requires the getIdLocationV2 to be called with the following parameters: language,
carTypeId, carTypeLevel, where carTypeId is id1 and represents the model id.

When filter is GENARAL data from getIdLocationV2 should be filtered by GENERAL

identifer, when filter is EQUIPMENT data from getIdLocationV2 should be filtered by EQUIPMENT

identifer.

### 5.3. Maintenance Service Times

To show the duration of a maintenance service, you need to start by calling the operation

getMaintenanceSystems V4 with the parameter “includeServiceTimes” set to “true”.


101

The time it returns is the default time of the service, but there can be tasks that are not

included by default in the service. In the previous example, in chapter 6.2.1, the service time is 1.3h.

You will also need to use the time (1.3 hours in this case) as the base time to which you add

the extra times in case it is necessary (if the user selects them or if you choose to show them as

selected by default).

In chapter 6.2.2, the task “Renew the air filter(s)” is not included by default in the service. It

should be done only “every 60,000 km/48 months”. This time is not included in the overall time from

the ExtMaintenancePeriodV3 (so it should appear with a checkbox), and it represents 0.20 hours. If

the checkbox for this task is selected, it should be added to the total time (if only this one is checked,

the time in this case should be periodTime + extraTimeForThisOptionalTime = 1.30 + 0.20 = 1.50)

There are also times for followUp tasks which are not normally included in the service, but the

mechanic may consider them necessary (for example after a check task). It is not included in the

overall time tither (so it should appear with a checkbox that is not checked) and it represents in this

example: 0.5 (“Check/set idle speed/emission behaviour” after the service-task “Analyze the exhaust

gas”).

If the user selects this repair as necessary, you may add this to the total time (periodTime + all

the tasks that had been included by the user).

**NOTE:** on top of the periodTime, in our implementation of workshopOnline, we add by default the

times for the optional tasks that have “mandatory replacement” set to “true”. We show there both

the “standard time”, which is the periodTime (the time from the MaintenanceSystem period).

#### 5.3.1. getTimingBeltMaintenanceTasksV5()

This operation returns the tasks from all periods of a system that refer to timing belts.

This operation requires the following parameters:

###  descriptionLanguage – String

```
This should be a 2 - character string, established by the 639-1 ISO; for example, for English it is
“en”, for French it is “fr”.
```
###  carTypeId – Integer

```
This number is the “id” of the Type found in ExtCarType; you can check chapter 3 for more
information about this object). This parameter can be null. In this case the first car type
containing the systemId mentioned will be used.
```
###  repairtimesTypeId – Integer *optional*

```
This is the “id” of another type of identification, and it can be specified to get a more refined
set of general articles and a more specific calculated service time. You can find these repair
times ids by calling “getRepairtimesTypes” described in chapter 12.
```

102

###  rtTypeCategory – String *optional*

```
This is a text that should have one of the two values: CAR or TRUCK. If empty or null, it will be
used as “CAR”. It is strictly in relation with repairtimesTypeId which in this case is the TecDoc
id. If the repairtimesTypeId represents a TecDoc id of a car, then it should be set as “CAR”,
otherwise it should be set as “TRUCK”.
```
###  systemId – Integer

```
This is the ExtMaintenanceSystem.id that you get from a system when calling the previous
operation – getMaintenanceSystems() or getMaintenanceSystemsImperial()
```
###  includeServiceTimes – Boolean

```
This is a boolean (true/false) value which indicates if the result should contain the service
times for the period and for the additional tasks. Please make sure you only add the times for
the additional tasks that are marked as “includeByDefault” and the default time from the
period object.
```
#### 5.3.2. getWearPartsIntervalsV3()

This operation returns a list of important wear parts that appear in the tasks of all intervals

from a MaintenanceSystem together with the repair times associated to each part, as well as relevant

criteria. In case the part belongs to a maintenance task with additional time this will be shown as well.

The wear parts will appear only once, and they will indicate the interval at which they have to be

replaced during the maintenance procedures.

This operation requires the following parameters:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carTypeId – int (this number is the “id” of the Type found in ExtCarType; you can check chapter

3 for more information about this object)

###  systemId – int (this is the ExtMaintenanceSystem.id that you get from a system when calling

the previous operation – getMaintenanceSystems() or getMaintenanceSystemsImperial() )

###  tecdocNumber – int (this number is the “id” of the Tecdoc Type identification – can be null or

0 if it is not known). This filters the general articles.

#### 5.3.3. getMaintenanceSystemOverviewV2

This operation returns an overview of the groups and tasks and the specifications of which


103

periods they belong to in a Maintenance System.

This operation requires the following parameters:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3

for more information about this object)

###  systemId – int (this is the ExtMaintenanceSystem.id that you get from a system when calling

the previous operation – getMaintenanceSystems() or getMaintenanceSystemsImperial() )

```
This operation returns an object of type ExtMaintenanceSystemOverviewV2. The difference
between V1 and V2 is that the last one contains a reduced number of columns where the
periods are shown.
```
This is an example of calling this operation:

Request:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:data="http://data.webservice.workshop.vivid.nl">
2. <soapenv:Header/>
3. <soapenv:Body>
4. **<data:getMaintenanceSystemOverviewV2>**
5. <data:vrid>[vrid]</data:vrid>
6. <data:descriptionLanguage>en</data:descriptionLanguage>
7. <data:carTypeId>26650</data:carTypeId>
8. <data:systemId>106002681</data:systemId>
9. **</data:getMaintenanceSystemOverviewV2>**
10. </soapenv:Body>
11. </soapenv:Envelope>

Response:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getMaintenanceSystemOverviewV2Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getMaintenanceSystemOverviewV2Return>
5. <groups>
6. <item>
7. **<groupDescription>Engine** </groupDescription>


104

8. <tasks>
9. <item>
10. < **columnIds** >
11. <item> **106019169** </item>
12. <item> **106019170** </item>
13. <item> **106019168** </item>
14. **</columnIds>**
15. <columnsAsBits>111</columnsAsBits>
16. <taskDescription>Renew the engine oil</taskDescription>
</item>
17. ...
18. <columnsAsBits>111</columnsAsBits>
19. <taskDescription>Renew the timing belt(s) (every 48 months;No recommended mileage
    interval;Timing belt renewal intervals may be subject to updates and may differ regionally)</taskDescription>
20. </item>
21. <item>
22. <columnIds>
23. <item>106019169</item>
24. <item>106019170</item>
25. <item>106019168</item>
26. </columnIds>
27. <columnsAsBits>111</columnsAsBits>
28. <taskDescription>Check the timing belt condition and tension; renew or adjust if necessary (first
    check at 60,000 miles; then every 20,000 miles)</taskDescription>
29. </item>
30. ...
31. </tasks>
32. </groups>
33. **<periods>**
34. <item>
35. <columnId>106019169</columnId>
36. <periodDescription>Every 20,000 miles/12 months</periodDescription>
37. <periodId>106027477</periodId>
38. </item>
39. <item>
40. < **columnId** > **106019170** </columnId>
41. **<periodDescription>Every 40,000 miles/24 months** </periodDescription>
42. < **periodId** > **102031882** </periodId>
43. </item>
44. <item>
45. <columnId>106019169</columnId>


105

46. <periodDescription>Every 60,000 miles/36 months</periodDescription>
47. <periodId>102031883</periodId>
48. </item>
49. ...
50. </periods>
51. <status xsi:nil="true"/>
52. <systemDescription>Time/distance dependent service, ( - 1999)</systemDescription>
53. </getMaintenanceSystemOverviewV2Return>
54. </getMaintenanceSystemOverviewV2Response>
55. </soapenv:Body>
56. </soapenv:Envelope>

#### 5.3.4. getMaintenancePartsForPeriod

This operation returns lists of mandatory and possible general articles (parts) for a selected

maintenance period.

When calling this operation, the following parameters need to be provided:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carTypeId – int (this number is the “id” of the Type found in ExtCarType; you can check chapter

3 for more information about this object)

###  repairtimesTypeId – Integer *optional (this is the “id” of another type of identification, and it

```
can be specified to get a more refined set of general articles. You can find these repair times
ids by calling “getRepairtimesTypes” described in chapter 12 )
```
###  rtTypeCategory – String *optional – this is a text that should have one of the two values: CAR

```
or TRUCK. If empty or null, it will be used as “CAR”. It is strictly in relation with
repairtimesTypeId which in this case is the TecDoc id. If the repairtimesTypeId represents a
TecDoc id of a car, then it should be set as “CAR”, otherwise it should be set as “TRUCK”.
```
###  systemId – int (this is the ExtMaintenanceSystemV4.id that you get from a system when calling

the previous operation – getMaintenanceSystemsV4())

###  periodId – int or int[] *optional-only if the 'withCalculator' is true (this is the

```
ExtMaintenancePeriodV4.id that you get from a period when calling the previous operation –
getMaintenanceSystemsV4() ). You should set more than one value for this parameter only if
the periods that they represent are combinable.
```
###  withCalculator – boolean *optional (this is a boolean value: using false or null for this it will

```
return the lists of general articles that are linked to the selected period; using true it will call an
experimental (for now) method that can compute the period based mainly on systemId,
registrationDate and mileage – it is not advisable to use this method for now.)
```

106

###  registationDate – String *optional-only if the 'withCalculator' is false (is the registration date of

the car type in the following format: dd-MM-yyyy(10- 04 - 1999) or MM-yyyy (05-1997))

###  mileage – int *optional-only if the 'withCalculator' is false (is the mileage registered by the

vehicle)

The returned structure is:

ExtPartsListContainer {

ExtGeneralArticleV2[] nonMandatoryMaintenaceParts;

ExtGeneralArticleV2[] mandatoryMaintenaceParts;

ExtGeneralArticleV2[] nonMandatoryAdditionalMaintenaceParts;

ExtGeneralArticleV2[] mandatoryAdditionalMaintenaceParts;

ExtStatus status;

}

###  nonMandatoryMaintenaceParts : this is a list of complex objects (ExtGeneralArticleV2)

```
containing information about general articles (parts) that are linked to Maintenance Tasks and
they are possible (not mandatory) ; the structure of each object is described next.
```
###  mandatoryMaintenaceParts : this is a list of complex objects (ExtGeneralArticleV2) containing

```
information about general articles (parts) that are linked to Maintenance Tasks and they are
mandatory ; the structure of each object is described next.
```
###  nonMandatoryAdditionalMaintenaceParts: this is a list of complex objects

```
(ExtGeneralArticleV2) containing information about general articles (parts) that are linked to
Maintenance Additional Tasks and they are possible(not mandatory) ; the structure of each
object is described next.
```
###  mandatoryAdditionalMaintenaceParts : this is a list of complex objects (ExtGeneralArticleV2)

```
containing information about general articles (parts) that are linked to Maintenance Additional
Tasks and they are mandatory ; the structure of each object is described next.
```
###  status : the status will contain 0 if the request was successful or another number if there was

an error (the possible errors are presented in chapter 2.1)

ExtGeneralArticleV2 is an extension of ExtGeneralArticle, with a supplementary field called 'remark'

ExtGeneralArticleV2 {
**Integer** id;
**boolean** mandatory;
**String** description;


107

**String** remark;
}

###  id : this is the number that uniquely identifies a general article

###  mandatory : this is a boolean value that shows if the replacement is mandatory or not;

###  description : this is a language dependent description of the general article (for example, 7

stands for “Oil filter”, 39 stands for “Trailer Hitch”)

###  remark : it is language dependent, and it is the remark of the additional task to which the part

is liked to. It can appear only for additional tasks.

We will call this operation with the following parameters:

###  descriptionLanguage – String – value: “en”

###  cartypeId – int – value: 26650

###  systemId – int – value: 106002681

###  periodId – int – value: 300135535

This result of calling this operation is:

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">

64. <soapenv:Body>
65. <getMaintenancePartsForPeriodResponse
    xmlns="http://data.webservice.workshop.vivid.nl">
66. <getMaintenancePartsForPeriodReturn>
67. < **mandatoryAdditionalMaintenaceParts** >
68. <item>
69. <description>Air filter</description>
70. <id>8</id>
71. <mandatory>true</mandatory>
72. <remark>every 40,000 miles/48 months</remark>
73. </item>
74. <item>
75. <description>Brake fluid</description>
76. <id>71</id>
77. <mandatory>true</mandatory>
78. <remark>every 24 months</remark>
79. </item>
80. ...
81. </mandatoryAdditionalMaintenaceParts>
82. < **mandatoryMaintenaceParts** >
83. <item>
84. <description>Oil filter</description>
85. <id>7</id>
86. <mandatory>true</mandatory>
87. <remark xsi:nil="true"/>


108

88. </item>
89. <item>
90. <description>Engine oil</description>
91. <id>3224</id>
92. <mandatory>true</mandatory>
93. <remark xsi:nil="true"/>
94. </item>
95. </mandatoryMaintenaceParts>
96. < **nonMandatoryAdditionalMaintenaceParts** >
97. <item>
98. <description>Timing belt</description>
99. <id>306</id>
100. <mandatory>false</mandatory>
101. <remark>first check at 60,000 miles; then every 20,000
    miles</remark>
102. </item>
103. ...
104. </nonMandatoryAdditionalMaintenaceParts>
105. < **nonMandatoryMaintenaceParts** >
106. <item>
107. <description>Exhaust pipe</description>
108. <id>17</id>
109. <mandatory>false</mandatory>
110. <remark xsi:nil="true"/>
111. </item>
112. ...
113. <item>
114. <description>Brake fluid</description>
115. <id>3357</id>
116. <mandatory>false</mandatory>
117. <remark xsi:nil="true"/>
118. </item>
119. </nonMandatoryMaintenaceParts>
120. <status xsi:nil="true"/>
121. </getMaintenancePartsForPeriodReturn>
122. </getMaintenancePartsForPeriodResponse>
123. </soapenv:Body>
124. </soapenv:Envelope>

#### 5.3.5. getCalculatedMaintenanceV4()

This operation calculates which maintenance tasks should be performed based on the

provided mileage and registration date. If there are more systems (conditions) and one is not provided

as parameter, the operation can also choose those that match certain criteria and provide the tasks

calculation for them.

The operation will return a complex object that contains:


109

### • ExtMaintenanceSystemV5 maintenanceSystem – this is a complex object that describes the

```
system for which the tasks are selected; you can find the structure of this object in the first
section of this chapter (6.1)
```
### • ExtMaintenancePeriodV5 maintenancePeriod – this is a complex object that describes the

```
selected period, which is selected by calculation by this operation; you can find the structure of
this object in the first section of this chapter (6.1)
```
### • ExtMaintenanceTaskV8[] tasks ; this is a list of complex objects that describe the tasks from the

```
selected period. The “ includeByDefault ” field of each object indicates if the task should be
included or not based on the calculation done by the operation taking in consideration the
mileage and the registration date. You can find more about the structure of this object in the
first section of this chapter (6.1)
```
Request parameters:

### • descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

### • carTypeId – int (this number is the “id” of the Type found in ExtCarType; you can check chapter

3 for more information about this object)

### • tecdocNumber – Integer *optional (this is the “id” of another type of identification, and it can

```
be specified to get a more refined set of general articles. You can find these repair times ids by
calling “getRepairtimesTypes” described in chapter 12 )
```
### • tecdocTypeCategory – String *optional – this is a text that should have one of the two values:

```
CAR or TRUCK. If empty or null, it will be used as “CAR”. It is strictly in relation with
repairtimesTypeId which in this case is the TecDoc id. If the repairtimesTypeId represents a
TecDoc id of a car, then it should be set as “CAR”, otherwise it should be set as “TRUCK”.
```
### • maintenanceSystemId – int *optional (this is the ExtMaintenanceSystemVx.id that you get from

```
a system when calling the previous operation – getMaintenanceSystemsVx()). If it is not
provided, the operation will provide the calculation for all the systems that match the provided
criteria (see the “criteria” parameter below)
```
### • registrationDate – String – this is a text that represents a date; the operation will parse the

```
date and it can have any of the next formats: dd-MM-yyyy, MM-yyyy or yyyy (where dd is the
day with 2 digits, MM is the month number with 2 digits and yyyy is the year with 4 digits);
example of correct date inputs: 2000 (which will be considered 01- 01 - 2000), 03-2000 (which
will be considered 01- 03 - 2000) or 28- 03 - 2000.
```
### • mileage – int – this is an integer numerical value which represents the number of Km or Miles


110

```
indicated by the vehicle. The selection of the measure unit (Km or Miles) is done by using
“useImperial”
```
### • useImperial – boolean – this is a boolean (true/false) value which indicates if the value

```
provided as mileage is in Miles (in which case it should be set as “true”) or in Km (in which case
it should be set as “false”)
```
### • includeServiceTimes – boolean – this is a boolean (true/false) value which indicates if the

```
result should contain the service times for the period and for the additional tasks. Please make
sure you only add the times for the additional tasks that are marked as “includeByDefault” and
the default time from the period object
```
### • countryCodes – String[] -- this is an array of strings containing country codes used to filter or

```
select the maintenance system(s).(ex:it, fo). If left null no filtering on maintenance systems will
be done
```
### • criteria – this is a complex object which can specify different types of criteria which would help

to filter or select the maintenance system(s). This object has the following structure:

### ◦ criteriaGroupId – int – this is an integer numerical value which represents the type of

```
criteria. For example, there is an id for specifying the VIN number of the car, or another to
specify in which country the vehicle is used. These ids can be found in the
maintenanceSystemsV5 and newer versions, but we provide them as an annex with all the
possibilities.
```
### ◦ criteriaId – int – this is an integer numerical value which represents a possible value in an

```
enumeration which is specific for a criteriaGroupId (for example, if the criteriaGroupId
represents the “ABS”, we provide a “criteriaId” for each possibility: “with ABS” will have a
criteriaId and “without ABS” another criteriaId). These ids can be found also in the
maintenanceSystemsV5 and newer versions when a system depend on such criteria, but we
also provide all possibilities for each criteriaGroup in an annex of this documentation.
```
### ◦ value – String – this is a text value which can be used when the criteriaGroup requires a

```
custom value (for example a VIN number, or an engine number or others). The groups that
require such values will be marked accordingly in the annex.
```
#### 5.3.6. getTimingBeltReplacementIntervals()

This operation returns all timing belt replacement intervals and their associated maintenance

system names.

This operation returns a complex object that contains:


111

### • String[] maintenanceIntervalsNames – this is an array of translated maintenance intervals

names

### • String[] maintenanceSystemsNames – this is an array of translated maintenance systems names

Request parameters:

### • descriptionLanguage - String (this should be a 2-character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

### • carTypeId – Integer (this number is the “id” of the Type found in ExtCarType; you can check

chapter 3 for more information about this object)

### • useImperial – boolean – this is a boolean (true/false) value which indicates if the value

```
provided as mileage is in Miles (in which case it should be set as “true”) or in Km (in which case
it should be set as “false”)
```
### • countryCodes – String[] -- this is an array of strings containing country codes used to filter or

```
select the maintenance system(s).(ex:it, fo). If left null no filtering on maintenance systems will
be done
```
Request:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:data="http://data.webservice.workshop.vivid.nl">
2. <soapenv:Header/>
3. <soapenv:Body>
4. <data: **getTimingBeltReplacementIntervals** >
5. <data:vrid>${vrid}</data:vrid>
**6. <data:descriptionLanguage>en</data:descriptionLanguage>
7. <data:carTypeId> 53680 </data:carTypeId>
8. <data:useImperial>false</data:useImperial>**
9. <!--1 or more repetitions:-->
10. <data:countryCodes></data:countryCodes>
11. </data: **getTimingBeltReplacementIntervals** >
12. </soapenv:Body>
13. </soapenv:Envelope>

Response:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">


112

2. <soapenv:Body>
3. <getTimingBeltReplacementIntervalsResponse
    xmlns="http://data.webservice.workshop.vivid.nl">
4. <getTimingBeltReplacementIntervalsReturn>
5. < **maintenanceIntervalsNames** >
6. <item>every 160,000 km/48 months</item>
7. </ **maintenanceIntervalsNames** >
8. < **maintenanceSystemsNames** >
9. <item>Dealer schedule, (2003 - 2004), (Up to Date Application
    Modification No. (DAM/RPO) 10247) (Sweden)</item>
10. <item>Dealer schedule, (2003 - 2004), (From Date Application
    Modification No. (DAM/RPO) 10248) (Sweden)</item>
11. </ **maintenanceSystemsNames** >
12. </getTimingBeltReplacementIntervalsReturn>
13. <getTimingBeltReplacementIntervalsReturn>
14. <maintenanceIntervalsNames>
15. <item>every 240,000 km/120 months</item>
16. </maintenanceIntervalsNames>
17. <maintenanceSystemsNames>
18. <item>OEM schedule, Normal conditions, (Up to Date Application
    Modification No. (DAM/RPO) 10247)</item>
19. <item>OEM schedule, Normal conditions, (From Date Application
    Modification No. (DAM/RPO) 10248)</item>
20. </maintenanceSystemsNames>
21. </getTimingBeltReplacementIntervalsReturn>
22. <getTimingBeltReplacementIntervalsReturn>
23. <maintenanceIntervalsNames>
24. <item>every 180,000 km/120 months</item>
25. </maintenanceIntervalsNames>
26. <maintenanceSystemsNames>
27. <item>OEM schedule, Severe conditions, (Up to Date Application
    Modification No. (DAM/RPO) 10247)</item>
28. <item>OEM schedule, Severe conditions, (From Date Application
    Modification No. (DAM/RPO) 10248)</item>
29. </maintenanceSystemsNames>
30. </getTimingBeltReplacementIntervalsReturn>
31. </getTimingBeltReplacementIntervalsResponse>
32. </soapenv:Body>
33. </soapenv:Envelope>


113

## 6. LUBRICANTS

### 6.1. Structure

Lubricants is also one of the subjects. You can find Lubricants for Engine,

Transmission, Steering & Suspension, Brakes, Exterior / Interior (and Quickguides, where all the

information for adjustments is presented in the same page).

This image is the Car-Home page from Workshop ATI Online. It shows where the links to

lubricants are located:

Figure 7.1.1 – Car Home – Lubricants

In web-services, for lubricants, there are two structure, which are;

ExtLubricantGroupV2 {
int order;
String name;
ExtLubricantItem[] lubricantItems;
ExtSmartLink[] smartLinks;


114

##### }

ExtLubricantItem {
String name;
String quality;
String viscosity;
String temperature;
int order;
}

Figure 7.1.2 – Lubricants – Groups (1) and Items (2)

The meaning of each property is:

ExtLubricantGroupV2 {
int order;
String name;
ExtLubricantItem[] lubricantItems;
ExtSmartLink[] smartLinks;
}

###  order : this is a number that is used to establish the order in which the groups should be

```
displayed. In the response message, the groups are already ordered by this property. In case
your client does not preserve the order from the response, you can use this number for
sorting.
```

115

###  name : this element is language dependent. It contains the name of the group that needs to be

shown.

###  lubricantItems : each group contains in this property an array of ExtLubricantItem objects

which are described next.

###  smartLinks : this is a list of links from group to other subjects (like capacities or other subjects).

For more info about smart links, please see chapter 6.2.3.

ExtLubricantItem {
String name;
String quality;
String viscosity;
String temperature;
int order;
}

###  name : this property is language dependent. It contains the name of the lubricant or fluid that

the other properties (quality, viscosity, and temperature) refer to.

###  quality : this property contains a string that describes a standard for quality (for example “SAE

SW-40”)

###  viscosity : this property contains a string that describes a standard for viscosity (for example

“VW 500 00”)

###  temperature : this property contains a string that describes the temperature or temperatures

that the lubricant or fluid is used at (for example: “all temperatures”).

###  order : his is a number that is used to establish the order in which the items should be

```
displayed. In the response message, the items are already ordered by this property. In case
your client does not preserve the order from the response, you can use this number for
sorting.
```
### 6.2. Operations

#### 6.2.1. getLubricantsV5()

descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3


116

for more information about this object)

###  carTypeGroup – String (this string should be one of the constants: “ENGINE”,

“TRANSMISSION”, ”BRAKES”, “STEERING”, ”EXTERIOR”, “QUICKGUIDES”, null or empty)

###  axleComponents – Integer – a list of axle components ids taken from “getAxleComponents”

```
operation. It is showing information for the selected axle components. These components
should be linked to requested cartype. If no axle component is provided, then all the
adjustment information is, otherwise it will be filtered using the provided axle components.
```
###  countryCodes – String[] -- this is an array of strings containing country codes used to filter or

```
select the lubricants component(s).(ex:AE, FO). If left null no filtering on lubricants
components will be done
```
**This operation returns an array of ExtLubricantGroupV3** that represent all the lubricants (groups and

items) for the specified Type and Group. Before calling this operation, you can check

ExtCarType.subjects to see in it contains “LUBRICANTS”. If it does, the operation will return information.

If not, it will return null.

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carType – int – 301000862 (MERCEDES-BENZ ACTROS MP4 (963) 1830 L 2011-)

###  carTypeGroup – String – QUICKGUIDES

###  axleComponents – int – 305005545 (MERCEDES-BENZ, Rear axle, (748.595))

###  countryCodes – String[] – AE

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getLubricantsV 5 Response xmlns="http://data.webservice.workshop.vivid.nl">
4. ...
5. <getLubricantsV 5 Return>
6. <groupTypes xsi:nil="true"/>
7. <lubricantItems>
8. ...
9. </lubricantItems>
10. <name> **MERCEDES-BENZ, Rear axle, (748.595)** </name>
11. <order>0</order>
12. <smartLinks>


117

13. <item>
14. <filter xsi:nil="true"/>
15. <id1>0</id1>
16. <id2 xsi:nil="true"/>
17. <operation xsi:nil="true"/>
18. <text>
19. <item>Differential</item>
20. <item>14.0</item>
21. <item>(l)</item>
22. </text>
23. </item>
24. </smartLinks>
25. <status xsi:nil="true"/>
26. </getLubricantsV 5 Return>
27. ...
28. </getLubricantsV 5 Response>
29. </soapenv:Body>
30. </soapenv:Envelope>

This is a screenshot from Workshop ATI Online:

Figure 7.2.1.1 – Lubricants – details

1 - < **name** > **Engine (Longlife)** </name> (line 22)
2 - < **name** > **Motor oil** </name> (line 7)


118

3 - < **viscosity** > **SAE 5W-30 / 5W- 40** </viscosity> (line 11)

4 - < **quality** > **VW 500 00, 502 00** </quality> (line 9)

5 - < **temperature** > **All temperatures** </temperature> (line 10)

6 - < **smartLinks** > (line 23)

#### 6.2.2. getLubricantCapacitiesV4()

### This operation is special. Even though the information that this operation returns is related to

lubricants, it is in fact adjustment data that is important for lubricants. Because of that, this operation

returns the structure used in Adjustments. For more information about Adjustments, check chapter

number 5.

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639- 1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3

for more information about this object)

###  carTypeGroup – String – (this group is the same as in table 3.1.2). It can be:

### ◦ ENGINE

### ◦ TRANSMISSION

### ◦ STEERING

### ◦ BRAKES

### ◦ EXTERIOR

### ◦ ELECTRONICS

### ◦ QUICKGUIDES

###  includeSmartLinks – boolean - this parameter is not used. When links from Repair Manuals

```
(chapter 9) to other subjects will be introduced, they will be described in a future version of
this document.
```
###  countryCodes – String[] -- this is an array of strings containing country codes used to

```
subAdjsutments item(s).(ex:AE, FO). If left null no filtering on lubricants subAdjustments will be
done
```

119

It returns an ExtAdjustmentsV3 object that contains the group called “Capacities” and has as

subAdjustments the information related to lubricants.

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carType – int – 34580 (you should find “golf iv akq” and make sure it is the same id; if it is not,

replace 26650 with the id that you find in the response)

###  carTypeGroup – String – QUICKGUIDES

###  includeSmartLinks – boolean – true

###  countryCodes – String[] – AE

The result of calling this operation contains less elements (only those containing AE):

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getLubricantCapacitiesV4Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getLubricantCapacitiesV4Return>
5. ...
6. < **name** > **Capacities** </name>
7. <order>1</order>
8. <remark xsi:nil="true" />
9. <subAdjustments>
10. <item>
11. <descriptionId>305381</descriptionId>
12. <extraInfoId xsi:nil="true"/>
13. <imageName xsi:nil="true"/>
14. < **name** >Brakes : General data</name>
15. <order>0</order>
16. <remark xsi:nil="true"/>
17. <smartLinks xsi:nil="true"/>
18. <status xsi:nil="true"/>
19. <subAdjustments xsi:nil="true"/>
20. <unit xsi:nil="true"/>
21. < value xsi:nil="true"/>
22. </item>
    ...
23. <item>
24. <descriptionId>102000067</descriptionId>


120

25. <extraInfoId xsi:nil="true"/>
26. <imageName xsi:nil="true"/>
27. < **name** >Brake system</name>
28. <order>0</order>
29. <remark xsi:nil="true"/>
30. < **smartLinks** >
31. <item>
32. <filter xsi:nil="true"/>
33. <id1>34580</id1>
34. <id2>BRAKES</id2>
35. <operation>getLubricantsByGroup</operation>
36. <text xsi:nil="true"/>
37. </item>
38. </smartLinks>
39. <status xsi:nil="true"/>
40. <subAdjustments xsi:nil="true"/>
41. < **unit** >(l)</unit>
42. < **value** >1.0</value>
43. </item>
    ...
44. </subAdjustments>
45.
46. </getLubricantCapacitiesV4Return>
47. </getLubricantCapacitiesV4Response>
48. </soapenv:Body>
49. </soapenv:Envelope>

When **countryCodes** is empty (no filtering) you will notice that the first subAdjustment item is Engine

(Europe | Australia | Russia).


121

This is a screenshot from Workshop ATI Online:

Figure 7.2.3.1 – Lubricants – Capacities

1 - < **name** > **Brakes : General data** </name> (line 14 )
2 - < **name> Brake system** </name> (line 27 )
3 - < **value** > **3.2** </value> (line 42 )
4 - < **unit** > **(l)** </unit> (line 41 )
5 - < **smartLinks** ></smartLinks> (line 30 )


122

## 7. TECHNICAL DRAWINGS

### 7.1. Structure

‘Technical drawings’ is one of the subjects that is available for a car. You can have technical

drawings for Engine, Transmission, Steering & Suspension, Brakes, Exterior / Interior (and Quickguides,

where all the information for adjustments is presented in the same page).

This image is the Car-Home page from Workshop ATI Online. It shows where the links to

technical drawings are:

Figure 8.1.1 – Car Home – Technical drawings

In Web-Services, for Technical Drawings, there is only one structure, but the same structure


123

can represent different levels in the data (it is similar to Adjustments in chapter 5)

The structure is:

ExtDrawingV2 {
String description;
String mimeDataName;
ExtDrawing2[] subDrawings;
ExtGeneralArticle[] generalArticles;
ExtRepairtimeNode[] repairTasks;
}

This is a screenshot from Workshop ATI Online:

Figure 8.1.2 – Technical drawings

Next, we will give an explanation for each element in the structure:

ExtDrawingV2 {


124

String description;
String mimeDataName;
ExtDrawing2[] subDrawings;
ExtGeneralArticle[] generalArticles;
ExtRepairtimeNode[] repairTasks;
}

###  description : this is language dependent, and it contains the name of the group (“Brakes”,

```
“ABS(mechanical0”, “Steering” - see figure 8.1.2) or the name of the picture (“Disk brake FSIII
dismantle”, “Caliper FSIII, dismantle” and so on – see figure 8.1.2); the description can be null
```
###  mimeDataName : this is a string that represents an URL to the location of the picture.

###  subDrawings : this property can contain an array of ExtDrawing2 object. Usually there are two

```
levels. The first level would be the group and the second level would contain all the pictures in
that group. There can be no more than these two levels. There is an exception, though: there
can be elements that only have one level, so mimeDataName will be not null and subDrawings
will be null, so the first level is not always a group.
```
###  generalArticles : this is a list of complex objects that contain information about the TecDoc

```
general articles that the drawing contains (this structure is used also in Maintenance and
Repair Times) – note: not all the articles that appear visually in the picture are identified as
general articles
```
###  repairTasks : this is a list or Repair Tasks (see chapter 12 for more details) with the description

and the time.

From this, we can extract the following rules regarding the structure levels:

###  there can be one or two levels

###  if one element has subDrawings not null, then it is a group and it does not contain a picture

### 7.2. Operations

#### 7.2.1. getDrawingsV4()

**This operation returns an array of ExtDrawingV 3** that represents all the technical drawings for

the specified type. Now also including criteria.

We will call this operation with the following parameters:

###  descriptionLanguage - String – en


125

###  carTypeId – int – 301000862

###  repairTimesTypeId – int – 301000862 ( MERCEDES-BENZ ACTROS MP4 (963) 1830 L 2011- )

###  typeCategory – String – TRUCK

###  carTypeGroup – String – QUICKGUIDES

<!--1 or more repetitions:-->

###  axleComponents – int – 305005542 ( MERCEDES-BENZ Front axle 739.573 )

###  axleComponents – int – 306000456 ( MERCEDES-BENZ Rear axle 748.282 )

The result of calling this operation is:

```
<getDrawingsV3Return>
```
1. <description>KNORR, 17.5-inch brake discs</description>
2. <generalArticles xsi:nil="true"/>
3. <mimeDataName xsi:nil="true"/>
4. <repairTasks xsi:nil="true"/>
5. <status xsi:nil="true"/>
6. <subDrawings>
7. <item>
8. <description>Brakes</description>
9. <generalArticles>
10. <item>
11. <description>Brake caliper</description>
12. <id>78</id>
13. <mandatory>true</mandatory>
14. </item>
15. <item>
16. <description>Brake pad set, disc brake</description>
17. <id>402</id>
18. <mandatory>true</mandatory>
19. </item>
20. <item>
21. <description>Carrier, brake caliper</description>
22. <id>1009</id>
23. <mandatory>true</mandatory>
24. </item>
25. </generalArticles>
26. <mimeDataName>http://acc.haynespro-
    assets.com/workshop/images/319010450.svgz?typeOfdrawing=tdrawing&amp;language=en</mimeDataName>
27. <repairTasks xsi:nil="true"/>
28. <status xsi:nil="true"/>
29. <subDrawings xsi:nil="true"/>


126

30. </item>
31. </subDrawings>
32. </getDrawingsV3Return>
33. **....**

#### 7.2.2. Highlighting Parts

If the image is an SVGz, the file can contain special ids for elements that surround some of the

parts/articles present in the picture. If you have a “genart” number in the response of the previous

operation call, you can look up in the SVG the element with the identifier “genart_genrartNumber” (in

the previous example, the id from the SVG would be “genart_424”).

34. <svg version="1.1" id="Layer_1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;" ... >
35. ...
36. **<path id="genart- 424 "** fill-rule="evenodd" clip-rule="evenodd" fill="#D0D2D8" stroke="#000000" stroke-width="1.5"
    stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="22.9256" d="
37. M347.936,430.487c-3.295-3.036-3.307-6.197,0.247-6.688l7.185-0.496l15.113-96.622l57.478-
    10.653l83.738,12.635l5.946,14.865
38. l5.698,59.956l2.684,3.797l2.767,8.838c1.82,3.531,1.237,5.146-0.991,5.45l-163.266,19.077c-2.643,0.456-
    4.707,0.042-6.193-1.239
39. L347.936,430.487z"/>
40. ...
41. </svg>

The id from the SVG can be the id of a path or of a group that contains “path” elements.

1. <svg contentScriptType="text/ecmascript" zoomAndPan="magnify" ...>
2. ...
3. **<g id="genart- 515 ">**
4. <path fill="#339933" d="M203.484,201.953...,201.953z" stroke-width="0.5" stroke-linejoin="round"
    stroke-linecap="round" stroke="#000000"/>
5. <path fill="#339933" d="M217.811,126.875...,126.875z" stroke-width="0.5" stroke-linejoin="round"
    stroke-linecap="round" stroke="#000000"/>
6. ...
7. <path fill="#339933" d="M340.523,312.057...,312.057z" stroke-width="0.5" stroke-linejoin="round"
    stroke-linecap="round" stroke="#000000"/>
8. </g>
9. </svg>


127

## 8. REPAIR MANUALS

### 8.1. Structure

Repair Manuals is one of the subjects that are available for a car. You can have repair manuals

for Engine, Transmission, Steering & Suspension, Brakes, Exterior / Interior (and Quickguides, where all

the information for adjustments is presented on the same page).

This screenshot is the Car-Home page from Workshop ATI Online. It shows where the links to

repair manuals are:

Figure 9.1.1 – Car Home – Repair manuals

For repair manuals there are three structures:


128

ExtStory {
String name;
int order;
int storyId;
}

This is a screenshot from Workshop ATI Online showing elements represented by this

structure:

Figure 9.1.2 – Repair manuals – Manual selection

Next, we will explain each element in the structure:

###  name : this property is language dependent. It is the only part of the structure that is displayed

and based on it, the user makes the selection of the repair manual.

###  order : this is a number that is used to establish the order in which the groups should be

```
displayed. In the response message, the groups are already ordered by this property. In case
your client does not preserve the order from the response, you can use this number for
sorting.
```
###  storyId : this is the number used to relate this element to the next structure (the content of the

manual)


129

ExtStory V2{
String imageName;
int order;
int storyId;
}

This is a screenshot from Workshop ATI Online showing elements represented by this

structure:

Figure 9.1.3 –Warning lights systems selection

Next, we will explain each element in the structure:

###  imageName : this property contains the URL to the image linked to a warning lights repair

manual.

###  order : this is a number that is used to establish the order in which the groups should be

```
displayed. In the response message, the groups are already ordered by this property. In case
your client does not preserve the order from the response, you can use this number for
sorting.
```
###  storyId : this is the number used to relate this element to the next structure (the content of the

manual)


130

ExtStoryV3{
String imageName;
int order;
int storyId;
ExtStoryLineV4[] storyLines;
}

Next, we will explain each element in the structure:

###  imageName : this property contains the URL to the image linked to a warning lights repair

manual.

###  order : this is a number that is used to establish the order in which the groups should be

```
displayed. In the response message, the groups are already ordered by this property. In case
your client does not preserve the order from the response, you can use this number for
sorting.
```
###  storyId : this is the number used to relate this element to the next structure (the content of the

manual)

###  storyLines: this is an array of ExtStoryLineV4 which represents all the story lines linked to a

repair manual


131

```
ExtStoryV4 {
String name;
int order;
int storyId;
Int categoryId;
ExtStatus status;
}
```
Next, we will explain each element in the structure:

###  name : this property is language dependent. It is the only part of the structure that is displayed

and based on it, the user makes the selection of the repair manual.

###  order : this is a number that is used to establish the order in which the groups should be

```
displayed. In the response message, the groups are already ordered by this property. In case
your client does not preserve the order from the response, you can use this number for
sorting.
```
###  storyId : this is the number used to relate this element to the next structure (the content of the

manual)

###  categoryId: this is a number representing the categoryId of a Story (e.g., 101, 102, etc etc)

###  status: the status will contain 0 if the request was successful or another number if there was

an error (the possible errors are presented in chapter 2.1).


132

The next structure is:

ExtStoryLineV4 {
Integer id;
int order;
String name;
String remark;
String mimeDataName;
ExtStoryLineV4[] subStoryLines;
ExtSmartLink[] smartLinks;
ExtSpecialTool[] specialTool;
ExtStatus status;
}

This is a screenshot from Workshop ATI Online showing the data that is contained by this structure:

Figure 9.1.3 – Repair manuals – Group names(1), name(2) and remark(3)

Next, we will explain each property of this structure:


133

ExtStoryLineV4 {
Integer id;
int order;
String name;
String remark;
String mimeDataName;
ExtStoryLineV4[] subStoryLines;
ExtSmartLink[] smartLinks;
ExtSpecialTool[] specialTool;
ExtStatus status;
}

###  id : this property can be either null for the group (1 in the above picture – figure 9.1.3) or a

unique identifier for the manual (2 in the above image).

###  order: this is a number that is used to establish the order in which the elements (from the

```
same level) should be displayed. In the response message, these elements are already ordered
by this property. In case your client does not preserve the order from the response, you can
use this number for sorting.
```
###  name : this property is language dependent. It is either the name of the group (1 in the above

```
picture – figure 9.1.3) or a sentence from the manual (2 in the above image); this element can
be null (no description), but then there should be either a remark or an image available.
```
###  remark : this property is also language dependent. It can be null. If it is not null, the text

```
contained by it comes to complete the information provided by the name (3 in the above
image); this element can also be null (meaning no remark)
```
###  mimeDataName : this property, if it is not null, contains a URL to an image. Usually only the

```
second level contains images, but there are cases when the first level also has an image (when
there is no level 2 and the image is the only element in the repair manual; one example is
Honda Jazz, the “timing” story)
```
###  subStoryLine : this property is an array of ExtStoryLineV4 objects. The first level contains

```
groups, and each group contains the second level in this property (subStoryLine). There are a
few cases when this is null (see the last remark in the description of “mimeDataName” just
above)
```
###  smartLinks: this is a list of links from group to other subjects. For more info about smart links,

please see chapter 6.2.3.

###  specialTool : this property is an array of ExtSpecialTool objects. It describes the special tools

that should be used for the linked repair.

###  status: the status will contain 0 if the request was successful or another number if there was

an error (the possible errors are presented in chapter 2.1) needed for the specific repair.


134

ExtStoryLineV5 {
Integer id;
int order;
String name;
String remark;
ExtStoryLineV5[] subStoryLines;
ExtSmartLink[] smartLinks;
ExtSpecialTool[] specialTool;
ExtStatus status;
String sentenceGroupType;
String sentenceStyle;
ExtParagraphContent[] paragraphContent;
ExtTableContent tableContent;
ExtMimeData mimeData;

##### }

###  id : this property can be either null for the group (1 in the above picture – figure 9.1.3) or a

unique identifier for the manual (2 in the above image).

###  order: this is a number that is used to establish the order in which the elements (from the

```
same level) should be displayed. In the response message, these elements are already ordered
by this property. In case your client does not preserve the order from the response, you can
use this number for sorting.
```
###  name : this property is language dependent. It is either the name of the group (1 in the above

```
picture – figure 9.1.3) or a sentence from the manual (2 in the above image); this element can
be null (no description), but then there should be either a remark or an image available.
```
###  remark : this property is also language dependent. It can be null. If it is not null, the text

```
contained by it comes to complete the information provided by the name (3 in the above
image); this element can also be null (meaning no remark)
```
###  subStoryLine : this property is an array of ExtStoryLineV5 objects. The first level contains

```
groups, and each group contains the second level in this property (subStoryLine). There are a
few cases when this is null (see the last remark in the description of “mimeData”)
```
###  smartLinks: this is a list of links from group to other subjects. For more info about smart links,

please see chapter 6.2.3.

###  specialTool : this property is an array of ExtSpecialTool objects. It describes the special tools

that should be used for the linked repair.

###  status: the status will contain 0 if the request was successful or another number if there was

an error (the possible errors are presented in chapter 2.1) needed for the specific repair.


135

###  sentenceGroupType: this is a constant value that specifies if the current storyline is a container

```
for other story lines like a paragraph, number list, table. Currently a sentence can be part of one
of these groups: PARAGRAPH, NUMBERED_LIST, BULLET_LIST, TABLE.
```
###  sentenceStyle: represents the style of the current storyline. Currently sentences can have one of

these constant values: HEADER_STYLE, SENTENCE_STYLE, SUBSENTENCE_STYLE.

###  paragraphContent: this property is an array of ExtParagraphContent objects which contains

the sentences that belong to a paragraph.

###  tableContent: this property is an array of ExtTableContent objects that contains the total

number of rows and columns of a table and also the value of each individual cell.

###  mimeData: this property, if it is not null, represents a ExtMimeData object that contains a URL

```
to an image and some additional information about the image that are stored using an array of
ExtStoryLineV5[] objects. Usually only the second level contains images, but there are cases
when the first level also has an image (when there is no level 2 and the image is the only
element in the repair manual; one example is Honda Jazz, the “timing” story).
```
ExtParagraphContent {
Integer id;
String name;
int order;
String sentenceStyle;
}

###  id : this property contains a unique identifier for the manual.

###  order: this is a number that is used to establish the order in which the elements of a paragraph

```
should be displayed. In the response message, these elements are already ordered by this
property. In case your client does not preserve the order from the response, you can use this
number for sorting.
```
###  name : this property is language dependent and represents a sentence that is part of the

current paragraph**.**

###  sentenceStyle: represents the style of the current storyline. Currently sentences can have one

of these constant values: HEADER_STYLE, SENTENCE_STYLE, SUBSENTENCE_STYLE.

ExtTableContent {
int numberOfColumns;
int numberOfRows;
ExtTableCell[] tableCells;
}


136

###  numberOfColumns : this property represents the total number of columns in the table.

###  numberOfRows: this property represents the total number of rows in the table.

###  tableCells: this property is an array of ExtTableCell objects where each object contains the

value and order of a table cell.

ExtTableCell {
String value;
int order;
}

###  value: this property represents the value of a table cell;

###  order: this property represents the order of a cell in a row. In the response message, these

```
elements are already ordered by this property. In case your client does not preserve the order
from the response.
```
ExtMimeData {
String mimeDataName;
ExtStoryLineV5[] subStoryLines;
}

###  mimeDataName: this property contains a URL to an image.

###  subStoryLines: this property is an array of ExtStoryLineV5 objects that represents additional

information about the current image.

ExtSpecialTool {

Integer id;

String code;

String dimensions;

String description;

String mimeDataName;

int order;

ExtStatus status;

}

###  id : this is the number that uniquely identifies a special tool

###  code : unique code of a special tool


137

###  dimensions : special tool dimensions

###  mimeDataName : this is an URL to an image. This image represents the special tool image

###  status: the status will contain 0 if the request was successful or another number if there was

an error (the possible errors are presented in chapter 2.1)

ExtStoryListContainerV2 {
String name;
ExtStoryLineV5[] storyLines;
ExtStatus status;
}

The meaning of the above elements is:

###  name : the name of the repair manual

###  storyLines : this is an array of ExtStoryLineV5 which represents all the story lines linked to a

repair manual

###  status : the status will contain 0 if the request was successful or another number if there was

an error (the possible errors are presented in chapter 2.1)

ExtStoryGeneralArticles {

ExtGeneralArticle[] generalArticles;

}

###  generalArticles: this is a list of objects containing information about general articles (parts); the

structure of each object is described next

ExtGeneralArticle {
**Integer** id;
**boolean** mandatory;
**String** description;
}

###  id : this is the number that uniquely identifies a general article

###  mandatory : this is a boolean value that shows if the replacement is mandatory or not;

###  description : this is a language dependent description of the general article (for example, 7

stands for “Oil filter”, 39 stands for “Trailer Hitch”)


138

### 8.2. Operations

#### 8.2.1. getStoryOverview()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3

for more information about this object)

**This operation returns an array of ExtStory** that represent all the repair manuals names for

the specified Type. Before calling this operation, you can check ExtCarType.subjects to see in it

contains “STORIES”. If it does, the operation will return information. If not, it will return null.

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carType – int – 26650 (you should find “golf iv akq” and make sure it is the same id; if it is not,

replace 26650 with the id that you find in the response)

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getStoryOverviewResponse xmlns="http://data.webservice.workshop.vivid.nl">
4. <getStoryOverviewReturn>
5. < **name** > **Body** </name>
6. <order>0</order>
7. < **storyId** > **3802** </storyId>
8. </getStoryOverviewReturn>
9. <getStoryOverviewReturn>
10. < **name** > **Keys** </name>
11. <order>1</order>
12. < **storyId** > **4014** </storyId>
13. </getStoryOverviewReturn>
14. <getStoryOverviewReturn>
15. < **name** > **Engine removal** </name>
16. <order>2</order>
17. < **storyId** > **3799** </storyId>
18. </getStoryOverviewReturn>
19. <getStoryOverviewReturn>


139

20. < **name** > **Timing** </name>
21. <order>3</order>
22. < **storyId** > **3864** </storyId>
23. </getStoryOverviewReturn>
24. </getStoryOverviewResponse>
25. </soapenv:Body>
26. </soapenv:Envelope>

This is a screenshot from Workshop ATI Online showing the same information:

Figure 9.2.1.1 – Repair manuals – selection

1 - < **name** > **Body** </name> (line 5)

When calling the operation to get the repair manual content, the id from this XML will be used

as parameters:

< **storyId** > **3801** </storyId> (line 7)

#### 8.2.2. getStoryOverviewByGroupV2()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3

for more information about this object)


140

###  group – String (this string should be one of the constants: “ENGINE”,

“TRANSMISSION”, ”BRAKES”, “STEERING”, ”EXTERIOR”)

This operation returns an array of **ExtStoryV4** that represent all repair manuals names for the

specified Type and Group.

Before calling this operation, you can check ExtCarType.subjectsByGroup to see if you can

expect to receive information from this operation. The returned information has the same structure.

The only difference compared to getStoryOverview() is the fact that it is restricted (filtered) to the

specified group.

The difference between V2 and previous one is that the last one contains categoryId in

response.

Request:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:data="http://data.webservice.workshop.vivid.nl">
2. <soapenv:Header/>
3. <soapenv:Body>
4. <data:getStoryOverviewByGroupV2>
5. <data:vrid>${vrid}</data:vrid>
6. <data:descriptionLanguage> **en** </data:descriptionLanguage>
7. <data:carType> **26650** </data:carType>
8. <data:carTypeGroup> **ENGINE** </data:carTypeGroup>
9. </data:getStoryOverviewByGroupV2>
10. </soapenv:Body>

Response:

11. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
12. <soapenv:Body>
13. <getStoryOverviewByGroupV2Response xmlns="http://data.webservice.workshop.vivid.nl">
14. <getStoryOverviewByGroupV2Return>
15. < **categoryId** > **102** </ **categoryId** >
16. <name>Engine assembly: removal/installation</name>
17. <order>0</order>
18. <status>
19. <confirmationLink xsi:nil="true"/>
20. <statusCode>0</statusCode>
21. </status>
22. <storyId>3799</storyId>
23. </getStoryOverviewByGroupV2Return>
24. <getStoryOverviewByGroupV2Return>


141

25. < **categoryId** > **101** </ **categoryId** >
26. <name>Timing belt: removal/installation</name>
27. <order>1</order>
28. <status xsi:nil="true"/>
29. <storyId>3864</storyId>
30. </getStoryOverviewByGroupV2Return>
31. </getStoryOverviewByGroupV2Response>
32. </soapenv:Body>
33. </soapenv:Envelope>

#### 8.2.3. getStoryInfoV6()

This operation returns an array of ExtStoryLineV5 (which represents all the story lines for the selected

repair manual) and the name of the repair manual. This operation is similar with “getStoryInfoV5()” , the
difference consists in the fact that for this operation the story lines that are returned will have specified all of

their grouping structures and styles like tables, lists paragraphs, headers etc.

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO; for

```
example, for English it is “en”, for French it is “fr”)
```
###  carTypeId - int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3 for

```
more information about this object; for this operation this parameter is optional)
```
###  storyId - int (this number is the “id” of the Story found in ExtStory when calling “getStoryOverview()” or

```
“getStoryOverviewByGroup()”)
```
###  smartLinks - boolean (his is a true/false value. It shows links from adjustments to other subjects (like

```
lubricants, technical drawings and so on). See chapter “6.2.3 Smart Links” for more details about Smart
Links. If this parameter is set to true than the “carType” must be specified in order to display the links.)
```
We can call this operation with the following parameters:

###  descriptionLanguage - String - en

###  carTypeId - int - 51060

###  storyId - int - 317000176

###  smartLinks - boolean – false

The result of calling this operation is:

1. soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getStoryInfoV6Response xmlns="http://data.webservice.workshop.vivid.nl">


142

4. <getStoryInfoV6Return>
5. **<name>General information: Air conditioning</name>**
6. <status xsi:nil="true"/>
7. <storyLines>
8. <storyLines>
9. <id xsi:nil="true"/>
10. <mimeData xsi:nil="true"/>
11. **<name>Basic operating principles</name>**
12. <order>0</order>
13. <paragraphContent xsi:nil="true"/>
14. <remark xsi:nil="true"/>
15. <sentenceGroupType xsi:nil="true"/>
16. <sentenceStyle xsi:nil="true"/>
17. <smartLinks xsi:nil="true"/>
18. <specialTool xsi:nil="true"/>
19. <status xsi:nil="true"/>
20. <subStoryLines>
21. <subStoryLines>
22. <id>300005586</id>
23. **<name>Air conditioning system:</name>**
24. <order>0</order>
25. <paragraphContent xsi:nil="true"/>
26. <remark/>
27. <sentenceGroupType xsi:nil="true"/>
28. **<sentenceStyle>HEADER_STYLE</sentenceStyle>**
29. <smartLinks xsi:nil="true"/>
30. <specialTool xsi:nil="true"/>
31. <status xsi:nil="true"/>
32. <subStoryLines xsi:nil="true"/>
33. <tableContent xsi:nil="true"/>
34. **<mimeData>**
35. **<mimeDataName>http://www.haynespro-**
    **services.com/workshop/images/317001519.jpg</mimeDataName>**
36. **<subStoryLines>**
37. **<subStoryLines>**
38. <id xsi:nil="true"/>
39. <mimeData xsi:nil="true"/>
40. **<name>Explanation** </name>
41. <order>0</order>
42. <paragraphContent xsi:nil="true"/>
43. <remark xsi:nil="true"/>
44. <sentenceGroupType xsi:nil="true"/>
45. <sentenceStyle xsi:nil="true"/>
46. <smartLinks xsi:nil="true"/>
47. <specialTool xsi:nil="true"/>
48. <status xsi:nil="true"/>


143

49. **<subStoryLines>**
50. **<subStoryLines>**
51. <id xsi:nil="true"/>
52. <mimeData xsi:nil="true"/>
53. <name xsi:nil="true"/>
54. <order>0</order>
55. <paragraphContent xsi:nil="true"/>
56. <remark xsi:nil="true"/>
57. **<sentenceGroupType>NUMBERED_LIST</sentenceGroupType>**
58. <sentenceStyle xsi:nil="true"/>
59. <smartLinks xsi:nil="true"/>
60. <specialTool xsi:nil="true"/>
61. <status xsi:nil="true"/>
62. **<subStoryLines>**
63. **<subStoryLines>**
64. <id>317000558</id>
65. <mimeData xsi:nil="true"/>
66. **<name>Air-conditioning condenser</name>**
67. <order>0</order>
68. <paragraphContent xsi:nil="true"/>
69. <remark/>
70. <sentenceGroupType xsi:nil="true"/>
71. **<sentenceStyle>SENTENCE_STYLE</sentenceStyle>**
72. <smartLinks xsi:nil="true"/>
73. <specialTool xsi:nil="true"/>
74. <status xsi:nil="true"/>
75. <subStoryLines xsi:nil="true"/>
76. <tableContent xsi:nil="true"/>
77. **</subStoryLines>**
78. **<subStoryLines>**
79. <id>318000510</id>
80. <mimeData xsi:nil="true"/>
81. **<name>Air-conditioning compressor</name>**
82. <order>1</order>
83. <paragraphContent xsi:nil="true"/>
84. <remark/>
85. <sentenceGroupType xsi:nil="true"/>
86. **<sentenceStyle>SENTENCE_STYLE</sentenceStyle>**
87. <smartLinks xsi:nil="true"/>
88. <specialTool xsi:nil="true"/>
89. <status xsi:nil="true"/>
90. <subStoryLines xsi:nil="true"/>
91. <tableContent xsi:nil="true"/>
92. < **/subStoryLines>**
93.
94. ...


144

34. <subStoryLines>
35. <id xsi:nil="true"/>
36. <mimeData xsi:nil="true"/>
37. <name xsi:nil="true"/>
38. <order>2</order>
39. **<paragraphContent>**
40. **<paragraphContent>**
41. <id>317000563</id>
42. **<name>The low-pressure side produces the cooling effect** </name>
43. <order>0</order>
44. <sentenceStyle>SENTENCE_STYLE</sentenceStyle>
45. **</paragraphContent>**
46. <paragraphContent>
47. <id>317000564</id>
48. **<name>The liquid flows from the expansion valve through the evaporator, returning as a**
    **vapour</name>**
49. <order>1</order>
50. <sentenceStyle>SENTENCE_STYLE</sentenceStyle>
51. **</paragraphContent>**
52. **</paragraphContent>**
53. <remark xsi:nil="true"/>
54. <sentenceGroupType>PARAGRAPH</sentenceGroupType>
55. <sentenceStyle xsi:nil="true"/>
56. <smartLinks xsi:nil="true"/>
57. <specialTool xsi:nil="true"/>
58. <status xsi:nil="true"/>
59. <subStoryLines xsi:nil="true"/>
60. <tableContent xsi:nil="true"/>
61. </subStoryLines>
95. ....
96. <subStoryLines>
97. <id xsi:nil="true"/>
98. <mimeData xsi:nil="true"/>
99. <name xsi:nil="true"/>
100. <order>3</order>
101. <paragraphContent xsi:nil="true"/>
102. <remark xsi:nil="true"/>
103. **<sentenceGroupType>BULLET_LIST</sentenceGroupType>**
104. <sentenceStyle xsi:nil="true"/>
105. <smartLinks xsi:nil="true"/>
106. <specialTool xsi:nil="true"/>
107. <status xsi:nil="true"/>
108. **<subStoryLines>**
109. **<subStoryLines>**
110. <id>317000594</id>
111. <mimeData xsi:nil="true"/>


145

112. **<name>Check that the manufacturer supports the conversion</name>**
113. <order>0</order>
114. <paragraphContent xsi:nil="true"/>
115. <remark/>
116. <sentenceGroupType xsi:nil="true"/>
117. <sentenceStyle>SENTENCE_STYLE</sentenceStyle>
118. <smartLinks xsi:nil="true"/>
119. <specialTool xsi:nil="true"/>
120. <status xsi:nil="true"/>
121. <subStoryLines xsi:nil="true"/>
122. <tableContent xsi:nil="true"/>
123. **</subStoryLines>**
124. **<subStoryLines>**
125. <id>317000595</id>
126. <mimeData xsi:nil="true"/>
127. **<name>When converting an R12 system to R134a, drain the existing oil</name>**
128. <order>1</order>
129. <paragraphContent xsi:nil="true"/>
130. <remark/>
131. <sentenceGroupType xsi:nil="true"/>
132. <sentenceStyle>SENTENCE_STYLE</sentenceStyle>
133. <smartLinks xsi:nil="true"/>
134. <specialTool xsi:nil="true"/>
135. <status xsi:nil="true"/>
136. <subStoryLines xsi:nil="true"/>
137. <tableContent xsi:nil="true"/>
138. **</subStoryLines>**
139. .....
140. <subStoryLines>
141. <id xsi:nil="true"/>
142. <mimeData xsi:nil="true"/>
143. <name>AC system test</name>
144. <order>0</order>
145. <paragraphContent xsi:nil="true"/>
146. <remark xsi:nil="true"/>
147. **<sentenceGroupType>TABLE</sentenceGroupType>**
148. <sentenceStyle>SENTENCE_STYLE</sentenceStyle>
149. <smartLinks xsi:nil="true"/>
150. <specialTool xsi:nil="true"/>
151. <status xsi:nil="true"/>
152. <subStoryLines xsi:nil="true"/>
153. **<tableContent>**
154. **<numberOfColumns> 8 </numberOfColumns>**
155. **<numberOfRows> 34 </numberOfRows>**
156. **<tableCells>**
157. **<tableCells>**


146

158. <order>0</order>
159. **<value>Engine speed (rpm)</value>**
160. **</tableCells>**
161. **<tableCells>**
162. <order>1</order>
163. **<value>Relative humidity</value>**
164. **</tableCells>**
165. **<tableCells>**
166. <order>2</order>
167. **<value>Ambient air temperature</value>**
168. **</tableCells>**
169. **<tableCells>**
170. <order>3</order>
171. **<value>Discharge air approximate temperature</value>**
172. **</tableCells>**
173.
62.


147

This is a screenshot from Workshop ATI Online showing the same information:

Figure 9.2.3.1 – Repair Manual

1 - < **name** > **Removal** </name>
2 - < **name** > **Lock the camshaft** </name>
3 - < **code** > **T10016** </remark>
4 - < **mimeDataName** >http://www.haynespro-
services.com:8080/workshop/images/16919_bcatim_dba_soest_3.svgz</mimeDataName>

#### 8.2.4. getStoryInfoByGenart()

**This operation returns an array of ExtStoryListContainerV2** that represents all the repair

manuals for the specified type based on the provided general article number.


148

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carTypeId - int (this number is the “id” of the Type found in ExtCarType; you can check chapter

3 for more information about this object; for this operation this parameter is optional)

###  genart - int - number (id) of General Article Number (genArt number, provided by TecDoc)

###  smartLinks - boolean (his is a true/false value. It shows links from adjustments to other

```
subjects (like lubricants, technical drawings and so on). See chapter “6.2.3 Smart Links” for
more details about Smart Links. If this parameter is set to true than the “carType” must be
specified in order to display the links.)
```
We can call this operation with the following parameters:

###  descriptionLanguage - String - en

###  carTypeId - int - 54200

###  genart - int - 890

###  smartLinks - boolean – true

The result of calling this operation is:

1. <getStoryInfoByGenartReturn>
2. <name>Clutch: removal/installation</name>
3. <status xsi:nil="true"/>
4. <storyLines>
5. <item>
6. <id xsi:nil="true"/>
7. <mimeData xsi:nil="true"/>
8. <name>Warnings and recommendations</name>
9. <order>0</order>
10. <paragraphContent xsi:nil="true"/>
11. <remark xsi:nil="true"/>
12. <sentenceGroupType xsi:nil="true"/>
13. <sentenceStyle xsi:nil="true"/>
14. <smartLinks xsi:nil="true"/>
15. <specialTool xsi:nil="true"/>
16. <status xsi:nil="true"/>
17. <subStoryLines>
18. <item>
19. <id>4013</id>
20. <mimeData xsi:nil="true"/>
21. <name>Before disconnecting the battery cable, check the audio system security code</name>
22. <order>0</order>


149

#### 8.2.5. getWarningLightsV2()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3

for more information about this object)

**This operation returns an array of ExtStoryV3** that represent all warning lights repair manuals

for the specified Type. The difference between ExtStoryV3 and ExtStoryV2 is that the V3 one contains

an array of ExtStoryLineV4 which represents all the story lines linked to a repair manual.

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carTypeId – int – 26650

The results will look like this :

23. <getWarningLightsV2Return>
24. <imageName>http://localhost:4040/workshop/images/303000760.svgz</imageName>
25. <order>0</order>
26. <status xsi:nil="true"/>
27. <storyId>302000086</storyId>
28. **<storyLines>**
29. <storyLines>
30. <id xsi:nil="true"/>
31. <mimeDataName xsi:nil="true"/>
32. <name>Description</name>
33. <order>0</order>
34. <remark xsi:nil="true"/>
35. <smartLinks xsi:nil="true"/>
36. <specialTool xsi:nil="true"/>
37. <status xsi:nil="true"/>
38. **<subStoryLines>**
39. <subStoryLines>
40. <id>302000103</id>
41. <mimeDataName xsi:nil="true"/>
42. <name>Engine-related malfunction</name>
43. <order>0</order>
44. <remark/>
45. <smartLinks xsi:nil="true"/>
46. <specialTool xsi:nil="true"/>
47. <status xsi:nil="true"/>


150

48. <subStoryLines xsi:nil="true"/>
49. </subStoryLines>
50. </subStoryLines>
51. </storyLines>
52. <storyLines>
53. <id xsi:nil="true"/>
54. <mimeDataName xsi:nil="true"/>
55. <name>Solution</name>
56. <order>1</order>
57. <remark xsi:nil="true"/>
58. <smartLinks xsi:nil="true"/>
59. <specialTool xsi:nil="true"/>
60. <status xsi:nil="true"/>
61. <subStoryLines>
62. <subStoryLines>
63. <id>10809</id>
64. <mimeDataName xsi:nil="true"/>
65. <name>Turn the ignition off and on</name>
66. <order>0</order>
67. <remark/>
68. <smartLinks xsi:nil="true"/>
69. <specialTool xsi:nil="true"/>
70. <status xsi:nil="true"/>
71. <subStoryLines xsi:nil="true"/>
72. </subStoryLines>
73. ...

Figure 9.2.4.1 – Workshop ATI Online – Warning lights repair manuals


151

### 8.3. Maintenance Stories

In the maintenance group, in Workshop ATI Online, you can see some elements that do not

have the maintenance structure. They are manuals (like Repair Manuals), but they are in close relation

to Maintenance. These elements are: “Service reset”, “Keys” and “Maintenance extra info”.

Figure 9.3.1 – Workshop ATI Online – Car Home – Maintenance Stories

There is an operation in this web service, called “getMaintenanceStories()” that returns all of

these manuals (those that are available), and also an operation for each of them individually:

“getMaintenanceServiceReset()”, “getMaintenanceKeys()” and “getMaintenanceExtraInfo()”, in case

you want to show only one of them in a different context.

#### 8.3.1. getMaintenanceStories()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3

for more information about this object)


152

**This operation returns an array of ExtStory** that represent all the repair manuals names

related to maintenance that exist for the specified Type.

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carType – int – 26650 (you should find “golf iv akq” and make sure it is the same id; if it is not,

replace 26650 with the id that you find in the response)

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getMaintenanceStoriesResponse xmlns="http://data.webservice.workshop.vivid.nl">
4. <getMaintenanceStoriesReturn>
5. < **name** > **Service reset** </name>
6. <order>0</order>
7. < **storyId** > **3969** </storyId>
8. </getMaintenanceStoriesReturn>
9. <getMaintenanceStoriesReturn>
10. < **name** > **Keys** </name>
11. <order>1</order>
12. < **storyId** > **4014** </storyId>
13. </getMaintenanceStoriesReturn>
14. <getMaintenanceStoriesReturn>
15. < **name** > **Maintenance extra info** </name>
16. <order>2</order>
17. < **storyId** > **3956** </storyId>
18. </getMaintenanceStoriesReturn>
19. </getMaintenanceStoriesResponse>
20. </soapenv:Body>
21. </soapenv:Envelope>


153

Figure 9.3.1.1 – Car Home – Maintenance stories

1 - < **name** > **Service reset** </name> (line 5)
2 - < **name** > **Keys** </name> (line 10)
3 - < **name** > **Maintenance extra info** </name> (line 15)

The rest is exactly the same as calling getStoryOverview(). You use the storyId from any result

to get the content of the repair manual, by using getStoryInfo().

#### 8.3.2. getMaintenanceServiceReset()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3

for more information about this object)

**This operation returns an array of ExtStory** that represent all the repair manuals names

related to maintenance and service reset that exist for the specified Type. In most of the cases, there

is only one element in this array. But there can also none or two or more.


154

#### 8.3.3. getMaintenanceKeys()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3

for more information about this object)

**This operation returns an array of ExtStory** that represent all the repair manuals names

related to maintenance and keys that exist for the specified Type. In most of the cases, there is only

one element in this array. But there can also none or two or more.

#### 8.3.4. getMaintenanceExtraInfo()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3

for more information about this object)

**This operation returns an array of ExtStory** that represent all the repair manuals names

related to maintenance and extra information that exist for the specified Type. In most of the cases,

there is only one element in this array. But there can also none or two or more.

#### 8.3.5. getTimingStoriesOverviewV2()

This operation receives the same parameters and returns the same data objects as

getStoriesOverview() (see chapter 9.2.1).

The returned data contains the descriptions of the Repair Manuals that refer to the engine

Timing Belt or Chain and the ids that can be used with the operation getStoryInfo (see chapter 9.2.3)

to get the content of these repair manuals.

The difference between this version and the previous one is that the latest contains a new field

categoryId. The response contains an array of **ExtStoryV4** objects.

Request:


155

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:data="http://data.webservice.workshop.vivid.nl">
2. <soapenv:Header/>
3. <soapenv:Body>
4. <data:getTimingStoriesOverviewV2>
5. <data:vrid>${vrid}</data:vrid>
6. <data:descriptionLanguage> **en** </data:descriptionLanguage>
7. <data:carType> **26650** </data:carType>
8. </data:getTimingStoriesOverviewV2>
9. </soapenv:Body>
10. </soapenv:Envelope>

Response:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getTimingStoriesOverviewV2Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getTimingStoriesOverviewV2Return>
5. < **categoryId** > **101** </ **categoryId** >
6. <name> **Timing belt: removal/installation** </name>
7. <order>0</order>
8. <status>
9. <confirmationLink xsi:nil="true"/>
10. <statusCode>0</statusCode>
11. </status>
12. <storyId>3864</storyId>
13. </getTimingStoriesOverviewV2Return>
14. </getTimingStoriesOverviewV2Response>
15. </soapenv:Body>
16. </soapenv:Envelope>
17.

#### 8.3.6. getStoryGeneralArticlesV2()...........................................................................................................................

This operation returns an object that contains a list of general articles objects (see

ExtStoryGeneralArticles in chapter 9.1)

This operation requires as parameters:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3


156

for more information about this object)

###  storyId – int (this number is the “id” of the Story found in ExtStory when calling

getStoryOverview() or getStoryOverviewByGroupV2())

###  tecdocNumber – int (this number is the “id” of the Tecdoc Type identification – can be null or

0 if it is not known). This filters the general articles.

This is an example request:

Request:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:data="http://data.webservice.workshop.vivid.nl">
2. <soapenv:Header/>
3. <soapenv:Body>
4. <data:getStoryGeneralArticlesV2>
5. <data:vrid>[vrid]</data:vrid>
6. <data:descriptionLanguage>en</data:descriptionLanguage>
7. <data:carTypeId>102001143</data:carTypeId>
8. <data:storyId>106001008</data:storyId>
9. <data:tecdocNumber>19914</data:tecdocNumber>
10. </data:getStoryGeneralArticlesV2>
11. </soapenv:Body>
12. </soapenv:Envelope>

Response:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getStoryGeneralArticlesV2Response
    xmlns="http://data.webservice.workshop.vivid.nl">
4. <getStoryGeneralArticlesV2Return>
5. <generalArticles>
6. <item>
7. < **description** > **Releaser** </description>
8. < **id** > **48** </id>
9. <mandatory>false</mandatory>
10. </item>
11. ...
12. <item>
13. < **description** > **Bolt kit, clutch** </description>
14. < **id** > **890** </id>


157

15. <mandatory>false</mandatory>
16. </item>
17. </generalArticles>
18. <status xsi:nil="true"/>
19. </getStoryGeneralArticlesV2Return>
20. </getStoryGeneralArticlesV2Response>
21. </soapenv:Body>
22. </soapenv:Envelope>

#### 8.3.7. getDisclaimerV2()...........................................................................................................................................

This operation returns the disclaimer from a specific manufacturer. If there is no make specific
disclaimer available, then it returns the standard disclaimer.
This operation requires as parameters:

###  vehicleId - int (this id can be obtained by calling “getIdentificationTree()” operation)

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  vehicle_level – String (this can be MAKE, MODEL, TYPE and MODEL_GROUP)

###  subject – String (set nothing, in case REPAIRTIMES subject is set it will return repair times

disclaimer)

This is an example request:

Request:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:data="http://data.webservice.workshop.vivid.nl">
2. <soapenv:Header/>
3. <soapenv:Body>
4. <data:getDisclaimerV2>
5. <data:vehicleId>820</data:vehicleId>
6. <data:language>en</data:language>
7. <data:vehicle_level>MAKE</data:vehicle_level>
8. <data:subject></data:subject>
9. </data:getDisclaimerV2>
10. </soapenv:Body>
11. </soapenv:Envelope>


158

Response:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getDisclaimerV2Response
    xmlns="http://data.webservice.workshop.vivid.nl">
4. <item> **This publication has not been issued by DAF Trucks N.V.** </item>
5. <item> **The contents of this publication are composed solely by**
    **HaynesPro without any endorsement of DAF Trucks N.V. as the manufacturer of DAF**
    **vehicles and distributor of original DAF replacement parts and DAF**
    **components** </item>
6. <item> **DAF consequently cannot be held responsible for any part of the**
    **information presented in this publication relative to DAF trucks, nor for the**
    **safety or reliability of the trucks and components that are maintained or**
    **repaired on the basis of the information presented in this publication** </item>
7. </getDisclaimerV2Response>
8. </soapenv:Body>
9. </soapenv:Envelope>

#### 8.3.8. getFuelTypeDisclaimers()

```
This operation returns the fuel type disclaimers linked to a vehicle.
This operation requires as parameters:
```
###  carType- int (this id can be obtained by calling “getIdentificationTree()” operation)

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

This is an example request:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:data="http://data.webservice.workshop.vivid.nl">
2. <soapenv:Header/>
3. <soapenv:Body>
4. <data:getFuelTypeDisclaimers>
5. <data:vrid>${vrid}</data:vrid>
6. <data:descriptionLanguage>en</data:descriptionLanguage>
7. <data:carType> **201000085** </data:carType>
8. </data:getFuelTypeDisclaimers>
9. </soapenv:Body>
10. </soapenv:Envelope>


159

Response:

11. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
12. <soapenv:Body>
13. <getFuelTypeDisclaimersResponse xmlns="http://data.webservice.workshop.vivid.nl">
14. <getFuelTypeDisclaimersReturn>
15. <name> **Caution! Read this before carrying out any work on the vehicle, Electricity** </name>
16. <status>
17. <confirmationLink xsi:nil="true"/>
18. <statusCode>0</statusCode>
19. </status>
20. <storyLines>
21. <item>
22. <id xsi:nil="true"/>
23. <mimeData xsi:nil="true"/>
24. <name>Safety precautions</name>
25. <order>0</order>
26. <paragraphContent xsi:nil="true"/>
27. <remark xsi:nil="true"/>
28. <sentenceGroupType xsi:nil="true"/>
29. <sentenceStyle xsi:nil="true"/>
30. <smartLinks xsi:nil="true"/>
31. <specialTool xsi:nil="true"/>
32. <status xsi:nil="true"/>
33. <subStoryLines>
34. <item>
35. <id xsi:nil="true"/>
36. <mimeData xsi:nil="true"/>
37. <name xsi:nil="true"/>
38. <order>0</order>
39. <paragraphContent>
40. <item>
41. <id>102001000</id>
42. <name>Work on high-voltage systems should only be carried out by trained technicians</name>
43. <order>0</order>
44. <sentenceStyle>SENTENCE_STYLE</sentenceStyle>
45. </item>
46. .......
47. </item>


160

48. </subStoryLines>
49. <tableContent xsi:nil="true"/>
50. </item>
51. </storyLines>
52. </getFuelTypeDisclaimersReturn>
53. </getFuelTypeDisclaimersResponse>
54. </soapenv:Body>
55. </soapenv:Envelope>

In touch the fuel type warning is displayed like this:

8.3.8- Fuel type disclaimer


161

## 9. MANAGEMENT

### 9.1. Structure – main elements (systems, schema and components)

This subject covers more elements from the ExtCarType.getSubjectsByGroup map. It contains:

MANAGEMENT, AUTOMATIC_TRANSMISSION and ABS_ELECTRONICAL.

This is a screenshot from Workshop ATI Online of Car Home, where you can find the links to

management information:

10.1.1 – Car Home – Engine Management, ABS Electronic and Automatic Transmission

The descriptions that are displayed on this page are generic names (it means that if a car has


162

ABS Electronic, then, no matter what the ABS Electronic system is or if there are more systems for ABS

Electronic, this name - “ABS Electronic” - will be displayed on this page).

If there are more Management Systems for one of these subjects, a page where the user can

select the system is shown:

Figure 10.1.2 – Management System selection

If there is only one Management System, the page with the content of that system is directly

shown:


163

Figure 10.1.3 – Management System – content (schema and components)

The first element in the web-service that describes the structure is ExtManagementSystem:

ExtManagementSystem {
Integer order;
Integer type;
String description;
String screenSchemaMimeDataName;
String printSchemaMimeDataName;
Integer managementSystemId;
}

###  order : this number gives the order in which the elements should be shown. When receiving

```
the request, elements should be already ordered. It is used mainly to give a clue in case the
client does not preserve the order in which the elements are received.
```
###  type : this number defines the type of the management system. It can be:

### ◦ 1 – Engine System


164

### ◦ 2 – Air Conditioning System

### ◦ 3 – Automatic Transmission System

### ◦ 4 – ABS System

###  description : this is the description of the system. If there is only one system, the description is

```
not important. If there are two or more systems, the user selects the appropriate one based on
this description. Usually, the element that differentiate between systems is the year (for
example: before or after 1999).
```
###  screenSchemaMimeDataName : this is an URL to an image. This image represents an electronic

schema.

###  printSchemaMimeDataName : this is an URL to an image. It contains the same elements as the

```
screenSchemaMimeDataName, but it is optimized for printing (different size, different colors,
so it fits well on the page and distinguish well the lines and the contrasts).
```
###  managementSystemId : this is an id that can be used to link the management system (this

structure) to other management elements related to this system.

To get these elements, you need to call “getManagementSystems()”. The next step is to call

“getSchemaLocations()”, where ExtMaintenanceSystemId is one of the parameters (together with the

language and the CarType id).

The next structure is ExtSchemaLocation:

ExtSchemaLocation {
Integer managementComponentId;
Integer x;
Integer y;
Integer width;
Integer height;
String pinsToGroundForScope1;
String pinsToGroundForScope2;
String betweenPinsForScope1;
}

###  managementComponentId : this is an id that identifies the component. It is used with another

operation to get all the information about the component (“getManagementComponents()”)

###  x : this is the location on the x-axis, on the management system's location picture

(ExtManagementSystem.screenSchemaMimeDataName)

###  y : this is the location on the y-axis, on the management system's location picture

(ExtManagementSystem.screenSchemaMimeDataName)


165

###  width : this is the width of the area on the schema where the specified component is located.

###  height : this is the height of the area on the schema where the specified component is located.

###  pinsToGroundForScope1 : this is a text that, if it is not null, contains some numbers separated

```
by comas. The numbers represent pins from the schema (for example: “3, 5, 20, 51”). When
you get the component information, you can also get a picture. The pins notation is different
for different schemes, so it is attached to the schema, while the picture is attached to the
component number (because the picture is always the same for that component). If this
property is not null, it is not mandatory that the picture is not null. See also
ExtComponent.scope1MimeDataName
```
Figure 10.1.4 – pinsToGroundForScope1

###  betweenPinsForScope1 : this is a text that, if not null, contains some pairs of numbers

```
separated by comas. The numbers represent pins from the schema (for example: “(5, 20)”).
This property is not null only if pinsToGroundForScope1 is null (so, for “scope1” is either
ground or between pins; but both of them can be null).
```
###  Figure 10.1.5 – betweenPinsForScope1 (Audi 80 1.9 TDi (1Z) 1991 - 1995 | EDC 15V 10/1994

**- > 10/1995 )pinsToGroundForScope2** : this is the same as pinsTOGroundForScope1, but it is in


166

```
relation with ExtComponent.scope2MimeDataName. This property is not null only if one of the
properties for scope1 is not null (pinsToGroundForScope1 or betweenPinsForScope1).
```
```
Figure 10.1.6 – pinsToGroundForScope2 (Opel Omega B 2.0 TD 16V (X 20 DTH) 1998 -
2000 | Bosch EDC 15 M 7.1)
```
The point (0,0) is in the bottom-left of the graphic. The (x, y) coordinates represent the center

of the element. Width and height are in pixel, and they describe a rectangle to highlight the

component in the schema.

Figure 10.1.7 – Management – Schema Location – coordinates (bottom left origin)

To find the coordinates of the location using an upper-left corner origin and to have the upper

left corner of the rectangle, you can use these formulas:

ul_width = width;


167

ul_height = height;
ul_x = x – (ul_width / 2);
ul_y = Image_height – (y + (ul_height / 2));
(ul_* comes from upper-left origin)

Figure 10.1.8 – Management – Schema Location – coordinates (upper left origin)

If you want the rectangle to be bigger, you can increment the width and height like this:

ul_width = width + 19;
ul_height = height + 19;
ul_x = x – (ul_width / 2);
ul_y = Image_height – (y + (ul_height / 2));

Next, using the managementComponentId as parameter, the operation

“getManagementComponents()” should be called.

ExtComponent {
Integer componentId;
Integer groupId;
String description;
String specifications;
String diagnostics;
String function;
String pictureMimeDataName;
String scope1MimeDataName;
String scope2MimeDataName;
boolean infoAvailable;
String extraInfoPath;
boolean extraInfoAvailable;
}


168

###  componentId : this is a unique identifier for the Component.

###  groupId : this is an identifier for the group. It is displayed before the description of the

component. It also appears in the schema (for example: _1_ is always an injector)

Figure 10.1.9 – groupId

###  description : this property is language dependent. It describes the “groupId” property (for

example: “Injector”).

###  specifications : this property is also language dependent. It gives specifications for the

```
component (for example: “ supply voltage: 12 V<br>resistance: 13 - 17 ohms<br>waveform
information: engine running at idle ”); you can notice in the example that it contains html-tags
for formatting (“<br>”).
```
###  diagnostics : this property is language dependent, and it contains text about diagnostics (for

```
example: “ Check connector(s): Inspect the connector(s) and if necessary clean or fix them to
make sure the connection is good.<br>Check resistance:<br>Turn ignition off. Remove
connector(s) from injector(s). Measure resistance between the two pins of the injector.
Compare with specified resistance.[...]<br>Connect oscilloscope to one of the signal wire pin(s)
of the ECU and ground. Start or crank the engine and compare to the scope image shown. ”);
```
###  function : this property is language dependent, and it contains text about the function of the

```
component (for example: “ A fuel injector is an electrically operated solenoid valve that is
powered by the control unit. The fuel injector injects fuel into the inlet manifold. ”)
```

169

Figure 10.1.10 – Component description – groupId(1), description(2), function(3), pictureMimeDataName(4),
specifications(5)

###  pictureMimeDataName : this property is a text that, if not null, contains a URL to an image that

represents the component. It is usually displayed next to the “ **function** ” property text.

###  scope1MimeDataName : this property is a text that, if not null, contains an URL to an image.

```
This image is in relation to the ExtSchemaLocation that contains pinsToGroundForScope1 and
betweenPinsForScope1, so they are usually displayed together.
```
###  scope2MimeDataName : property is remarkably like scope1MimeDataName. It is in relation to

ExtSchemaLocation, but with scope2 (pinsToGroundForScope2).

###  infoAvailable : this property contains a boolean value and it is set to true only if one of these

```
properties contain information (are not null): specifications, diagnostics, function,
pictureMimeDataName, scope1MimeDataName, scope2MimeDataName.
```
###  extraInfoPath: this property is a text that, if not null, contains an URL to a HTML page that

```
shows extra information about the component. This page has general information about the
component, and it is the same for all the components in the group (you can notice the groupId
property in the link, for example : http://www.haynespro-
```

170

_services.com:8080/workshopServices2/ManagementExtraInfo?lang=&gr=1_ **)**

###  extraInfoAvailable : this property contains a boolean value and it is set to true only if there is

extra information for this component (or extraInfoPath is not null).

### Operations – for systems, schema, and components

#### 9.1.1. getManagementSystems()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2-character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3

for more information about this object)

**This operation returns an array of ExtManagementSystem** that represent all the management

system names for the specified Type. Before calling this operation, you can check ExtCarType.subjects

to see in it contains “MANAGEMENT”. If it does, the operation will return information. If not, it will

return null.

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carType – int – 26650 (you should find “golf iv akq” and make sure it is the same id; if it is not,

replace 26650 with the id that you find in the response)

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getManagementSystemsResponse xmlns="http://data.webservice.workshop.vivid.nl">
4. <getManagementSystemsReturn>
5. < **description** > **4AV 05/1999 ->** </description>
6. < **managementSystemId** > **1892** </managementSystemId>
7. <order>0</order>
8. < **printSchemaMimeDataName** > **[http://www.haynespro-](http://www.haynespro-)**
    **services.com:8080/workshop/images/4av02.wmf_dba_electude.gif** </printSchemaMimeDataName>
9. < **screenSchemaMimeDataName** > **[http://www.haynespro-](http://www.haynespro-)**
    **services.com:8080/workshop/images/4av02.tif_dba_electude.gif** </screenSchemaMimeDataName>
10. < **type** > **1** </type>


171

11. </getManagementSystemsReturn>
12. <getManagementSystemsReturn>
13. < **description** > **4AV -> 05/1999** </description>
14. < **managementSystemId** > **880** </managementSystemId>
15. <order>1</order>
16. < **printSchemaMimeDataName** > **[http://www.haynespro-](http://www.haynespro-)**
    **services.com:8080/workshop/images/4av01.wmf_dba_electude.gif** </printSchemaMimeDataName>
17. < **screenSchemaMimeDataName** > **[http://www.haynespro-](http://www.haynespro-)**
    **services.com:8080/workshop/images/4av01.tif_dba_electude.gif** </screenSchemaMimeDataName>
18. < **type** > **1** </type>
19. </getManagementSystemsReturn>
20. <getManagementSystemsReturn>
21. <description>A/T AG4</description>
22. <managementSystemId>930</managementSystemId>
23. <order>2</order>
24. <printSchemaMimeDataName>http://www.haynespro-
    services.com:8080/workshop/images/ag4_01.wmf_dba_electude.gif</printSchemaMimeDataName>
25. <screenSchemaMimeDataName>http://www.haynespro-
    services.com:8080/workshop/images/ag4_01.tif_dba_electude.gif</screenSchemaMimeDataName>
26. <type>3</type>
27. </getManagementSystemsReturn>
28. <getManagementSystemsReturn>
29. < **description** > **Teves Mark 20 IE 10/1997 ->** </description>
30. < **managementSystemId** > **1007** </managementSystemId>
31. <order>3</order>
32. < **printSchemaMimeDataName** >http://www.haynespro-
    services.com:8080/workshop/images/vwg4b02s.wmf_dba_electude.gif</printSchemaMimeDataName>
33. <screenSchemaMimeDataName>http://www.haynespro-
    services.com:8080/workshop/images/vwg4b02s.tif_dba_electude.gif</screenSchemaMimeDataName>
34. <type>4</type>
35. </getManagementSystemsReturn>
36. </getManagementSystemsResponse>
37. </soapenv:Body>
38. </soapenv:Envelope>


172

Figure 10.1.11 – Engine management systems

**1 -** < **description** > **4AV 05/1999 ->** </description>

Figure 10.1.12 – ABS Electronic

**2 -** < **description** > **Teves Mark 20 IE 10/1997 ->** </description> (line 29)


173

Figure 10.1.13 – Engine Management System schema

**1 -** < **description** > **4AV 05/1999 ->** </description> (line 5)
**3 -** < **screenSchemaMimeDataName** > **[http://www.haynespro-](http://www.haynespro-)
services.com:8080/workshop/images/4av02.tif_dba_electude.gif** </screenSchemaMimeDataName>
(line 9)

We will use the id of the first management system to call the next operation:
< **managementSystemId** > **1892** </managementSystemId> (line 6)

#### 9.1.2. getSchemaLocation()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3

for more information about this object)

###  managementId – int (this number is the “id” of the Management System found in

ExtManagementSystem.managementSystemId)


174

**This operation returns an array of ExtSchemaLocation** that represent the location of all the

component on the schema.

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carType – int – 26650 (you should find “golf iv akq” and make sure it is the same id; if it is not,

replace 26650 with the id that you find in the response)

###  managementId – int - 1892

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getSchemaLocationsResponse xmlns="http://data.webservice.workshop.vivid.nl">
4. <getSchemaLocationsReturn>
5. < **height** >65</height>
6. < **managementComponentId** >170</managementComponentId>
7. < **pinsBetweenPinsForScope1** xsi:nil="true" />
8. < **pinsToGroundForScope1** >58, 65, 73, 80</pinsToGroundForScope1>
9. < **pinsToGroundForScope2** xsi:nil="true" />
10. < **width** >95</width>
11. < **x** >227</x>
12. < **y** >207</y>
13. </getSchemaLocationsReturn>
14. <getSchemaLocationsReturn>
15. <height>65</height>
16. <managementComponentId>315</managementComponentId>
17. <pinsBetweenPinsForScope1 xsi:nil="true" />
18. <pinsToGroundForScope1>15</pinsToGroundForScope1>
19. <pinsToGroundForScope2 xsi:nil="true" />
20. <width>43</width>
21. <x>106</x>
22. <y>207</y>
23. </getSchemaLocationsReturn>
24. <getSchemaLocationsReturn>
25. <height>70</height>
26. <managementComponentId>465</managementComponentId>
27. <pinsBetweenPinsForScope1 xsi:nil="true" />
28. <pinsToGroundForScope1 xsi:nil="true" />
29. <pinsToGroundForScope2 xsi:nil="true" />
30. <width>25</width>
31. <x>35</x>


175

32. <y>75</y>
33. </getSchemaLocationsReturn>
34. ...
35. <getSchemaLocationsReturn>
36. <height>15</height>
37. <managementComponentId>3823</managementComponentId>
38. <pinsBetweenPinsForScope1 xsi:nil="true" />
39. <pinsToGroundForScope1 xsi:nil="true" />
40. <pinsToGroundForScope2 xsi:nil="true" />
41. <width>25</width>
42. <x>325</x>
43. <y>252</y>
44. </getSchemaLocationsReturn>
45. </getSchemaLocationsResponse>
46. </soapenv:Body>
47. </soapenv:Envelope>

Figure 10.2.2.1 – Management – Schema Location

**1 -** < **x** >227</x> (line 11)

**2 -** < **y** >207</y> (line 12)


176

**3 -** < **width** >95</width> (line 10)

**4 -** < **height** >65</height> (line 5)

Figure 10.2.2.2 – Management – Schema location

5 - < **pinsToGroundForScope1** >58, 65, 73, 80</pinsToGroundForScope1>

Next, we will use managementComponentId elements to get information about each

component:

< **managementComponentId** >170</managementComponentId>

<managementComponentId>315</managementComponentId>

#### 9.1.3. getSchemaLocations2()

This operation requires exactly the same as getSchemaLocations, but it returns a few extra


177

information (that can be found also in getManagementSystems), so it does not bring anything new,

but it puts the information together (which could be more convenient for the implementation of the

client application). The returned structure is:

ExtSchemaLocation2Container {

String screenSchemaMimeDataName;

String printSchemaMimeDataName;

ExtSchemaLocation[] schemaLocations;

}

###  screenSchemaLocationMimeDataName is the same one from getManagementSystems

###  printSchemaMimeDataName is the same one from getManagementSystems

###  schemaLocations is the same result that getSchemaLocations return

#### 9.1.4. getManagementComponents()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  ids – int[] (this is an array of ids of the Management components found in

ExtSchemaLocation.managementComponentId)

**This operation returns an array of ExtManagementComponents** that represent the location

of all the component on the schema.

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  ids – int[] – {170, 315}

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getManagementComponentsResponse xmlns="http://data.webservice.workshop.vivid.nl">


178

4. <getManagementComponentsReturn>
5. < **componentId** > **170** </componentId>
6. < **description** > **injector** </description>
7. < **diagnostics** > **Check connector(s): Inspect the connector(s) and if necessary clean or fix them to make sure the**
    **connection is good.<br>Check resistance:<br>Turn ignition off. Remove connector(s) from injector(s). Measure**
    **resistance between the two pins of the injector. Compare with specified resistance.<br>Check supply**
    **voltage:<br>Turn ignition off. Remove connector(s) from injector(s). Crank the engine and measure voltage between**
    **one connector terminal and the negative terminal of the battery. Check the second terminal, one of the two should**
    **equal battery voltage. If not check wiring and, if present, fuse(s) and relay or power supply control unit.<br>Check**
    **connection to ECU:<br>Turn ignition off. Remove connector(s) from injector(s) and ECU. Measure resistance between**
    **one of the two connector terminals and the corresponding terminal in the ECU connector. Check the other terminal.**
    **One of the two should be < 1 ohm. If not check wiring.<br>Check injector activation:<br>Connect oscilloscope to one**
    **of the signal wire pin(s) of the ECU and ground. Start or crank the engine and compare to the scope image**
    **shown.** </diagnostics>
8. < **extraInfoAvailable** > **true** </extraInfoAvailable>
9. < **extraInfoPath** > **[http://www.haynespro-](http://www.haynespro-)**
    **services.com:8080/workshopServices3/ManagementExtraInfo?lang=&gr=1** </extraInfoPath>
10. < **function** > **A fuel injector is an electrically operated solenoid valve that is powered by the control unit. The fuel**
    **injector injects fuel into the inlet manifold.** </function>
11. < **groupId** > **1** </groupId>
12. < **infoAvailable** > **true** </infoAvailable>
13. < **pictureMimeDataName** > **[http://www.haynespro-](http://www.haynespro-)**
    **services.com:8080/workshop/images/1vw_mp.f_dba_electude.gif** </pictureMimeDataName>
14. < **scope1MimeDataName** > **[http://www.haynespro-](http://www.haynespro-)**
    **services.com:8080/workshop/images/1mo1_3.sc_dba_electude.gif** </scope1MimeDataName>
15. <scope2MimeDataName xsi:nil="true" />
16. < **specifications** > **supply voltage: 12 V<br>resistance: 13 - 17 ohms<br>waveform information: engine running at**
    **idle** </specifications>
17. </getManagementComponentsReturn>
18. <getManagementComponentsReturn>
19. <componentId> **315** </componentId>
20. <description>canister purge solenoid</description>
21. <diagnostics>Check connector(s): Inspect the connector(s) and if necessary clean or fix them to make sure the
    connection is good.<br>Check resistance:<br>Turn ignition off. Remove connector from solenoid.<br>Measure
    resistance between the two pins of the solenoid. Compare with specified resistance. Alternatively, check solenoid
    function by applying battery voltage to its pins. The solenoid should "click".<br>Check supply voltage:<br>Turn ignition
    off. Remove connector from solenoid.<br>Start the engine and measure voltage between one connector terminal and
    the negative terminal of the battery. Check the second terminal. One of the two should equal battery voltage. If not
    check wiring and, if present, fuse(s) and relay or power supply control unit.<br>Check connection to ECU:<br>Turn
    ignition off. Remove connector from solenoid and ECU.<br>Measure resistance between one of the two connector
    terminals and the corresponding terminal in the ECU connector. Check the other terminal. One of the two should be <
    1 ohm. If not check wiring.<br>Check solenoid activation:<br>Connect oscilloscope to signal pin of the ECU and ground.
    Start the engine and compare to the scope image shown.</diagnostics>
22. < **extraInfoAvailable** > **true** </extraInfoAvailable>
23. <extraInfoPath>http://www.haynespro-
    services.com:8080/workshopServices2/ManagementExtraInfo?lang=&gr=2</extraInfoPath>


179

24. <function>The evaporative canister is equipped with a purge solenoid valve. The control unit switches the
    solenoid on or off. This controls the amount of vapour purged into the inlet manifold.</function>
25. <groupId>2</groupId>
26. <infoAvailable>true</infoAvailable>
27. <pictureMimeDataName>http://www.haynespro-
    services.com:8080/workshop/images/2vw.f_dba_electude.gif</pictureMimeDataName>
28. <scope1MimeDataName>http://www.haynespro-
    services.com:8080/workshop/images/2a.sc_dba_electude.gif</scope1MimeDataName>
29. <scope2MimeDataName xsi:nil="true" />
30. <specifications>supply voltage: 12 V<br>resistance: 15 - 40 ohms<br>waveform information: engine running at
    idle<br></specifications>
31. </getManagementComponentsReturn>
32. </getManagementComponentsResponse>
33. </soapenv:Body>
34. </soapenv:Envelope>

Figure 10.2.3.1 – Engine Management – Component description

1 - < **groupId** > **1** </groupId> (line 11)
2 - < **description** > **injector** </description> (line 6)


180

Figure 10.2.3.2 – Engine Management – Component details

1 - < **groupId** > **1** </groupId> (line 11)
2 - < **description** > **injector** </description> (line 6)
3 - < **function** > **A fuel injector is an electrically operated solenoid valve that is powered by the control unit. The
fuel injector injects fuel into the inlet manifold.** </function>
(line 10)
4 - < **pictureMimeDataName** >http://www.haynespro-
services.com:8080/workshop/images/1vw_mp.f_dba_electude.gif</pictureMimeDataName>
(line 13)
5 - < **specifications** > **supply voltage: 12 V<br>resistance: 13 - 17 ohms<br>waveform information: engine running
at idle** </specifications>
(line 16)

8 - < **extraInfoPath** >http://www.haynespro-
services.com:8080/workshopServices3/ManagementExtraInfo?lang=&gr=1</extraInfoPath>
(line 9)
8 - < **extraInfoAvailable** > **true** </extraInfoAvailable>
(line 22)

If you click on the link from number “8” - “Extra Information” (if there is any, so you should

display it if the property “extraInfoAvailable” is true), it displays the HTML page provided by the URL in


181

“extraInfoPath” property. This page shows general descriptions about the group, for example if group-

id is 1, it displays general information about injectors. If you need to restyle the HTML to your needs,

you can use the following operation (getManagementComponentExtraInfo; see next sub-chapter)

which returns the same data.

Figure 10.2.3.2 – Engine Management – Component details 2 (scrolled down)

**6 -** < **scope1MimeDataName** >http://www.haynespro-
services.com:8080/workshop/images/1mo1_3.sc_dba_electude.gif</scope1MimeDataName>
(line 14)
**7 -** < **diagnostics** > **Check connector(s): Inspect the connector(s) and if necessary clean or fix them to make sure
the connection is good.<br>Check resistance:<br>Turn ignition off. Remove connector(s) from injector(s). Measure
resistance between the two pins of the injector. Compare with specified resistance.<br>Check supply voltage:<br>Turn
ignition off. Remove connector(s) from injector(s). Crank the engine and measure voltage between one connector
terminal and the negative terminal of the battery. Check the second terminal, one of the two should equal battery
voltage. If not check wiring and, if present, fuse(s) and relay or power supply control unit.<br>Check connection to
ECU:<br>Turn ignition off. Remove connector(s) from injector(s) and ECU. Measure resistance between one of the two
connector terminals and the corresponding terminal in the ECU connector. Check the other terminal. One of the two
should be < 1 ohm. If not check wiring.<br>Check injector activation:<br>Connect oscilloscope to one of the signal wire
pin(s) of the ECU and ground. Start or crank the engine and compare to the scope image shown.** </diagnostics>
(line 7)


182

#### 9.1.5. getManagementComponentExtraInfo

This operation returns the data that is contained in the HTML that is provided by the URL from

the extraInfoPath property. It is useful if you need to display the same information with a different

style.

The operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  groupId – String (this is the number that identifies the group from

getManagementComponents)

The operation returns an object that has the following structure:

ExtExtraInfoPage {

String pageTitle;

String compNr;

ExtExtraInfoContainer[] containers;

}

###  pageTitle : is a text that is language dependent which contains the title of the page (for

example: “Petrol injector”)

###  compNr : is a text that is also language dependent, and it contains the group number (for

example: “Component number 1”)

###  containers : is an array of objects that contain sections of the page. The structure of each such

object is described next.

ExtExtraInfoContainer {

String header;

ExtExtraInfoContentElement[] elements;

}

###  header : is a text that is language dependent. Each page is divided into sections and each

```
section has a title (which is this header). For example: “Identification”, “Function”,
“Specifications”...
```

183

###  elements : is an array of ExtExtraInfoContentElement objects. Each section, apart from the

```
header, also has some elements (which could be paragraphs, images, lists and so on). These
elements are described next.
```
ExtExtraInfoContentElement {

ExtExtraInfoImage image;

ExtExtraInfoText[] text;

}

###  image : is a complex object that contains information about the URL (or URLs if there are more)

```
and comments related to the picture. The structure of this object will be described next in this
chapter;
```
###  text : this is an array of complex objects that contain information about different elements that

```
contain text (like paragraphs and lists). The structure of this object is described next in this
chapter.
```
ExtExtraInfoImage {

String[] imageURLs;

String referenceText;

ExtExtraInfoText[] descriptions;

}

###  imageURLs : is an array of text elements which contain the URLs of the images (one or more; if

more, all have to be displayed)

###  referenceText : is a text which is language dependent, and it describes the picture shortly; can

be null

###  descriptions : is an array of complex objects that contain text related to the image(s). The same

```
structure (ExtExtraInfoText) is used inside ExtExtraInfoContentElement. The structure is
described next
```
ExtExtraInfoText {

String type;

ExtExtraInfoTextPart[] textParts;

}

###  type : is a text that describes the type of text that the “ExtExtraInfoText” contains. It can be one

of the following values:


184

### ◦ SUB_HEADER: the content of textParts is a sub-header

### ◦ SUB_SUB_HEADER: the content of the textParts is a sub-sub-header

### ◦ PARAGRAPH: the content of the textParts is a paragraph

### ◦ LIST_ITEM: the content of the textParts is an element that is part of a list

###  textParts : is an array of complex objects that contains text and information about formatting.

The structure of this object is described next;

ExtExtraInfoTextPart {

String style;

String text;

}

###  style : is a String that describes the way the text in the following property should be displayed.

It can be one of the following values:

### ◦ NONE: plain text

### ◦ BLUE

### ◦ RED

### ◦ GREEN

### ◦ BOLD

### ◦ ITALIC

###  text : is a String that is language dependent, and it should be displayed with the specific style

### 9.2. Structure – Physical Location

Physical locations are related to management systems. They contain a picture (a URL to a

picture, in fact) and a set of marks on that picture. The schema locations only show the location on a

logical representation of the system while the physical locations show where the components are

located on the car.

It is described by this object:


185

ExtPhysicalLocationGroup {
String pictureMimeDataName;
ExtPhysicalLocationItem[] items;
}

###  pictureMimeDataName : this property is a String that contains a URL to a picture. That picture

is the used to represent the physical location.

###  items : this property is an array of complex objects that show the locations of the components.

The structure of the object is described next.

ExtPhysicalLocationItem {
Integer managementComponentId;
Integer x;
Integer y;
String location;
int arrow;
}

###  managementComponentId : this is the id of the component whose location on the car is

```
described by this object. Use this id with the operation described in chapter 10.2.3 –
getManagementComponents()
```
###  x : this is the location on the x-axis, on the ExtPhysicalLocationGroup.pictureMimeDataName

```
picture; the origin is on the bottom left corner. This value is -1 when the location cannot be
shown.
```
###  y : this is the location on the y-axis, on the ExtPhysicalLocationGroup.pictureMimeDataName

```
picture; the origin is on the bottom left corner. This value is -1 when the location cannot be
shown.
```
###  location : this text is language dependent. If it is not null, it contains a text that describes the

```
location of the component (it is usually null; you will be not null mostly when the location of
the component is not directly visible on the picture)
```
###  arrow: this property is an integer that shows how the arrow that points to the location should

be directed:

### ◦ - 1 – not shown

### ◦ 0 – arrow pointing up

### ◦ 1 – arrow pointing down

### ◦ 2 – arrow pointing left

### ◦ 3 – arrow pointing right


186

Figure 10.3.1 – Physical Location – tab(1), picture, component(2) and location(3)

#### 9.2.1. getPhysicalLocations()....................................................................................................................................

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3

for more information about this object)

###  managementId – int (this number is the “id” of the Management System found in

ExtManagementSystem.managementSystemId)

**This operation returns an ExtPhysicalLocationGroup object** that represent the location of the

components on the schema.


187

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carType – int – 26650 (you should find “golf iv akq” and make sure it is the same id; if it is not,

replace 26650 with the id that you find in the response)

###  managementId – int - 1892

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getPhysicalLocationsResponse xmlns="http://data.webservice.workshop.vivid.nl">
4. <getPhysicalLocationsReturn>
5. < **items** >
6. <item>
7. < **arrow** > **1** </arrow>
8. <location />
9. < **managementComponentId** > **170** </managementComponentId>
10. < **x** > **244** </x>
11. < **y** > **183** </y>
12. </item>
13. ...
14. <item>
15. < **arrow** > **- 1** </arrow>
16. < **location** > **in tank** </location>
17. < **managementComponentId** > **465** </managementComponentId>
18. < **x** > **- 1** </x>
19. < **y** > **- 1** </y>
20. </item>
21.
22. ...
23. </items>
24. <pictureMimeDataName>http://www.haynespro-
    services.com:8080/workshop/images/vwahw01.f_dba_electude.gif</pictureMimeDataName>
25. </getPhysicalLocationsReturn>
26. </getPhysicalLocationsResponse>
27. </soapenv:Body>
28. </soapenv:Envelope>


188

Figure 10.3.1.1 – Physical Location

1 - < **x** > **244** </x> (line 10)
2 - < **y** > **183** </y> (line 11)
3 - < **arrow** > **1** </arrow> (1 = arrow pointing down – line 7)


189

Figure 10.3.1.2 – Physical location (not visible)

< **arrow** > **- 1** </arrow> (line 15 - “-1” not shown)
< **location** > **in tank** </location> (line 16)
< **x** > **- 1** </x> (line 18 - “-1” location not visible)
< **y** > **- 1** </y> (line 19 - “-1” location not visible)

### 9.3. Error Codes

Error codes are related directly to a Management System, but not all Management Systems

have error codes.

The structure that holds the error codes information is:

ExtManagementFaultCode {
String mimeDataName;
String plug;
String readout;
String reset;
String signal;


190

String codes;
}

###  mimeDataName : this property is a string that, if not null, contains a URL to a picture

###  plug : this property is language dependent. It can be null

###  readout : this property is language dependent. It contains information about how to read the error codes. It can

```
be null.
```
###  reset: this property is language dependent. It contains information about how to reset the error code. It can be

```
null.
```
###  signal : this property is language dependent. It contains information about the structure of the signal which sends

```
the error code. This property is rarely null.
```
###  codes : this property is language dependent. It contains the possible error codes and the explanation for each of

```
them. This property should never be null.
```
Figure 10.4.1 – Car Home – Diagnostics – Error codes

#### 9.3.1. getManagementFaultCode()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)


191

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3

for more information about this object)

###  managementId – int (this number is the “id” of the Management System found in

ExtManagementSystem.managementSystemId)

**This operation returns an ExtManagementFaultCode object** that represents the information

about fault codes for the specified car type and management system.

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carType – int – 14650 (you should find “passat iii 2e” and make sure it is the same id; if it is not,

replace 14650 with the id that you find in the response)

###  managementId – int - 101

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getManagementFaultCodeResponse xmlns="http://data.webservice.workshop.vivid.nl">
4. <getManagementFaultCodeReturn>
5. < **codes** >1111 Faulty ECU.<br>1231 Speed sensor.<br>1232 Idle speed motor.<br>2111 rpm sensor.<br>2112
    Camshaft sensor.<br>2113 Hall sensor.<br>2114 Distributor timing fault.<br>2121 Idle switch.<br>2122 No rpm
    signal.<br>2123 Throttle wide open switch.<br>2124 Throttle position sensor.<br>2132 Datalink injection/ignition or
    faulty ECU.<br>2141 Knock sensor 1 timing out of range.<br>2142 Knock sensor 1 no signal.<br>2143 Knock sensor 2
    timing out of range.<br>2144 Knock sensor 2 no signal.<br>2212 Throttle position sensor.<br>2214 Exceeding
    maximum engine rpm. <br>2221 Incorrect vacuum signal.<br>2222 MAP sensor in computer. <br>2223 Barometric
    sensor.<br>2224 Overboost.<br>2231 Idle speed control.<br>2232 Mass air-flow meter.<br>2233 Reference voltage,
    mass air-flow meter.<br>2234 Supply voltage.<br>2242 CO potentiometer.<br>2312 Coolant temperature
    sensor.<br>2314 Link transmission.<br>2322 Air temperature sensor.<br>2323 Air-flow meter.<br>2324 Mass air-flow
    meter.<br>2341 A/F ratio out of range.<br>2342 Oxygen sensor.<br>2343 Rich exhaust gas.<br>2344 Lean exhaust
    gas.<br>2411 EGR.<br>2412 Air temperature sensor.<br>2413 Lean exhaust gas.<br>4332 Intermittent connection with
    actuators.<br>4343 Canister purge solenoid.<br>4411-4 Injectors 1-4.<br>4421-2 Injectors 5-6.<br>4431-2 Idle speed
    motor.<br>4442 Waste gate solenoid.<br>4443 Canister purge solenoid.<br>4444 No faults</codes>
6. < **mimeDataName** >http://www.haynespro-
    services.com:8080/workshop/images/vw2.st_dba_electude.gif</mimeDataName>
7. < **plug** >1 = Datalink LED tester</plug>
8. < **readout** >-Turn ignition on.<br>- Do a 6 minute test-drive. At least 10 seconds above 2,000 rpm. Once full
    throttle.<br>- Let engine run at idle speed.<br>- If it is impossible to run engine then crank for at least 6 seconds by
    hand.<br>- Don't switch off ignition.<br>- Connect datalink to ground for 5 seconds.<br>- Flash code will appear on LED
    tester or on 'check engine' light in dashboard.<br></readout>
9. < **reset** >- Switch off ignition.<br>- Connect datalink to ground.<br>- Switch on ignition.<br>- Disconnect
    datalink.<br></reset>
10. < **signal** >-Start code: one light pulse for 0.5 seconds.<br>- Digit 1: Light pulse 0.5 second long, 0.5 second pause in-


192

```
between.<br>- Pause 2.5 seconds light-off.<br>- Digit 2: Light pulse 0.5 second long, 0.5 second pause in-
between.<br>- Pause 2.5 seconds light-off.<br>- Digit 3: Light pulse 0.5 second long, 0.5 second pause in-
between.<br>- Pause 2.5 seconds light-off.<br>- Digit 4: Light pulse 0.5 second long, 0.5 second pause in-
between.<br>- Pause 2.5 seconds light-on.<br>- The 4-digit fault code will be repeated until datalink is grounded for 5
seconds. After grounding, next fault code will appear.<br>- After last code the light pulses 2.5 seconds on and 2.5
seconds off.</signal>
```
11. </getManagementFaultCodeReturn>
12. </getManagementFaultCodeResponse>
13. </soapenv:Body>
14. </soapenv:Envelope>

This is a screenshot from Workshop ATI Online:

Figure 10.4.1.1 – Diagnostics – Error codes: picture(1), plug(2) and readout(3)

1 - < **mimeDataName** >http://www.haynespro-
services.com:8080/workshop/images/vw2.st_dba_electude.gif</mimeDataName>
(line 6)
2 - < **plug** >1 = Datalink LED tester</plug>
(line 7)
3 - < **readout** >-Turn ignition on.<br>- Do a 6 minute test-drive. At least 10 seconds above 2,000 rpm. Once full


193

throttle.<br>...</readout>
(line 8)

The next picture is from Workshop ATI Online too, and it shows the rest of the error codes

elements:

Figure 10.4.1.2 – Diagnostics – Error codes – reset(4), signal(5) and codes(6)

4 - < **reset** >- Switch off ignition.<br>- Connect datalink to ground.<br>- Switch on ignition.<br>- Disconnect
datalink.<br></reset>
(line 9)
5 - < **signal** >-Start code: one light pulse for 0.5 seconds.<br>- Digit 1: Light pulse 0.5 second long, 0.5 second pause
in-between.<br>- Pause 2.5 seconds light-off.<br>...</signal> (line 10)
6 - < **codes** >1111 Faulty ECU.<br>1231 Speed sensor.<br>1232 Idle speed motor.<br>2111 rpm sensor.<br>2112
Camshaft sensor.<br>2113 Hall sensor.<br>...</codes> (line 5)


194

### 9.4. Diagnostics

Diagnostics are related to Management Systems. The user enters a code, and this gives the

explanation for the code.

The structure is:

ExtDiagnosis {
String sentence;
ExtComponent[] components;
}

###  sentence : this property is language dependent. It contains the explanation for the code that

has been entered.

###  components : this property is an array that can contain components that are related to the

specified code.

#### 9.4.1. getDiagnosis()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3

for more information about this object)

###  managementId – int (this number is the “id” of the Management System found in

ExtManagementSystem.managementSystemId)

###  pCode – String (this is the code that the user is looking for; it is called “p”-Code, because, in

the beginning, all the codes started with a “P”; for example, “P0300”)

**This operation returns an ExtDiagnosis object** that represent the location of the components

on the schema.

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carType – int – 26650 (you should find “golf iv akq” and make sure it is the same id; if it is not,

replace 26650 with the id that you find in the response)

###  managementId – int - 1892


195

###  pCode – String - “P0300”

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getDiagnosisResponse xmlns="http://data.webservice.workshop.vivid.nl">
4. <getDiagnosisReturn>
5. < **components** >
6. <item>
7. <componentId>170</componentId>
8. < **description** > **injector** </description>
9. <diagnostics>Check connector(s): Inspect the connector(s) and if necessary clean or fix them to
    make sure the connection is good.<br> ...</diagnostics>
10. <extraInfoAvailable>true</extraInfoAvailable>
11. <extraInfoPath>http://www.haynespro-
    services.com:8080/workshop/static_html//extra_info/elc1.html</extraInfoPath>
12. <function>A fuel injector is an electrically operated solenoid valve that is powered by the
    control unit. The fuel injector injects fuel into the inlet manifold.</function>
13. < **groupId** > **1** </groupId>
14. <infoAvailable>true</infoAvailable>
15. <pictureMimeDataName>http://www.haynespro-
    services.com:8080/workshop/images/1vw_mp.f_dba_electude.gif</pictureMimeDataName>
16. <scope1MimeDataName>http://www.haynespro-
    services.com:8080/workshop/images/1mo1_3.sc_dba_electude.gif</scope1MimeDataName>
17. <scope2MimeDataName xsi:nil="true" />
18. <specifications>supply voltage: 12 V<br>resistance: 13 - 17 ohms<br>waveform information:
    engine running at idle</specifications>
19. </item>
20. ...
21. </components>
22. < **sentence** > **Random/Multiple Cylinder Misfire Detected** </sentence>
23. </getDiagnosisReturn>
24. </getDiagnosisResponse>
25. </soapenv:Body>
26. </soapenv:Envelope>

This is a screenshot from Workshop ATI Online:


196

10.5.1.1 – Diagnostics – sentence(1), components (group(2) and description(3))

1 - < **sentence** > **Random/Multiple Cylinder Misfire Detected** </sentence> (line 22)
2 - < **groupId** > **1** </groupId> (line 13)
3 - < **description** > **injector** </description> (line 8)

#### 9.4.2. getDiagnosisAvailableCodes()

This operation finds all the available pCodes that contain a fragment that is entered by the user

(that can be entered as parameter of the previous operation: “getDiagnosis()”). Normally, it is not

necessary to call this operation, because the user should read the exact code from the diagnosis tool

that is connected to the car, and then enter it here to find the meaning of the code.

This operation requires the following parameters when calling:

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3

for more information about this object)


197

###  codePart – String (this is the fragment of the code that is searched)

**This operation returns an array of String objects** that represent the pCodes that are available for that

car and contain the entered codePart.

As you can see, this operation does not require the Management System id, while

getDiagnosis() operation requires it. The “components” from ExtDiagnosis object makes the result

different for the same car and a different Management System (in another system, other components

could be the cause, or some specifications of the components could be different).

We will call this operation with the following parameters:

###  carType – int – 26650 (you should find “golf iv akq” and make sure it is the same id; if it is

**not, replace 26650 with the id that you find in the response)**

###  codePart – String - “300”

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getDiagnosisAvailableCodesResponse xmlns="http://data.webservice.workshop.vivid.nl">
4. <getDiagnosisAvailableCodesReturn> **P1300** </getDiagnosisAvailableCodesReturn>
5. < **getDiagnosisAvailableCodesReturn** > **P0300** </getDiagnosisAvailableCodesReturn>
6. <getDiagnosisAvailableCodesReturn> **P2300** </getDiagnosisAvailableCodesReturn>
7. < **getDiagnosisAvailableCodesReturn** > **U0300** </getDiagnosisAvailableCodesReturn>
8. </getDiagnosisAvailableCodesResponse>
9. </soapenv:Body>
10. </soapenv:Envelope>


198

Figure 10.5.2.1 – Diagnostics – pCode suggestions

1 - < **getDiagnosisAvailableCodesReturn** > **P0300** </getDiagnosisAvailableCodesReturn> (line5)

2 - < **getDiagnosisAvailableCodesReturn** > **U0300** </getDiagnosisAvailableCodesReturn> (line7)

### 9.5. EOBD Locations

An EOBD location is the location where the diagnosis tool is connected to the car.

The structure is:

ExtEobdLocation {
Integer order;
String location;
String mimeDataName;
}

###  order : this number gives the order in which the elements should be shown. When receiving

the request, elements should be already ordered. It is used mainly to give a clue in case the


199

client does not preserve the order in which the elements are received.

###  location : this property is language dependent. It contains a description about the location or

```
about the location picture (for example: “LHD is shown” - LHD stands for Left Hand Drive – so
this is a remark about the picture).
```
###  mimeDataName : this property is a string that contains a URL to a picture that shows the

location of the connector.

#### 9.5.1. getEobdLocations()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carTypeId – int (this number is the “id” of the Type found in ExtCarType; you can check chapter

3 for more information about this object)

**This operation returns an ExtEobdLocation object** that represent the location of the

components on the schema.

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carTypeId – int – 26650 (you should find “golf iv akq” and make sure it is the same id; if it is

not, replace 26650 with the id that you find in the response)

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getEobdLocationsResponse xmlns="http://data.webservice.workshop.vivid.nl">
4. <getEobdLocationsReturn>
5. < **location** > **LHD is shown** </location>
6. < **mimeDataName** > **[http://www.haynespro-services.com:8080/workshop/images/volkswagen](http://www.haynespro-services.com:8080/workshop/images/volkswagen) golf iv &**
    **bora_dba_romania.svgz** </mimeDataName>
7. < **order** > **0** </order>
8. </getEobdLocationsReturn>
9. </getEobdLocationsResponse>
10. </soapenv:Body>
11. </soapenv:Envelope>


200

Figure 10.6.1.1 – Diagnostics – Eobd Location Picture (1) and Eobd Location Text(2)

1 - < **mimeDataName** > **[http://www.haynespro-](http://www.haynespro-)**

**services.com:8080/workshop/images/volkswagen golf iv &**

**bora_dba_romania.svgz** </mimeDataName> (line 6)

2 - < **location** > **LHD is shown** </location> (line 5)

#### 9.5.2. getEobdLocationsForModel()

This operations gets all eobd locations for all types linked to a model

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)


201

###  carModelId – int (this number is the “id” of the Model)

**This operation returns an array of ExtEobdLocation objects.**

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carModelId – int

Request:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:data="http://data.webservice.workshop.vivid.nl">
2. <soapenv:Header/>
3. <soapenv:Body>
4. <data:getEobdLocationsForModel>
5. <data:vrid>?</data:vrid>
6. <data:descriptionLanguage>en</data:descriptionLanguage>
7. <data:carModelId>400</data:carModelId>
8. </data:getEobdLocationsForModel>
9. </soapenv:Body>
10. </soapenv:Envelope>

Response:

63. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
64. <soapenv:Body>
65. <getEobdLocationsForModelResponse
    xmlns="http://data.webservice.workshop.vivid.nl">
66. <getEobdLocationsForModelReturn>
67. <location>Left-hand drive is shown, LHD</location>
68.
    <mimeDataName>http://localhost:8080/workshop/images/audi_a4__2001_plus_dba_ellem
    eet.svgz</mimeDataName>
69. <order>0</order>
70. <status xsi:nil="true"/>
71. </getEobdLocationsForModelReturn>
72. <getEobdLocationsForModelReturn>
73. <location>Left-hand drive is shown, LHD</location>
74.
    <mimeDataName>http://localhost:8080/workshop/images/audi_a6_4f_dba_ellemeet.svgz
    </mimeDataName>
75. <order>1</order>
76. <status xsi:nil="true"/>
77. </getEobdLocationsForModelReturn>
78. </getEobdLocationsForModelResponse>
79. </soapenv:Body>
80. </soapenv:Envelope>


202

## 10. ENGINE AND FUSE LOCATIONS...............................................................................................................

### 10.1. Structure

Engine locations and fuse locations are two different subjects, but they have the same

structure.

Both of them have Systems, with a name that describes the picture that shows the locations, and each

system has a set of elements with their names and the number that identifies them on the picture.

The structures that define these objects are:

ExtLocationSystemV3 {
Integer order;
Integer id;
String description;
Integer side;
String systemLocationMimeDataName;
String itemsLocationMimeDataName;
ExtLocationItemV3[] items;
}

###  order : this number gives the order in which the elements should be shown. When receiving

```
the request, elements should be already ordered. It is used mainly to give a clue in case the
client does not preserve the order in which the elements are received.
```
###  id : this element uniquely identifies the system. It does not have an active role in this structure,

because it is not needed in any other call.

###  description : this element is language dependent. It contains the description of the system.

Based on this, the user makes the right selection.

###  side : this property is a number that indicates the side of the wheel:

### ◦ 0 – both

### ◦ 1 – left

### ◦ 2 – right

### ◦ - 1 – unknown

###  systemLocationMimeDataName : this property is a string that contains an URL to a picture that

```
shows the location of the system on the car. This property can be null (usually it is null for
engine location and not null for fuse locations).
```
###  itemsLocationMimeDataName : this property is a string that contains an URL to a picture that

shows the location of the elements in the system. This property should not be null.


203

###  items: this property is an array of ExtLocationItemV2 objects. These objects contain

```
information about the description and location on the itemsLocationMimeDataName picture.
This property should not be null.
```
ExtLocationItemV3 {
String description;
String remark;
String type;
String location;
float value;
String oemName;
}

###  description : this property is language dependent. It contains the description of an element that is shown in the

```
schema.
```
###  remark : this property is language dependent. It contains the remark of an element that is shown in the schema

###  type : this property is a string that is not language dependent. It contains a short id of the type of item that is

```
shown. Using this property and the “location” property, you can create the id of the element in the schema (the
picture has the SVG format which uses XML; using this id, you can find the tag element that draws the element, so
you can make the border thicker, change its color or anything else that could help user interaction). The id is
formed like this: type-location (for example: fus-12). The known types are:
```
### ◦ For fuses & relays schemes:

### ▪ “fus” (fuse)

### ▪ “fut” (fuse)

### ▪ “fuu” (fuse)

### ▪ “fux” (fuse)

### ▪ “loc” (location)

### ▪ “rel” (relay)

### ▪ “oth” (other)

### ◦ For engine location schemes: they are all “mmp” (motor management), so they do not bring any useful

```
information (and this is the reason in the engine location page the types of the items are not shown); it is still
used to form the id of the element in the svg-schema.
```
###  location : this value is a string that contains the notation of the element in the picture. This string is shown in the

```
picture to identify the element, but it can also be used together with “type” property to create an id (see the
above description of “type” for more details)
```
###  value : this property is a float number. It is used for fuses to give the number of amperes. This property is usually

```
shown together with the description. It can be used also to indicate in the picture the color that it corresponds to
the value by using this id: arrow-value (for example: arrow-15 for 15A, arrow-30 for 30A; this is the only exception
from the rule: arrow-750 for 7.5A).
```
###  oemName : this property is a String. It is used to show the oem name of a location. This property is usually shown


204

```
together with the description.
```
#### 10.1.1. getFuseLocationsV3()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3

for more information about this object)

The difference between V3 and V2 version of this method is that the latest one contains item

remark in the response.

**This operation returns an ExtLocationSystemV3 array** that represent the location of the

components on the schema.

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carType – int – 43600 (you should find “opel astra h XEP 1.2” and make sure it is the same id; if

it is not, replace 43600 with the id that you find in the response)

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getFuseLocationsV3Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getFuseLocationsV3Return>
5. <description> **Additional relays in engine compartment** </description>
6. <id> **302000459** </id>
7. <items>
8. <items>
9. < **description** >Cooling fan relay</ **description** >
10. < **location** >R1</ **location** >
11. < **oemName** >K30A</ **oemName** >
12. < **remark** xsi:nil="true"/>
13. < **type** >rel</ **type** >
14. < **value** >0.0</ **value** >
15. </items>
16. <items>
17. <description>Cooling fan relay</description>
18. <location>R2</location>
19. <oemName>K30B</oemName>


205

20. <remark xsi:nil="true"/>
21. <type>rel</type>
22. <value>0.0</value>
23. </items>
24. ...
25. </items>
26. < **itemsLocationMimeDataName** > **[http://www.haynespro-](http://www.haynespro-)**
    **services.com:8080/workshop/images/astra_h_2_dba_romania.svgz** </itemsLocationMimeDataName>
27. <order>1</order>
28. <side>0</side>
29. < **systemLocationMimeDataName** > **[http://www.haynespro-](http://www.haynespro-)**
    **services.com:8080/workshop/images/loc_engroomleft1_dba_ellemeet.svgz** </systemLocationMimeDataName>
30. </getFuseLocationsV3Return>
31. <getFuseLocationsV3Return>
32. <description>Fuse box in luggage compartment</description>
33. <id>7233</id>
34. <items>...</items>
35. <itemsLocationMimeDataName>http://www.haynespro-
    services.com:8080/workshop/images/astra_h_4_dba_romania.svgz</itemsLocationMimeDataName>
36. <order>2</order>
37. <side>0</side>
38. <systemLocationMimeDataName>http://www.haynespro-
    services.com:8080/workshop/images/loc_back_left_luggage_dba_romania.svgz</systemLocationMimeDataName>
39. </getFuseLocationsV3Return>
40. ...
41. </getFuseLocationsV3Return>
42. </soapenv:Body>
43. </soapenv:Envelope>


206

Figure 11.2.1 – Fuses and Relays – System(1) and system location picture (2)

1 - < **description** > **Additional relays in engine compartment, MY 2006** </description>
(line 5)
2 - < **systemLocationMimeDataName** >http://www.haynespro-
services.com:8080/workshop/images/loc_engroomleft1_dba_ellemeet.svgz</systemLocationMimeDataName>
(line 25)

**Note** : _There may be different systems that have the same system-location-picture (as you can_

_see in the Figure 11.2.1: “Additional relays in engine compartment...” and “Main fuses in engine_

_compartment”). You may choose to show them separately (description-picture) or grouped together_

_(descriptions-picture)._


207

Figure 11.2.2 – Fuses and Relays – Type(3), location(4), description(5) and value(6)

3 - < **type** > **fus** </type> (line 17)
4 - < **location** > **50** </location> (line 16)
5 - < **description** > **Air conditioning** </description> (line 15)
6 - < **value** > **10.0** </value> (line 18)
7 - < **itemsLocationMimeDataName** >http://www.haynespro-
services.com:8080/workshop/images/astra_h_2_dba_romania.svgz</itemsLocationMimeDataName>
(line 22)

If the mouse is over the descriptions in the left, the component (if it is a component and not a

location description) in the schema can be highlighted and an arrow can be shown to indicate the

color and the value:


208

Figure 11.2.3 – Fuses and relays – highlighted component, indicated color/value

If you check the source of the picture (right click on the picture, select “Save SVG as...” and

open with a text editor – Notepad for example – the saved file), you can find the following elements:

###  the fuse with the type “fus” and the location number “50”:

```
<path id="fus-50" i:knockout="Off" fill="none" stroke="#000000" stroke-width="0.6071"
d="M168.791,52.819v16h-36.666v-16H168.791z"/>
```
###  the arrow corresponding to the red color and “10 A” value:

```
<path id="arrow-10" i:knockout="Off" fill="none"
d="M240.304,72.965V55.266l15.604,8.9L240.304,72.965z"/>
```
For the JavaScript operations used in Workshop ATI Online for handling Fuses & Relays

diagrams , see the code at the end of this chapter.


209

#### 10.1.2. getEngineLocation()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carType – int (this number is the “id” of the Type found in ExtCarType; you can check chapter 3

for more information about this object)

**This operation returns an ExtLocationSystem array** that represent the location of the

components on the schema.

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carType – int – 43600 (you should find “opel astra h XEP 1.2” and make sure it is the same id; if

it is not, replace 43600 with the id that you find in the response)

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getEngineLocationsResponse xmlns="http://data.webservice.workshop.vivid.nl">
4. <getEngineLocationsReturn>
5. < **description** > **Engine compartment** </description>
6. <id>4534</id>
7. <items>
8. <item>
9. < **description** > **Injector** </description>
10. < **location** > **1** </location>
11. < **type** > **mmp** </type>
12. <value>0.0</value>
13. </item>
14. <item>
15. <description>Mass air-flow meter</description>
16. <location>31</location>
17. <type>mmp</type>
18. <value>0.0</value>
19. </item>
20. ...
21. </items>
22. < **itemsLocationMimeDataName** >http://www.haynespro-
    services.com:8080/workshop/images/astra_h_z14xep_z14_xel_ec_dba_romania.svgz</itemsLocationMimeDataName>
23. <order>0</order>


210

24. <side>0</side>
25. <systemLocationMimeDataName xsi:nil="true"/>
26. </getEngineLocationsReturn>
27. <getEngineLocationsReturn>
28. <description>Engine, rear view</description>
29. <id>7279</id>
30. <items>...</items>
31. <itemsLocationMimeDataName>http://www.haynespro-
    services.com:8080/workshop/images/corsa_c_z10xep_engine_rear_dba_romania.svgz</itemsLocationMimeDataName
    >
32. <order>1</order>
33. <side>0</side>
34. <systemLocationMimeDataName xsi:nil="true"/>
35. </getEngineLocationsReturn>
36. </getEngineLocationsResponse>
37. </soapenv:Body>
38. </soapenv:Envelope>

Figure 11.3.1 – Component Location – System(1)

1 - < **description** > **Engine compartment** </description> (line 5)


211

Figure 11.3.2 – Engine Location – location(2), description(3), itemLocationMimeData(4)

2 - < **location** > **1** </location> (line 10)
3 - < **description** > **Injector** </description> (line 9)
4 - < **itemsLocationMimeDataName** >http://www.haynespro-
services.com:8080/workshop/images/astra_h_z14xep_z14_xel_ec_dba_romania.svgz</itemsLocationMimeDataName>
(line 22)

If you check the source of the picture (right click on the picture, select “Save SVG as...” and

open with a text editor – Notepad for example – the saved file), you can find the following:

###  the item with the type “mmp” (line 11) and the location “1” (line 10):

```
<g id="mmp-1" i:knockout="Off">
<path i:knockout="Off" fill="none" stroke="#E31A38" stroke-miterlimit="2.4142" d="M272.84,418.448h-
42.581v-42.326h42.581 V418.448z"/>
<path i:knockout="Off" fill="none" stroke="#E31A38" stroke-miterlimit="2.4142"
d="M251.83,182.463v193.658"/>
```

212

</g>
Next, there is an example of fuses and relays SVG and how to paint, highlight and remove highlight border for
that fuse.
Here is a small html demo showing how to include a svg image in a figure object. The html demo content is:

1. <html>
2. <head></head>
3.
4. <body>
5. <header>
6. <script src="js/jquery-1.7.2.svg.min.js"></script>
7. <script src="js/jquery-ui.min.js"></script>
8. <script src="js/jquery.svg.js"></script>
9. <script src="js/location_systems.js"></script>
10. </header>
11.
12. <section class="content" style="height=500px;">
13. <figure class="svgFigure" id="systemDetailImage" data-
    svgurl="https://acc.haynespro-assets.com/workshop/images/65555.svgz"></figure>
14. </section>
15.
16. </body>
17. </html>

The svg image will be loaded inside the figure element using the id “systemDetailImage”. The code to

load svg, paint/highlight fuses is inside the javascript file location_systems.js. The content of jquery

files can be taken from our TOUCH website(right click – view source, search by jquery)

Here you have the content of the svg interactivity file (location_systems.js):

The demo of paint/highlight a fuse is found inside the method: addInteractivity(svg)

1. $(document).ready(function() {
2.
3. defineColors();
4. loadSvgs();
5.
6. //USE THIS TO RETRIEVE SVG OBJECT WHEN NEDED!
7. //var svg = $('#systemDetailImage').svg('get');
8.
9. });
10.
11.
12. function loadSvgs() {
13. var systemDetailImage = $("#systemDetailImage");
14. var svgDetailUrl = systemDetailImage.attr('data-svgurl');
15.
16. systemDetailImage.svg({
17. loadURL: svgDetailUrl,


213

18. onLoad: initLoadDone,
19. initPath:''
20. });
21.
22. }
23.
24. function initLoadDone(svg, error) {
25.
26. resetSize(svg);
27. reApplyStyles(svg);
28. addInteractivity(svg);
29.
30. }
31.
32.
33. function resetSize(svg, width, height) {
34. svg.configure({width: width || $(svg._container).width(), height:
    height || $(svg._container).height()});
35. }
36.
37. function reApplyStyles(svg) {
38. var svgroot = svg.root();
39. var styleTags = svgroot.getElementsByTagName('style');
40. $(styleTags).each(function() {
41. var styleText = $(this).text();
42. $(this).text(styleText);
43. });
44. }
45.
46. function handleClicksOnLocationCompOnSVG(svg) {
47. try {
48. var allTextElements = svg.root().getElementsByTagName('text');
49.
50. //Your code for interaction with left menu; when svg is clicked
    make LEFT menu fuses and relays highlighted and active
51. } catch (e) {
52. console.log(e);
53. }
54. }
55.
56. function addInteractivity(svg) {
57. handleClicksOnLocationCompOnSVG(svg);
58.
59.
60. //DEMO - Please comment the DEMO in PRODUCTION;
61.
62.
63. var compType = 'fus';
64. var compLocation ='2';
65. var compAmperage = '40';


214

##### 66.

##### 67. //PAINT FUSES

68. paintFuse(svg,compType,compLocation,compAmperage);
69.
70. //MARK SELECTED FUSE WITH BORDER
71. var part = findPart(svg,compType,compLocation);
72. highlightSvgPart(part,true);
73.
74. //REMOVE SELECTED FUSES BORDER
75. //highlightSvgPart(part,false);
76.
77. //END DEMO
78. }
79.
80.
81. var orgStrokeColor = "#000000";
82. var selectedStrokeColor = "#00FF00";
83. var orgStrokeWidth = "";
84.
85. function highlightSvgPart(part,toggle) {
86. var strokeColor = orgStrokeColor;
87. var strokeWidth = orgStrokeWidth;
88. if(part != null) {
89. if(toggle == true || toggle == 'selected') {
90. if(toggle == true) {
91. strokeColor = "#000000";
92. } else if(toggle == 'selected') {
93. strokeColor = selectedStrokeColor;
94. }
95. strokeWidth = "4";
96. if(part.nodeName == "g") {
97. orgStrokeColor = $(part).children().attr("stroke");
98. if($(part).children().children().length > 0) {
99. orgStrokeColor =
    $(part).children().children().attr("stroke");
100. }
101. } else {
102. orgStrokeColor = $(part).attr("stroke");
103. }
104. }
105. if(part.nodeName == "g") {
106. $(part).children().attr("stroke",strokeColor).attr("stroke-
    width",strokeWidth);
107. if($(part).children().children().length > 0) {
108.
    $(part).children().children().attr("stroke",strokeColor).attr("stroke-
    width",strokeWidth);
109. }
110. } else {
111. $(part).attr("stroke",strokeColor).attr("stroke-


215

```
width",strokeWidth);
```
112. }
113. }
114. }
115.
116. function findPart(svg,compType,compLocation) {
117. var partId = compType + "-" + compLocation;
118. var part = svg.getElementById(partId); // find the component with a
    plain id
119.
120. if(part == null && compType != undefined) {
121.
122. partId2 = compType.substring(0, 1).toUpperCase() +
    compType.substring(1) + "-" + compLocation;
123. part = svg.getElementById(partId2); // find the component with a
    capital first letter
124. if(part == null) {
125. partId3 = compType + "-" + compLocation + "_1_";
126. part = svg.getElementById(partId3); // find the component
    with a plain id + extension
127. if(part == null) {
128. partId4 = compType.substring(0, 1).toUpperCase() +
    compType.substring(1) + "-" + compLocation + "_1_";
129. part = svg.getElementById(partId4); // find the
    component with a capital first letter + extension
130. }
131. }
132. }
133. return part;
134. }
135.
136. function defineColors() {
137. fusecol = new Array();
138. fusecol[0] = new Array();
139. fusecol[0][0] = 'none';
140. fusecol[0][1] = '#666666';
141. fusecol[0][2] = '#CCCCCC';
142. fusecol[0][3] = '#FF99CC';
143. fusecol[0][4] = '#FF3399';
144. fusecol[0][5] = '#CC9933';
145. fusecol[0][7] = '#8B6F00';
146. fusecol[0][10] = '#FF0000';
147. fusecol[0][15] = '#3399CC';
148. fusecol[0][20] = '#FFFF0F';
149. fusecol[0][25] = '#F7F7F7';
150. fusecol[0][30] = '#00CC33';
151. fusecol[0][35] = '#2FADAA';
152. fusecol[0][40] = '#FF9933';
153. fusecol[0][50] = '#CC0000';
154. fusecol[2] = new Array();


216

155. fusecol[2][15] = '#3399CC';
156. fusecol[2][20] = '#FFFF0F';
157. fusecol[2][25] = '#F7F7F7';
158. fusecol[2][30] = '#00CC33';
159. fusecol[2][40] = '#FF9933';
160. fusecol[2][50] = '#CC0000';
161. fusecol[2][60] = '#3399CC';
162. fusecol[2][70] = '#CC9933';
163. fusecol[2][80] = '#F7F7F7';
164. fusecol[2][100] = '#3399CC';
165. fusecol[3] = new Array();
166. fusecol[3][30] = '#FF3399';
167. fusecol[3][40] = '#339933';
168. fusecol[3][50] = '#CC0000';
169. fusecol[3][60] = '#FFFF0F';
170. fusecol[3][80] = '#666666';
171. }
172.
173. function paintFuse(svg,compType,compLocation,compAmperage) {
174.
175. var col = null;
176. if (compType == 'fus') {
177. col = 0;
178. } else if (compType == 'fut') {
179. col = 2;
180. } else if (compType == 'fuu') {
181. col = 3;
182. }
183.
184. var part = findPart(svg,compType,compLocation);
185.
186.
187. if(part != null && col != null) {
188. $(part).attr("fill",fusecol[col][compAmperage]);
189. }
190. }

After running the demo for the given svg, based on the svg source code, you will get this result: The

fuse with number 2 is painted with yellow. The fuse is searched within the svg source code between

all svg nodes and will be found in this location:

Figure 11.3.3 Svg source code node containing a fuse with id “Fus-2”


217

Figure 13.3.4 The result of running the demo paintFuse method


218

## 11. REPAIR TIMES

### 11.1. Structure

Repair Times are not based directly on Vivid carTypes. There are some equivalent types (car-

types with the same engine). They are the same ones required by the operation

getCarTypesByTecdocNumber() from chapter 3 (3.2.5) – the TecDoc types. We called them “repair

time types”.

ExtRepairtimeTypeV2 {
String make;
String model;
String type;
Short output;
String madeFrom;
String madeUntil;
Integer repairtimeTypeId;
String typeCategory;
String rootNodeId;
}


219

Figure 12.1.1 – Workshop ATI Online – Repair Time Type selection

Next, we will give an explanation for each element in the object:

ExtRepairtimeTypeV2 {
String make;
String model;
String type;
Short output;
String madeFrom;
String madeUntil;
Integer repairtimeTypeId;
String typeCategory;
String rootNodeId;
}

###  make : This is a String that contains the name of the maker (for example: “VW”)

###  model : This is a String that contains the model of the repair-time-car (for example: “Golf IV (1J1)”)

###  type : This is a String that contains the type of the repair-time-car (for example: “1.4 16V”)

###  output: This is the output of the car (for example “55” - kW)

###  madeFrom : This is a String that contains the year and the month when the production of the car started (for


220

```
example “1997-08” - year: 1997, month: 08)
```
###  madeUntil : This is a String that contains the year and the month when the production of the car stopped. If it is

```
null, it means that it is still in production. The structure of the String is the same as for “madeFrom” (yyyy-MM).
```
###  repairtimeTypeId : This is an id of the car that can be used with other operations (to get the repair time

```
information for the car with the specified id)
```
###  typeCategory : This is a text which can have 2 values: “CAR” and “TRUCK”

###  rootNodeId : This is a String that contains the id of the root node. By default, it is “root”. It is used with other

```
operations to get the groups of repairs (makes the connection between the type and repair time data)
```
ExtRepairtimeTypeV3 {
String make;
String model;
String type;
Short output;
String madeFrom;
String madeUntil;
Integer repairtimeTypeId;
String typeCategory;
String rootNodeId;
Integer[] motnrs;
}

###  motnrs : this is an array of motor numbers that a repair task may have.

We have created the 3rd version for ExtRepairtimeType so that we can include in the results an

array of the motor numbers. An array of ExtRepairtimeTypeV3 objects is returned in the ExtCarTypeV2

results of the decodeVINV2 operation.

For each of these types there is a tree with groups of repairs (on the first level), subgroups of

repairs (on the second level) and with repairs short descriptions on the third level. This tree-structure

is described by the next data-structure:

ExtRepairtimeNodeV2 {
Integer order;
String awNumber;
String description;
Integer value;
String id;
boolean hasSubnodes;
boolean hasInfoGroups;
ExtGeneralArticle[] genarts;
}

###  order : this number gives the order in which the elements should be shown. When receiving

```
the request, elements should be already ordered. It is used mainly to give a clue in case the
client does not preserve the order in which the elements are received.
```

221

###  awNumber : this is an identifier that is provided by the producer of the data. It has no use in

Workshop ATI Online.

###  description : this is a String that contains the description of the node: group description (if it is

```
a first level node), the sub-group description (if it is a second level node) and the description of
the repair task (if it is the third level node).
```
###  value : this is an integer number that represents the estimated time to finish the repair task. It

```
has a (meaningful) value only for a repair task (level 3). If you divide this value to 100, you get
the number of hours. The decimals represent fractions of an hour. For example: value = 125 =
1.25 hours = 1 hour and 15 minutes (0.25 hours = 60 * 0.25 minutes = 15 minutes)
```
###  id: this is an identifier used by the web-services to make the relations by setting it as a

```
parameter when calling a web-service operations (relations between the root node and
groups, between a group node and sub-group nodes, between the sub-group nodes and the
repair nodes and between the repair node and the details of the repair task).
```
###  hasSubnodes : this is a boolean value and it is set to “true” if it has sub-nodes (so, for first level

nodes – the groups – and the second level nodes – the sub-groups)

###  hasInfoGroups : this is a boolean value and it is set to “true” if it has detailed information about

a repair node. So, it can be “true” only for a 3rd level node.

###  genarts : this is an array of complex objects that can contain numbers (ids) of General Article

```
Numbers (genArt numbers, provided by TecDoc). This property can be null if the specific repair
does not require articles/parts. It will always be null for the first and second level (for groups
and subgroups; they have a meaning only for a repair task)
```
ExtRepairtimeNodeV3 {
Integer order;
String awNumber;
String description;
String jobType
Integer value;
String id;
boolean hasSubnodes;
boolean hasInfoGroups;
ExtGeneralArticle[] genarts;
}
ExtRepairTimeNodeV3 is the same as ExtRepairtimeNodeV2 excepting that it contains a new parameter called job type.

###  jobType : this is a String value which can have one of the three options: MECHANICAL,BODY or

ELECTRONICS

ExtRepairtimeNodeV4 {
Integer order;
String awNumber;


222

String description;
String jobType
Integer value;
String id;
boolean hasSubnodes;
boolean hasInfoGroups;
ExtGeneralArticle[] genarts;
String oeCode;
ExtCriteriaGroup[] timeCriterias;
}
ExtRepairTimeNodeV4 is the same as ExtRepairtimeNodeV3 excepting that it contains two new parameters

###  oeCode : this is a String value representing the job OE code;

###  timeCriterias : an array of ExtCriteriaGroup[] – for future development;

ExtGeneralArticle {
Integer id;
boolean mandatory;
String description;
}

###  id : the general article number

###  mandatory : true if the replacement is mandatory

###  description : the name of the article (language dependent)


223

Figure 12.1.2 – Repair Times tree – group (1), sub-group (2), repair task (3)

Each repair task (level 3) can have more details, like what exactly is included in that task

(included), what other tasks might be necessary before (preliminary) or after the actual task(follow

up).


224

Figure 12.1.3 – Repair Times details – included tasks (4), follow up actions (5)

The “follow up actions” and the “preliminary actions” are tasks that can be found also as level

3 nodes in the tree. The included tasks are only internal, and they represent, in fact, subtasks of the

selected repair task.

The data structure that describes this is:

ExtRepairtimeInfoGroupV4 {
ExtRepairtimeInfoV4[] includedList;
ExtRepairtimeInfoV4[] notIncludedList;
ExtRepairtimeInfoV4[] preliminaryList;
ExtRepairtimeInfoV4[] followUpWorkList;
String nodeId;
}

###  includedList: this is a list of ExtRepairtimeInfoV2 elements (this structure will be described

```
next). They are the sub-tasks that describes better the selected task. It is not mandatory to
have subtasks because many task descriptions are composed of a single action which cannot
be separated in more sub-tasks, so this property can be null.
```
###  notIncludedList: this should contain all the tasks that should not be included, but it is not used.

It is always null.


225

###  preliminaryList: this is a list of ExtRepairtimeInfoV2 elements that contain tasks that could be

performed before the selected repair task because they are in close relation.

###  followUpList: this is a list of ExtRepairtimeInfo elements that contain tasks that could be

performed after the selected repair task because they are in close relation.

###  NodeId: this is a String representing the id of the node to which the information belongs to. It

```
is set only when more such objects are returned by an operations (when the extra information
is requested for more nodes and this property is necessary to distinguish between them)
```
ExtRepairtimeInfoV2 {
String awNumber;
String description;
Integer value;
String direction;
ExtGeneralArticle[] genarts;
boolean hasInfoGroups;
}

###  awNumber : this is an identifier. For “follow up” and “preliminary” it can be used as id to get

the details for the task, in case the user wants to add it to the shopping basket too.

###  description : this is a String that contains the description of the sub-task (for all types: follow-

up, preliminary and included).

###  value : this is a number that represents the time it takes to do the sub-task, only if the type is

```
“follow-up” of “preliminary.” If it is an “included” sub-task, the value should not be shown. The
value has the same encoding as for ExpRepairtimeNode (for example: value = 125, the
estimated time is 1.25 hours = 1 hour and 0.25 * 60 minutes = 1hour and 15 minutes)
```
###  direction : this is an extra value that shows what kind of subtask it is: U for included, F for

```
follow-up and V for preliminary. Since the tasks are already separated by types (direction) into
different lists, this value may not be necessary.
```
###  genarts : this is an array of complex objects that contains all the general article numbers for a

```
followUp task or a preliminary task (like for a 3rd level ExtRepairtimeNode element; this way
the node can be used directly, no need to make an extra request)
```
###  hasInfoGroups : this is a boolean element that has the same meaning as for the

```
ExtRepairtimeNode (if true, the id can be used with ExtRepairtimeInfo); it can be true only for
preliminary and followUp tasks
```
```
ExtRepairtimeInfoV3 {
```
###  String awNumber;

###  String description;


226

###  String jobType;

###  Integer value;

###  String direction;

###  ExtGeneralArticle[] genarts;

###  boolean hasInfoGroups;

##### }

ExtRepairtimeInfoV3 is the same as ExtRepairtimeInfoV2 except that it contains a new parameter called job type.

###  jobType : this is a String value which can have one of the three options: MECHANICAL, BODY or

```
ELECTRONICS
ExtRepairtimeInfoV4 {
```
###  String awNumber;

###  String description;

###  String jobType;

###  Integer value;

###  String direction;

###  ExtGeneralArticle[] genarts;

###  boolean hasInfoGroups;

###  String oeCode;

###  ExtCriteriaGroup[] timeCriterias

##### }

ExtRepairtimeInfoV4 is the same as ExtRepairtimeInfoV3 except that it contains two new parameters

###  oeCode : this is a String value representing the job OE code;

###  timeCriterias : an array of ExtCriteriaGroup[] – for future development.

### 11.2. Operations

#### 11.2.1. getRepairtimeTypesV2()

This operation requires these parameters when calling:

###  descriptionLanguage - String (this should be a 2-character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carTypeId – int (this number is the “id” of the Type found in ExtCarType; you can check chapter

3 for more information about this object)

This operation returns an array of ExtRepairtimeType objects that represent all the equivalent

repair-times-types for a specified carTypeId.


227

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carType – int – 26650 (you should find “golf iv akq” and make sure it is the same id; if it is not,

replace 26650 with the id that you find in the response)

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getRepairtimeTypesV2Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getRepairtimeTypesV2Return>
5. <madeFrom> **1997 - 08** </madeFrom>
6. <madeUntil> **2005 - 06** </madeUntil>
7. <make> **VW** </make>
8. <model> **GOLF IV (1J1)** </model>
9. <output> **55** </output>
10. <repairtimeTypeId> **8799** </repairtimeTypeId>
11. <rootNodeId> **root** </rootNodeId>
12. <type> **1.4 16V** </type>
13. <typeCategory> **CAR** </typeCategory>
14. </getRepairtimeTypesReturn>
15. <getRepairtimeTypesReturn>
16. <madeFrom>1999-05</madeFrom>
17. <madeUntil xsi:nil="true"/>
18. <make>VW</make>
19. <model>GOLF IV Variant (1J5)</model>
20. <output>55</output>
21. <repairtimeTypeId>11599</repairtimeTypeId>
22. <rootNodeId>root</rootNodeId>
23. <type>1.4 16V</type>
24. </getRepairtimeTypesV2Return>
25. </getRepairtimeTypesV2Response>
26. </soapenv:Body>
27. </soapenv:Envelope>


228

Figure 12.2.1.1 – Repair Times Types selection

1 - <make> **VW** </make> (line 7)
2 - <model> **GOLF IV (1J1)** </model> (line 8)
3 - <type> **1.4 16V** </type> (line 9)
4 - <madeFrom> **1997 - 08** </madeFrom> (line 5)
5 - <madeUntil> **2005 - 06** </madeUntil> (line 6)
6 - <output> **55** </output> (line 9)

Other properties that are important (for calling the next operation: getRepairtimeSubnodesV2)

are:

<repairtimeTypeId> **8799** </repairtimeTypeId> (line 10)
<typeCategory>CAR</typeCategory> (line 13)
<rootNodeId> **root** </rootNodeId> (line 11)

#### 11.2.2. getRepairtimeSubnodesByGroupV4()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  repairtimeTypeId – int– 8799 (this value is in the result of previous operation call:

getRepairtimeTypes)

###  typeCategory – String – this text is one of the constant values “CAR” or “TRUCK” (this value is

in the result of previous operation call: getRepairtimeTypesV2)

###  nodeId – String (this number is the “id” of the node from the repair tree – ids of groups,

subgroups and repairs)


229

###  carTypeGroup – String – optional - (this group is the same as in table 3.1.2). It can be:

### ◦ ENGINE

### ◦ TRANSMISSION

### ◦ STEERING

### ◦ BRAKES

### ◦ EXTERIOR

### ◦ ELECTRONICS

### ◦ QUICKGUIDES (if the value is null, QUICKGUIDES will be used)

This operation returns an array of ExtRepairtimeNodeV4 that represents all the sub-nodes of

the specified **nodeId** for the car with the **repairtimeTypeId**.

The difference between V4 and V3 is that the results contain now eCode and timeCriterias fields for

each job.

We will make several calls to this operation to see how the elements of the tree are obtained:

###  First call:

### ◦ descriptionLanguage – String – en

### ◦ repairtimeTypeId – int– 8799 (this value is in the result of previous operation call:

getRepairtimeTypes)

### ◦ typeCategory – String – CAR (this value is in the result of previous operation call:

getRepairtimeTypes)

### ◦ nodeId – String – root (this value is in the result of the previous operation call:

getRepairtimeTypes – as the property **rootNodeId** )

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getRepairtimeSubnodesByGroupV4Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getRepairtimeSubnodesByGroupV4Return>
5. < **awNumber** > **1A1** </awNumber>
6. < **description** > **Engine assembly** </description>
7. <genarts/>


230

8. <timeCriterias xsi:nil="true"/>
9. <hasInfoGroups>false</hasInfoGroups>
10. <hasSubnodes>true</hasSubnodes>
11. < **id** > **1A1** </id>
12. <jobType xsi:nil="true"/>
13. <oeCode xsi:nil="true"/>
14. <order>0</order>
15. <status>
16. <confirmationLink xsi:nil="true"/>
17. <statusCode>0</statusCode>
18. </status>
19. <value xsi:nil="true"/>
20. </getRepairtimeSubnodesByGroupV4Return>
191. <getRepairtimeSubnodesByGroupV4Return>
21. < **awNumber** > **1C1** </awNumber>
22. < **description** > **Lubrication system** </description>
23. <genarts/>
24. < **timeCriterias** xsi:nil="true"/>
25. <hasInfoGroups>false</hasInfoGroups>
26. <hasSubnodes>true</hasSubnodes>
27. <id>1C1</id>
28. <jobType xsi:nil="true"/>
29. < **oeCode** xsi:nil="true"/>
30. <order>1</order>
31. <status xsi:nil="true"/>
32. <value xsi:nil="true"/>
33. </getRepairtimeSubnodesByGroupV4Return>
192. ...
34. </getRepairtimeSubnodesByGroupV4Response>
35. </soapenv:Body>
36. </soapenv:Envelope>


231

Figure 12.2.2.1 – Repair Times – first level: groups (1)

1 - <description> **Engine assembly** </description> (line 6)

When calling this operation again to get the sub-groups for this “Engine assembly ” group, we will use this
property:
2 - <id> **1A1** </id> (line 11)

###  Second call:

### ◦ descriptionLanguage – String – en

### ◦ repairtimeTypeId – int– 8799 (this value is in the result of previous operation call:

getRepairtimeTypes)

### ◦ typeCategory – String – CAR (this value is in the result of previous operation call:

getRepairtimeTypes)

### ◦ nodeId – String – 1A1 (this value is in the result of the previous operation call:

getRepairtimeTypes – as the property id)


232

##### 1.

2. <getRepairtimeSubnodesByGroupV4Response xmlns="http://data.webservice.workshop.vivid.nl">
3. <getRepairtimeSubnodesByGroupV4Return>
4. <awNumber>1A00000000G</awNumber>
5. < **description** > **Checks - Adjustments** </description>
6. <genarts/>
7. < **timeCriterias** xsi:nil="true"/>
8. <hasInfoGroups>false</hasInfoGroups>
9. <hasSubnodes>true</hasSubnodes>
10. < **id** > **1A00000000G** </id>
11. <jobType xsi:nil="true"/>
12. < **oeCode** xsi:nil="true"/>
13. <order>0</order>
14. <status>
15. <confirmationLink xsi:nil="true"/>
16. <statusCode>0</statusCode>
17. </status>
18. <value xsi:nil="true"/>
19. </getRepairtimeSubnodesByGroupV4Return>
193. .....
20. </soapenv:Body>
21. </soapenv:Envelope>

Figure 12.2.2.2 – Repair Times – sub-groups (level 2)

1 - <description> **Checks - Adjustments** </description>


233

(line 5)
When calling this operation again to get the repairs for this “Checks - Adjustments ” sub-group, we will use this
property:

2 - <id> **1A00000000G** </id> (line 10)

###  Third call:

### ◦ descriptionLanguage – String – en

### ◦ repairtimeTypeId – int– 8799 (this value is in the result of previous operation call:

getRepairtimeTypes)

### ◦ typeCategory – String – CAR (this value is in the result of previous operation call:

getRepairtimeTypes)

### ◦ nodeId – String – 1A00000000G (this value is in the result of the previous operation call:

getRepairtimeTypes – as the property i **d** )

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getRepairtimeSubnodesByGroupV4Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getRepairtimeSubnodesByGroupV4Return>
5. <awNumber>1A00001000WV0</awNumber>
6. < **description** > **Check the engine for abnormal noise** </description>
7. <genarts/>
8. < **timeCriterias** xsi:nil="true"/>
9. < **hasInfoGroups** > **true** </hasInfoGroups>
10. <hasSubnodes>false</hasSubnodes>
11. < **id** > **1A00001000WV0** </id>
12. <jobType>MECHANICAL</jobType>
13. < **oeCode** />
14. <order>0</order>
15. <status>
16. <confirmationLink xsi:nil="true"/>
17. <statusCode>0</statusCode>
18. </status>
19. < **value** > **40** </value>
20. </getRepairtimeSubnodesByGroupV4Return>
194. ...
21. </getRepairtimeSubnodesV4Response>
22. </soapenv:Body>
23. </soapenv:Envelope>
24.
25.


234

Figure 12.2.2.3 – Repair Times – repairs (level 3)

1 - <description> **Check the engine for abnormal noise <** description> (line 6)


235

Figure 12.2.2.4 – Repair times – time (level 3)

1 - <value> **40** </value> (line 19)

This property represents the estimation of the time it takes to finish this repair task (“Check

the engine for abnormal noise **“** ). The value “40” translated to hours means 0.4 hours which means

0.4 * 60 minutes = 24 minutes

Other properties that are important (for calling the next operation: getRepairtimeInfos) are:

2 - <id> **1A00001000WV0** </id> (line 11)
3 - <hasInfoGroups> **true** </hasInfoGroups> (line 9)

The id value ( **1A00001000WV0** ) is used as parameter when calling the getRepairtimeInfosV4

operation and hasInfoGroups property shows if you should expect to receive any information from this

operation (there are repairs that do not have any preliminary, follow-up or included sub-tasks for a

repair and for those, the hasInfoGroups property is “false”).

#### 11.2.3. getRepairtimeInfosV4()

###  descriptionLanguage – String – en

###  repairtimeTypeId – int– 8799 (this value is in the result of previous operation call:

getRepairtimeTypes)

###  typeCategory – String – CAR (this value is in the result of previous operation call:


236

getRepairtimeTypes)

###  nodeId – String – 1A0000 1 000 (this value is in the result of the previous operation call:

getRepairtimeTypes – as the property id)

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getRepairtimeInfosV4Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getRepairtimeInfosV4Return>
5. <followUpWorkList xsi:nil="true"/>
6. < **includedList** >
7. <item>
8. <awNumber>0000003866</awNumber>
9. < **description** > **Upgrade diagnose unit (acoustic)** </description>
10. <direction>U</direction>
11. <generalArticles xsi:nil="true"/>
12. < **timeCriterias** xsi:nil="true"/>
13. <genarts xsi:nil="true"/>
14. <hasInfoGroups>false</hasInfoGroups>
15. < **jobType** > **MECHANICAL** </jobType>
16. < **oeCode** xsi:nil="true"/>
17. <value>0</value>
18. </item>
19. <item>
20. <awNumber>0000000004</awNumber>
21. <description>Start engine and appraise sound when idling</description>
22. <direction>U</direction>
23. <generalArticles xsi:nil="true"/>
24. <timeCriterias xsi:nil="true"/>
25. <genarts xsi:nil="true"/>
26. <hasInfoGroups>false</hasInfoGroups>
27. <jobType>MECHANICAL</jobType>
28. <oeCode xsi:nil="true"/>
29. <value>0</value>
30. </item>
31. ...
32. </includedList>
33. <notIncludedList xsi:nil="true"/>
34. <preliminaryList xsi:nil="true"/>
35. <status xsi:nil="true"/>
36. </getRepairtimeInfosV4Return>
37. </getRepairtimeInfosV4Response>
38. </soapenv:Body>
39. </soapenv:Envelope>


237

Figure 12.2.3.1 – Repair times info – included sub-tasks

1 - <description> **Upgrade diagnose unit (acoustic)** </description> (line 9)

#### 11.2.4. processRepairTasksV4()

This operation can be used to calculate the correct time for a set of repair tasks by removing

the sub-tasks that are found in more than one of the tasks. More than this, it can also calculate the

total time for the set of repairs when they are done together with the procedures of a service interval

(with a Maintenance Period – see chapter 6 for more details on Maintenance Periods).

The operation will request parameters for identifying the service interval

(maintenanceSystemId, maintenancePeriodId and maintenanceTasksId) which are optional and turned

on or off by “useMaintenanceTasks.” The rest of the parameters are mandatory.

Next, we will present all the parameters of this operation:

###  descriptionLanguage - String (this should be a 2-character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carTypeId – int – this is the id of the CarType

###  maintenanceSystemId – String – this the “System” identifier of the maintenance period

(service interval system)


238

###  maintenancePeriodIds – int[] - this is an array of maintenance period identifiers (service

```
interval ids); normally it should contain only one and should contain more than one for
combinable periods (see chapter 6 for more details)
```
###  repairtimeTypeId – int (this value is in the result of previous operation call:

getRepairtimeTypesV2)

###  typeCategory – String – this text is one of the constant values “CAR” or “TRUCK” (this value is

in the result of the previous operation call: getRepairtimeTypesV2)

###  maintenanceTasksIds – String[] - this is a list of maintenance tasks which are included in the

```
maintenance period but are not mandatory (for example a task with “every 24 months” in a
“Every 20,000 Km / 24 months” period); only those optional maintenance tasks that the user
chooses to include should be included here. Their times presented in the Maintenance Period
will not change, but they can influence (reduce) times of the Repair tasks included.
```
###  useMaintenanceTasks – boolean – should be “true” or “false” (cannot be null); if true, the

```
maintenance elements (maintenanceSystemId, maintenancePeriodIds and
maintenanceTasksIds) will be used for calculation; if false, the maintenance elements will be
ignored even if they are present
```
###  repairTaskIds – String[] - this is an array of ids of the Repair nodes from the repair tree (the last

level of the repair tree – see getRepairtimeSubnodesByGroupV2) that the user selects

###  repairVatRates – int[] - this is an array of numbers that represent the VAT rate for each of the

```
repairTaskIds; usually there is a unique VAT rate, but to cover exception cases, the VAT rate
must be specified for each repair task. The format in which the VAT rate is requested is NNDD
as integer where NN is the integer part and DD the decimal part (for example, for a VAT rate on
19.5%, the requested integer number is 1950)
```
###  labourRateMechanical – long - this represents the labour rate for a mechanical job type.

###  labourRateBody – long - this represents the labour rate for a body job type

###  labourRateElectronics – long- this represents the labour rate for an electronic job type. For all 3

```
labour rates the format is the same as for VAT rate: NN...NNDD (formula: round(realValue *
100) – for example, a labour rate of 123.52 Euros/hour should be sent as 12352)
```
This operation returns a message with the following structure:

ExtRepairtimesBasketV4 {
ExtRepairtimesBasketItemV4[] basketItems;
int totalRepairTime;
long repairPriceWithoutVat;
long repairTasksVat;


239

long totalRepairPrice;
}

###  basketItems : this is a list of complex objects that contain information about each distinct

Repair Task that has been specified in the request.

###  totalRepairTime : this is an integer number that encodes the total time as NN..NDD (where N

```
are the integer digits and DD the two decimals; for example, 1125 means 11.25 hours, which
means 11 hours and 0.25x60minutes=15minutes; formula decimalTime = totalRepairTime /
100)
```
###  repairPriceWithoutVat : this is an integer number that encodes the price without the VAT the

```
same way as totalRepairTime (actual price without VAT= repairPriceWithoutVat / 100; for
example, repairPriceWithoutVat = 65423 means 654.23)
```
###  repairTasksVat : this is an integer number that encodes the amount of VAT; the encoding is the

same as for repairPriceWithoutVat

###  totalRepairPrice : this is an integer that encodes the total price of the repair

```
(repairPriceWithoutVat + repairTasksVat); the encoding is the same as for
repairPriceWithoutVat
```
ExtRepairtimesBasketItemV4 {
String id;
String description;
ExtRepairtimeInfoGroupV4 repairtimesInfo;
ExtGeneralArticle[] genarts;
String jobType;
int calculatedTime;
long priceWithoutVat;
long vat;
long subtotal;
String oeCode;
ExtCriteriaGroup[] timeCriterias

}

###  id : this is the id of the Repair Task as entered as parameter when the operation was called

###  description : this text represents the main description of the Repair Task as it appears in the

repair tasks tree.

###  repairtimesInfo : this is a complex object that contains information about included sub-tasks,

follow-up, and preliminary tasks

###  genarts : this is an array of complex objects that contain information about the TecDoc general

articles

###  calculatedTime : this is an integer number that encodes the time of the Repair Task as NN..NDD


240

```
(where N are the integer digits and DD the two decimals; for example, 125 means 1.25 hours,
which means 1 hour and 0.25x60minutes=15minutes; formula decimalTime = totalRepairTime
/ 100)
```
###  priceWithoutVat : this is an integer number that encodes the price of the Repair Task without

```
the VAT the same way as calculatedTime (actual price without VAT= repairPriceWithoutVat /
100; for example, repairPriceWithoutVat = 5423 means 54.23)
```
###  vat : this is an integer number that encodes the amount of VAT for this Repair Task; the

encoding is the same as for priceWithoutVat

###  subtotal : this represents the price of the Repair Task including the VAT (priceWithoutVAT + vat)

###  jobType : this is a String value which can have one of the three options: MECHANICAL, BODY or

ELECTRONICS

###  oeCode : this is a String value representing the job OE code;

###  timeCriterias : an array of ExtCriteriaGroup[] – for future development.

ExtGeneralArticle {
Integer id;
boolean mandatory;
String description;
}

The detailed description of the structure is presented in sub-chapter 12.1

ExtRepairtimeInfoGroupV4 {
ExtRepairtimeInfoV4[] includedList;
ExtRepairtimeInfoV4[] notIncludedList;
ExtRepairtimeInfoV4[] preliminaryList;
ExtRepairtimeInfoV4[] followUpWorkList;
String nodeId;
}

The detailed description of the structure is presented in sub-chapter 12.1

#### 11.2.5. getRepairtimeNodesByGenartsV4()

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  repairtimeTypeId – int (this number is the “id” of the Type found in ExtCarType; you can check

chapter 3 for more information about this object)

###  typeCategory – String – can be CAR or TRUCK (this value is in the result of the previous

operation call: getRepairtimeTypesV2)


241

###  genArtNumbers – int[] (this is a list of numbers which represent the “id” of a general article

numbers that comes from TecDoc; for example, 7 stands for “Oil filter”)

This operation returns an array of ExtRepairtimeNodeV4 which represents all the repairs that

are related to this article. The difference between V4 and V3 is that V4 results contain also oeCode

and timeCriterias fields.

We will call this operation using the following parameters:

###  descriptionLanguage – String – en

###  repairtimeTypeId – int– 8799 (this value is in the result of previous operation call:

getRepairtimeTypes)

###  typeCategory – String - CAR (this value is in the result of previous operation call:

getRepairtimeTypes)

###  genArtNumber – int[] – 7

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getRepairtimeNodesByGenartsV4Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getRepairtimeNodesByGenartsV4Return>
195. <awNumber>1C03005000WV0</awNumber>
5. < **description>Renew the oil filter** </description>
6. < **genarts** >
7. <item>
8. < **description** > **Oil filter** </description>
9. < **id** > **7** </id>
10. <mandatory>true</mandatory>
11. </item>
12. </genarts>
13. < **timeCriterias** xsi:nil="true"/>
14. <hasInfoGroups>true</hasInfoGroups>
15. <hasSubnodes>false</hasSubnodes>
16. <id>1C03005000WV0</id>
17. <jobType>MECHANICAL</jobType>
18. < **oeCode** />
19. <order>0</order>
20. <status>
21. <confirmationLink xsi:nil="true"/>
22. <statusCode>0</statusCode>
23. </status>


242

24. <value>50</value>
25. </getRepairtimeNodesByGenartsV3Return>
26. <getRepairtimeNodesByGenartsV3Return>
27. <awNumber>1C00501030WV0</awNumber>
28. <description>Renew the engine oil and filter</description>
29. <genarts>
30. <item>
31. <description>Oil filter</description>
32. <id>7</id>
33. <mandatory>true</mandatory>
34. </item>
35. <item>
36. <description>Engine oil</description>
37. <id>3224</id>
38. <mandatory>true</mandatory>
39. </item>
40. </genarts>
41. <timeCriterias xsi:nil="true"/>
42. <hasInfoGroups>true</hasInfoGroups>
43. <hasSubnodes>false</hasSubnodes>
44. <id>1C00501030WV0</id>
45. <jobType>MECHANICAL</jobType>
46. <oeCode/>
47. <order>1</order>
48. <status xsi:nil="true"/>
49. <value>50</value>
50. </getRepairtimeNodesByGenartsV4Return>
51. </getRepairtimeNodesByGenartsV4Response>
52. </soapenv:Body>
53. </soapenv:Envelope>

#### 11.2.6. getRepairtimeNodesV4

This operation returns all the nodes that are specified as parameters. It is useful in case you

store the ids of the nodes, and you need to use all of them later.

This operation requires as parameters:

###  descriptionLanguage - String (this should be a 2-character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  repairtimeTypeId – int (this value is in the result of previous operation call:


243

getRepairtimeTypes)

###  typeCategory – String – can be CAR or TRUCK (this value is in the result of the previous

operation call: getRepairtimeTypesV2)

###  nodesIds– String[] (this array of numbers contains the “id” of the node from the repair tree –

ids of groups, subgroups, and repairs).

The difference between V4 and V3 versions is that results contain now oeCode and

timeCriterias fields.

This is an example of the request:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:data="http://data.webservice.workshop.vivid.nl">
2. <soapenv:Header/>
3. <soapenv:Body>
4. <data:getRepairtimeNodesV4>
5. <data:vrid>${vrid}</data:vrid>
6. <data:descriptionLanguage>en</data:descriptionLanguage>
7. <data:repairtimeTypeId>8799</data:repairtimeTypeId>
8. <data:typeCategory>CARS</data:typeCategory>
9. <!--1 or more repetitions:-->
10. **<data:nodesIds** > **1A00039900** </data:nodesIds>
11. < **data:nodesIds** > **1R40074900** </data:nodesIds>
12. </data:getRepairtimeNodesV4>
13. </soapenv:Body>
14. </soapenv:Envelope>
15. </soapenv:Envelope>

And this is a part of the reply:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getRepairtimeNodesV4Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getRepairtimeNodesV4Return>
5. < **awNumber** > **1A00039900WV0** </awNumber>
6. < **description** > **Renew the short-block assembly** </description>
7. <genarts>
8. <item>
9. <description>Sub-assembly</description>
10. <id>1265</id>
11. <mandatory>true</mandatory>
12. </item>
13. <item>
14. <description>Engine oil</description>
15. <id>3224</id>


244

16. <mandatory>true</mandatory>
17. </item>
18. <item>
19. <description>Antifreeze</description>
20. <id>3356</id>
21. <mandatory>true</mandatory>
22. </item>
23. </genarts>
24. < **timeCriterias** xsi:nil="true"/>
25. <hasInfoGroups>true</hasInfoGroups>
26. <hasSubnodes>false</hasSubnodes>
27. < **id** > **1A00039900WV0** </id>
28. <jobType> **MECHANICAL** </jobType>
29. < **oeCode** />
30. <order>0</order>
31. <status>
32. <confirmationLink xsi:nil="true"/>
33. <statusCode>0</statusCode>
34. </status>
35. <value>950</value>
36. </getRepairtimeNodesV4Return>
37. </getRepairtimeNodesV4Response>
38. </soapenv:Body>
39. </soapenv:Envelope>

#### 11.2.7. getRepairtimeSubnodesTextSearchV4()

Repair times are presented as a tree, the first level being the main groups, the second level

being the sub-groups and the third level being the repair tasks. The search operates only on the third

level, the repair tasks. Even though the search terms are checked only against the third level

descriptions, the results still need to be presented as a tree.

This operation requires the following parameters:

###  descriptionLanguage - String (this should be a 2-character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  repairtimeTypeId – int (this value is in the result of previous operation call:

getRepairtimeTypes)

###  typeCategory – String – can be CAR or TRUCK (this value is in the result of the previous

operation call: getRepairtimeTypesV2)

###  nodeId – String (this number is the “id” of the node from the repair tree – ids of groups,

subgroups and repairs)

###  searchText – String (this text is the text that is searched for in the repair tasks descriptions)


245

###  carTypeGroup – String (this string should be one of the constants: “MAINTENANCE”, “ENGINE,”

```
“TRANSMISSION”, ”BRAKES,” “STEERING”, ”EXTERIOR,” “QUICKGUIDES” or null/empty for
quickguides - see chapter 3.1 for more details about the groups)
```
This operation returns all the sub-elements in the tree of the element set as nodeId that have

repair tasks containing the search terms. For example, if you set nodeId=”root”, it will return all the

level 1 elements – groups – that have on the third level tasks that contain the search term. If you set

the nodeId to a level 1 element (“1A”) for example, the results will be only the sub-groups (the level 2

elements) that contain tasks having the search terms in their descriptions. Same thing for nodeId

being a level 2 element (it will return level 3 elements related to the specified level2 element that

contain the search terms).

This operation was intended to work by calling it first with nodeId=”root”. Present the result to

the user as the first level of the tree and when the user clicks on one of the elements, call the

operation again changing the nodeId to the id of the clicked element. Then present the new result as

the sub-elements of the previously clicked element.

The difference between V3 and V4 versions is that the search results contain now oeCode and

timeCriterias fields.

Example:

First call:

1. ...
2. <data:repairtimeTypeId>8799</data:repairtimeTypeId>
3. <data:nodeId>root</data:nodeId>
4. <data:searchText>replace clutch</data:searchText>
5. < **Error! Hyperlink reference not valid.** >QUICKGUIDES</data:carTypeGroup>
6. ...

Result:

1. ...
2. <description>Engine - electric - electronics - control units</description>
3. <id>1E</id>
4.
5. <description>Clutch - gearbox - automatic transmission - gearshift</description>
6. <id>1H</id>
7.
8. <description>Brake system - ABS - cruise control</description>
9. <id>1M</id>
10.
11. <description>Air conditioning - central locking</description>
12. <id>1V</id>


246

##### 13. ...

The tree should be:

###  Engine - electric - electronics - control units

###  Clutch - gearbox - automatic transmission – gearshift

###  Brake system - ABS - cruise control

###  Air conditioning - central locking

```
The user clicks on “Clutch - gearbox - automatic transmission - gearshift” (1H). We call again
the operation changing nodeId to “1H”:
```
1. ...
2. <data:repairtimeTypeId>8799</data:repairtimeTypeId>
3. <data:nodeId>1H</data:nodeId>
4. <data:searchText>replace clutch</data:searchText>
5. < **Error! Hyperlink reference not valid.** >QUICKGUIDES</data:carTypeGroup>
6. ...

The result will be:

1. ...
2. <description>Clutch mechanism</description>
3. <id>1H03001000</id>
4. ...
5. <description>Sensor - slave cylinder</description>
6. <id>1H03990000</id>
7. ...
8. <description>Clutch</description>
9. <id>1H06099000</id>
10. ...
11. <description>Clutch housing - gearbox</description>
12. <id>1H13700000</id>
13. ...

So, the tree should be:

###  Engine - electric - electronics - control units

###  Clutch - gearbox - automatic transmission – gearshift

###  Clutch mechanism

###  Sensor - slave cylinder

###  Clutch

###  Clutch housing - gearbox

###  Brake system - ABS - cruise control


247

###  Air conditioning - central locking

The user now clicks on Sensor - slave cylinder (1H03990000). We call the operation again with

nodeId = “1H03990000”:

1. ...
2. <data:repairtimeTypeId>8799</data:repairtimeTypeId>
3. <data:nodeId>1H03990000</data:nodeId>
4. <data:searchText>replace clutch</data:searchText>
5. < **Error! Hyperlink reference not valid.** >QUICKGUIDES</data:carTypeGroup>
6. ...

The result will be:

1. ...
2. <description> **Replace clutch master cylinder** </description>
3. <hasSubnodes>false</hasSubnodes>
4. <id> **1H03995000** </id>
5. <value> **120** </value>
6. ...
7. <description> **Replace clutch slave cylinder** </description>
8. <hasSubnodes>false</hasSubnodes>
9. <id> **1H04995000** </id>
10. <value> **70** </value>
11. ...
12. <description> **Replace clutch operation hydraulic line** </description>
13. <hasSubnodes>false</hasSubnodes>
14. <id> **1H05514950** </id>
15. <value> **110** </value>
16. ...

This is the last level (hasSubnodes is false and the value is not null). All these elements have in

their descriptions both “replace” and “clutch” search terms.

#### 11.2.8. getRepairtimeSubnodesSpecificTimesV4

This operation returns the tasks that are specific to the selected car and removes from the

view the generic times (like check horn, lighting, thread depth on tires, tire pressure)

It requires the following parameters:

###  descriptionLanguage - String (this should be a 2-character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  repairtimeTypeId – int (this value is in the result of previous operation call:

getRepairtimeTypes)


248

###  typeCategory – String – can be CAR or TRUCK (this value is in the result of the previous

operation call: getRepairtimeTypesV2)

###  nodeId – String (this number is the “id” of the node from the repair tree – ids of groups,

subgroups and repairs)

###  carTypeGroup – String (this string should be one of the constants: “MAINTENANCE”, “ENGINE”,

```
“TRANSMISSION”, ”BRAKES”, “STEERING”, ”EXTERIOR” - see chapter 3.1 for more details about
the groups)
```
This operation is remarkably similar with the “getRepairtimeSubnodesTextSearch” operation in

the way it should be used, except for the fact that there is not a search term for the tasks, but there is

a condition that the description of the task does not contain the character *. The difference between

V3 and V4 versions is that the results contain now oeCode and timeCriterias fields.

It returns all the sub-elements in the tree of the element set as nodeId that have repair tasks

containing the search terms. For example, if you set nodeId=”root”, it will return all the level 1

elements – groups – that have on the third level tasks with specific times. If you set the nodeId to a

level 1 element (“1A”) for example, the results will be only the sub-groups (the level 2 elements) that

contain tasks having specific times. Same thing for nodeId being a level 2 element (it will return level 3

elements related to the specified level2 element that have specific times).

#### 11.2.9. getDisclaimerV2

This operation returns the repair times disclaimer. This operation requires as parameters:

###  vehicleId - int (this id can be obtained by calling “getIdentificationTree()” operation, can be

null)

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  vehicle_level – String (this can be MAKE, MODEL, TYPE and MODEL_GROUP, can be null)

###  subject – String (should be REPAIRTIMES, REPAIR_TIMES or REPAIR-TIMES); when subject is null

repair manuals manufacturer disclaimer will be returned

This is an example request:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:data="http://data.webservice.workshop.vivid.nl">
2. <soapenv:Header/>
3. <soapenv:Body>
4. <data:getDisclaimerV2>


249

5. <data:vehicleId>26650</data:vehicleId>
6. <data:descriptionLanguage>en</data:descriptionLanguage>
7. <data:vehicle_level>TYPE</data:vehicle_level>
8. <data:subject> **REPAIRTIMES** </data:subject>
9. </data:getDisclaimerV2>
10. </soapenv:Body>
11. </soapenv:Envelope>

With response:

12. <soapenv:Envelope
    xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
13. <soapenv:Body>
14. <getDisclaimerV2Response
    xmlns="http://data.webservice.workshop.vivid.nl">
15. <getDisclaimerV2Return> **All job times are compiled from OEM**
    **documentation, using best practice experience. While every care has been**
    **taken to ensure accuracy in compiling this data, no responsibility can be**
    **accepted for any omissions or consequential damage and/or changes made by**
    **user.** </getDisclaimerV2Return>
16. </getDisclaimerV2Response>
17. </soapenv:Body>
18. </soapenv:Envelope>

In Workshop touch you see this disclaimer in Repair times page with yellow:


250

## 12. COMFORT ELECTRONICS AND AIR-CONDITIONING WIRING DIAGRAMS

### 12.1. Structure

“Comfort Electronics” and “Air-conditioning Wiring Diagrams” have the same structure. The

first one contains information about things like cooling fans, exterior lights, mobile phone

connections, navigation, CD changer, wipers, door locks, power tops, mirrors and so on. The second

one contains information only about air-conditioning.

The first step is a more refined identification of the car (based on year). This identification is

covered by this structure:

ExtWiringDiagramType {
String id;
Integer order;
String vehType;
Integer modelYear;
String startDate;
String endDate;
String exportCountry;
String enginePower;
String engineDisplacement;
String engineType;
String engineName;
Integer engineCylinders;
}


251

Figure 13.1.1 – Comfort Electronics – car type select

###  id : the id is an identifier for each type, unique within the response and it is used as parameter

```
when calling the operation for making the relation between the WiringDiagramTypes and the
next level
```
###  order : is an integer and gives the order within the response; the elements in the response are

already ordered, so you may not need to use this element.

###  vehType : this property is a String, and it contains the description of the car type based on

which the wiring diagrams are created

###  modelYear : this is an integer, and it represents the year when the car was built (the specific

car, not the car-type)

###  startDate : this property is a String, and it contains the start date of the car type in the

following format: YYYY-MM (1997-05)

###  endDate : this property is a String, and it contains the end date of the car type in the following

format: YYYY-MM (2000-05); if null, it means that it is still in production

###  exportCountry : this property is a String that contains the exporting country of the car in case

```
there are more; in the rest of the situations, it is null (for example, for “Golf III 1.8”, the
exporting country can be “BR”)
```
###  enginePower : is the power of the engine expressed in “kW” (for example “55”)


252

###  engineDisplacement : is the capacity of the engine expressed in cc (for example, 1390)

###  engineType : is the code of the engine (for example: “AKQ”)

###  engineName : is the name of the engine (for example: “ZPJ4”); it can be null

###  engineCylinders : is the number of cylinders of that engine (for example: “4”)

For each WiringDiagramType object, there is a set of systems. A system is represented by the

following structure:

ExtWiringSystem {
long id;
Integer order;
String valleySystem;
String valleyOptional;
}

###  id : is an identifier for each system, unique within each response. It is used to make the relation

between the system and the diagrams.

###  order : is an integer and gives the order within the response; the elements in the response are

```
already ordered, so you may not need to use this element. In this case, they are ordered
alphabetically for each language.
```
###  valleySystem : this property is a text that describes the system. There might be other systems

```
in the same response with the same description (but the next element, valleyOptional) will
make the description unique for each response.
```
###  valleyOptional : this property is an extra description for the system; it can be null.


253

Figure 13.1.2 – Wiring Diagrams – systems

For each system, there is at least one WiringDiagram. This diagram is described by the

following structure:

ExtWiringDiagram {
String numberOfSchematics;
String valleySubSystem;
String mimeDataName;
}

###  numberOfSchematics : this is a text that specifies the number of the diagram and the total

number of diagrams (for example: “1/5”, “2/5”, ...)

###  valleySubSystem : this is a description of the diagram (for example: “Comfort system control

module and anti-theft circuit”)

###  mimeDataName : this is a text that contains the URL to the schema


254

In each schema there are several components. In the schema they appear as codes (for

example “A268”). There is an operation that returns for each schema (based on the mimeDataName)

all the components that appear in it. Each component element has the following structure:

ExtWiringComponent {
String id;
String name;
String description;
}

###  id : this is a text that represents a unique identifier for each component in a schema. This id is

```
also the id of the tag-element inside the svg document, so it can be used to alter the image
according with the user input (for example, to center the component when the mouse is over
it is description)
```
###  name : this is the code of the component as it is shown in the diagram (for example “A268”)

###  description : this is the description of the component (language dependent; for example:

“Main fuse box”)

### 12.2. Operations

#### 12.2.1. getWiringDiagramTypesByGroup()

This operation returns the WiringDiagramTypes for a specified carTypeId. The text “ByGroup”

appears in the name of the operation because there “Comfort Electronics” belongs to the

“ELECTRONICS” group, the “Air-conditioning wiring diagrams” belongs to the “EXTERIOR” group

(“exterior” is in fact short for “exterior/interior”), the ABS diagrams belong to “BRAKES” and those for

engine in the “ENGINE” group. So, if you call the operation using the “electronics” group, it will return

the types for “Comfort Electronics”, if you call it using “exterior” group, it will return the air-

conditioning elements and so on.

This operation requires the following parameters when calling:

###  descriptionLanguage - String (this should be a 2-character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carTypeId – int (this number is the “id” of the Type found in ExtCarType; you can check chapter

3 for more information about this object)

###  carTypeGroup – String (this string should be one of the constants: ”EXTERIOR”, “ELECTRONICS”,

“BRAKES" or “ENGINE”)


255

This operation returns an array of ExtWiringDiagramType objects that represent all the specific

types for wiring diagrams. Before calling this operation, you can check ExtCarType.subjects and

ExtCarType.subjectsByGroup to see in it contains “WIRING_DIAGRAMS”. If it does, the operation will

return information. If not, it will return null.

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carType – int – 26650 (you should find “golf iv akq” and make sure it is the same id; if it is not,

replace 26650 with the id that you find in the response)

###  carTypeGroup: - String - ELECTRONICS

### The result of calling this operation is:

### 1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"

```
xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
```
2. <soapenv:Body>
3. <getWiringDiagramTypesByGroupResponse xmlns="http://data.webservice.workshop.vivid.nl">
4. <getWiringDiagramTypesByGroupReturn>
5. <endDate xsi:nil="true"/>
6. <engineCylinders> **4** </engineCylinders>
7. <engineDisplacement> **1390** </engineDisplacement>
8. <engineName xsi:nil="true"/>
9. <enginePower> **55** </enginePower>
10. <engineType> **AKQ** </engineType>
11. <exportCountry xsi:nil="true"/>
12. <id> **l_76933** </id>
13. <modelYear> **1997** </modelYear>
14. <order>0</order>
15. <startDate> **1997 - 10** </startDate>
16. <vehType> **Golf IV 1.4 ()** </vehType>
17. </getWiringDiagramTypesByGroupReturn>
18. <getWiringDiagramTypesByGroupReturn>
19. ...
20. <modelYear>1998</modelYear>
21. <order>1</order>
22. <startDate>1997-10</startDate>
23. <vehType>Golf IV 1.4 ()</vehType>
24. </getWiringDiagramTypesByGroupReturn>
25. ...


256

26. </soapenv:Body>
27. </soapenv:Envelope>

Figure 13.2.1.1 – Wiring Diagrams – types

1 - <vehType> **Golf IV 1.4 ()** </vehType> (line 16)
2 - <modelYear> **1997** </modelYear> (line 13)
3 - <startDate> **1997 - 10** </startDate> (line 15)
4 - <endDate xsi:nil="true"/> (line 5)
5 - <engineType> **AKQ** </engineType> (line 10)
6 - <engineDisplacement> **1390** </engineDisplacement> (line 7)
7 - <engineCylinders> **4** </engineCylinders> (line 6)
8 - <enginePower> **55** </enginePower> (line 9)

Calling the next operation will require setting this id as parameter:

<id> **l_76933** </id> (line 12)

#### 12.2.2. getWiringDiagramSystems()

This operation gets all the wiring diagrams systems for a specified wiringDiagramType.

It requires the following parameters:


257

###  descriptionLanguage - String (this should be a 2-character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  wiringDiagramTypeId – String (this is the id of the wiringDiagramType from the previous

example)

We will call this operation with the following parameters:

###  descriptionLanguage - String - en

###  wiringDiagramTypeId – String – l_76933

The result of calling this operation is:

### 1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"

```
xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
```
### 2. <soapenv:Body>

### 3. <getWiringDiagramSystemsResponse xmlns="http://data.webservice.workshop.vivid.nl">

### 4. <getWiringDiagramSystemsReturn>

### 5. <id> 100174 </id>

### 6. <order>0</order>

### 7. <valleyOptional> With power windows </valleyOptional>

### 8. <valleySystem> Anti-theft </valleySystem>

### 9. </getWiringDiagramSystemsReturn>

### 10. <getWiringDiagramSystemsReturn>

### 11. <id>100172</id>

### 12. <order>1</order>

### 13. <status xsi:nil="true"/>

### 14. <valleyOptional>Without power windows</valleyOptional>

### 15. <valleySystem>Anti-theft</valleySystem>

### 16. </getWiringDiagramSystemsReturn>

### 17. ...

### 18. </getWiringDiagramSystemsResponse>

### 19. </soapenv:Body>

### 20. </soapenv:Envelope>


258

Figure 3.2.2.1 – Wiring Diagrams – systems

### 1 - <valleySystem> Anti-theft </valleySystem> (line 8)

### 2 - <valleyOptional> With power windows </valleyOptional> (line 7)

To call the next operation, we will use this id:

### <id> 100174 </id> (line 5)

#### 12.2.3. getWiringDiagramSchemes()

This operation returns all the schemes for the specified system.

It requires the following parameters:

###  descriptionLanguage - String (this should be a 2-character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  wiringDiagramSystemId – int (this is the id of the system from the previous example)

We will call the operation with the following parameters:

###  descriptionLanguage - String - en

###  wiringDiagramSystemId – int – 100174


259

The result of calling this operation is:

### 1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"

```
xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
```
### 2. <soapenv:Body>

### 3. <getWiringDiagramSchemesResponse xmlns="http://data.webservice.workshop.vivid.nl">

### 4. <getWiringDiagramSchemesReturn>

### 5. <mimeDataName> http://www.haynespro-

```
services.com:8080/workshop/images/M3589.svgz </mimeDataName>
```
### 6. <numberOfSchematics> 1/5 </numberOfSchematics>

### 7. <valleySubSystem> Comfort system control module and anti-theft circuit </valleySubSystem>

### 8. </getWiringDiagramSchemesReturn>

### 9. ...

### 10. </getWiringDiagramSchemesResponse>

### 11. </soapenv:Body>

### 12. </soapenv:Envelope>

### Figure 13.2.3.1 – Wiring diagrams – schema

### 1 - <numberOfSchematics> 1/5 </numberOfSchematics> (line 6)

### 2 - <mimeDataName>http://www.haynespro-

services.com:8080/workshop/images/M3589.svgz</mimeDataName> (line 5)

### <valleySubSystem> Comfort system control module and anti-theft circuit </valleySubSystem>


260

(line 7)

To call the next operation, we will use the mimeDataName property.

#### 12.2.4. getWiringComponents()

This operation returns all the components that can be found in a scheme.

It requires the following parameters:

###  descriptionLanguage - String (this should be a 2 - character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  mimeDataName – String (this is the mimeDataName of the scheme from the previous example

- getWiringDiagramSystems)

We will call the operation with the following parameters:

###  descriptionLanguage - String - en

###  mimeDataName – String – http://www.haynespro-

### services.com:8080/workshop/images/M3589.svgz

The result of calling this operation is:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getWiringComponentsResponse xmlns="http://data.webservice.workshop.vivid.nl">
4. <getWiringComponentsReturn>
5. <description> **Main fuse box** </description>
6. <id> **comp_0001_A268** </id>
7. <name> **A268** </name>
8. </getWiringComponentsReturn>
9. <getWiringComponentsReturn>
10. <description>Fuse 14</description>
11. <id>comp_0001_F87</id>
12. <name>F87</name>
13. <status xsi:nil="true"/>
14. </getWiringComponentsReturn>
15. <getWiringComponentsReturn>
16. <description>Fuse 6</description>
17. <id>comp_0001_F1</id>
18. <name>F1</name>


261

19. <status xsi:nil="true"/>
20. </getWiringComponentsReturn>
21. ...
22. </getWiringComponentsResponse>
23. </soapenv:Body>
24. </soapenv:Envelope>

Figure 13.2.4.1 – Wiring Diagrams – components

1 - <name> **A268** </name> (line 7)
2 - <description> **Main fuse box** </description> (line 5)

This is a part of the content of the XML that makes the SVG file:

<g id=" **comp_0001_A268** " style="&st34;">
<text x="12.6" y="-17.35">A268</text>
</g>
<g id="comp_0001_F87" style="&st34;">
<text x="11.7" y="-17.095">F87</text>
</g>
<g id="comp_0001_F1" style="&st34;">
<text x="10.7" y="-17.095">F1</text>
</g>


262

The id of the “g” tag is “comp_0001_A268” which is also the id of the component returned by

the operation:

<id> **comp_0001_A268** </id> (line 6)

### 12.3. Annex – colour codes

In the diagrams there are codes used for wire colours. The legend for these codes is:

Code Colour

TAN Beige

BLK Black

BRN Brown

BLU Blue

GRN Green

GRY Gray

ORG Orange

PNK Pink

RED Red

VIO Violet

WHT White

YEL Yellow


263

## 13. CONVERTER

### 13.1. Introduction

The converter has the purpose of transforming some values from one or more measurement

units to another one or other ones.

All the operations in this chapter have a different endpoint and WSDL:

[http://www.haynespro-services.com/workshopServices3/services/ConverterEndpoint?wsdl](http://www.haynespro-services.com/workshopServices3/services/ConverterEndpoint?wsdl)

None of these operations require authentication.

### 13.2. Operations

The conversion operations are for toe, torque, pressure, volume, length, and speed

#### 13.2.1. Converting toe

This conversion has two operations. One transforms angle and diameter into toe, and the

other one from toe and diameter into angle.

**_13.2.1.1. convertToeMm_**

This operation requires 3 parameters:

###  degrees – integer – this represents the degrees part of the angle measurement

###  minutes – integer – this represents the minutes part of the angle measurement

###  rimDiameterInch – float – this represents the diameter of the rim represented in inch

The operation returns the toe represented in millimeters (mm).

**_13.2.1.2. covertToeReverse_**

This operation requires 2 parameters:

###  rimDiameterInch – float – this represents the diameter of the rim represented in inch

###  toeMm – float – this is the measurement of the toe in millimeters (mm)

The operation returns an array of two integers. The first element (result[0]) is the degrees part

of the angle and the second element (result[1]) is the minutes part of the angle.


264

#### 13.2.2. convertTorqueNmToFtPerLbs

This operation converts the torque from one unit to another and it requires one parameter:

###  nmValue – float – this represents the value of the torque measured in Nm (Newton meter)

The operation returns a float number that represents the torque as Ft Lbs (pound-feet).

#### 13.2.3. convertPressureBarToPsi

This operation converts pressure from Bar to Psi. It requires one parameter:

###  barValue – float – this represents the value of the pressure measured in Bar

This operation returns a float number that represents the pressure measured in Psi.

#### 13.2.4. convertVolumeLitersToPints

This operation converts volumes from liters to pints. It requires one parameter:

###  valueLiters – float – this represents the value of the volume measured in liters

This operation returns a float number that represents the volume measured in Pints.

#### 13.2.5. convertLengthMmToInches

This operation converts lengths from mm(millimeters) to inches. It requires one parameter:

###  mmValue – float – this represents the value of the length measured in millimeters

This operation returns a float number that represents the length measured in Inches.

#### 13.2.6. convertSpeedKphToMph

This operation converts speeds from Kph(Km/hour) to Mph(Miles/hour). It requires one

parameter:

###  kmphValue – float – this represents the value of the speed measured in Kilometers / hour

This operation returns a float number that represents the speed measured in Miles / hour


265

## 14. DATA EXPORT

The data export is a web-service that exports bulk data from our databases when it is needed.

For example, making a link between Vivid cars (makes, models and types) need to be linked manually

to other existing car identification.

The WSDL of this web-service is:

[http://www.haynespro-services.com/workshopServices3/services/ExportEndpoint?wsdl](http://www.haynespro-services.com/workshopServices3/services/ExportEndpoint?wsdl)

This web-service has been implemented to present the data in a structure that is like relational

database tables. For now, it will only return the data in the reply of the web-service, but the structure

allows that, in the future, the data to be also returned in links (URLs) to pages that contain the data in

different formats (like CSV, for example).

The object structure is the following:

ExtExport {

ExtTable[] tables;

String[] exportURLs;

ExtStatus status;

}

###  the tables element contains the description of the structure and the data for each table

involved in the export

###  exportURLs is not used for the moment; it will contain links to pages that present data in

different formats, according to the parameters in the request (xml, csv and so on)

###  the status will contain 0 if the request was successful or another number if there was an error

(the possible errors are presented in chapter 2.1)

ExtTable {

String tableName;

String[] columnTypes;

String[] columnNames;

ExtRow[] values;

}


266

###  tableName contains the name of the table

###  columnTypes is an array that contains the type of data for each column of the table (the order

```
is important as it is the same for column names and data); the types we have until now are (if
you are encountering a new type that is not in the following list, please contact us):
```
### ◦ integer

### ◦ text

### ◦ date (format: MM-yyyy)

###  columnNames: contain the names of the columns; each time you use the web-service, make

```
sure you take them in consideration as the order may change, new columns could be added, or
columns could be removed
```
###  values: is an array of complex objects that contain the values stored in the table

ExtRow {

String[] elements;

}

###  ‘elements’ is an array of text which contain on each position the value of the row for the

```
column specified by the columnNames (on the same array index) and the text value of each
element should be transformed to the type specified in the columnTypes (on the same array
index).
```
### 14.1. exportIdentification

The operation requires the following parameters:

###  distributorUsername – String – this is a username that is provided by us (which is different

from the one you use for the other web-services)

###  distributorPassword – String – this is a password which is provided by us

###  exportType – String – this text selects the way the data will be exported; for the moment, the

only accepted value is “ws”


267

## 15. EUROPEAN TYPE APPROVAL SEARCH

The WSDL for this web-service is:

[http://www.haynespro-services.com/workshopServices3/services/EtaServiceEndpoint?wsdl](http://www.haynespro-services.com/workshopServices3/services/EtaServiceEndpoint?wsdl)

This web-service searches for the cars (tecdoc type number and tecdoc engine number) that

are linked to a certain European Type Approval Number. This number is, in fact, used together with 2

other codes: variant code (eegVarCode) and implementation code (eegImplementCode)

### 15.1. findTecdocByEtk()

The request is formed by 2 main parts: authentication and search code.

These are the exact request parameters:

###  distributorUsername: authentication (text)

###  distributorPassword: authentication (text)

###  typeApprovalNumber : this is part of the search; it represents the main part of the it and it is

```
mandatory (there should be at least the 4 consecutive characters from it, from any part of the
code, preferably the most significant ones for a more precise result) – example:
E1*01/116*0254*10
```
###  eggVarCode : this is also part of the search terms; it is optional, and it represents the variant

```
code of the car (<<"type of vehicle" means vehicles of a particular category which do not differ
in at least the essential respects specified in Section B of Annex II. A type of vehicle may
contain variants and versions>> - according to the “Directive 2007/46/EC of the European
Parliament”); example: LBRFF1
```
###  eggImplementCode : this is the third element of the search terms; it is optional – example:

FM6XG0R4F600GGQ

**NOTE** : the varCode and implementCode are looked for from left to right (for example, if you enter

FM6X, the search will be successful, but if you look for M6X, the result might be empty or wrong).

Even though the last two search terms (varCode and implementCode) are optional, setting

them would result in a much more precise response.

The **structure** of the **result** of this operation is a **list** of complex objects. Each such object

contains two numbers: the **tecdoc type number** and the **tecdoc engine number**. The first (type

number) is always present and the second one (engine number) may be null.


268

Here is a full example:

###  request:

##### 1. ...

2. <etk:distributorUsername>***</etk:distributorUsername>
3. <etk:distributorPassword>***</etk:distributorPassword>
4. <etk:typeApprovalNumber>E1*01/116*0254*10</etk:typeApprovalNumber>
5. <etk:eegVarCode>LBRFF1</etk:eegVarCode>
6. <etk:eegImplementCode>FM6XG0R4F600GGQ</etk:eegImplementCode>
7. ...

###  response:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <findTecdocByEtkResponse xmlns="http://etk.data.webservices.workshop.vivid.nl">
4. <findTecdocByEtkReturn>
5. <ktypNr>19232</ktypNr>
6. <motNr>18748</motNr>
7. </findTecdocByEtkReturn>
8. <findTecdocByEtkReturn>
9. <ktypNr>19233</ktypNr>
10. <motNr>18748</motNr>
11. </findTecdocByEtkReturn>
12. </findTecdocByEtkResponse>
13. </soapenv:Body>
14. </soapenv:Envelope>

### 15.2. findVarcodesAndImplCodesByTypeApprovalNumber

This operation returns all eggVarCodes (variant codes of the car) and the corresponding

eggImplementCodes (imlementation codes) for each eggVarCode.

The request is formed by 2 main parts: authentication and search code.

These are the exact request parameters:

###  distributorUsername: authentication (text)

###  distributorPassword: authentication (text)

###  typeApprovalNumber : this is part of the search; it represents the main part of the it and it is

```
mandatory (there should be at least the 4 consecutive characters from it, from any part of the
code, preferably the most significant ones for a more precise result) – example:
```

269

E1*01/116*0254*10

Here is a full example:

###  request:

###  ...

###  <etk:distributorUsername>***</etk:distributorUsername>

###  <etk:distributorPassword>***</etk:distributorPassword>

###  <etk:typeApprovalNumber>E1*01/116*0254*10</etk:typeApprovalNumber>

###  ...

###  response:

###  <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"

```
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
```
###  <soapenv:Body>

###  <findVarcodesAndImplCodesByTypeApprovalNumberResponse

```
xmlns="http://etk.data.webservices.workshop.vivid.nl">
```
###  <findVarcodesAndImplCodesByTypeApprovalNumberReturn>

###  <eggImplementationCodes>

### 

```
<eggImplementationCodes>FAVJN0R4F600GGQ</eggImplementationCodes>
```
### 

```
<eggImplementationCodes>FAVJN0R4F800GGR</eggImplementationCodes>
```
### 

```
<eggImplementationCodes>FM6XC0R4F600GGQ</eggImplementationCodes>
```
###  </eggImplementationCodes>

###  <eggVarCode>AAUKF1</eggVarCode>

###  </findVarcodesAndImplCodesByTypeApprovalNumberReturn>

###  ...

###  <findVarcodesAndImplCodesByTypeApprovalNumberReturn>

###  <eggImplementationCodes>

### 

```
<eggImplementationCodes>QA6LA0R4F600GGR</eggImplementationCodes>
```
### 

```
<eggImplementationCodes>QA6LA0R4F907GGS</eggImplementationCodes>
```

270

###  </eggImplementationCodes>

###  <eggVarCode>LBSGQ1</eggVarCode>

###  </findVarcodesAndImplCodesByTypeApprovalNumberReturn>

###  </findVarcodesAndImplCodesByTypeApprovalNumberResponse>

###  </soapenv:Body>

###  </soapenv:Envelope>

### 15.3. findCarTypesByEtk

This operation searches for the car types that are linked to a certain European Type Approval

Number. This number is, in fact, used together with 2 other codes: variant code (eegVarCode) and

implementation code (eegImplementCode).

The request is formed by 2 main parts: authentication and search code.

These are the exact request parameters:

###  distributorUsername: authentication (text)

###  distributorPassword: authentication (text)

###  typeApprovalNumber : this is part of the search; it represents the main part of the it and it is

```
mandatory (there should be at least the 4 consecutive characters from it, from any part of the
code, preferably the most significant ones for a more precise result) – example:
E1*01/116*0254*10
```
###  eggVarCode : this is also part of the search terms; it is optional, and it represents the variant

```
code of the car (<<"type of vehicle" means vehicles of a particular category which do not differ
in at least the essential respects specified in Section B of Annex II. A type of vehicle may
contain variants and versions>> - according to the “Directive 2007/46/EC of the European
Parliament”); example: LBRFF1
```
###  eggImplementCode : this is the third element of the search terms; it is optional – example:

FM6XG0R4F600GGQ

###  descriptionLanguage String (this should be a 2-character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

**NOTE** : the varCode and implementCode are looked for from left to right (for example, if you enter

FM6X, the search will be successful, but if you look for M6X, the result might be empty or wrong).

Even though the last two search terms (varCode and implementCode) are optional, setting

them would result in a much more precise response.


271

Here is a full example:

###  ...

###  <etk:distributorUsername>***</etk:distributorUsername>

###  <etk:distributorPassword>***</etk:distributorPassword>

###  <etk:typeApprovalNumber>E1*01/116*0254*10</etk:typeApprovalNumber>

###  <etk:eegVarCode>LBRFF1</etk:eegVarCode>

###  <etk:eegImplementCode>FM6XG0R4F600GGQ</etk:eegImplementCode>

###  <etk:descriptionLanguage></etk:descriptionLanguage>

###  ...

###  response:

##### 196. ...

197. <findCarTypesByEtkResponse
    xmlns="http://etk.data.webservices.workshop.vivid.nl">
198. <findCarTypesByEtkReturn>
199. <capacity>1968</capacity>
200. <criteria xsi:nil="true"/>
201. <engineCode>BRF</engineCode>
202. <fuelType>
203. <fuelType>DIESEL</fuelType>
204. </fuelType>
205. <fullName>AUDI A6 /A6 Allroad (2006 ->) (4F) 2.0 TDi 16V
    (DPF)</fullName>
206. <id>73020</id>
207.
    <image>http://localhost:8080/workshop/images/a6_my04_dba_soest.jpg</image>
208. <level>TYPE</level>
209. <madeFrom>2005-01</madeFrom>
210. <madeUntil>2009-01</madeUntil>
211. <name>2.0 TDi 16V (DPF)</name>
212. <order>0</order>
213. <output>100</output>
214. <status xsi:nil="true"/>
215. <subElements xsi:nil="true"/>
216. <subjects>
217. <subjects>ADJUSTMENTS</subjects>
218. ...
219. <subjects>CASES</subjects>
220. </subjects>
221. <subjectsByGroup>
222. <mapItems>
223. <item>
224. <key>ENGINE</key>
225.


272

```
<value>ADJUSTMENTS,LUBRICANTS,STORIES,REPAIR_TIMES,TSB,CASES</value>
```
226. </item>
227. ...
228. <item>
229. <key>QUICKGUIDES</key>
230.
    <value>ADJUSTMENTS,LUBRICANTS,STORIES,DRAWINGS,REPAIR_TIMES,TSB,CASES</value>
231. </item>
232. </mapItems>
233. </subjectsByGroup>
234. <superElementId>450</superElementId>
235. <superElementLevel>MODEL</superElementLevel>
236. <tonnage xsi:nil="true"/>
237. </findCarTypesByEtkReturn>
238. </findCarTypesByEtkResponse>
239. </soapenv:Body>
Directive 2007/46/EC of the European Parliament and of the Council of 5 September 2007 establishing a framework for the
approval of motor vehicles and their trailers, and of systems, components and separate technical units intended for such
vehicles
_“For the purposes of category M1:
A "type" shall consist of vehicles which do not differ in at least the following essential respects:
- the manufacturer,
- the manufacturer’s type designation,
- essential aspects of construction and design:
- chassis/floor pan (obvious and fundamental differences),
- power plant (internal combustion/electric/hybrid).
"Variant" of a type means vehicles within a type which do not differ in at least the following essential respects:
- body style (e.g., saloon, hatchback, coupé, convertible, station-wagon, multi-purpose vehicle),
- power plant:
- working principle (as in item 3.2.1.1 of Annex III),
- number and arrangement of cylinders,
- power differences of more than 30 % (the highest is more than 1,3 times the lowest),
- capacity differences of more than 20 % (the highest is more than 1,2 times the lowest),
- powered axles (number, position, interconnection),
- steered axles (number and position).
"Version" of a variant means vehicles, which consist of a combination of items shown in the information package subject to
the requirements in Annex VIII.
Multiple entries of the following parameters may not be combined within one version:
- technically permissible maximum laden mass,
- engine capacity,
- maximum net power,
- type of gearbox and number of gears,
- maximum number of seating positions as defined in Annex II C.”_

(http://eur-lex.europa.eu/LexUriServ/LexUriServ.do?uri=OJ:L:2007:263:0001:01:EN:HTML )


273

## 16. TECHNICAL SERVICE BULLETINS (TSB)

### 16.1. Structure

Technical Service Bulletins is a subject related directly to Vivid Car Types. They can be filtered

based on main groups (Engine, Transmission, Steering and Suspension, Brakes, Exterior & Interior and

Quickguides – where all the information for adjustments is presented on the same page).

The Service Bulletins are grouped in categories (for example: Service Bulletin, Recall, Case),

then into Systems (which represent the central element of this subject, the bulletin – for example

“Abnormal engine noise”) - sometimes together with some Criteria on when it applies (based on build

year, transmission type or others). Each system has an id based on which the details of the bulletins

can be retrieved. Each bulletin is also composed of a group (for example Symptom, Solution, Parts

Required, ...) and in each group one or more elements with the descriptions and values.

ExtTSBCategoryV3 {
**String** categoryDescription;
**ExtTSBSystemV3[]** systems;
}

###  categoryDescription : this is a text which is language dependent and describes the category

###  systems : this is a list of complex elements with general details about the bulletin (as describes

next)

ExtTSBCategoryV4 {
**String** categoryDescription;
**ExtTSBSystemV3[]** systems;
**String** categoryTypeConstant;
}

ExtTSBCategoryV5 {
**String** categoryDescription;
**ExtTSBSystemV4[]** systems;
**String** categoryTypeConstant;
}

###  categoryTypeConstant : this is a text which is not language dependent and describes the

```
category in order to be used by the application (so it can distinguish between the three types
of elements). These constants are TSB, CASE, RECALL
```
ExtTSBSystemV3{
**String** systemDescription;
**String** oeCode;
**ExtTSBCriteria[]** criteria;
**Integer** systemId;


274

##### }

ExtTSBSystemV4{
**String** systemDescription;
**String** oeCode;
**ExtTSBCriteria[]** tsbCriteria;
**ExtCriteriaGroup[]** storyCriteria;
**Integer** systemId;
}

###  systemDescription : this is a language dependent text which describes the bulletin

###  oeCode : this text is not language dependent, and it represents the OE code

###  criteria/tsbCriteria : this is an array of complex objects which, when present (can be null),

```
establishes when the data in the bulletin applies (build dates, transmission types, transmission
codes, VIN numbers or others). The structure of this complex object will be described next
```
###  storyCriteria : this property contains an array of ExtCriteriaGroup objects. Each object stores all

```
maintenance criteria grouped by criteria groups. Each criteria group can have more than one
general criterion linked. These criteria can be linked both to a description and a remark and we
can find out which criteria level is by using the field criteriaLevel.
```
###  systemId : this is a number based on which the details of a service bulletin (system) are

retrieved.

ExtTSBCriteria {
**ExtMapItem[]** values;
}

###  values : complex object similar to a map/dictionary (key-value pairs)

ExtMapItem {
**String** key;
**String** value;
}

###  key : text which is not language dependent (constant values)

###  value : text value corresponding to the key

In this case, the keys can be:

###  BODY_STYLE: this represents the body type of the car (for example: “Estate”, “Hatchback” or “Mini-van”)

###  DAM_FROM: the start of an interval of DAM codes (DAM means “Date Application Modification”, mainly used by

```
Peugeot and Citroen)
```
###  DAM_TO: the end of a DAM codes interval

###  DATE_FROM: this is the start date (format: YYYY-MM; for example, 2010-06)

###  DATE_TO: this is the end date (same format)

###  ENGINE_FROM: the start of an interval of engines (for example: 0020593)

###  ENGINE_TO: the end of an interval of engines (for example: 0042724); they are not always both from and to


275

```
present
```
###  VIN_FROM: the start of an interval of Vehicle Identification Numbers (see European Type Approval numbers for

```
more information about VINs)
```
###  VIN_TO: the end of a VIN interval

###  TRANSMISSION_TYPE: a language dependent text representing the type of transmission (for example “Automatic”

```
or “Manual”)
```
###  TRANSMISSION_CODE: the code of a transmission (for example: iB5MTX-75, MMT6, AWF21)

###  TRANSMISSION_FROM: the start of a transmission codes interval

###  TRANSMISSION_TO: the end of a transmission codes interval (for example: DS450406576)

In time more can appear, and they will be added to the documentation.

ExtTSBGroupV3{
String groupDescription;
ExtTSBDataElementV3[] bulletin;
}

###  groupDescription : this is a language dependent text which represents the description of the

group (for example Symptom, Solution, Parts Required, ...)

###  bulletin : this is a list of complex objects which contain the details of the bulletin as described

next

ExtTSBDataElementV3 {
String text;
String remark;
String image;
String EOBDCode;
String OECode;
String issueDate;
Integer repairTime;
ExtSmartLink[] smartLinks;
ExtSpecialTool[] specialTools;
ExtTableContent tableContent;
}

###  text : this is a language dependent text which contains bulletin data

###  remark : this is a language dependent text which may contain (can be null) extra information

###  image : this is a text which may contain (can be null) a URL to an image

###  EOBDCode : this is a text which may contain (can be null) an EOBD code

###  OECode : this is a text which may contain (can be null) an OE code

###  issueDate : this is a text that can contain a data (can be null) at which the bulletin was issued;

the format is DD/MM/YYYY (DD – day, MM – month; YYYY - year)

###  repairTime : this is a number (integer) which may contain (can be null) the time to perform the

specified repair. The value is a number with 2 decimals to which the decimal point has been


276

```
moved 2 positions to the right (for example: 1.2 hours is represented as 120; 1.2h = 1 hour and
60minutes*0.2 = 1 hour and 12 minutes)
```
###  smartLinks – used in getTSBDataV4, getRecallDataV3, getSmartCaseDataV3, ; this is a list of

links from tsb to other subjects. For more info about smart links, please see chapter 6.2.4.

###  ExtSpecialTool: this property is an array of ExtSpecialTool objects. It describes the special tools

that should be used for the linked bulletin.

###  ExtTableContent: this property is an object that contains the total number of rows and

columns of a table and the value of each individual cell.

### 16.2. Operations

#### 16.2.1. getTSBSystemsV3

This operation returns the TSB categories which contain the TSB systems.

These are the required parameters for calling the operation:

###  descriptionLanguage - String (this should be a 2-character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carTypeId – int (this number is the “id” of the Type found in ExtCarType; you can check chapter

3 for more information about this object)

###  carTypeGroup - (this group is the same as in table 3.1.2). It can be:

### ◦ ENGINE

### ◦ TRANSMISSION

### ◦ STEERING

### ◦ BRAKES

### ◦ EXTERIOR

### ◦ ELECTRONICS

### ◦ QUICKGUIDES

In order to find out if a specific car has Recalls or SmartCases data available in our database,

you can check the ExtCarType object (see chapter 3 on how to get an ExtCarType). If it has “TSB”,

“CASES” or “RECALLS” inside a “subject” or group-subject element, the data is available for this call.

Request example:


277

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:data="http://data.webservice.workshop.vivid.nl">
2. <soapenv:Header/>
3. <soapenv:Body>
4. <data:getTSBSystemsV3>
5. <data:vrid>60E133A847DE6494486D4B2D551EEC76</data:vrid>
6. <data:descriptionLanguage>en</data:descriptionLanguage>
7. <data:carTypeId>26600</data:carTypeId>
8. <data:carTypeGroup>QUICKGUIDES</data:carTypeGroup>
9. </data:getTSBSystemsV3>
10. </soapenv:Body>
11. </soapenv:Envelope>

Response example:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getTSBSystemsV3Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getTSBSystemsV3Return>
5. <categoryDescription>Service Bulletin</categoryDescription>
6. <status xsi:nil="true"/>
7. <systems>
8. <item>
9. <criteria xsi:nil="true"/>
10. <oeCode>B2CW2DQ0</oeCode>
11. <systemDescription>Oil leakage from the automatic transmission</systemDescription>
12. <systemId>102000004</systemId>
13. </item>
14. ...
15. <item>
16. <criteria>
17. <item>
18. <values>
19. <item>
20. <key>DAM_TO</key>
21. <value>10432</value>
22. </item>
23. </values>
24. </item>
25. </criteria>
26. <issueDate>03/03/2007</issueDate>
27. <oeCode>B2CW1CK1</oeCode>
28. <systemDescription>First and second gear cannot be engaged; Gearbox slippage</systemDescription>
29. < **systemId** > **300000256** </systemId>
30. </item>
31. </systems>


278

32. </getTSBSystemsReturn>
33. </getTSBSystemsResponse>
34. </soapenv:Body>
35. </soapenv:Envelope>

#### 16.2.2. getTSBDataV4, getRecallDataV3 and getSmartCaseDataV3

These operations return the TSB, Recall or SmartCase groups which contain the data-elements.

These are the required parameters for calling the operation:

###  descriptionLanguage - String (this should be a 2-character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  systemId: - Integer – this value should be set based on the value found in the

ExtTSBSystem.systemId in the result of the previous operation call

###  carTypeId: – int (this number is the “id” of the Type found in ExtCarType; you can check

chapter 3 for more information about this object)

```
Compared with previous versions, these operations have carTypeId in request which is now used
to populate the smartLinks field like other subjects.
```
Request example:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:data="http://data.webservice.workshop.vivid.nl">
2. <soapenv:Header/>
3. <soapenv:Body>
4. <data:getTSBDataV4>
5. <data:vrid>60E133A847DE6494486D4B2D551EEC76</data:vrid>
6. <data:descriptionLanguage>en</data:descriptionLanguage>
7. <data:systemId> **301000672** </data:systemId>
8. <data:carTypeId> **54200** </data:carTypeId>
9. </data:getTSBDataV4>
10. </soapenv:Body>
11. </soapenv:Envelope>

Result example:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getTSBDataV4Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getTSBDataV4Return>
5. <bulletin>


279

6. <item>
7. <EOBDCode xsi:nil="true"/>
8. <OECode xsi:nil="true"/>
9. <image xsi:nil="true"/>
10. <remark xsi:nil="true"/>
11. <repairTime xsi:nil="true"/>
12. <smartLinks>
13. <smartLinks>
14. <filter xsi:nil="true"/>
15. <id1>0</id1>
16. <id2 xsi:nil="true"/>
17. <operation xsi:nil="true"/>
18. <text>
19. <text> **Air conditioning** </text>
20. <text/>
21. <text xsi:nil="true"/>
22. <text> **Air conditioning : General data** </text>
23. </text>
24. </smartLinks>
25. ...
26. <smartLinks>
27. <filter xsi:nil="true"/>
28. <id1>0</id1>
29. <id2 xsi:nil="true"/>
30. <operation xsi:nil="true"/>
31. <text>
32. <text> **Air-conditioning compressor oil, system total** </text>
33. <text> **90 ± 10** </text>
34. <text> **(ml** )</text>
35. <text> **Denso, Air-conditioning compressor, 6SEU14C** </text>
36. </text>
37. </smartLinks>
240. <groupDescription> **Solution** </groupDescription>
38. <status xsi:nil="true"/>
39. </getTSBDataV4Return>
40. ...
41. <getTSBDataV4Return>
42. <bulletin>
43. <item>
44. <EOBDCode xsi:nil="true"/>
45. <OECode>25001A</OECode>
46. <image xsi:nil="true"/>
47. <remark></remark>
48. < **repairTime** > **120** </repairTime>
49. <smartLinks xsi:nil="true"/>
50. <text>Remove the metal filings</text>


280

51. </item>
52. </bulletin>
53. <groupDescription> **Repair time** </groupDescription>
54. <status xsi:nil="true"/>
55. </getTSBDataV4Return>
56. </getTSBDataV4Response>
57. </soapenv:Body>
58. </soapenv:Envelope>

Figure 17.2.2 – getTSBDataV4 including sentence links (lines 13-37)

#### 16.2.3. filterTSBSystemsV3

This operation offers search functionality. It requires one or more words to look for, and a car

for which the search will take place. The words are looked for in the description (titles) of the

Technical Service Bulletins and in the text fields of the bulletins data. If a bulletin contains all the

searched words, the system is included in the result. Because only the systems are presented in the

result (and not the actual content of the bulletins), we considered that the “filter” describes better the

functionality than “find” or “search”.

These are the required parameters for calling the operation:

###  descriptionLanguage - String (this should be a 2-character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carTypeId – int (this number is the “id” of the Type found in ExtCarType; you can check chapter

3 for more information about this object)

###  carTypeGroup - (this group is the same as in table 3.1.2). It can be:

### ◦ ENGINE


281

### ◦ TRANSMISSION

### ◦ STEERING

### ◦ BRAKES

### ◦ EXTERIOR

### ◦ ELECTRONICS

### ◦ QUICKGUIDES

###  searchedText – String – the words to look for in the bulletin's content

Request example:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:data="http://data.webservice.workshop.vivid.nl">
2. <soapenv:Header/>
3. <soapenv:Body>
4. <data:filterTSBSystemsV3>
5. <data:vrid>60E133A847DE6494486D4B2D551EEC76</data:vrid>
6. <data:descriptionLanguage> **en** </data:descriptionLanguage>
7. <data:carTypeId> **105000112** </data:carTypeId>
8. <data:carTypeGroup> **STEERING** </data:carTypeGroup>
9. <data:searchedText> **bolt** </data:searchedText>
10. </data:filterTSBSystemsV3>
11. </soapenv:Body>
12. </soapenv:Envelope>

Response example:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <filterTSBSystemsV3Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <filterTSBSystemsV3Return>
5. <categoryDescription>Service Bulletin</categoryDescription>
6. <status xsi:nil="true"/>
7. < **systems** >
8. <item>
9. <criteria>
10. <item>
11. <values>
12. <item>
13. <key>DAM_TO</key>
14. <value>11795</value>


282

15. </item>
16. </values>
17. </item>
18. </criteria>
19. <issueDate xsi:nil="true"/>
20. <oeCode>B3EW0102Q0</oeCode>
21. < **systemDescription** > **Play in the steering wheel** </systemDescription>
22. < **systemId** > **300000095** </systemId>
23. </item>
24. </systems>
25. </filterTSBSystemsV3Return>
26. </filterTSBSystemsV3Response>
27. </soapenv:Body>
28. </soapenv:Envelope>

Request for system 300000095 and carTypeId 54200:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:data="http://data.webservice.workshop.vivid.nl">
2. <soapenv:Header/>
3. <soapenv:Body>
4. <data:getTSBDataV4>
5. <data:vrid>60E133A847DE6494486D4B2D551EEC76</data:vrid>
6. <data:descriptionLanguage>en</data:descriptionLanguage>
7. <data:systemId> **300000095** </data:systemId>
8. <data:carTypeId> **54200** </data:carTypeId>
9.
10. </data:getTSBDataV4>
11. </soapenv:Body>
12. </soapenv:Envelope>

Response for system 300000095:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getTSBDataV4Response xmlns="http://data.webservice.workshop.vivid.nl">
4. ...
5. <getTSBDataV4Return>
6. <bulletin>
7. <item>
8. <EOBDCode xsi:nil="true"/>
9. <OECode xsi:nil="true"/>
10. <image xsi:nil="true"/>
11. <remark></remark>
12. <repairTime xsi:nil="true"/>
13. <smartLinks xsi:nil="true"/>


283

14. < **text** >Renew the **bolt** (s)</text>
15. </item>
16. </bulletin>
17. <groupDescription>Solution</groupDescription>
18. <status xsi:nil="true"/>
19. </getTSBDataV4Return>
20. ...
21. </getTSBDataV4Response>
22. </soapenv:Body>
23. </soapenv:Envelope>

#### 16.2.4. getSmartPackFaultCodes()

This operation returns the SmartCase and SmartFix bulletins for a certain car, searching by fault

codes. The operation takes into consideration the user license, so if the user has license only for

SmartCase , only those bulletins will be displayed.

The operation needs the following parameters:

###  descriptionLanguage - String (this should be a 2-character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carTypeId - int (this number is the “id” of the Type found in ExtCarType; you can check chapter

3 for more information about this object)

###  faultCode - String[] (one or more fault codes, used as the search criteria for the bulletins that

will be returned)

Request example:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:data="http://data.webservice.workshop.vivid.nl">
2. <soapenv:Header/>
3. <soapenv:Body>
4. <data:getSmartPackFaultCodes>
5. <data:vrid>7B35931E508CED63C06B6CDA504C1FE6</data:vrid>
6. <data:descriptionLanguage>en</data:descriptionLanguage>
7. <data:carTypeId>55140</data:carTypeId>
8. <!--1 or more repetitions:-->
9. <data:faultCode>C1142</data:faultCode>
10. <data:faultCode>P0200</data:faultCode>
11. <data:faultCode>P0625</data:faultCode>
12. </data:getSmartPackFaultCodes>
13. </soapenv:Body>
14. </soapenv:Envelope>

Response example:


284

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getSmartPackFaultCodesResponse xmlns="http://data.webservice.workshop.vivid.nl">
4. <getSmartPackFaultCodesReturn>
5. <categoryDescription>SmartFIX</categoryDescription>
6. <categoryTypeConstant>TSB</categoryTypeConstant>
7. <status xsi:nil="true"/>
8. <systems>
9. <systems>
10. <criteria>
11. <criteria>
12. <values>
13. <values>
14. <key>DATE_FROM</key>
15. <value>2004-07</value>
16. </values>
17. </values>
18. </criteria>
19. </criteria>
20. <issueDate>02/02/2012</issueDate>
21. <oeCode>56/2011</oeCode>
22. <systemDescription>The brake warning light illuminates</systemDescription>
23. <systemId>301002995</systemId>
24. </systems>
25. <systems>
26. <criteria>
27. <criteria>
28. <values>
29. <values>
30. <key>DATE_FROM</key>
31. <value>2004-06</value>
32. </values>
33. <values>
34. <key>VIN_FROM</key>
35. <value>**********4K*****</value>
36. </values>
37. </values>
38. </criteria>
39. </criteria>
40. <issueDate>03/11/2010</issueDate>
41. <oeCode>44/2010</oeCode>
42. <systemDescription>Fuel leakage; Power loss</systemDescription>
43. <systemId>300000178</systemId>
44. </systems>
45. </systems>


285

46. </getSmartPackFaultCodesReturn>
47. <getSmartPackFaultCodesReturn>
48. <categoryDescription>SmartCASE</categoryDescription>
49. <categoryTypeConstant>CASE</categoryTypeConstant>
50. <status xsi:nil="true"/>
51. <systems>
52. <systems>
53. <criteria xsi:nil="true"/>
54. <issueDate xsi:nil="true"/>
55. <oeCode xsi:nil="true"/>
56. <systemDescription>The engine warning light illuminates; The battery charge warning light
    illuminates</systemDescription>
57. <systemId>301001292</systemId>
58. </systems>
59. </systems>
60. </getSmartPackFaultCodesReturn>
61. </getSmartPackFaultCodesResponse>
62. </soapenv:Body>
63. </soapenv:Envelope>

#### 16.2.5. getRecallSystemsV3(), filterRecallSystemsV3(), getCasesSystemsV3() and filterCasesSystemsV3()

These four operations are the same as getTSBSystemsV3 and filterTSBSystemsV3. They require

the same parameters (except for recalls where there is not a group filtering – as engine, transmission)

when calling them and they return the data in the same format as the “TSB” operations. The only

difference is in the data they present:

###  getRecallSystems and filterRecallSystems return data that represents Recalls issued by the

manufacturer

###  getCasesSystems and filterCasesSystems retrun data that represent SmartCases (common

problems for specific cars and solutions for them)

In order to find out if a specific car has Recalls or SmartCases data available in our database, you can

check the ExtCarType object (see chapter 3 on how to get an ExtCarType). If the “subjects” or group-

subjects contain “RECALLS” (for Recalls) or “CASES” (for SmartCases), then the corresponding data is

available by using these operations

#### 16.2.6. getTSBCasesRecallsSystemsV4() and filterTSBCasesRecallsSystemsV4()

These two operations are the same as the getTSBSystemsV3, filterTSBSystemsV3,

getRecallsSystemsV3, filterRecallsSystemsV3, getCasesSystemsV3 and filterCasesSystemsV3. They

require the same parameters, and they return the data structured the same way.


286

The difference is that they return the data for all “Techincal Service Bulletins”, “Recalls” and

“SmartCases”, depending on the licence that the user has (if “SmartCases” is not in the licence of the

user, only the existing “TSB”s and “Recalls” will be returned, with no other warning or error). They also

return a constant (see ExtTSBCategoryV4) in each group of TSBs, RECALLs and CASEs.

#### 16.2.7. filterTSBCasesRecallsStories()

This method encompasses all the functionality provided by the filterTSBCasesRecallsSystemsV4

with the additional capability of searching for repair manuals as well.

Like filterTSBCasesRecallsSystemsV4 it uses one or more words to look for, a car and an additional

repair task id (aw number) to match against the repair manual. The words are looked for in the

description (titles) of the manuals.

The operation needs the following parameters:

###  descriptionLanguage - String (this should be a 2-character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carTypeId – int (this number is the “id” of the Type found in ExtCarType; you can check chapter

3 for more information about this object)

###  carTypeGroup - (this group is the same as in table 3.1.2). It can be:

### ◦ ENGINE

### ◦ TRANSMISSION

### ◦ STEERING

### ◦ BRAKES

### ◦ EXTERIOR

### ◦ ELECTRONICS

### ◦ QUICKGUIDES

###  searchedText – String – the words to look for in the bulletin's content and manual’s title

###  repairTaskIds – String[] - this is an array of ids of the Repair nodes from the repair tree (the last

level of the repair tree – see getRepairtimeSubnodesByGroupV2) that the user selects

Request example:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"


287

```
xmlns:data="http://data.webservice.workshop.vivid.nl">
```
2. <soapenv:Header/>
3. <soapenv:Body>
4. <data:filterTSBCasesRecallsStories>
5. <data:vrid>7B35931E508CED63C06B6CDA504C1FE6</data:vrid>
6. <data:descriptionLanguage>en</data:descriptionLanguage>
7. <data:carTypeId>102001964</data:carTypeId>
8. <data:carTypeGroup>QUICKGUIDES</data:carTypeGroup>
9. <data:searchedText>Diesel</data:searchedText><!-- Optional -->
10. <!--1 or more repetitions:-->
11. <data:repairTaskIds>1G00010150</data:repairTaskIds><!-- Optional and does not require WV postfix -->
12. </data:filterTSBCasesRecallsStories>
13. </soapenv:Body>
14. </soapenv:Envelope>

Response example:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <filterTSBCasesRecallsStoriesResponse xmlns="http://data.webservice.workshop.vivid.nl">
4. <filterTSBCasesRecallsStoriesReturn>
5. <categoryDescription>SmartFIX</categoryDescription>
6. <categoryTypeConstant>TSB</categoryTypeConstant>
7. <status>
8. <confirmationLink xsi:nil="true"/>
9. <statusCode>0</statusCode>
10. </status>
11. <systems>
241. ...
242. </systems>
243. </filterTSBCasesRecallsStoriesReturn>
244. <filterTSBCasesRecallsStoriesReturn>
245. <categoryDescription>SmartCASE</categoryDescription>
246. <categoryTypeConstant>CASE</categoryTypeConstant>
247. <status xsi:nil="true"/>
248. <systems>
249. ....
250. </systems>
251. </filterTSBCasesRecallsStoriesReturn>
252. <filterTSBCasesRecallsStoriesReturn>
253. <categoryDescription xsi:nil="true"/>
254. <categoryTypeConstant>STORY</categoryTypeConstant>
255. <status xsi:nil="true"/>


288

256. <systems>
257. <item>
258. <issueDate xsi:nil="true"/>
259. <oeCode xsi:nil="true"/>
260. <storyCriteria>
261. <item>
262. <groupCriterias>
263. <item>
264. <criteriaId>319007069</criteriaId>
265. <criteriaLevel>DESCRIPTION</criteriaLevel>
266. <description>4WD</description>
267. <value1 xsi:nil="true"/>
268. <value2 xsi:nil="true"/>
269. </item>
270. </groupCriterias>
271. <groupDescription>Drive type</groupDescription>
272. <groupId>301000014</groupId>
273. </item>
274. </storyCriteria>
275. <systemDescription>Diesel particulate filter (4WD)</systemDescription>
276. <systemId>319010994</systemId>
277. <tsbCriteria xsi:nil="true"/>
278. </item>
279. </systems>
280. </filterTSBCasesRecallsStoriesReturn>
281. </filterTSBCasesRecallsStoriesResponse>
282. </soapenv:Body>
283. </soapenv:Envelope>
284.


289

## 17. IDENTIFICATION LOCATION

This is a small subject, and it can be considered as being part of the Identification. It shows

where to find on a model the identification codes.

### 17.1. Structure

There is only one structure-element for this subject:

ExtIdLocationV2 {
String identifier;
String title;
String description;
String mimeDataName;
}

###  identifier : this is a text that represents a constant value (not translated), and it can be one of:

ENGINE, GENERAL, TRANSMISSION, EQUIPMENT (new elements can be added in the future)

###  title : this is a text that is translated, and it represents the title of the identification element (for

example, for English, they can be: “Engine”, “Equipment code”, ...)

###  description : This is a text that is language related, usually in html format (can contain “<br>” as

```
line break) that contains information about the locations; this can refer to elements shown in
an image (see mimeDataName); can be null or empty
```
###  mimeDataName : this is a text that represents an URL to an image where the locations are

shown (can be null or empty if there is no image)

### 17.2. Fetching the id-location data via getIdLocationV3()

This operation requires the following parameters:

###  descriptionLanguage – the language code – in this case “en”

###  carTypeId – the id of the model or type car – in this case 102000182 (model id for Volkswagen)

###  level – 2 if the car id is for a Model and 3 if the car id is for a Type – in this case “2”

This operation getIdLocationV2 returns all id locations linked to a car type (can be General, Engine,

Transmission, Equipment code, Diagnostic connector or Jacking points). The type of id location is a

constant called **identifier** and can be GENERAL ENGINE, TRANSMISSION, EQUIPMENT,

DIAGNOSTIC_CONNECTOR and JACKING_POINTS, being not translatable.

Starting V3 version, all id locations are shown to the user in a repair manuals structure.


290

Response for getIdLocationV3 operation looks like this:

The identifiers are now stories with names:

**ID location, ( - 2013 ), Equipment code overview, Diagnostic connector, Jacking points**

Each of this locations identifiers cand have one or more storyLines (ex IdLocation has General, Engine,

Transmission) and each of the storylines can have one or more subStoryLines each containing a

sentence or an image.

**This operation returns an array of ExtStoryListContainerV2**

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getIdLocationV3Response xmlns="http://data.webservice.workshop.vivid.nl">
4. <getIdLocationV3Return>
5. <name> **ID location, ( - 2013)** </name>
6. <status>
7. <confirmationLink xsi:nil="true"/>
8. <statusCode>0</statusCode>
9. </status>
10. <storyLines>
11. <item>
12. <id xsi:nil="true"/>
13. <mimeData xsi:nil="true"/>
14. <name>General</name>
15. <order>0</order>
16. <paragraphContent xsi:nil="true"/>
17. <remark xsi:nil="true"/>
18. <sentenceGroupType xsi:nil="true"/>
19. <sentenceStyle xsi:nil="true"/>
20. <smartLinks xsi:nil="true"/>
21. <specialTool xsi:nil="true"/>
22. <status xsi:nil="true"/>
    ....
23. <subStoryLines>
24. <item>
25. <id>277</id>
26. <mimeData>
27. <mimeDataName> **https://acc.haynespro-**
    **assets.com/workshop/images/319090664.svgz** </mimeDataName>
28. <subStoryLines xsi:nil="true"/>
29. </mimeData>
30. <name/>
31. <order>0</order>
32. <paragraphContent xsi:nil="true"/>
33. <remark/>
34. <sentenceGroupType xsi:nil="true"/>
35. <sentenceStyle>SENTENCE_STYLE</sentenceStyle>


291

36. <smartLinks xsi:nil="true"/>
37. <specialTool xsi:nil="true"/>
38. <status xsi:nil="true"/>
39. <subStoryLines xsi:nil="true"/>
40. <tableContent xsi:nil="true"/>
41. </item>
42. <item>
43. <id>319045312</id>
44. <mimeData xsi:nil="true"/>
45. <name>To identify the vehicle, engine and optional
    equipment, check the details on the identification plate</name>
46. <order>1</order>
47. <paragraphContent xsi:nil="true"/>
48. <remark/>
49. <sentenceGroupType xsi:nil="true"/>
50. ...
51. <getIdLocationV3Return>
52. <name> **Equipment code overview** </name>
53. <status xsi:nil="true"/>
54. <storyLines>
55. ...
56. <getIdLocationV3Return>
57. <name> **Diagnostic connector** </name>
58. <status xsi:nil="true"/>
59. <storyLines>
60. ...
61. <getIdLocationV3Return>
62. <name> **Jacking points** </name>
63. <status xsi:nil="true"/>
64. <storyLines>

In touch id locations are displayed in the image:

Figure 17.2 - How Id Locations are displayed on a model in TOUCH

Request for previous getIdLocationV2:


292

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:data="http://data.webservice.workshop.vivid.nl">
65. <soapenv:Header/>
66. <soapenv:Body>
67. <data:getIdLocationV2>
68. <data:vrid>${vrid}</data:vrid>
69. <data:descriptionLanguage></data:descriptionLanguage>
70. <data:carTypeId>102000182</data:carTypeId>
71. <data:carTypeLevel>2</data:carTypeLevel>
72. </data:getIdLocationV2>
73. </soapenv:Body>
74. </soapenv:Envelope>
This is the response:
75. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
76. <soapenv:Body>
77. <getIdLocationV2Response xmlns="http://data.webservice.workshop.vivid.nl">
78. <getIdLocationV2Return>
79. < **description** ><![CDATA[To identify the vehicle, engine and optional equipment, check the details on the
identification plate <br> The vehicle data label shows all the optional equipment fitted to the vehicle <br> <br> VIN
behind the windscreen <br> <br> Vehicle data label <br>1 VIN <br>2 Model type/Engine output <br>3 Engine
and gearbox code <br> Colour code/Interior equipment code <br>4 Optional equipment codes
<br>]]></description>
80. < **identifier** >GENERAL</identifier>
81. < **mimeDataName** >https://acc.haynespro-assets.com/workshop/images/319020846.svgz</mimeDataName>
82. <status>
83. <confirmationLink xsi:nil="true"/>
84. <statusCode>0</statusCode>
85. </status>
86. < **title** >General</title>
87. </getIdLocationV2Return>
88. <getIdLocationV2Return>
89. <description>7K Tyre pressure monitoring system &lt;br> &lt;br>J1D Battery: 72 Ah/380 CCA&lt;br>0K1
Battery: 75 Ah/420 CCA&lt;br>J1U Battery: 95 Ah/450 CCA&lt;br></description>
90. <identifier>EQUIPMENT</identifier>
91. <mimeDataName>https://acc.haynespro-assets.com/workshop/images/319020847.svgz</mimeDataName>
92. <status xsi:nil="true"/>
93. <title>Equipment code</title>
94. </getIdLocationV2Return>
95. <getIdLocationV2Return>
96. <description>Left-hand drive is shown; no additional information is available for right-hand drive</description>
97. <identifier> **DIAGNOSTIC_CONNECTOR** </identifier>
98. <mimeDataName>https://acc.haynespro-assets.com/workshop/images/66235.svgz</mimeDataName>


293

99. <status xsi:nil="true"/>
100. <title>Diagnostic connector</title>
101. </getIdLocationV2Return>
102. <getIdLocationV2Return>
103. <description xsi:nil="true"/>
104. <identifier> **JACKING_POINT** S</identifier>
105. <mimeDataName>https://acc.haynespro-
    assets.com/workshop/images/319055913.svgz</mimeDataName>
106. <status xsi:nil="true"/>
107. <title>Jacking points</title>
108. </getIdLocationV2Return>
109. </getIdLocationV2Response>
110. </soapenv:Body>
111. </soapenv:Envelope>


294

## 18. PROFIT TOPICS

“ProFit” is a project which is part of the Workshop Data Web-Services. It started from the need

for fitting instructions for various parts. Those instructions include data from different subjects, like

repair manuals, adjustments data, technical drawings, or repair times, depending on the existing data

for each car and part.

This service has the following URL:

[http://www.haynespro-services.com/workshopServices3/services/ProFitEndpoint?wsdl](http://www.haynespro-services.com/workshopServices3/services/ProFitEndpoint?wsdl)

### 18.1. Structure

The project contains two main parts:

###  topics

###  data

The topics part presents the names of parts, a unique number used as identifier, a text-code

that can be used as identifier (which is also human-readable) and the subjects which are available for

each topic.

ExtProFitTopic {

Integer id;

String key;

String description;

String[] availableSubjects;

}

###  id – numeric, integer; used as identifier. This id is used as relay to get the data for the topic

###  key – text; used as human-readable identifier.

###  description – text, language dependent; it represents the description of the ProFit topic

###  availableSubject – list of text elements; they represent the subjects available in data part. The

subjects can be (new values can be added in newer versions):

### ◦ REPAIR_MANUALS

### ◦ REPAIR_TIMES

### ◦ TECHNICAL_DRAWINGS

### ◦ MAINTENANCE

### ◦ ADJUSTMENTS


295

### ◦ LUBRICANTS

### ◦ WIRING_DIAGRAMS

### ◦ GENERAL_INFO

The data part starts with a container for all the subjects that a ProFit topic can have. In the

container, most of the elements have the already-known structure found in each chapter of this

document.

ExtProfitContainer {

String topicDescription;

ExtProfitRepairManualsContainer[] repairManuals;

ExtRepairtimeNodeV2[] repairTimes;

ExtDrawingV2[] technicalDrawings;

ExtProfitMaintenanceSystem[] maintenance;

ExtAdjustmentV3[] adjustments;

ExtLubricantGroupV2[] lubricants;

ExtMapItem[] generalInformationLinks;

}

###  topicDescription – this is a text field, language specific, containing the description of the ProFit

topic

###  repairManuals – this is a complex object containing repair manuals data

###  repairTimes – this is a complex object containing repair times data

###  technicalDrawings – this is a complex object containing technical drawings data

###  maintenance – this is a complex object containing maintenance interval information

###  adjustments – this is a complex object containing adjustments data

###  lubricants – this is a complex object containing lubricants data

###  generalInformationLinks – this is a complex object containing pairs formed by keys (that

identify the general info) and a link to a page that contains html with the specified information

ExtProfitRepairManualsContainer {

String title;

ExtStoryLineV2[] storyLines;

}


296

###  title – this is a text, language specific, which contains the name of the manual

###  storyLines – this is a complex object which contains the repair manual data; this object is

already described in chapter 9

ExtRepairtimeNodeV2 – described in chapter 12

ExtDrawingV2 – described in chapter 8

ExtProfitMaintenanceSystem {

String systemDescription;

ExtMaintenanceTaskV6[] tasks;

}

###  systemDescription – this is a text, language dependent, which contains the description of the

system

###  tasks – this is a list of complex objects which contain the maintenance tasks data

ExtAdjustmentV3 - this is described in chapter 5

ExtLubricantGroupV2 – this is described in chapter 7

ExtMapItem {

String key;

String value;

}

###  key: text, language independent; used as identifier for the value

###  value: text; in this case it contains a link to a html page that contains the information for the

general information

### 18.2. Calling Operations

#### 18.2.1. getProFitTopics

This operation returns all the available topics for a vehicle.


297

The required parameters are:

###  descriptionLanguage - String (this should be a 2-character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carTypeId – int (this number is the “id” of the Type found in ExtCarType; you can check chapter

3 for more information about this object)

This operation returns an array of ExtProfitContainer objects.

We will call this operation with the following parameters:

###  descriptionLanguage - String – en

###  carType – int – 26650 (you should find “golf iv akq” and make sure it is the same id; if it is not,

replace 26650 with the id that you find in the response)

Request:

###  <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"

```
xmlns:prof="http://profit.data.webservice.workshop.vivid.nl">
```
###  <soapenv:Header/>

###  <soapenv:Body>

###  <prof:getProFitTopics>

###  <prof:vrid>89B6C8D13F37FBDC20600EFCA3CF7CD0</prof:vrid>

###  <prof: descriptionLanguage > en </prof:descriptionLanguage>

###  <prof: carTypeId > 26650 </prof:carTypeId>

###  </prof:getProFitTopics>

###  </soapenv:Body>

###  </soapenv:Envelope>

Response:

1. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
2. <soapenv:Body>
3. <getProFitTopicsResponse
    xmlns="http://profit.data.webservice.workshop.vivid.nl">
4. <getProFitTopicsReturn>
5. <availableSubjects>
6. <item>REPAIR_MANUALS</item>
7. </availableSubjects>
8. <description>Key Programming</description>
9. < **id** > **1** </id>
10. <key>KEY_PROGRAMMING</key>


298

11. <status xsi:nil="true"/>
12. </getProFitTopicsReturn>
13. ...
14. <getProFitTopicsReturn>
15. <availableSubjects>
16. <item>REPAIR_MANUALS</item>
17. <item>REPAIR_TIMES</item>
18. <item>ADJUSTMENTS</item>
19. </availableSubjects>
20. <description>Battery</description>
21. < **id** > **6** </id>
22. <key>BATTERY</key>
23. <status xsi:nil="true"/>
24. </getProFitTopicsReturn>
25. ...
26. </getProFitTopicsReturn>
27. </getProFitTopicsResponse>
28. </soapenv:Body>
29. </soapenv:Envelope>

#### 18.2.2. getProFitDataById

This operation returns the data for a specified ProFit Topic.

The required parameters are:

###  descriptionLanguage - String (this should be a 2-character string, established by the 639-1 ISO;

for example, for English it is “en”, for French it is “fr”)

###  carTypeId – int (this number is the “id” of the Type found in ExtCarType; you can check chapter

3 for more information about this object)

###  tecdocTypeId – int (this number is the “id” of the Tecdoc Type identification – can be null or 0 if

it is not known)

###  tecdocTypeCategory – String (this can be CAR or TRUCK; it specifies if the Tecdoc Type

identification should be searched in the cars data or in the trucks data in the Tecdoc database)

###  topicId – int (this number is the “id” of the topic; it can be found in the response of the

previous call)

Request:

###  <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"

```
xmlns:prof="http://profit.data.webservice.workshop.vivid.nl">
```
###  <soapenv:Header/>

###  <soapenv:Body>


299

###  <prof:getProFitDataById>

###  <prof:vrid>475A11072310AE7BBD6C70DF663ABEF1</prof:vrid>

###  <prof:descriptionLanguage>en</prof:descriptionLanguage>

###  <prof:carTypeId>26650</prof:carTypeId>

###  <prof:tecdocTypeId></prof:tecdocTypeId>

###  <prof:tecdocTypeCategory></prof:tecdocTypeCategory>

###  <prof:topicId>1</prof:topicId>

###  </prof:getProFitDataById>

###  </soapenv:Body>

###  </soapenv:Envelope>

Response:

112. <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
113. <soapenv:Body>
114. <getProFitDataByIdResponse
    xmlns="http://profit.data.webservice.workshop.vivid.nl">
115. <getProFitDataByIdReturn>
116. < **adjustments** xsi:nil="true"/>
117. < **generalInformationLinks** xsi:nil="true"/>
118. < **lubricants** xsi:nil="true"/>
119. < **maintenance** xsi:nil="true"/>
120. < **repairManuals** >
121. <item>
122. <storyLines>
123. <item
    xmlns:ns1="http://data.webservice.workshop.vivid.nl">
124. <ns1:mimeDataName xsi:nil="true"/>
125. <ns1:name>General</ns1:name>
126. <ns1:order>0</ns1:order>
127. <ns1:remark xsi:nil="true"/>
128. <ns1:smartLinks xsi:nil="true"/>
129. <ns1:status xsi:nil="true"/>
130. <ns1:subStoryLines>
131. <item>
132. <ns1:mimeDataName xsi:nil="true"/>
133. <ns1:name>A diagnostic tool must be used for
    this operation</ns1:name>
134. <ns1:order>0</ns1:order>
135. <ns1:remark></ns1:remark>
136. <ns1:smartLinks xsi:nil="true"/>
137. <ns1:status xsi:nil="true"/>


300

138. <ns1:subStoryLines/>
139. </item>
140. ...
141. </ns1:subStoryLines>
142. </item>
143. <item
    xmlns:ns1="http://data.webservice.workshop.vivid.nl">
144. <ns1:mimeDataName xsi:nil="true"/>
145. <ns1:name>Programming keys</ns1:name>
146. <ns1:order>1</ns1:order>
147. <ns1:remark xsi:nil="true"/>
148. <ns1:smartLinks xsi:nil="true"/>
149. <ns1:status xsi:nil="true"/>
150. <ns1:subStoryLines>
151. <item>
152. <ns1:mimeDataName xsi:nil="true"/>
153. <ns1:name>Insert a key into the ignition
    switch</ns1:name>
154. <ns1:order>0</ns1:order>
155. <ns1:remark></ns1:remark>
156. <ns1:smartLinks xsi:nil="true"/>
157. <ns1:status xsi:nil="true"/>
158. <ns1:subStoryLines/>
159. </item>
160. ...
161. </ns1:subStoryLines>
162. </item>
163. ...
164. </storyLines>
165. <title/>
166. </item>
167. </repairManuals>
168. < **repairTimes** xsi:nil="true"/>
169. <status xsi:nil="true"/>
170. < **technicalDrawings** xsi:nil="true"/>
171. < **topicDescription** > **Key Programming** </topicDescription>
172. </getProFitDataByIdReturn>
173. </getProFitDataByIdResponse>
174. </soapenv:Body>
175. </soapenv:Envelope>



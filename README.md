Representational State Transfer (REST) APIs are service endpoints that support sets of HTTP operations (methods), which provide create, retrieve, update, or delete access to the service's resources. This article walks you through:

How to call Azure REST APIs with Postman
The basic components of a REST API request/response pair.
How to register your client application with Azure Active Directory (Azure AD) to secure your REST requests.
Overviews of creating and sending a REST request, and handling the response.
The most effective method to call Azure REST APIs with Postman
This article will tell you the best way to rapidly verify with the Azure REST APIs by means of the customer id/secret strategy. We support you keep perusing beneath to find out about what comprises a REST activity, however in the event that you have to rapidly call the APIs.

The Azure REST APIs require a Bearer Token Authorization header. The docs work superbly clarifying each validation necessity, however, don't reveal to you how to rapidly begin. This post will ideally tackle that for you.

Make AAD[AZURE ACTIVE DIRECTORY] Token Request:
This Make will POST to https://login.microsoftonline.com//{{tenantId}}/oauth2/token with our Service Principal settings and afterward, in the "Tests" will set a Postman Global Variable called bearerToken to the access_token in the reaction.



Set Environment Variables:
At the point when you tapped on the "Run in Postman" button Postman likewise made an Environment for you called "Sky blue REST". You will presently set your Service Principal settings in the Environment to be utilized in the solicitations.

Snap on the apparatus symbol in the upper right hand corner of Postman and select Manage Environments.


Snap on the Azure REST Environment and you will see all the necessary settings.


Enter every one of your settings from the Service Principal we made before. Here's the means by which they map:

tenant = XXXXXXX
appId = XXXXXXX
password = XXXXXXXXX
subscriptionId =XXXXXXXXXXXXXXXXXXXXXXXXXXXX
fill these details into the postman as mentioned in the image.

Make Get  Request for AAD Token:
To begin with, we will execute the Get AAD Token solicitation to get our Bearer Token and put it in a Postman worldwide variable.

Open the Get AAD Token solicitation and snap the Send button.

Now the output will be like this.

 {
    "token_type": "Bearer",
    "expires_in": "3599",
    "ext_expires_in": "0",
    "expires_on": "1512031433",
    "not_before": "1512027533",
    "resource": "https://management.azure.com/",
    "access_token": "eyJ0eXAiOiJKV.XXXXXXXXXX"
}
We get the access_token, now we will use this acccess_token get other API response like capacity lists, update capacity, etc.

Now I am going to make a request to check the subscription of AZURE.

Request header:
The solicitation URI is packaged in the solicitation message header, alongside any extra fields required by your administration's REST API particular and the HTTP detail. Your solicitation may require the accompanying regular header fields:

Approval: Contains the OAuth2 conveyor token to verify the solicitation, as obtained prior from Azure AD.

Content-Type: Typically set to "application/json" (name/esteem matches in JSON design), and determines the MIME kind of the solicitation body.

Host: The space name or IP address of the server where the REST administration endpoint is facilitated.

Send the request:
Now that you have the administration's solicitation URI and have made the related solicitation message header and body, you are prepared to send the solicitation to the REST administration endpoint.

For instance, you may send a HTTPS GET demand strategy for an Azure Resource Manager supplier by utilizing demand header handle that are like the accompanying (note that the solicitation body is unfilled):

GET /subscriptions?api-version=2014-04-01-preview HTTP/1.1
Authorization: Bearer <bearer-token>
Host: management.azure.com

<no body>

And you might send an HTTPS PUT request method for an Azure Resource Manager provider, by using request header and body fields similar to the following example:

PUT /subscriptions/.../resourcegroups/ExampleResourceGroup?api-version=2016-02-01 HTTP/1.1
Authorization: Bearer <bearer-token>
Content-Length: 29
Content-Type: application/json
Host: management.azure.com

{
"location": "West US"
}

HTTP/1.1 200 OK
Content-Length: 303
Content-Type: application/json;
And you should receive a response body that contains a list of Azure subscriptions and their individual properties encoded in JSON format, similar to:

{
    "value":[
        {
        "id":"/subscriptions/...",
        "subscriptionId":"...",
        "displayName":"My Azure Subscription",
        "state":"Enabled",

"subscriptionPolicies":{
            "locationPlacementId":"Public_2015-09-01",
            "quotaId":"MSDN_2014-05-01",
            "spendingLimit":"On"}
        }
    ]
}


Now get the capacity list API request:



after fil these details press hit button send it will give the response like this which is given below:

Sample Request
Https://management.azure.com/subscriptions/613192d7-503f-477a-9cfe-4efc3ee2bd60/providers/Microsoft.PowerBIDedicated/capacities?api-version=2017-10-01

Sample Response
Status code:
200
{
  "value": [
    {
      "id": "/subscriptions/613192d7-503f-477a-9cfe-4efc3ee2bd60/providers/Microsoft.PowerBIDedicated/capacities/azsdktest",
      "location": "West US",
      "name": "azsdktest",
      "properties": {
        "administration": {
          "members": [
            "azsdktest@microsoft.com"
          ]
        },
        "provisioningState": "Provisioning",
        "state": "Provisioning"
      },
      "sku": {
        "name": "A1",
        "tier": "PBIE_Azure"
      },
      "tags": {
        "testKey": "testValue"
      }
    },
    {
      "id": "/subscriptions/613192d7-503f-477a-9cfe-4efc3ee2bd60/providers/Microsoft.PowerBIDedicated/capacities/azsdktest",
      "location": "West US",
      "name": "azsdktest2",
      "properties": {
        "administration": {
          "members": [
            "azsdktest@microsoft.com"
          ]
        },
        "provisioningState": "Provisioning",
        "state": "Provisioning"
      },
      "sku": {
        "name": "A2",
        "tier": "PBIE_Azure"
      },
      "tags": {
        "testKey": "testValue"
      }
    }
  ]
}
All the above processes explaining this is the direct process only, Fill all the details in postman browser the get the details.

Now I am going to tell you all the process by code, I mean how you will generate a token by PHP code, this is the PHP curl code put all details inside the code this will give you response.
This is the code for generating Authorization token.


 /*
*Generate Authentication Token
*/
$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => "https://login.microsoftonline.com/{{put here your directory id from azure}}/oauth2/token",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "POST",
CURLOPT_POSTFIELDS => "grant_type=client_credentials&client_id={{put here client_id}}&client_secret={{put here client_secret}}&resource=https%3A%2F%2Fmanagement.azure.com",
CURLOPT_HTTPHEADER => array(
"cache-control: no-cache",
"content-type: application/x-www-form-urlencoded"
),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
$Bearer_token=json_decode($response);
$BeareToken=$Bearer_token->access_token;
echo $BeareToken;
this will generate the token

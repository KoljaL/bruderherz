# Video Wall


## Done
- Ich hab die php Datei noch tewas ändern müssen, sie muss ja, bei erfolgreicher Speierung, die Daten wieder zurückgeben.

## Unity
Du nutzt in Unity wahrscheinlichdie `UnityWebRequest` API. Die kann nicht nur GET und POST, sondern auch PUT.
Vielleicht wäre es doch besser, die vorhandenen Weg zu nutzen und nicht alles über POST zu machen.

https://docs.unity3d.com/ScriptReference/Networking.UnityWebRequest.html

Mein Vorschlag: 

- lade Daten mit GET, Datenamen in der URL und Password als `Authorization: Bearer` im Header

**JS**
```javascript
async function getWithAuth(file) {
    const response = await fetch(URL + 'file=' + file, {
        method: 'GET',
        headers: {
            Authorization: `Bearer ${PASSWORD}`,
        },
    });
    const data = await response.json();
    console.log(data);
}
```



**Unity**
```csharp
using System.Collections;
using UnityEngine;
using UnityEngine.Networking;

public class ApiRequest : MonoBehaviour
{
    private string apiUrl = "https://example.com/api/endpoint"; // Replace with your API URL
    private string bearerToken = "YOUR_BEARER_TOKEN"; // Replace with your actual bearer token

    void Start()
    {
        StartCoroutine(SendGetRequest());
    }

    IEnumerator SendGetRequest()
    {
        UnityWebRequest www = UnityWebRequest.Get(apiUrl);

        // Set the "Authorization" header with the bearer token
        www.SetRequestHeader("Authorization", "Bearer " + bearerToken);

        yield return www.SendWebRequest();

        if (www.isNetworkError || www.isHttpError)
        {
            Debug.LogError("Error: " + www.error);
        }
        else
        {
            // Request was successful, handle the response
            string jsonResponse = www.downloadHandler.text;
            Debug.Log("Response: " + jsonResponse);

            // You can parse and work with the response data here
        }
    }
}
```

- speichere Daten mit PUT, Datenamen in der URL und Password als `Authorization: Bearer` im Header

**JS**
```javascript
async function putWithAuth(file, data) {
    const response = await fetch(URL + 'file=' + file, {
        method: 'PUT',
        headers: {
            Authorization: `Bearer ${PASSWORD}`,
        },
        body: JSON.stringify(data),
    });
    const data = await response.json();
    console.log(data);
}
```

**Unity**
Brauchts du nicht, oder? 


In PHP wird der Header so gelesen:
```php
$authorizationHeader = isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION']) ? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] : null);

if ($authorizationHeader !== null) {
    // Extract the token from the "Authorization" header
    $token = str_replace('Bearer ', '', $authorizationHeader);

    // Now, $token contains the bearer token
    echo "Bearer Token: " . $token;
} else {
    // No "Authorization" header found
    echo "Authorization header not present";
}
```

Sieht kompliziert aus, aber `$token` ist dein Passwort, der Rest ist ja egal. :-)


## Link for Development
- https://codesandbox.io/embed/drag-and-drop-with-vanilla-javascript-for-touch-and-mouse-based-screens-o5456k?file=/src/index.js:752-894&codemirror=1
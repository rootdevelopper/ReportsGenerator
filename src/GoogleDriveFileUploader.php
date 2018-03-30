<?php

namespace AutomatedReports;

class GoogleDriveFileUploader{

    private $client;

function getClient() {
    $this->client = new \Google_Client();
    $this->client->setApplicationName(APPLICATION_NAME);
    $this->client->setScopes(SCOPES);
    $this->client->setAuthConfig(CLIENT_SECRET_PATH);
    $this->client->setAccessType('offline');

    $credentialsPath = $this->expandHomeDirectory(CREDENTIALS_PATH);
    /*the credentials will expire */
    /*Google require manual authorization for this api*/
    //comment out if statemenet below and uncomment $accessToken

     if (file_exists($credentialsPath)) {
        $accessToken = json_decode(file_get_contents($credentialsPath), true);
    } else {
         $accessToken = $this->coppyAndPasteCredentials($credentialsPath);
     }

     //uncomment this $access token if credentials expire and need to manualy grant permission
    //$accessToken = $this->coppyAndPasteCredentials($credentialsPath);

    $this->client->setAccessToken($accessToken);

    // Refresh the token if it's expired and save it for next time
    if ($this->client->isAccessTokenExpired()) {
        $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
        file_put_contents($credentialsPath, json_encode($this->client->getAccessToken()));
    }
    return $this->client;
}


function expandHomeDirectory($path) {
    $homeDirectory = getenv('HOME');
    if (empty($homeDirectory)) {
        $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
    }
    return str_replace('~', realpath($homeDirectory), $path);
}

function setFiles($filesPath, $reportName)
{
   // $filesLocation = ROOT_PATH.$filesPath;
    $client = $this->getClient();
    $service = new \Google_Service_Drive($client);
    $fileMetadata = new \Google_Service_Drive_DriveFile(array(
        'name' => $reportName,
        'mimeType' => 'application/vnd.google-apps.spreadsheet'));

    $content = file_get_contents(ROOT_PATH.$filesPath);
    $file = $service->files->create($fileMetadata, array(
        'data' => $content,
        'mimeType' => 'text/csv',
        'uploadType' => 'multipart',
        'fields' => 'id'));
    printf("File ID: %s\n", $file->id);

  }


    public function coppyAndPasteCredentials($credentialsPath)
    {
// Request authorization from the user.
        $authUrl = $this->client->createAuthUrl();
        printf("Open the following link in your browser:\n%s\n", $authUrl);
        print 'Enter verification code: ';
        $pasteYourVerificationCodeHere = '';
        $authCode = trim($pasteYourVerificationCodeHere);
        $accessToken = $this->client->fetchAccessTokenWithAuthCode($authCode);

        // Store the credentials to disk, this credentials will expire in the set time
        if (!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0700, true);
        }
        file_put_contents($credentialsPath, json_encode($accessToken));
        return $accessToken;
        //printf("Credentials saved to %s\n", $credentialsPath);
    }

}



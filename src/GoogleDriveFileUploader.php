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

     if (file_exists($credentialsPath)) {
        $accessToken = json_decode(file_get_contents($credentialsPath), true);
    } else {

        // Request authorization from the user.
        $authUrl = $this->client->createAuthUrl();
        printf("Open the following link in your browser:\n%s\n", $authUrl);
        print 'Enter verification code: ';
        $pasteYourVerificationCodeHere = '';
        $authCode = trim($pasteYourVerificationCodeHere);
        $accessToken = $this->client->fetchAccessTokenWithAuthCode($authCode);

        // Store the credentials to disk, this credentials will expire in the set time
        if(!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0700, true);
        }
        file_put_contents($credentialsPath, json_encode($accessToken));
        //printf("Credentials saved to %s\n", $credentialsPath);
   }

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

function setFiles($filesPath)
{
    $filesLocation = ROOT_PATH.$filesPath;
    $client = $this->getClient();
    $service = new \Google_Service_Drive($client);
    $fileMetadata = new \Google_Service_Drive_DriveFile(array(
        'name' => 'My Report2',
        'mimeType' => 'application/vnd.google-apps.spreadsheet'));

    $content = file_get_contents($filesLocation.'3test.csv');
    $file = $service->files->create($fileMetadata, array(
        'data' => $content,
        'mimeType' => 'text/csv',
        'uploadType' => 'multipart',
        'fields' => 'id'));
    printf("File ID: %s\n", $file->id);

  }

}



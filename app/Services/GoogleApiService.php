<?php

namespace App\Services;

use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Support\Facades\Request;

class GoogleApiService
{
    protected $client;
    
    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName('Google Drive API PHP Quickstart');
        $this->client->setScopes([
            Google_Service_Drive::DRIVE,
            Google_Service_Drive::DRIVE_APPDATA,
            Google_Service_Drive::DRIVE_FILE,
            Google_Service_Drive::DRIVE_METADATA,
            Google_Service_Drive::DRIVE_METADATA_READONLY,
            Google_Service_Drive::DRIVE_PHOTOS_READONLY,
            Google_Service_Drive::DRIVE_READONLY,
            Google_Service_Drive::DRIVE_SCRIPTS
            ]
        );
        $this->client->setAuthConfig(storage_path('credentials.json'));
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
    }


    function setConfigClient() {
        $authCode = Request::get('code');

        if ($this->client->isAccessTokenExpired()) {
            $tokenPath = storage_path('token.json');

            if (file_exists($tokenPath)) {
                $accessToken = json_decode(file_get_contents($tokenPath), true);
                $this->client->setAccessToken($accessToken);
            }
          
            if ($this->client->getRefreshToken()) {
                $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());

            } else {
                if (!$authCode) {
                    $authUrl = $this->client->createAuthUrl();
                    return ['url_auth' => $authUrl];
                }

                $accessToken = $this->client->fetchAccessTokenWithAuthCode($authCode);

                if (array_key_exists('error', $accessToken)) {
                    return $accessToken;
                }

                $this->client->setAccessToken($accessToken);
            }

            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($this->client->getAccessToken()));
        }

        return ['message' => 'Cliente Autenticado', 'auth' => true];
    }

  public function driveUpload($data, $extension, $mime) {
    $filename = null;
    $createdFileID = null;

    if(!isset($this->setConfigClient()['auth'])) {
        return ['message' => 'Precisa autenticar o usuário', 'status' => 500];
    }

    try {
        $filename = uniqid().'.'.$extension;
        $service = new Google_Service_Drive($this->client);
        $file = new Google_Service_Drive_DriveFile();
        $file->setName($filename);
        //$file->setDescription('A test document');
        $file->setMimeType($mime);

        $createdFile = $service->files->create($file, [
            'data' => $data,
            'mimeType' => 'text/xml',
            'uploadType' => 'multipart'
        ]);

        $createdFileID = $createdFile->getId();
        if ($createdFileID) {
            return ['message' => 'Arquivo enviado', 'id_file' => $createdFileID, 'status' => 200];
        }

        
    } catch (\Exception $e) {
        return ['message' => $e->getMessage(), 'id_file' => $createdFileID, 'status' => 500];
    }
  }

  function deleteFile($fileID) {
    if(!isset($this->setConfigClient()['auth'])) {
        return ['message' => 'Precisa autenticar o usuário', 'status' => 500];
    }
    
    $drive = new Google_Service_Drive($this->client);
    $drive->files->delete($fileID);
  }
}
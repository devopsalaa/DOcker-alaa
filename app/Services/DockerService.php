<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Broadcast;


class DockerService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:2375/',
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'timeout' => 30,
        ]);
    }

   public function listContainers($all = true)
{
    try {
        $response = $this->client->get('containers/json', [
            'query' => ['all' => $all]
        ]);

        $containers = json_decode($response->getBody(), true);

        // Ensure each container has the expected structure
        foreach ($containers as &$container) {
            if (!isset($container['Names'])) {
                $container['Names'] = ['/unknown'];
            } elseif (is_string($container['Names'])) {
                $container['Names'] = [$container['Names']];
            }

            if (!isset($container['State'])) {
                $container['State'] = 'unknown';
            }
        }

        return $containers;
    } catch (GuzzleException $e) {
        return ['error' => $e->getMessage()];
    }
}

   public function createContainer($image, $name, $ports = [])
{
    // First try to pull the image if it doesn't exist locally
    try {
        $this->client->post('images/create', [
            'query' => ['fromImage' => $image]
        ]);
    } catch (\Exception $e) {
        // Continue even if pull fails (might already exist)
    }

    $portBindings = [];
    $exposedPorts = [];

    foreach ($ports as $containerPort => $hostPort) {
        $portKey = $containerPort . '/tcp';
        $portBindings[$portKey] = [['HostPort' => (string)$hostPort]];
        $exposedPorts[$portKey] = (object)[];
    }

    try {
        // Create the container
        $response = $this->client->post('containers/create', [
            'json' => [
                'Image' => $image,
                'HostConfig' => [
                    'PortBindings' => $portBindings
                ],
                'ExposedPorts' => $exposedPorts
            ],
            'query' => ['name' => $name]
        ]);

        $container = json_decode($response->getBody(), true);

        // Start the container
        $this->client->post('containers/'.$container['Id'].'/start');

        return $container;
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        return [
            'error' => $e->getMessage(),
            'response' => $e->hasResponse() ? (string)$e->getResponse()->getBody() : null
        ];
    } catch (\Exception $e) {
        return [
            'error' => $e->getMessage(),
            'response' => null
        ];
    }
}
   public function startContainer($containerId)
{
    try {
        $this->client->post('containers/'.$containerId.'/start');
        Broadcast::channel('containers', function () use ($containerId) {
            return ['id' => $containerId, 'state' => 'running'];
        });
        return ['success' => true];
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

    public function stopContainer($id)
    {
        try {
            $this->client->post('containers/'.$id.'/stop');
            return true;
        } catch (GuzzleException $e) {
            return false;
        }
    }

    public function removeContainer($id)
    {
        try {
            $this->client->delete('containers/'.$id, [
                'query' => ['force' => true]
            ]);
            return true;
        } catch (GuzzleException $e) {
            return false;
        }
    }

    public function buildImage($path, $tag, $dockerfile = 'Dockerfile')
{
    try {
        $tar = new \PharData(tempnam(sys_get_temp_dir(), 'docker') . '.tar');
        $tar->buildFromDirectory($path);

        $response = $this->client->post('build', [
            'query' => [
                't' => $tag,
                'dockerfile' => $dockerfile
            ],
            'body' => fopen($tar->getPath(), 'r'),
            'headers' => [
                'Content-Type' => 'application/tar'
            ]
        ]);

        unlink($tar->getPath());
        return json_decode($response->getBody(), true);
    } catch (GuzzleException $e) {
        return ['error' => $e->getMessage()];
    }
}

public function listImages()
{
    try {
        $response = $this->client->get('images/json');
        return json_decode($response->getBody(), true);
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

public function getContainerLogs($containerId)
{
    try {
        $response = $this->client->get("containers/{$containerId}/logs", [
            'query' => [
                'stdout' => true,
                'stderr' => true,
                'timestamps' => false
            ]
        ]);
        $logs = (string)$response->getBody();
        return ['logs' => $logs];
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}




public function getContainerDetails($containerId)
{
    try {
        $response = $this->client->get("containers/{$containerId}/json");
        $details = json_decode($response->getBody(), true);
        return $details;
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}



public function pullImage($image)
{
    try {
        $response = $this->client->post('images/create', [
            'query' => ['fromImage' => $image]
        ]);
        return ['success' => true];
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}




public function backupContainer($containerId)
{
    try {
        $response = $this->client->post("containers/{$containerId}/commit", [
            'query' => [
                'repo' => 'backup-' . $containerId,
                'tag' => 'latest'
            ]
        ]);
        $image = json_decode($response->getBody(), true);
        return ['success' => true, 'image' => $image];
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}








}

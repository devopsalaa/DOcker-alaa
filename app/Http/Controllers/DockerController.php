<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DockerService;
use App\Models\Container;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DockerController extends Controller
{
    protected $docker;

    public function __construct(DockerService $docker)
    {
        $this->docker = $docker;
    }

    public function dashboard()
    {
        // Initialize variables with default values
        $runningContainers = 0;
        $totalContainers = 0;
        $totalImages = 0;
        $recentContainers = [];
        $recentImages = [];
        $error = null;

        try {
            // Fetch containers
            $containers = $this->docker->listContainers();
            if (isset($containers['error'])) {
                $error = $containers['error'];
                Log::error('Failed to list containers: ' . $error);
            } else {
                $runningContainers = count(array_filter($containers, fn($container) => $container['State'] === 'running'));
                $totalContainers = count($containers);
                $recentContainers = array_slice($containers, 0, 5); // Limit to 5 recent containers
            }

            // Fetch images
            $images = $this->docker->listImages();
            if (isset($images['error'])) {
                $error = $error ?? $images['error']; // Preserve container error if present
                Log::error('Failed to list images: ' . $images['error']);
            } else {
                $totalImages = count($images);
                $recentImages = array_slice($images, 0, 5); // Limit to 5 recent images
            }
        } catch (\Exception $e) {
            $error = 'An unexpected error occurred while fetching Docker data: ' . $e->getMessage();
            Log::error($error, ['exception' => $e]);
        }

        return view('dashboard', compact(
            'runningContainers',
            'totalContainers',
            'totalImages',
            'recentContainers',
            'recentImages',
            'error'
        ));
    }

    public function index()
    {
        $containers = $this->docker->listContainers();

        if (isset($containers['error'])) {
            return view('docker.index', [
                'containers' => [],
                'error' => $containers['error']
            ]);
        }

        return view('docker.index', [
            'containers' => $containers
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
            'name' => 'required|string',
            'ports' => 'sometimes|array',
            'ports.*.container' => 'required|integer',
            'ports.*.host' => 'required|integer',
        ]);

        $images = $this->docker->listImages();
        $imageExists = false;

        if (!isset($images['error'])) {
            foreach ($images as $image) {
                if (in_array($request->image, $image['RepoTags'] ?? [])) {
                    $imageExists = true;
                    break;
                }
            }
        }

        $ports = [];
        foreach ($request->ports ?? [] as $port) {
            $ports[$port['container']] = $port['host'];
        }

        $result = $this->docker->createContainer(
            $request->image,
            $request->name,
            $ports
        );

        if (isset($result['error'])) {
            return back()
                ->with('error', $result['error'])
                ->with('debug', $result['response'] ?? null);
        }

        return redirect()->route('docker.index')->with('success', 'Container created!');
    }

    public function start($id)
    {
        $this->docker->startContainer($id);
        return back()->with('success', 'Container started');
    }

    public function stop($id)
    {
        $this->docker->stopContainer($id);
        return back()->with('success', 'Container stopped');
    }

    public function destroy($id)
    {
        $this->docker->removeContainer($id);
        return back()->with('success', 'Container removed');
    }

    public function metrics($id)
    {
        return view('docker.metrics', [
            'containerId' => $id
        ]);
    }

    public function images()
    {
        $images = $this->docker->listImages();
        return view('docker.images', compact('images'));
    }

    public function build(Request $request)
    {
        $request->validate([
            'tag' => 'required|string',
            'dockerfile' => 'required|file|mimes:tar',
        ]);

        $tempPath = $request->file('dockerfile')->storeAs(
            'temp',
            'dockerfile_' . time() . '.tar'
        );

        $result = $this->docker->buildImage(
            storage_path('app/' . $tempPath),
            $request->tag
        );

        unlink(storage_path('app/' . $tempPath));

        if (isset($result['error'])) {
            return back()->with('error', $result['error']);
        }

        return redirect()->route('docker.images')->with('success', 'Image built successfully!');
    }


    public function logs($id)
{
    try {
        $logs = $this->docker->getContainerLogs($id);
        if (isset($logs['error'])) {
            return view('docker.logs', ['containerId' => $id, 'logs' => [], 'error' => $logs['error']]);
        }
        return view('docker.logs', ['containerId' => $id, 'logs' => $logs['logs'], 'error' => null]);
    } catch (\Exception $e) {
        Log::error("Failed to fetch logs for container $id: " . $e->getMessage());
        return view('docker.logs', ['containerId' => $id, 'logs' => [], 'error' => 'Unable to fetch logs: ' . $e->getMessage()]);
    }
}

public function details($id)
{
    try {
        $container = $this->docker->getContainerDetails($id);
        if (isset($container['error'])) {
            return view('docker.details', ['containerId' => $id, 'details' => [], 'error' => $container['error']]);
        }
        return view('docker.details', ['containerId' => $id, 'details' => $container, 'error' => null]);
    } catch (\Exception $e) {
        Log::error("Failed to fetch details for container $id: " . $e->getMessage());
        return view('docker.details', ['containerId' => $id, 'details' => [], 'error' => 'Unable to fetch details: ' . $e->getMessage()]);
    }
}



public function pull(Request $request)
{
    $request->validate(['image' => 'required|string']);
    try {
        $result = $this->docker->pullImage($request->image);
        if (isset($result['error'])) {
            return back()->with('error', $result['error']);
        }
        return redirect()->route('docker.images')->with('success', "Image {$request->image} pulled successfully!");
    } catch (\Exception $e) {
        Log::error("Failed to pull image {$request->image}: " . $e->getMessage());
        return back()->with('error', 'Unable to pull image: ' . $e->getMessage());
    }
}











}

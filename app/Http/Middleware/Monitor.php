<?php

namespace App\Http\Middleware;

use App\Facades\Logger;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Response;
use App\Models\Monitor as MonitorModel;

class Monitor
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    /**
     * @param $request
     * @param $response
     */
    public function terminate($request, $response)
    {
        if (method_exists($request, 'isMethod') && $request->isMethod(Request::METHOD_GET)) {
            return;
        }
        MonitorModel::monitor(class_basename(self::class), [
            'headers' => $request->headers->all(),
            'request' => $this->parseRequest($request),
            'response' => $this->parseResponse($response)
        ], Str::upper(optional($request)->getMethod()) . ' ' . optional($request)->path());
    }

    /**
     * @param Request $request
     * @return array
     */
    private function parseRequest($request): array
    {
        if ($request->has('image')) { // Avoid big image strings
            $request->merge(['image' => Str::limit($request->get('image'), 30)]);
        }
        return [
            'user' => optional($request->user())->only(['id', 'name', 'email', 'role_id']),
            'url' => $request->url(),
            'verb' => $request->getMethod(),
            'data' => $request->except(['file', 'files']),
            'files' => $this->parseFiles($request),
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function parseFiles($request): array
    {
        if ($file = $request->file('file')) {
            $files = collect([$file]);
        } else {
            $files = collect($request->allFiles()['files'] ?? []);
        }

        return $files
            ->filter()
            ->map(fn (UploadedFile $file) => [
               'filename' => $file->getFilename(),
               'extension' => $file->guessClientExtension(),
               'mime' => $file->getMimeType(),
               'size' => $file->getSize(),
            ])->toArray();
    }

    /**
     * @param JsonResponse|Response $response
     * @return array|string
     */
    private function parseResponse($response)
    {
        if ($response instanceof JsonResponse) {
            return (array)$response->getData();
        }

        return $response->getContent();
    }
}

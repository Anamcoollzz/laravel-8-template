<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class DropboxController extends StislaController
{
    public function index(Request $request)
    {
        $files = collect([]);
        if ($folderName = request('create_folder')) {
            $folder = $request->folder_prefix ? decrypt($request->folder_prefix) : '';
            $folderName = $folder . '/' . $folderName;
            $this->dropBoxService->createFolder($folderName);
            return back()->with('successMessage', 'Folder created successfully');
        } else if ($id = request('download')) {
            $metaData = $this->dropBoxService->getMetaData($id);
            $filename = $metaData['name'];
            $pathDownload = $this->dropBoxService->download($id, $filename);
            return response()->download($pathDownload)->deleteFileAfterSend();
        } else if (session('dropbox_access_token')) {
            $folder = request('folder') ? decrypt(request('folder')) : '';
            $response = $this->dropBoxService->getListFile($folder, session('dropbox_access_token'));
            $files = collect($response['entries']);
        } else if (request('code')) {
            $response = $this->dropBoxService->getAccessToken(request('code'), request('client_id'), request('client_secret'));
            return $response;
            if (isset($response['error'])) {
                return redirect()->route('dropboxs.index')->with('errorMessage', $response['error_description']);
            }
            session(['dropbox_access_token' => $response['access_token']]);
            session(['dropbox_refresh_token' => $response['refresh_token']]);
        }
        return view('stisla.dropboxs.index', [
            'title' => 'Dropbox',
            'data'  => $files,
        ]);
    }

    public function destroy()
    {
        $id = request('id');
        $this->dropBoxService->deleteFile($id);
        return back()->with('successMessage', 'File deleted successfully');
    }

    public function upload(Request $request)
    {
        $folder = $request->folder ? decrypt($request->folder) : '';
        $path = $request->file('file')->storeAs('public/dropboxs/uploads', $request->file('file')->getClientOriginalName());
        $path = storage_path('app/' . $path);
        $this->dropBoxService->uploadFile($path, $folder);
        return back()->with('successMessage', 'File uploaded successfully');
    }
}

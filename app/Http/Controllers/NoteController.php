<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Mail\BroadcastNotes;
use App\Models\Note;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upload($id)
    {
        $data = [
            'title' => 'Upload Notulen',
            'scheduleId' => $id,
            'noteTitle' => 'Notulen ' . Schedule::getById($id)[0]->description
        ];

        return view('schedule.upload-notulen', $data);
    }

    public function store(NoteRequest $request)
    {
        if (isNoteEmpty($request)) {
            return back()->with('noteEmpty', 'Cantumkan minimal satu informasi dari 3 pilihan dibawah sebagai notulen rapat.');
        }

        $contentImageName = null;
        $contentFileName = null;

        if ($request->hasFile('contentImage')) {
            // Buat nama gambar
            $content = $request->file('contentImage');
            $contentImageName = time() . '_' . str($content->getClientOriginalName())->lower();

            // Move gambar ke public
            $content->move('uploaded/images/', $contentImageName);
        }

        if ($request->hasFile('contentFile')) {
            // Buat nama file
            $content = $request->file('contentFile');
            $contentFileName = time() . '_' . str($content->getClientOriginalName())->lower();

            // Move gambar ke public
            $content->move('uploaded/files/', $contentFileName);
        }

        // Note::upload($request->only('title', 'scheduleId', 'contentText'), $contentImageName, $contentFileName);

        $this->broadcast($request->only('title', 'scheduleId', 'contentText'), $contentImageName, $contentFileName);
        dd('sent');

        return redirect()->to('/')->with('status', 'Berhasil menambah notulen rapat');
    }

    public function broadcast($note, $imageName, $fileName)
    {
        Mail::send(new BroadcastNotes($note, $imageName, $fileName));
    }
}

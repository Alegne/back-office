<?php

namespace App\Http\Controllers\Back;

use App\DataTables\AlbumDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\AlbumRequest;
use App\Models\Album;
use App\Rules\AlbumUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param AlbumDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(AlbumDataTable $dataTable)
    {
        return $dataTable->render('back.shared.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $album = null;

        if ($request->ok)
        {
            # dd($request->ok);
            $ok = 'The post has been successfully created';
            return view('back.album.form', compact('album','ok'));
        }

        return view('back.album.form', compact('album'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AlbumRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlbumRequest $request)
    {
        $album = Album::create($request->all());

        # return back()->with('ok', 'The post has been successfully created');
        return redirect()->route('album.photos.view', ['album' => $album]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Album $album
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Album $album)
    {
        return view('back.album.form', compact('album'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Album $album
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Album $album)
    {
        $request->validate([
            'titre'        => ['required', new AlbumUpdate($request->titre, $album->id)],
            'description'  => 'required',
        ]);

        $album->update($request->all());

        #return back()->with('ok', 'The post has been successfully updated');
        return redirect()->route('album.photos.view', ['album' => $album]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Album $album
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Album $album)
    {
        $album->delete();

        return response()->json();
    }


    /**
     * @param Album $album
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function photosView(Album $album)
    {
        return view('back.album.photos', compact('album'));
    }

    /**
     * Upload photos
     *
     * @param Request $request
     * @param Album $album
     * @return \Illuminate\Http\JsonResponse
     */
    public function photos(Request $request, Album $album)
    {
        $extensions_images = [
            'jpeg',
            'pjpeg',
            'png',
            'gif',
            'jpg',
            'PNG'
        ];

        $data = collect();

        if ($album->photos)
        {
            if (count($album->photos) > 0)
            {
                $data = $data->merge($album->photos);
            }
        }

        $name = $request->file('file')->getClientOriginalName();

        if (in_array($request->file('file')->extension(), $extensions_images))
        {
            $img   = Image::make($request->file('file')->path());
            $img->resize(1000,800)->encode()->save(public_path('/storage/images/') . $name);
            $img->resize(400,400)->encode()->save(public_path('/storage/images/thumbs/') . $name);

            # $img->resize(300, 200);
        }else{

            # dd(public_path('/storage/fichiers/')); # D:\projet M1\WebCup\_projet\projet-back-office-webcup\public\/storage/fichiers/
            # dd(public_path('storage\fichiers'));  # D:\projet M1\WebCup\_projet\projet-back-office-webcup\public\storage\fichiers


            $request->file('file')->storeAs('public\fichiers', $name);
            # $jointe->move(public_path('storage\fichiers'), $name);

        }

        # array_push($data, $name);
        $data->push($name);

        # $album->photos = json_encode($data->all());
        $album->photos = $data->all();

        $album->save();

        return response()->json(['success' => $album]);
    }

    /**
     * Delete les photos
     *
     * @param Request $request
     * @param album $album
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletephotos(Request $request, album $album)
    {

        $filename =  $request->get('filename');
        $data = collect();

        $extension = explode('.', $filename)[1];

        $extensions_images = [
            'jpeg',
            'pjpeg',
            'png',
            'gif',
            'jpg'
        ];

        if (in_array($extension, $extensions_images)){
            File::delete([
                public_path('/storage/images/') . $filename,
                public_path('/storage/images/thumbs/') . $filename,
            ]);
        }else{
            File::delete([
                public_path('/storage/fichiers/') . $filename,
            ]);
        }

        if ($album->photos)
        {
            if (count($album->photos) > 0)
            {
                foreach ($album->photos as $piece)
                {
                    if ($piece != $filename)
                    {
                        $data->push($piece);
                    }
                }
            }
        }

        # $album->photos = count($data) > 0 ? json_encode($data->all()) : null;
        $album->photos = count($data) > 0 ? $data->all() : null;
        $album->save();

        return response()->json(['success' => $album]);
    }
}

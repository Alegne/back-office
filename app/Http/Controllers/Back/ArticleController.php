<?php

namespace App\Http\Controllers\Back;

use App\DataTables\ArticleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\ArticleRequest;
use App\Models\Article;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ArticleDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(ArticleDataTable $dataTable)
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
        $article = null;

        $clubs = Club::all()->pluck('libelle', 'id');

        if ($request->ok)
        {
            # dd($request->ok);
            $ok = 'The post has been successfully created';
            return view('back.article.form', compact('article', 'clubs', 'ok'));
        }

        return view('back.article.form', compact('article', 'clubs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ArticleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $inputs = $this->getInputs($request);

        $article = Article::create($inputs);

        # return back()->with('ok', 'The post has been successfully created');
        return redirect()->route('article.galeries.view', ['article' => $article]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $clubs = Club::all()->pluck('libelle', 'id');
        return view('back.article.form', compact('article', 'clubs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ArticleRequest $request
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $inputs = $this->getInputs($request);

        if($request->has('image') && $request->image) {
            $this->deleteImages($article);
        }

        $article->update($inputs);

        # return back()->with('ok', 'The post has been successfully updated');
        return redirect()->route('article.galeries.view', ['article' => $article]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Article $article)
    {
        $article->delete();
        $this->deleteImages($article);

        return response()->json();
    }

    /**
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function galeriesView(Article $article)
    {
        return view('back.article.galerie', compact('article'));
    }

    /**
     * Upload Galeries
     *
     * @param Request $request
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function galeries(Request $request, Article $article)
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

        if ($article->galerie)
        {
            if (count($article->galerie) > 0)
            {
                $data = $data->merge($article->galerie);
            }
        }

        $name = $request->file('file')->getClientOriginalName();

        if (in_array($request->file('file')->extension(), $extensions_images))
        {
            $img   = Image::make($request->file('file')->path());
            $img->widen(800)->encode()->save(public_path('/storage/images/') . $name);
            $img->widen(400)->encode()->save(public_path('/storage/images/thumbs/') . $name);

        }else{

            # dd(public_path('/storage/fichiers/')); # D:\projet M1\WebCup\_projet\projet-back-office-webcup\public\/storage/fichiers/
            # dd(public_path('storage\fichiers'));  # D:\projet M1\WebCup\_projet\projet-back-office-webcup\public\storage\fichiers


            $request->file('file')->storeAs('public\fichiers', $name);
            # $jointe->move(public_path('storage\fichiers'), $name);

        }

        # array_push($data, $name);
        $data->push($name);

        $article->galerie = $data->all();

        $article->save();

        return response()->json(['success' => $article]);
    }

    /**
     * Delete les pieces jointes
     *
     * @param Request $request
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteGaleries(Request $request, Article $article)
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

        if ($article->galerie)
        {
            if (count($article->galerie) > 0)
            {
                foreach ($article->galerie as $piece)
                {
                    if ($piece != $filename)
                    {
                        $data->push($piece);
                    }
                }
            }
        }

        $article->galerie = count($data) > 0 ? json_encode($data->all()) : null;
        $article->save();

        return response()->json(['success' => $article]);
    }


    ### Manage upload image

    protected function getInputs($request)
    {
        $inputs = $request->except(['image']);

        # $inputs['active'] = $request->has('active');

        if($request->image) {
            $inputs['image'] = $this->saveImages($request);
        }

        # dd($inputs);

        return $inputs;
    }

    protected function saveImages($request)
    {
        # dd($request->file('image'));

        $image = $request->file('image');
        $name  = time() . '.' . $image->extension();
        $img   = Image::make($image->path());

        # $img->resize(width, height);

        $img->widen(800)->encode()->save(public_path('/storage/images/') . $name);
        $img->widen(400)->encode()->save(public_path('/storage/images/thumbs/') . $name);

        return $name;
    }

    protected function deleteImages($article)
    {
        File::delete([
            public_path('/storage/images/') . $article->image,
            public_path('/storage/images/thumbs/') . $article->image,
        ]);
    }
}

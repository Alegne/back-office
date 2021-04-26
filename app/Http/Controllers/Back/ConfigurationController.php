<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ConfigurationController extends Controller
{

    public function edit()
    {
        return view('back.configuration.lien');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $keys = $request->except('_token', '_method');

        # dd($keys);

        if ($request->has('image_directeur') && $request->image_directeur) {

            # dd('condition');
            $this->deleteImages(getConfiguration('image_directeur'));

            $keys['image_directeur'] = $this->saveImages($request);
        } else {
            # dd('Aucun', Configuration::get('image_directeur'));
            $keys['image_directeur'] = Configuration::get('image_directeur');
        }

        # dd($keys, 'condition after');

        foreach ($keys as $key => $value) {
            Configuration::set($key, $value);
        }

        # dd(getConfiguration('image_directeur'));

        if ($request->has('mot_directeur'))
            return redirect()->route('configuration.contenu')
                ->with('ok', 'Mise à jour a été un  succès');
        elseif ($request->has('lien_facebook'))
            return redirect()->route('configuration.lien')
                ->with('ok', 'Mise à jour a été un  succès');
        elseif ($request->has('email'))
            return redirect()->route('configuration.contact')
                ->with('ok', 'Mise à jour a été un  succès');

        return back()->with('ok', 'Mise à jour a été un  succès');
    }

    protected function saveImages($request)
    {
        # dd($request->file('photo'));

        $image = $request->file('image_directeur');
        $name  = time() . '.' . $image->extension();
        $img   = Image::make($image->path());

        # $img->resize(width, height);

        $img->widen(800)->encode()->save(public_path('/storage/images/') . $name);
        $img->widen(400)->encode()->save(public_path('/storage/images/thumbs/') . $name);

        return $name;
    }

    protected function deleteImages($image)
    {
        File::delete([
            public_path('/storage/images/') . $image,
            public_path('/storage/images/thumbs/') . $image,
        ]);
    }
}

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

            return back()
                #->route('configuration.contenu')
                ->with('ok', 'The post has been successfully updated')
                ->with('active_contenu', 'Active');
        elseif ($request->has('lien_facebook'))
            return back()
                #->route('configuration.lien')
                ->with('ok', 'The post has been successfully updated')
                ->with('active_lien', 'Active');
        elseif ($request->has('email'))
            return back()
                #->route('configuration.contact')
                ->with('ok', 'The post has been successfully updated')
                ->with('active_contact', 'Active');
        elseif ($request->has('apropos_informations'))
            return back()
                #->route('configuration.contact')
                ->with('ok', 'The post has been successfully updated')
                ->with('active_apropos', 'Active');


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

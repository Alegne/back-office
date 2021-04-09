<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $keys = $request->except('_token');

        foreach ($keys as $key => $value)
        {
            Configuration::set($key, $value);
        }

        return back()->with('ok', 'The post has been successfully updated');
    }
}

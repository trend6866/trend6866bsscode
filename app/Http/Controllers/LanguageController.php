<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Utility;
use App\Models\Setting;
use App\Models\Admin;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Cookie;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changeLanquage($lang)
    {
        $user       = Auth::user();
        $user->lang = $lang;
        $user->save();

        return redirect()->back()->with('success', __('Language change successfully.'));
    }

    public function manageLanguage($currantLang)
    {
        if(\Auth::user()->can('Manage Language'))
        {
            $languages = Utility::languages();
            $settings = Setting::pluck('value', 'name')->toArray();
            if (!empty($settings['disable_lang'])) {
                $disabledLang = explode(',', $settings['disable_lang']);
            } else {
                $disabledLang = [];
            }

            $dir = base_path() . '/resources/lang/' . $currantLang;
            if(!is_dir($dir))
            {
                $dir = base_path() . '/resources/lang/en';
            }
            $arrLabel   = json_decode(file_get_contents($dir . '.json'));
            $arrFiles   = array_diff(
                scandir($dir), array(
                                    '..',
                                    '.',
                                )
            );
            $arrMessage = [];

            foreach($arrFiles as $file)
            {
                $fileName = basename($file, ".php");
                $fileData = $myArray = include $dir . "/" . $file;
                if(is_array($fileData))
                {
                    $arrMessage[$fileName] = $fileData;
                }
            }

            return view('lang.index', compact('languages', 'currantLang', 'arrLabel', 'arrMessage','disabledLang'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function storeLanguageData(Request $request, $currantLang)
    {
        if (\Auth::user()->can('Create Language')) {
            $dir = base_path() . '/resources/lang/' . $currantLang;

            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }

            // Update JSON language file
            if (isset($request->label) && !empty($request->label)) {
                $jsonFilePath = $dir . ".json";

                // Read existing JSON data
                $existingData = [];

                if(file_exists($jsonFilePath)){
                    $existingData = json_decode(file_get_contents($jsonFilePath), true);
                }

                // Merge with new key-value pairs
                $mergedData = array_merge($existingData , $request->label);

                // Write the merged data back to the JSON file
                file_put_contents($jsonFilePath, json_encode($mergedData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            }

            // Update PHP language files
            if (isset($request->message) && !empty($request->message)) {
                foreach ($request->message as $fileName => $fileData) {
                    $content = "<?php return " . var_export($fileData , true) . ";";
                    file_put_contents($dir . "/" . $fileName . '.php', $content);
                }
            }

            return redirect()->route('admin.manage.language', [$currantLang])->with('success', 'Language saved successfully.');
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function createLanguage()
    {
        return view('lang.create');
    }

    public function storeLanguage(Request $request)
    {
        if(\Auth::user()->can('Create Language'))
        {

            $Filesystem = new Filesystem();
            $langCode   = strtolower($request->code);
            $langDir    = base_path() . '/resources/lang/';
            $dir        = $langDir;
            if(!is_dir($dir))
            {
                mkdir($dir);
                chmod($dir, 0777);
            }
            $dir      = $dir . '/' . $langCode;
            $jsonFile = $dir . ".json";
            \File::copy($langDir . 'en.json', $jsonFile);

            if(!is_dir($dir))
            {
                mkdir($dir);
                chmod($dir, 0777);
            }
            $Filesystem->copyDirectory($langDir . "en", $dir . "/");

            // Specify the path to your JSON file
            $filePath = base_path('resources/lang/language.json');

            // Read the existing JSON file and decode its contents into an array
            $jsonContents = File::get($filePath);
            $data = json_decode($jsonContents, true);

            //append key wise data
            $data[$request->code] = $request->name;

            // Encode the updated array back to JSON format
            $jsonContentsUpdated = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            // Write the JSON data back to the file, preserving the existing contents
            File::put($filePath, $jsonContentsUpdated);


            return redirect()->route('admin.manage.language', [$langCode])->with('success', __('Language successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroyLang($lang)
    {
        if(\Auth::user()->can('Delete Language'))
        {
            $default_lang = env('default_language') ?? 'en';
            $langDir      = base_path() . '/resources/lang/';
            if(is_dir($langDir))
            {
                // remove directory and file
                Utility::delete_directory($langDir . $lang);

                // Specify the path to your JSON file
                $filePath = base_path('resources/lang/language.json');

                // Read the contents of the existing JSON file and decode it into an array
                $jsonContents = File::get($filePath);
                $data = json_decode($jsonContents, true);

                // Remove the data based on the key
                $keyToRemove = $lang;
                unset($data[$keyToRemove]);

                // Encode the updated array back to JSON format
                $jsonContentsUpdated = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                // Write the JSON data back to the file, replacing the existing contents
                File::put($filePath, $jsonContentsUpdated);


                unlink($langDir . $lang . '.json');
                // update user that has assign deleted language.
                Admin::where('lang', 'LIKE', $lang)->update(['lang' => $default_lang]);
            }
            return redirect()->route('admin.manage.language', $default_lang)->with('success', __('Language Deleted Successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function changelanguage($lang = '')
    {
        // dd($lang);
        if(Auth::check()){
            $user       = Auth::user();
            $user->lang = $lang;
            $user->save();
            return redirect()->back()->with('success', __('Language change successfully.'));
        }else{
            session()->put('lang',$lang);
            return redirect()->back()->with('success', __('Language change successfully.'));
        }
    }

    public function disableLang(Request $request)
    {
        if (\Auth::user()->type == 'superadmin') {

            $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();

            $settings = Setting::where('theme_id', $theme_name)->where('store_id', getCurrentStore())->pluck('value', 'name')->toArray();
            // $disablelang  = '';
            if ($request->mode == 'off') {
                if (!empty($settings['disable_lang'])) {
                    $disablelang = $settings['disable_lang'];
                    $disablelang = $disablelang . ',' . $request->lang;
                } else {
                    $disablelang = $request->lang;
                }
                \DB::insert(
                    'insert into settings (`value`,`name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?,?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        $disablelang,
                        'disable_lang',
                        $theme_name,
                        getCurrentStore(),
                        \Auth::guard()->user()->id,
                    ]
                );
                $data['message'] = __('Language Disabled Successfully');
                $data['status'] = 200;
                return $data;
            } else {
                $disablelang = $settings['disable_lang'];
                $parts = explode(',', $disablelang);
                while (($i = array_search($request->lang, $parts)) !== false) {
                    unset($parts[$i]);
                }
                \DB::insert(
                    'insert into settings (`value`,`name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?,?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        implode(',', $parts),
                        'disable_lang',
                        $theme_name,
                        getCurrentStore(),
                        \Auth::guard()->user()->id,
                    ]
                );
                $data['message'] = __('Language Enabled Successfully');
                $data['status'] = 200;
                return $data;
            }
        }
    }

    public function changeLanquageStore($lang = '')
    {
        Cookie::queue('LANGUAGE',$lang, 120);
        return redirect()->back()->with('success', __('Language change successfully.'));
    }

}



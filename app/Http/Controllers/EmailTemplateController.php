<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Models\EmailTemplateLang;
use App\Models\UserEmailTemplate;
use App\Models\Utility;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function __construct()
    {
        if(\Auth::check())
        {
             \App::setLocale(\Auth::user()->lang);
        }
    }

    public function emailTemplate($lang = 'en')
    {
        // $usr = \Auth::user();
        $languages         = Utility::languages();
        $emailTemplate     = EmailTemplate::first();

        $currEmailTempLang = EmailTemplateLang::where('parent_id', '=', $emailTemplate->id)->where('lang', $lang)->first();

        if(!isset($currEmailTempLang) || empty($currEmailTempLang))
        {
            $currEmailTempLang       = EmailTemplateLang::where('parent_id', '=', $emailTemplate->id)->where('lang', 'en')->first();
            $currEmailTempLang->lang = $lang;

        }

        $EmailTemplates = EmailTemplate::all();


        return view('email_templates.show', compact('emailTemplate', 'languages', 'currEmailTempLang','lang','EmailTemplates'));
    }

    public function manageEmailLang($id, $lang = 'en')
    {

        $languages         = Utility::languages();
        $emailTemplate     = EmailTemplate::where('id', '=', $id)->first();
        $currEmailTempLang = EmailTemplateLang::where('parent_id', '=', $id)->where('lang', $lang)->first();

        if(!isset($currEmailTempLang) || empty($currEmailTempLang))
        {
            $currEmailTempLang       = EmailTemplateLang::where('parent_id', '=', $id)->where('lang', 'en')->first();

            $currEmailTempLang->lang = $lang;
        }
        $EmailTemplates = EmailTemplate::all();
        return view('email_templates.show', compact('emailTemplate', 'languages', 'currEmailTempLang','EmailTemplates'));
    }

    public function updateEmailSettings(Request $request,$id){

        $validator = \Validator::make(
            $request->all(), [
                               'from' => 'required',
                               'subject' => 'required',
                               'content' => 'required',
                           ]
        );

        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $emailTemplate       = EmailTemplate::where('id',$id)->first();
        $emailTemplate->from = $request->from;
        $emailTemplate->save();

        $emailLangTemplate = EmailTemplateLang::where('parent_id', '=', $id)->where('lang', '=', $request->lang)->first();
        // if record not found then create new record else update it.
        if(empty($emailLangTemplate))
        {
            $emailLangTemplate            = new EmailTemplateLang();
            $emailLangTemplate->parent_id = $id;
            $emailLangTemplate->lang      = $request['lang'];
            $emailLangTemplate->subject   = $request['subject'];
            $emailLangTemplate->content   = $request['content'];
            $emailLangTemplate->save();
        }
        else
        {
            $emailLangTemplate->subject = $request['subject'];
            $emailLangTemplate->content = $request['content'];
            $emailLangTemplate->save();
        }

        return redirect()->route(
            'admin.manage.email.language', [
                                       $emailTemplate->id,
                                       $request->lang,
                                   ]
        )->with('success', __('Email Template successfully updated.'));
    }


    public function updateStatus(Request $request)
    {
        $post = $request->all();
        unset($post['_token']);

        $usr = \Auth::user();

        if($usr->type == 'super admin' || $usr->type == 'admin')
        {
            UserEmailTemplate::where('user_id', $usr->id)->update([ 'is_active' => 0]);
            foreach ($post as $key => $value) {
                $UserEmailTemplate  = UserEmailTemplate::where('user_id', $usr->id)->where('template_id', $key)->first();
                $UserEmailTemplate->is_active = $value;
                $UserEmailTemplate->save();
            }
            return redirect()->back()->with('success', __('Status successfully updated!'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));

        }
    }
}

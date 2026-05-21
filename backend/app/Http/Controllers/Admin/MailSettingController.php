<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mailsetting;
use Illuminate\Http\Request;

class MailSettingController extends Controller
{
    public function index()
    {
        $mail = Mailsetting::first() ?? new Mailsetting();

        return view('setting.setting.mail', ['mail' => $mail]);
    }

    public function update(Request $request, Mailsetting $mailsetting)
    {
        $data = $request->validate([
            'mail_transport'  => 'required|string',
            'mail_host'       => 'required|string',
            'mail_port'       => 'required|string',
            'mail_username'   => 'required|string',
            'mail_password'   => 'required|string',
            'mail_encryption' => 'nullable|string',
            'mail_from'       => 'required|email',
        ]);

        $mailsetting->update($data);

        return redirect()->route('admin.mail.index')->with('status', 'Mail settings updated.');
    }
}

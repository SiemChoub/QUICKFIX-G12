<?php

namespace Database\Seeders;

use App\Models\Mailsetting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['mail_transport' => 'smtp', 'mail_host' => 'smtp.gmail.com',          'mail_port' => '587', 'mail_username' => 'support@quickfix.com',    'mail_password' => 'password001', 'mail_encryption' => 'tls', 'mail_from' => 'support@quickfix.com'],
            ['mail_transport' => 'smtp', 'mail_host' => 'smtp.gmail.com',          'mail_port' => '465', 'mail_username' => 'noreply@quickfix.com',    'mail_password' => 'password002', 'mail_encryption' => 'ssl', 'mail_from' => 'noreply@quickfix.com'],
            ['mail_transport' => 'smtp', 'mail_host' => 'smtp.mailtrap.io',        'mail_port' => '2525','mail_username' => 'mailtrap_user',           'mail_password' => 'password003', 'mail_encryption' => 'tls', 'mail_from' => 'dev@quickfix.com'],
            ['mail_transport' => 'smtp', 'mail_host' => 'smtp.sendgrid.net',       'mail_port' => '587', 'mail_username' => 'apikey',                  'mail_password' => 'password004', 'mail_encryption' => 'tls', 'mail_from' => 'alerts@quickfix.com'],
            ['mail_transport' => 'smtp', 'mail_host' => 'smtp.office365.com',      'mail_port' => '587', 'mail_username' => 'admin@quickfix.com',      'mail_password' => 'password005', 'mail_encryption' => 'tls', 'mail_from' => 'admin@quickfix.com'],
            ['mail_transport' => 'smtp', 'mail_host' => 'smtp.zoho.com',           'mail_port' => '465', 'mail_username' => 'billing@quickfix.com',    'mail_password' => 'password006', 'mail_encryption' => 'ssl', 'mail_from' => 'billing@quickfix.com'],
            ['mail_transport' => 'smtp', 'mail_host' => 'smtp.mail.yahoo.com',     'mail_port' => '587', 'mail_username' => 'contact@quickfix.com',    'mail_password' => 'password007', 'mail_encryption' => 'tls', 'mail_from' => 'contact@quickfix.com'],
            ['mail_transport' => 'smtp', 'mail_host' => 'smtp.aws-ses.com',        'mail_port' => '587', 'mail_username' => 'ses_user',                'mail_password' => 'password008', 'mail_encryption' => 'tls', 'mail_from' => 'no-reply@quickfix.com'],
            ['mail_transport' => 'smtp', 'mail_host' => 'smtp.postmarkapp.com',    'mail_port' => '587', 'mail_username' => 'postmark_user',           'mail_password' => 'password009', 'mail_encryption' => 'tls', 'mail_from' => 'tx@quickfix.com'],
            ['mail_transport' => 'log',  'mail_host' => 'localhost',               'mail_port' => '25',  'mail_username' => 'local_dev',               'mail_password' => 'password010', 'mail_encryption' => null,  'mail_from' => 'dev@local.test'],
        ];

        foreach ($settings as $setting) {
            Mailsetting::create($setting);
        }
    }
}
